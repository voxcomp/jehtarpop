<?php

namespace App\Http\Controllers;

use App\Http\Repositories\hostedPaymentRepository;
use App\Models\Donation;
use App\Models\Sponsoritem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DonationsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showPage(): View
    {
        return view('donations.page');
    }

    public function submitDonation(Request $request): RedirectResponse
    {
        if (! (isset($request->inkind) && $request->inkind == '101')) {
            $isDonationExist = Donation::where('sponsor', 0)->where('clientip', $request->ip())->where('created_at', '>', now()->subMinutes(2)->toDateTimeString())->first();
        } else {
            $isDonationExist = null;
        }
        if (! $isDonationExist) {
            $request->validate([
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:75',
                'title' => 'nullable|string|max:75',
                'phone' => 'nullable|string|max:20',
                'email' => 'required|email:rfc,dns|max:150',
                'address' => 'required|string|max:200',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:20',
                'zip' => 'required|string|max:20',
                'amount' => 'required|numeric|min:1',
            ]);
            $donation = Donation::create([
                'fname' => $request->input('firstname'),
                'lname' => $request->input('lastname'),
                'title' => $request->input('title'),
                'company' => $request->input('company'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip' => $request->input('zip'),
                'amount' => $request->input('amount'),
                'clientip' => $request->ip(),
            ]);
            if ($donation) {
                if (isset($request->inkind) && $request->inkind == '101') {
                    $donation->paid = $donation->amount;
                    $donation->paytype = 'inkind';
                    $donation->save();

                    return redirect()->route('donations.confirmation', $donation->id);
                } else {
                    return redirect()->route('donations.payment', $donation->id);
                }
            } else {
                return redirect()->route('donations.page')->with('message', 'There was an error saving your donation.');
            }
        } else {
            return redirect()->route('donations.page')->with('message', 'It seems you already submitted a donation.');
        }
    }

    public function showPayment(Donation $donation): View
    {
        $anpay = new hostedPaymentRepository;

        $token = $anpay->getHostedFormTokenFromPayment($donation);

        return view('donations.payment', compact('token', 'donation'));
    }

    public function submitPayment(Request $request, Donation $donation): RedirectResponse
    {
        if ($donation->id != 72682) {
            $donation->paid = $request->paid;
            $donation->cardno = substr($request->card, -4);
            $donation->cardtype = (($request->cardtype == 'eCheck') ? 'eCheck' : 'credit');
            $donation->save();
            \Mail::to($this->settings->get('ADMIN_EMAIL', 'general'))->send(new \App\Mail\DonationMail($donation));
            \Mail::to($this->settings->get('ADMIN_EMAIL2', 'general'))->send(new \App\Mail\DonationMail($donation));
        }

        return redirect()->route('donations.confirmation', $donation->id);
    }

    public function showConfirmation(Donation $donation): View
    {
        return view('donations.confirmation', compact('donation'));
    }

    public function showProgress(): View
    {
        $total = (int) number_format(Donation::get()->sum('paid'), 2, '.', '');
        $goal = (int) number_format($this->settings->get('fund_goal', 'donation'), 0, '.', '');
        $percent = (int) ceil(29 * ($total / $goal));
        $total = '$'.number_format($total, 0);

        return view('donations.progress', compact('total', 'goal', 'percent'));
    }

    /******************************/
    /******************* Sponsors *************************************************************************************************************************/
    /******************************/

    public function showSponsorPage(): View
    {
        $items = Sponsoritem::get();

        return view('sponsors.page', compact('items'));
    }

    public function submitSponsor(Request $request): RedirectResponse
    {
        if (! (isset($request->inkind) && $request->inkind == '101')) {
            $isDonationExist = Donation::where('sponsor', 1)->where('clientip', $request->ip())->where('created_at', '>', now()->subMinutes(2)->toDateTimeString())->first();
        } else {
            $isDonationExist = null;
        }
        if (! $isDonationExist) {
            $request->validate([
                'logo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:75',
                'title' => 'nullable|string|max:75',
                'phone' => 'nullable|string|max:20',
                'email' => 'required|email:rfc,dns|max:150',
                'address' => 'required|string|max:200',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:20',
                'zip' => 'required|string|max:20',
            ]);
            $sponsoritem = Sponsoritem::where('id', $request->sponsoritem)->first();
            if (! is_null($sponsoritem)) {
                $sponsoritem->sold += 1;
                $sponsoritem->save();
                if ($request->file()) {
                    $fileName = time().'_'.str_replace([' ', '/', '\\', "'", '"'], ['', '', '', '', ''], $request->logo->getClientOriginalName());
                    $filePath = $request->file('logo')->storeAs('logo', $fileName, 'public');
                    $file = time().'_'.$request->logo->getClientOriginalName();
                    $image = '/storage/'.$filePath;
                }
                $donation = Donation::create([
                    'fname' => $request->input('firstname'),
                    'lname' => $request->input('lastname'),
                    'title' => $request->input('title'),
                    'company' => $request->input('company'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zip' => $request->input('zip'),
                    'amount' => $sponsoritem->price,
                    'options' => $sponsoritem->name,
                    'sponsor' => 1,
                    'clientip' => $request->ip(),
                    'paytype' => 'hold',
                ]);
                if (isset($image)) {
                    $donation->logo = $image;
                    $donation->save();
                }
                if ($donation) {
                    if (isset($request->inkind) && $request->inkind == '101') {
                        $donation->paid = $donation->amount;
                        $donation->paytype = 'inkind';
                        $donation->save();
                        \Mail::to($this->settings->get('ADMIN_EMAIL', 'general'))->send(new \App\Mail\SponsorMail($donation));
                        \Mail::to($this->settings->get('ADMIN_EMAIL2', 'general'))->send(new \App\Mail\SponsorMail($donation));

                        return redirect()->route('sponsor.confirmation', $donation->id);
                    } else {
                        if ($donation->amount < $this->settings->get('payment_limit', 'donation')) {
                            return redirect()->route('sponsor.payment', $donation->id);
                        } else {
                            $donation->paid = $donation->amount;
                            $donation->paytype = 'check';
                            $donation->save();
                            \Mail::to($this->settings->get('ADMIN_EMAIL', 'general'))->send(new \App\Mail\SponsorMail($donation));
                            \Mail::to($this->settings->get('ADMIN_EMAIL2', 'general'))->send(new \App\Mail\SponsorMail($donation));

                            return redirect()->route('sponsor.confirmation', $donation->id);
                        }
                    }
                } else {
                    return redirect()->back()->withInput(\Input::all())->with('message', 'There was an error saving your donation.');
                }
            } else {
                return redirect()->back()->withInput(\Input::all())->with('message', 'A sponsorship item must be chosen');
            }
        } else {
            return redirect()->route('sponsor.page')->with('message', 'It seems you already submitted a donation.');
        }
    }

    public function submitSponsorPaymentAlternate(Request $request, Donation $donation): RedirectResponse
    {
        $donation->paid = $donation->amount;
        $donation->paytype = 'check';
        $donation->save();
        \Mail::to($this->settings->get('ADMIN_EMAIL', 'general'))->send(new \App\Mail\SponsorMail($donation));
        \Mail::to($this->settings->get('ADMIN_EMAIL2', 'general'))->send(new \App\Mail\SponsorMail($donation));

        return redirect()->route('sponsor.confirmation', $donation->id);
    }

    public function showSponsorPayment(Donation $donation): View
    {
        $anpay = new hostedPaymentRepository;

        $token = $anpay->getHostedFormTokenFromPayment($donation);

        return view('sponsors.payment', compact('token', 'donation'));
    }

    public function submitSponsorPayment(Request $request, Donation $donation): RedirectResponse
    {
        $donation->paid = $request->paid;
        $donation->cardno = substr($request->card, -4);
        $donation->cardtype = $donation->paytype = (($request->cardtype == 'eCheck') ? 'eCheck' : 'credit');
        $donation->save();
        \Mail::to($this->settings->get('ADMIN_EMAIL', 'general'))->send(new \App\Mail\SponsorMail($donation));
        \Mail::to($this->settings->get('ADMIN_EMAIL2', 'general'))->send(new \App\Mail\SponsorMail($donation));

        return redirect()->route('sponsor.confirmation', $donation->id);
    }

    public function showSponsorConfirmation(Donation $donation): View
    {
        return view('sponsors.confirmation', compact('donation'));
    }
}

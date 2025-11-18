<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Registration;
use App\Models\SupportTicket;
use App\Models\SupportTicketFile;
use App\Models\SupportTicketNote;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function showPage(): View
    {
        return view('support.form');
    }

    public function showPagePath($path): View
    {
        if (session()->has($path.'registration')) {
            $register = session()->get($path.'registration');

            return view('support.form', compact('path', 'register'));
        }

        return view('support.form', compact('path'));
    }

    public function showPageRegistration($path, Registration $registration): View
    {
        $payment = $registration->payment()->where('payment_status', 'hold')->first();

        return view('support.form', compact('path', 'registration', 'payment'));
    }

    public function showList(): View
    {
        $tickets = SupportTicket::orderBy('created_at', 'DESC')->get();

        return view('support.list', compact('tickets'));
    }

    public function showDetail(SupportTicket $ticket): View
    {
        return view('support.detail', compact('ticket'));
    }

    public function createTicket(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'contactname' => 'nullable|string|max:100',
            'contactemail' => 'nullable|email|max:200',
            'contactphone' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:300',
        ]);
        $ticket = new SupportTicket;
        if (isset($request->contactname)) {
            $ticket->contactname = $request->contactname;
            $ticket->contactemail = $request->contactemail;
            $ticket->contactphone = $request->contactphone;
        }
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        if (\Auth::check()) {
            $ticket->visitor = 0;
            $ticket->email = $request->email;
        } else {
            $ticket->email = $this->settings->get('ADMIN_EMAIL', 'general').','.env('SUPPORT_EMAIL');
        }
        if (isset($request->registration)) {
            $registration = Registration::where('id', \Crypt::decrypt($request->registration))->first();
            if (! empty($registration)) {
                if ($registration->coid == 7617) {
                    $registrant = $registration->registrants()->first();
                    $ticket->contactname = $registrant->firstname.' '.$registrant->lastname;
                    $ticket->contactemail = $registrant->email;
                    $ticket->contactphone = $registrant->mobile;
                } else {
                    $ticket->contactname = $registration->contact;
                    $ticket->contactemail = $registration->cemail;
                    $ticket->contactphone = $registration->cphone;
                }
            }
            $ticket->registration_id = \Crypt::decrypt($request->registration);
        }
        if (isset($request->path)) {
            if (session()->has(\Crypt::decrypt($request->path).'registration')) {
                $register = session()->get(\Crypt::decrypt($request->path).'registration');
                $ticket->registration = serialize($register);
                if (isset($register['coid'])) {
                    if ($register['coid'] == 7617) {
                        $registrant = $register['registrants'][0];
                        $ticket->contactname = $registrant['firstname'].' '.$registrant['lastname'];
                        $ticket->contactemail = $registrant['email'];
                        $ticket->contactphone = $registrant['mobile'];
                    } else {
                        $ticket->contactname = $register['contactfname'].' '.$register['contactlname'];
                        $ticket->contactemail = $register['cemail'];
                        $ticket->contactphone = $register['cphone'];
                    }
                }
            }
        }
        $ticket->save();

        if (\Auth::check()) {
            return redirect()->route('support.detail', $ticket->id)->with('message', 'A support ticket has been created.');
        } elseif (isset($request->registration)) {
            return redirect()->route('support.confirmation.registration', [\Crypt::decrypt($request->registration)]);
        } elseif (isset($request->path)) {
            return redirect()->route('support.confirmation', [\Crypt::decrypt($request->path)]);
        }
    }

    public function saveEmail(SupportTicket $ticket, Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required|string|max:300',
        ]);
        $ticket->email = $request->email;
        $ticket->save();

        return redirect()->back()->with('message', 'Email addresses saved.');
    }

    public function saveNote(SupportTicket $ticket, Request $request): RedirectResponse
    {
        $this->validate($request, [
            'note' => 'required|string',
        ]);
        $ticket->notes()->create(['description' => $request->note]);

        return redirect()->back()->with('message', 'Note saved.');
    }

    public function deleteNote(SupportTicketNote $note): RedirectResponse
    {
        $note->delete();

        return redirect()->back()->with('message', 'Note deleted.');
    }

    public function saveStatus(SupportTicket $ticket, Request $request): RedirectResponse
    {
        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->back()->with('message', 'Status updated successfully.');
    }

    public function showConfirmation($path): View
    {
        if (session()->has($path.'registration')) {
            $register = session()->get($path.'registration');

            return view('support.confirmation', compact('path', 'register'));
        }

        return view('support.confirmation', compact('path'));
    }

    public function showConfirmationRegistration(Registration $registration): View
    {
        $payment = $registration->payment()->where('payment_status', 'hold')->first();

        return view('support.confirmation', compact('registration', 'payment'));
    }

    public function delete(SupportTicket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('support.list')->with('message', 'Support ticket has been deleted.');
    }

    public function download(SupportTicketFile $file)
    {
        $path = storage_path('app/support/'.$file->filename);
        if (! file_exists($path)) {
            return redirect()->back()->with('message', 'The file was not found');
        }

        return response()->download($path, $file->original);
    }

    public function upload(SupportTicket $ticket, Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,png,docx,doc,xls,xlsx,ppt,pptx,odt,ods,odp,rtf,jpg,jpeg,gif|max:4048', // adjust as needed
        ]);
        if ($request->hasFile('document')) {
            $file = $request->file('document');

            // Store in storage/app/public/uploads
            $path = $file->store('support');

            $ticket->files()->create(['original' => $file->getClientOriginalName(), 'filename' => basename($path)]);

            return back()->with('message', 'File uploaded successfully');
        }

        return back()->with('message', 'No file was uploaded.');
    }

    public function deleteFile(SupportTicketFile $file)
    {
        $file->delete();

        return back()->with('message', 'File deleted successfully');
    }
}

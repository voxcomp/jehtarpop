<?php

namespace App\Exports;

use App\Registration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class EventRegistrationsExport implements FromView, WithTitle
{
    protected $regtype;

    protected $start;

    protected $end;

    protected $hold;

    public function __construct($regtype, $start, $end, $hold)
    {
        $this->regtype = $regtype;
        $this->start = $start;
        $this->end = $end;
        $this->hold = $hold;
    }

    public function view(): View
    {
        // $registrations = Registration::where('regtype','event')->where('paytype','<>','none')->where('paytype','<>','hold')->where('created_at','>=',date("Y/m/d",strtotime($this->start)).' 0:01:00')->where('created_at','<=',date("Y/m/d",strtotime($this->end)).' 23:59:00')->get();
        $query = Registration::where('regtype', $this->regtype)->where('created_at', '>=', date('Y/m/d', strtotime($this->start)).' 0:01:00')->where('created_at', '<=', date('Y/m/d', strtotime($this->end)).' 23:59:00');
        if ($this->hold) {
            $query->where('paytype', '=', 'hold');
        } else {
            $query->where('paytype', '<>', 'hold');
        }
        $registrations = $query->get();

        return view('reports.event-registrations', compact('registrations'));
    }

    public function title(): string
    {
        return 'tempWebReg';
    }
}

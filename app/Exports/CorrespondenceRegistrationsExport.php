<?php

namespace App\Exports;

use App\Registration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class CorrespondenceRegistrationsExport implements FromView, WithTitle
{
    protected $start;

    protected $end;

    protected $hold;

    public function __construct($start, $end, $hold)
    {
        $this->start = $start;
        $this->end = $end;
        $this->hold = $hold;
    }

    public function view(): View
    {
        //        $registrations = Registration::where('regtype','correspondence')->where('paytype','<>','none')->where('paytype','<>','hold')->where('created_at','>=',date("Y/m/d",strtotime($this->start)).' 0:01:00')->where('created_at','<=',date("Y/m/d",strtotime($this->end)).' 23:59:00')->get();
        $query = Registration::where('regtype', 'correspondence')->where('created_at', '>=', date('Y/m/d', strtotime($this->start)).' 0:01:00')->where('created_at', '<=', date('Y/m/d', strtotime($this->end)).' 23:59:00');
        if ($this->hold) {
            $query->where('paytype', '=', 'hold');
        } else {
            $query->where('paytype', '<>', 'hold');
        }
        $registrations = $query->get();

        return view('reports.correspondence-registrations', compact('registrations'));
    }

    public function title(): string
    {
        return 'tempWebRegEdu';
    }
}

<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Donation;

class DonationsExport implements FromView, WithTitle
{
    protected $start;
    protected $end;
    
    function __construct($start, $end) {
        $this->start = $start;
        $this->end = $end;
    }
    
    public function view(): View
    {
        $donations = Donation::where('paytype','<>','hold')->where('created_at','>=',date("Y/m/d",strtotime($this->start)).' 0:01:00')->where('created_at','<=',date("Y/m/d",strtotime($this->end)).' 23:59:00')->get();
    
        return view('reports.donations',compact('donations'));
    }
    public function title(): string
    {
        return 'tempWebDonations';
    }
}

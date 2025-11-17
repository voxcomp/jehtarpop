<?php

namespace App\Imports;

use App\Event;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class EventsImport implements ToModel, WithStartRow, WithColumnFormatting
{
    public function model(array $row)
    {
	    $startdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]);
	    $starttime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);
        return new Event([
	        'event_id' => $row[0],
	        'startdate' => strtotime($startdate->format('m/d/Y')." ".$starttime->format('G:i:s')),
	        'name' => $row[5],
	        'contact' => (is_null($row[8]))?'':$row[8],
	        'location' => (is_null($row[9]))?'':$row[9],
	        'city' => (is_null($row[13]))?'':$row[13],
	        'minimum' => $row[6],
	        'maximum' => $row[7]
        ]);
    }

    public function columnFormats(): array
	{
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_TIME4,
        ];
	}

    public function startRow(): int
    {
        return 2;
    }
}

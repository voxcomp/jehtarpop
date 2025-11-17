<?php

namespace App\Imports;

use App\OnlineCourse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OnlineImport implements ToModel, WithStartRow, WithMultipleSheets
{
	use Importable;
	
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OnlineCourse([
            'schoolyear' => $row[0],
            'courseid' => $row[1],
            'coursedesc' => $row[2],
            'member' => (float)str_replace(["$",","],["",""],$row[6]),
            'nonmember' => (float)str_replace(["$",","],["",""],$row[7]),
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}

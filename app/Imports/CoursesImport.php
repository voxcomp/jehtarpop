<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CoursesImport implements ToModel, WithMultipleSheets, WithStartRow
{
    use Importable;

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Course([
            'schoolyear' => $row[0],
            'courseid' => $row[1],
            'coursedesc' => $row[2],
            'trade' => ($row[3] != 'HVAC') ? ucfirst(strtolower($row[3])) : $row[3],
            'tradedesc' => $row[4],
            'location' => ucfirst(strtolower($row[5])),
            'member' => (float) str_replace(['$', ','], ['', ''], $row[6]),
            'nonmember' => (float) str_replace(['$', ','], ['', ''], $row[7]),
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

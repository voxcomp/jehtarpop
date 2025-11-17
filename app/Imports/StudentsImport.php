<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentsImport implements SkipsOnFailure, ToModel, WithStartRow
{
    use Importable, SkipsFailures;

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Company types of *, * are members
        // Self Students  7617
        // New Company 9999
        foreach ($row as &$item) {
            if (is_null($item)) {
                $item = '';
            }
        }

        return new Student([
            'coid' => (string) $row[0],
            'indid' => (string) $row[2],
            'first' => $row[3],
            'last' => $row[5],
            'phone' => (! is_null($row[9])) ? $row[9] : '',
            'mobile' => (! is_null($row[10])) ? $row[10] : '',
            'mobilecarrier' => $row[11],
            'email' => $row[12],
            'address' => $row[13].' '.$row[14],
            'city' => $row[15],
            'state' => $row[16],
            'zip' => $row[17],
            'balance' => str_replace('$', '', ((empty($row[18])) ? '0.00' : $row[18])),
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    /*
        WithValidation
        public function rules(): array
        {
            return [
                '1' => Rule::in(['A']),
            ];
        }
    */
}

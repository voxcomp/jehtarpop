<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

// use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements SkipsOnFailure, ToModel, WithStartRow
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

        return new Customer([
            'coid' => (string) $row[0],
            'name' => $row[1],
            'member' => (! is_null($row[2])) ? $row[2] : '',
            'address' => $row[3],
            'city' => $row[4],
            'state' => $row[5],
            'zip' => substr($row[6], 0, 5),
            'phone' => $row[7],
            'balance' => str_replace('$', '', ((empty($row[8])) ? '0.00' : $row[8])),
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

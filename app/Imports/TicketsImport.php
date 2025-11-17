<?php

namespace App\Imports;

use App\Event;
use App\Ticket;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TicketsImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        $event = Event::where('event_id', $row[0])->first();
        if (is_null($event)) {
            return null;
        } else {
            return new Ticket([
                'ticket_id' => $row[2],
                'event_id' => $event->id,
                'name' => $row[1],
                'member' => str_replace('$', '', $row[3]),
                'nonmember' => str_replace('$', '', $row[4]),
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}

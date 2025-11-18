<?php

namespace App\Observers;

use App\Models\SupportTicket;
use App\Notifications\SupportTicketChange;

class SupportTicketObserver
{
    /**
     * Handle the support ticket "created" event.
     */
    public function created(SupportTicket $supportTicket): void
    {
        $supportTicket->refresh();
        $supportTicket->notify(new SupportTicketChange($supportTicket));
    }

    /**
     * Handle the support ticket "updated" event.
     */
    public function updated(SupportTicket $supportTicket): void
    {
        $supportTicket->refresh();
        $supportTicket->notify(new SupportTicketChange($supportTicket));
    }

    /**
     * Handle the support ticket "deleted" event.
     */
    public function deleted(SupportTicket $supportTicket): void
    {
        //
    }

    /**
     * Handle the support ticket "restored" event.
     */
    public function restored(SupportTicket $supportTicket): void
    {
        //
    }

    /**
     * Handle the support ticket "force deleted" event.
     */
    public function forceDeleted(SupportTicket $supportTicket): void
    {
        //
    }
}

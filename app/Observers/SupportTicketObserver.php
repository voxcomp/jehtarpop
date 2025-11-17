<?php

namespace App\Observers;

use App\Notifications\SupportTicketChange;
use App\Models\SupportTicket;

class SupportTicketObserver
{
    /**
     * Handle the support ticket "created" event.
     *
     * @return void
     */
    public function created(SupportTicket $supportTicket)
    {
        $supportTicket->refresh();
        $supportTicket->notify(new SupportTicketChange($supportTicket));
    }

    /**
     * Handle the support ticket "updated" event.
     *
     * @return void
     */
    public function updated(SupportTicket $supportTicket)
    {
        $supportTicket->refresh();
        $supportTicket->notify(new SupportTicketChange($supportTicket));
    }

    /**
     * Handle the support ticket "deleted" event.
     *
     * @return void
     */
    public function deleted(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Handle the support ticket "restored" event.
     *
     * @return void
     */
    public function restored(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Handle the support ticket "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SupportTicket $supportTicket)
    {
        //
    }
}

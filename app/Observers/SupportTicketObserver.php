<?php

namespace App\Observers;

use App\SupportTicket;
use App\Notifications\SupportTicketChange;

class SupportTicketObserver
{
    /**
     * Handle the support ticket "created" event.
     *
     * @param  \App\SupportTicket  $supportTicket
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
     * @param  \App\SupportTicket  $supportTicket
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
     * @param  \App\SupportTicket  $supportTicket
     * @return void
     */
    public function deleted(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Handle the support ticket "restored" event.
     *
     * @param  \App\SupportTicket  $supportTicket
     * @return void
     */
    public function restored(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Handle the support ticket "force deleted" event.
     *
     * @param  \App\SupportTicket  $supportTicket
     * @return void
     */
    public function forceDeleted(SupportTicket $supportTicket)
    {
        //
    }
}

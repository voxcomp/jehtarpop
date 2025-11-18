<?php

namespace App\Observers;

use App\Models\SupportTicketNote;
use App\Notifications\SupportTicketNoteChange;

class SupportTicketNoteObserver
{
    /**
     * Handle the support ticket note "created" event.
     */
    public function created(SupportTicketNote $supportTicketNote): void
    {
        $supportTicketNote->refresh();
        $supportTicketNote->notify(new SupportTicketNoteChange($supportTicketNote));
    }

    /**
     * Handle the support ticket note "updated" event.
     */
    public function updated(SupportTicketNote $supportTicketNote): void
    {
        //
    }

    /**
     * Handle the support ticket note "deleted" event.
     */
    public function deleted(SupportTicketNote $supportTicketNote): void
    {
        //
    }

    /**
     * Handle the support ticket note "restored" event.
     */
    public function restored(SupportTicketNote $supportTicketNote): void
    {
        //
    }

    /**
     * Handle the support ticket note "force deleted" event.
     */
    public function forceDeleted(SupportTicketNote $supportTicketNote): void
    {
        //
    }
}

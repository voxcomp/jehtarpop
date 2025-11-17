<?php

namespace App\Observers;

use App\Models\SupportTicketNote;
use App\Notifications\SupportTicketNoteChange;

class SupportTicketNoteObserver
{
    /**
     * Handle the support ticket note "created" event.
     *
     * @return void
     */
    public function created(SupportTicketNote $supportTicketNote)
    {
        $supportTicketNote->refresh();
        $supportTicketNote->notify(new SupportTicketNoteChange($supportTicketNote));
    }

    /**
     * Handle the support ticket note "updated" event.
     *
     * @return void
     */
    public function updated(SupportTicketNote $supportTicketNote)
    {
        //
    }

    /**
     * Handle the support ticket note "deleted" event.
     *
     * @return void
     */
    public function deleted(SupportTicketNote $supportTicketNote)
    {
        //
    }

    /**
     * Handle the support ticket note "restored" event.
     *
     * @return void
     */
    public function restored(SupportTicketNote $supportTicketNote)
    {
        //
    }

    /**
     * Handle the support ticket note "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SupportTicketNote $supportTicketNote)
    {
        //
    }
}

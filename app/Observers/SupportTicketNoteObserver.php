<?php

namespace App\Observers;

use App\SupportTicketNote;
use App\Notifications\SupportTicketNoteChange;

class SupportTicketNoteObserver
{
    /**
     * Handle the support ticket note "created" event.
     *
     * @param  \App\SupportTicketNote  $supportTicketNote
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
     * @param  \App\SupportTicketNote  $supportTicketNote
     * @return void
     */
    public function updated(SupportTicketNote $supportTicketNote)
    {
        //
    }

    /**
     * Handle the support ticket note "deleted" event.
     *
     * @param  \App\SupportTicketNote  $supportTicketNote
     * @return void
     */
    public function deleted(SupportTicketNote $supportTicketNote)
    {
        //
    }

    /**
     * Handle the support ticket note "restored" event.
     *
     * @param  \App\SupportTicketNote  $supportTicketNote
     * @return void
     */
    public function restored(SupportTicketNote $supportTicketNote)
    {
        //
    }

    /**
     * Handle the support ticket note "force deleted" event.
     *
     * @param  \App\SupportTicketNote  $supportTicketNote
     * @return void
     */
    public function forceDeleted(SupportTicketNote $supportTicketNote)
    {
        //
    }
}

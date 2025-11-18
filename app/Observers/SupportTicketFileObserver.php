<?php

namespace App\Observers;

use App\Models\SupportTicketFile;
use App\Notifications\SupportTicketFileChange;

class SupportTicketFileObserver
{
    /**
     * Handle the support ticket file "created" event.
     */
    public function created(SupportTicketFile $supportTicketFile): void
    {
        $supportTicketFile->refresh();
        $supportTicketFile->notify(new SupportTicketFileChange($supportTicketFile));
    }

    /**
     * Handle the support ticket file "updated" event.
     */
    public function updated(SupportTicketFile $supportTicketFile): void
    {
        //
    }

    /**
     * Handle the support ticket file "deleted" event.
     */
    public function deleted(SupportTicketFile $supportTicketFile): void
    {
        //
    }

    /**
     * Handle the support ticket file "restored" event.
     */
    public function restored(SupportTicketFile $supportTicketFile): void
    {
        //
    }

    /**
     * Handle the support ticket file "force deleted" event.
     */
    public function forceDeleted(SupportTicketFile $supportTicketFile): void
    {
        //
    }
}

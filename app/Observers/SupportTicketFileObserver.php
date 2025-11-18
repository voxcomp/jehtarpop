<?php

namespace App\Observers;

use App\Models\SupportTicketFile;
use App\Notifications\SupportTicketFileChange;

class SupportTicketFileObserver
{
    /**
     * Handle the support ticket file "created" event.
     *
     * @return void
     */
    public function created(SupportTicketFile $supportTicketFile): void
    {
        $supportTicketFile->refresh();
        $supportTicketFile->notify(new SupportTicketFileChange($supportTicketFile));
    }

    /**
     * Handle the support ticket file "updated" event.
     *
     * @return void
     */
    public function updated(SupportTicketFile $supportTicketFile): void
    {
        //
    }

    /**
     * Handle the support ticket file "deleted" event.
     *
     * @return void
     */
    public function deleted(SupportTicketFile $supportTicketFile): void
    {
        //
    }

    /**
     * Handle the support ticket file "restored" event.
     *
     * @return void
     */
    public function restored(SupportTicketFile $supportTicketFile): void
    {
        //
    }

    /**
     * Handle the support ticket file "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SupportTicketFile $supportTicketFile): void
    {
        //
    }
}

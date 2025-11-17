<?php

namespace App\Observers;

use App\Notifications\SupportTicketFileChange;
use App\Models\SupportTicketFile;

class SupportTicketFileObserver
{
    /**
     * Handle the support ticket file "created" event.
     *
     * @return void
     */
    public function created(SupportTicketFile $supportTicketFile)
    {
        $supportTicketFile->refresh();
        $supportTicketFile->notify(new SupportTicketFileChange($supportTicketFile));
    }

    /**
     * Handle the support ticket file "updated" event.
     *
     * @return void
     */
    public function updated(SupportTicketFile $supportTicketFile)
    {
        //
    }

    /**
     * Handle the support ticket file "deleted" event.
     *
     * @return void
     */
    public function deleted(SupportTicketFile $supportTicketFile)
    {
        //
    }

    /**
     * Handle the support ticket file "restored" event.
     *
     * @return void
     */
    public function restored(SupportTicketFile $supportTicketFile)
    {
        //
    }

    /**
     * Handle the support ticket file "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SupportTicketFile $supportTicketFile)
    {
        //
    }
}

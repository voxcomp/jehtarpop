<?php

namespace App\Observers;

use App\SupportTicketFile;
use App\Notifications\SupportTicketFileChange;

class SupportTicketFileObserver
{
    /**
     * Handle the support ticket file "created" event.
     *
     * @param  \App\SupportTicketFile  $supportTicketFile
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
     * @param  \App\SupportTicketFile  $supportTicketFile
     * @return void
     */
    public function updated(SupportTicketFile $supportTicketFile)
    {
        //
    }

    /**
     * Handle the support ticket file "deleted" event.
     *
     * @param  \App\SupportTicketFile  $supportTicketFile
     * @return void
     */
    public function deleted(SupportTicketFile $supportTicketFile)
    {
        //
    }

    /**
     * Handle the support ticket file "restored" event.
     *
     * @param  \App\SupportTicketFile  $supportTicketFile
     * @return void
     */
    public function restored(SupportTicketFile $supportTicketFile)
    {
        //
    }

    /**
     * Handle the support ticket file "force deleted" event.
     *
     * @param  \App\SupportTicketFile  $supportTicketFile
     * @return void
     */
    public function forceDeleted(SupportTicketFile $supportTicketFile)
    {
        //
    }
}

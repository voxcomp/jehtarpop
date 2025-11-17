<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\SupportTicket;
use App\SupportTicketNote;
use App\SupportTicketFile;
use App\Observers\SupportTicketObserver;
use App\Observers\SupportTicketFileObserver;
use App\Observers\SupportTicketNoteObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SupportTicket::observe(SupportTicketObserver::class);
        SupportTicketNote::observe(SupportTicketNoteObserver::class);
        SupportTicketFile::observe(SupportTicketFileObserver::class);
    }
}

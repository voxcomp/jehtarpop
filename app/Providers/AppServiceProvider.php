<?php

namespace App\Providers;

use App\Observers\SupportTicketFileObserver;
use App\Observers\SupportTicketNoteObserver;
use App\Observers\SupportTicketObserver;
use App\SupportTicket;
use App\SupportTicketFile;
use App\SupportTicketNote;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
    }
}

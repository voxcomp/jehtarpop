<?php

namespace App\Providers;

use App\Observers\SupportTicketFileObserver;
use App\Observers\SupportTicketNoteObserver;
use App\Observers\SupportTicketObserver;
use App\SupportTicket;
use App\SupportTicketFile;
use App\SupportTicketNote;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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

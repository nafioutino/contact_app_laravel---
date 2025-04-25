<?php

namespace App\Listeners;

use App\Events\ContactDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactDeletedNotification;

class ContactDeletedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactDeletedEvent $event): void
    {
        $user = Auth::user();
        $user->notify(new ContactDeletedNotification($event->contact));
    }
}
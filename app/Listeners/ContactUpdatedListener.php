<?php

namespace App\Listeners;

use App\Events\ContactUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactUpdatedNotification;

class ContactUpdatedListener
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
    public function handle(ContactUpdatedEvent $event): void
    {
        $user = Auth::user();
        $user->notify(new ContactUpdatedNotification($event->contact));
    }
}
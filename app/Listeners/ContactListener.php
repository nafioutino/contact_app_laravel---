<?php

namespace App\Listeners;

use App\Events\ContactEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactCreatedNotification;


class ContactListener
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
    public function handle(ContactEvent $event): void
    {
        $user = Auth::user();
        $user->notify(new ContactCreatedNotification($event->contact));
    }
}

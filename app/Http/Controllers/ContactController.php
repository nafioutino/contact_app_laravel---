<?php

namespace App\Http\Controllers;

use App\Models\Contact;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Notifications\Notification;
use App\Events\ContactEvent;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index(): Response
    {
        return Inertia::render('Contacts/Index', [
            'contacts' => Contact::orderBy('last_name')
                ->orderBy('first_name')
                ->get()
                ->map(function ($contact) {
                    return [
                        'id' => $contact->id,
                        'first_name' => $contact->first_name,
                        'last_name' => $contact->last_name,
                        'full_name' => $contact->full_name,
                        'email' => $contact->email,
                        'phone' => $contact->phone,
                        'country' => $contact->country,
                    ];
                }),
        ]);
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create(): Response
    {
        return Inertia::render('Contacts/Create');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:150',
            'city' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'profile_image' => 'nullable|string',
        ]);

        // Contact::create($validated);
        $contact = Contact::create($validated);
        event(new ContactEvent($contact));

        return Redirect::route('contacts.index')->with('success', 'Contact créé avec succès.');
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact): Response
    {
        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(Contact $contact): Response
    {
        return Inertia::render('Contacts/Edit', [
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:150',
            'city' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'profile_image' => 'nullable|string',
        ]);

        $contact->update($validated);

        return Redirect::route('contacts.index')->with('success', 'Contact mis à jour avec succès.');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return Redirect::route('contacts.index')->with('success', 'Contact supprimé avec succès.');
    }
}

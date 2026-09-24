<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContactController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Contact Messages
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $contacts = Contact::query()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {

                    $search = trim(
                        $request->search
                    );

                    $query->where(
                        function ($query) use ($search) {

                            $query
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'phone',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'subject',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'message',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->when(
                $request->filled('status'),
                function ($query) use ($request) {

                    if (
                        in_array(
                            $request->status,
                            [
                                'new',
                                'read',
                                'resolved',
                            ],
                            true
                        )
                    ) {

                        $query->where(
                            'status',
                            $request->status
                        );
                    }
                }
            )
            ->when(
                $request->filled('inquiry_type'),
                function ($query) use ($request) {

                    if (
                        in_array(
                            $request->inquiry_type,
                            [
                                'general',
                                'donor_support',
                                'beneficiary_support',
                                'account_support',
                                'technical',
                                'feedback',
                                'other',
                            ],
                            true
                        )
                    ) {

                        $query->where(
                            'inquiry_type',
                            $request->inquiry_type
                        );
                    }
                }
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalContacts =
            Contact::count();


        $newContacts =
            Contact::where(
                'status',
                'new'
            )->count();


        $readContacts =
            Contact::where(
                'status',
                'read'
            )->count();


        $resolvedContacts =
            Contact::where(
                'status',
                'resolved'
            )->count();


        return view(
            'pages.admins.contacts.index',
            compact(
                'contacts',
                'totalContacts',
                'newContacts',
                'readContacts',
                'resolvedContacts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | View Contact Message
    |--------------------------------------------------------------------------
    */

    public function show(Contact $contact): View
    {
        if ($contact->status === 'new') {

            $contact->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Mark Related Notification As Read
        |--------------------------------------------------------------------------
        */

        auth()->user()
            ->unreadNotifications()
            ->get()
            ->filter(
                function ($notification) use ($contact) {

                    return
                        ($notification->data['type'] ?? null)
                            === 'contact_message'
                        &&
                        (int) (
                            $notification->data['contact_id']
                            ?? 0
                        )
                            === (int) $contact->id;
                }
            )
            ->each(
                function ($notification) {

                    $notification->markAsRead();
                }
            );


        $contact->refresh();


        return view(
            'pages.admins.contacts.show',
            compact('contact')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Contact As Resolved
    |--------------------------------------------------------------------------
    */

    public function resolve(Contact $contact): RedirectResponse
    {
        $contact->update([
            'status' => 'resolved',

            'read_at' =>
                $contact->read_at
                    ?? now(),
        ]);


        return redirect()
            ->route('admin.contacts.show', $contact)
            ->with(
                'success',
                'Contact message marked as resolved successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Contact Message
    |--------------------------------------------------------------------------
    */

    public function destroy(Contact $contact): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Remove Related Notifications
        |--------------------------------------------------------------------------
        */

        auth()->user()
            ->notifications()
            ->get()
            ->filter(
                function ($notification) use ($contact) {

                    return
                        ($notification->data['type'] ?? null)
                            === 'contact_message'
                        &&
                        (int) (
                            $notification->data['contact_id']
                            ?? 0
                        )
                            === (int) $contact->id;
                }
            )
            ->each(
                function ($notification) {

                    $notification->delete();
                }
            );


        $contact->delete();


        return redirect()
            ->route('admin.contacts.index')
            ->with(
                'success',
                'Contact message deleted successfully.'
            );
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class AdminContactController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Contact Messages Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Contact::query();


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'phone',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'subject',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'message',
                    'like',
                    '%' . $search . '%'
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $request->validate([
                'status' => [
                    'in:new,read,resolved',
                ],
            ]);

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Inquiry Type Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('inquiry_type')) {

            $request->validate([
                'inquiry_type' => [
                    'in:general,donor_support,beneficiary_support,account_support,technical,feedback,other',
                ],
            ]);

            $query->where(
                'inquiry_type',
                $request->inquiry_type
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Latest Messages First
        |--------------------------------------------------------------------------
        */

        $contacts = $query
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalContacts = Contact::count();

        $newContacts = Contact::where(
            'status',
            'new'
        )->count();

        $readContacts = Contact::where(
            'status',
            'read'
        )->count();

        $resolvedContacts = Contact::where(
            'status',
            'resolved'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.admin.contact.index',
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
    | Show Contact Message
    |--------------------------------------------------------------------------
    */

    public function show(Contact $contact)
    {
        /*
        |--------------------------------------------------------------------------
        | Mark Contact Message As Read
        |--------------------------------------------------------------------------
        */

        if ($contact->status === 'new') {

            $contact->update([
                'status' => 'read',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Mark Related Notification As Read
        |--------------------------------------------------------------------------
        */

        $notification = auth()
            ->user()
            ->unreadNotifications()
            ->get()
            ->first(function ($notification) use ($contact) {

                $contactId =
                    $notification->data['contact_id']
                    ?? null;

                return $contactId
                    &&
                    (int) $contactId
                    ===
                    (int) $contact->id;

            });


        if ($notification) {

            $notification->markAsRead();

        }


        return view(
            'pages.admin.contact.show',
            compact('contact')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Contact Status
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        Request $request,
        Contact $contact
    ) {
        $validated = $request->validate(
            [
                'status' => [
                    'required',
                    'in:new,read,resolved',
                ],
            ],
            [
                'status.required' =>
                    'Please select a status.',

                'status.in' =>
                    'Please select a valid status.',
            ]
        );


        $contact->update([
            'status' => $validated['status'],
        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Contact message status updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Single Contact Message
    |--------------------------------------------------------------------------
    */

    public function destroy(Contact $contact)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Related Notifications
        |--------------------------------------------------------------------------
        */

        $this->deleteContactNotifications([
            $contact->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Delete Contact
        |--------------------------------------------------------------------------
        */

        $contact->delete();


        return redirect()
            ->route('admin.contact.index')
            ->with(
                'success',
                'Contact message deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Selected Contact Messages
    |--------------------------------------------------------------------------
    */

    public function destroySelected(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Selected IDs
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'ids' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'ids.*' => [
                    'required',
                    'integer',
                    'distinct',
                    'exists:contacts,id',
                ],
            ],
            [
                'ids.required' =>
                    'Please select at least one contact message.',

                'ids.array' =>
                    'Invalid contact selection.',

                'ids.min' =>
                    'Please select at least one contact message.',

                'ids.*.exists' =>
                    'One or more selected contact messages no longer exist.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Normalize Contact IDs
        |--------------------------------------------------------------------------
        */

        $contactIds = collect(
            $validated['ids']
        )
            ->map(
                fn ($id) => (int) $id
            )
            ->unique()
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Delete Related Notifications
        |--------------------------------------------------------------------------
        */

        $this->deleteContactNotifications(
            $contactIds
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Selected Contacts
        |--------------------------------------------------------------------------
        */

        $deletedCount = Contact::whereIn(
            'id',
            $contactIds
        )->delete();


        return redirect()
            ->route('admin.contact.index')
            ->with(
                'success',
                $deletedCount .
                ' contact message(s) deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Contact Notifications
    |--------------------------------------------------------------------------
    |
    | Removes database notifications associated with deleted contact
    | messages so the notification dropdown does not contain broken links.
    |
    */

    private function deleteContactNotifications(
        array $contactIds
    ): void {
        $contactIds = collect(
            $contactIds
        )
            ->map(
                fn ($id) => (int) $id
            );


        DatabaseNotification::query()
            ->get()
            ->filter(function ($notification) use ($contactIds) {

                $contactId =
                    $notification->data['contact_id']
                    ?? null;


                if (!$contactId) {
                    return false;
                }


                return $contactIds->contains(
                    (int) $contactId
                );

            })
            ->each(function ($notification) {

                $notification->delete();

            });
    }
}
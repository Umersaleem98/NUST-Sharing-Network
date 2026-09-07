<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('index');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Contact Message
    |--------------------------------------------------------------------------
    */

    public function contactStore(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:30',
                ],

                'user_type' => [
                    'nullable',
                    'in:donor,beneficiary,visitor,other',
                ],

                'subject' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'inquiry_type' => [
                    'required',
                    'in:general,donor_support,beneficiary_support,account_support,technical,feedback,other',
                ],

                'message' => [
                    'required',
                    'string',
                    'min:10',
                    'max:3000',
                ],

                'privacy' => [
                    'required',
                    'accepted',
                ],
            ],
            [
                'name.required' =>
                    'Please enter your full name.',

                'email.required' =>
                    'Please enter your email address.',

                'email.email' =>
                    'Please enter a valid email address.',

                'subject.required' =>
                    'Please enter the subject of your inquiry.',

                'inquiry_type.required' =>
                    'Please select an inquiry type.',

                'inquiry_type.in' =>
                    'Please select a valid inquiry type.',

                'message.required' =>
                    'Please enter your message.',

                'message.min' =>
                    'Your message must contain at least 10 characters.',

                'message.max' =>
                    'Your message may not exceed 3000 characters.',

                'privacy.required' =>
                    'Please accept the privacy acknowledgement.',

                'privacy.accepted' =>
                    'Please accept the privacy acknowledgement.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Save Contact Message
        |--------------------------------------------------------------------------
        */

        $contact = Contact::create([
            'name' =>
                trim($validated['name']),

            'email' =>
                strtolower(trim($validated['email'])),

            'phone' =>
                !empty($validated['phone'])
                    ? trim($validated['phone'])
                    : null,

            'user_type' =>
                $validated['user_type'] ?? null,

            'subject' =>
                trim($validated['subject']),

            'inquiry_type' =>
                $validated['inquiry_type'],

            'message' =>
                trim($validated['message']),

            'privacy' =>
                true,

            'status' =>
                'new',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Notify All Admin Users
        |--------------------------------------------------------------------------
        */

        $admins = User::where(
            'role',
            'admin'
        )->get();


        if ($admins->isNotEmpty()) {

            Notification::send(
                $admins,
                new ContactMessageNotification($contact)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Return Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->back()
            ->with(
                'success',
                'Your message has been received successfully. Our team will review your inquiry and get back to you as soon as possible.'
            );
    }
}
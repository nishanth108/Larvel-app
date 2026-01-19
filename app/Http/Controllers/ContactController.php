<?php

namespace App\Http\Controllers;

use App\Events\ContactNotification;
use App\Http\Requests\StoreContactReqest;
use App\Models\Contact;
use App\Models\User;
use App\Services\Contracts\EmailServiceInterface;
use Illuminate\Validation\ValidationException;
use App\Notifications\ContactSubmittedNotification;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected $emailService;

    public function __construct(EmailServiceInterface $emailService)
    {
        $this->emailService = $emailService;
    }

    public function ContactStore(StoreContactReqest $request)
    {
        try {
            $this->emailService->sendMail($request->validated());
            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                event(new ContactNotification(
                    $admin->id,
                    'New contact form submission'
                ));
            }
            return response()->json([
                'status'  => true,
                'message' => 'Your message has been sent successfully'
            ]);
        } catch (ValidationException $e) {
            Log::info("error");
            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function message(Contact $contact)
    {
        return response()->json([
            'message' => $contact->message,
            'name' => $contact->name,
            'email' => $contact->email,
        ]);
    }
}

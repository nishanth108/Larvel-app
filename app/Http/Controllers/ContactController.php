<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactReqest;
use App\Models\Contact;
use App\Services\Contracts\EmailServiceInterface;
use Illuminate\Validation\ValidationException;

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
            return response()->json([
                'status'  => true,
                'message' => 'Your message has been sent successfully'
            ]);
        } catch (ValidationException $e) {

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

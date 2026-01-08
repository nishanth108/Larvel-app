<?php

namespace App\Services;

use App\Jobs\SendEmail;
use App\Models\Contact;
use App\Services\Contracts\EmailServiceInterface;
// use Illuminate\Support\Facades\Hash

class EmailService implements EmailServiceInterface
{

    public function sendMail(array $data)
    {
        Contact::create($data);
        SendEmail::dispatch();

        return true;
    }
}

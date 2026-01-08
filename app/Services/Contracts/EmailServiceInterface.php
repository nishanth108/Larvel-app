<?php

namespace App\Services\Contracts;

use App\Models\User;
use Arr;

interface EmailServiceInterface
{
    public function sendMail(array $data);
}

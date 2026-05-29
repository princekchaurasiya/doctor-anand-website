<?php

namespace App\Contracts\Services;

use App\Models\ContactSubmission;

interface ContactSubmissionServiceInterface
{
    /**
     * @param  array{name: string, phone: string, email?: string|null, message?: string|null}  $payload
     */
    public function store(array $payload): ContactSubmission;
}

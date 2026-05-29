<?php

namespace App\Services;

use App\Contracts\Services\ContactSubmissionServiceInterface;
use App\Models\ContactSubmission;

class ContactSubmissionService implements ContactSubmissionServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function store(array $payload): ContactSubmission
    {
        return ContactSubmission::query()->create([
            'name' => $payload['name'],
            'phone' => $payload['phone'],
            'email' => $payload['email'] ?? null,
            'message' => $payload['message'] ?? null,
        ]);
    }
}

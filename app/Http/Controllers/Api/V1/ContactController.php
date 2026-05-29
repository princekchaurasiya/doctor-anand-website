<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\ContactSubmissionServiceInterface;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ContactStoreRequest;
use Illuminate\Http\JsonResponse;

class ContactController extends ApiController
{
    public function store(
        ContactStoreRequest $request,
        ContactSubmissionServiceInterface $contacts
    ): JsonResponse {
        $submission = $contacts->store($request->validated());

        return $this->created([
            'id' => $submission->id,
            'created_at' => $submission->created_at?->toIso8601String(),
        ]);
    }
}

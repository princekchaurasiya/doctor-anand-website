<?php

namespace App\Http\Controllers\Web;

use App\Contracts\Services\ContactSubmissionServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactStoreRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactPageController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Contact');
    }

    public function store(ContactStoreRequest $request, ContactSubmissionServiceInterface $contacts): RedirectResponse
    {
        $contacts->store($request->validated());

        return redirect()
            ->route('contact.show')
            ->with('status', 'Thank you — we will call you back shortly.');
    }
}

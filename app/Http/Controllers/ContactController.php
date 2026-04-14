<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $phone = preg_replace('/\D/', '', (string) $request->input('phone', ''));
        $request->merge(['phone' => $phone]);

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'regex:/^05[0-9]{8}$/'],
                'message' => ['required', 'string'],
            ],
            [
                'phone.regex' => __('site.contact.form.phone_invalid'),
            ]
        );

        ContactMessage::create($validated);

        $message = __('site.contact.success');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ]);
        }

        return back()
            ->with('success', $message)
            ->withFragment('contact');
    }
}

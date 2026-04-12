<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        ContactMessage::create($validated);

        $message = 'تم استلام رسالتك بنجاح. سيتواصل معك فريقنا قريبًا.';

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

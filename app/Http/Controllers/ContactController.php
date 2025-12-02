<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact', [
            'data' => config('website')
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Save to JSON file
        $contact = [
            'id' => uniqid(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        $this->saveContact($contact);

        return back()->with('success', 'تم إرسال رسالتك بنجاح!');
    }

    private function saveContact($contact)
    {
        $file = storage_path('app/contacts.json');
        
        $contacts = [];
        if (file_exists($file)) {
            $data = file_get_contents($file);
            $contacts = json_decode($data, true) ?? [];
        }

        $contacts[$contact['id']] = $contact;
        
        file_put_contents($file, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

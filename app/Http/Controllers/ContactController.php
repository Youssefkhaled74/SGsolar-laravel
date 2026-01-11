<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CrmLeadIntakeService;

class ContactController extends Controller
{
    protected CrmLeadIntakeService $intake;

    public function __construct(CrmLeadIntakeService $intake)
    {
        $this->intake = $intake;
    }

    public function index()
    {
        return view('pages.contact', [
            'data' => config('website')
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Create lead in CRM
        $this->intake->createFromContactUs($validated);

        return back()->with('success', 'تم إرسال رسالتك بنجاح!');
    }
}

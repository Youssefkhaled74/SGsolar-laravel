<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Static admin credentials
    private $adminEmail = 'admin@sgsolar.com';
    private $adminPassword = 'Admin@123';

    public function showLogin()
    {
        // Check if already logged in
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === $this->adminEmail && $password === $this->adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'بيانات الدخول غير صحيحة');
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $contacts = $this->getContacts();
        
        return view('admin.dashboard', compact('contacts'));
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function updateStatus(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $status = $request->input('status');
        $contacts = $this->getContacts();

        if (isset($contacts[$id])) {
            $contacts[$id]['status'] = $status;
            $this->saveContacts($contacts);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Contact not found'], 404);
    }

    public function deleteContact($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $contacts = $this->getContacts();
        
        if (isset($contacts[$id])) {
            unset($contacts[$id]);
            $this->saveContacts($contacts);
        }

        return redirect()->route('admin.dashboard')->with('success', 'تم حذف الرسالة بنجاح');
    }

    public function saveDownloadRequest(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string',
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'subject' => 'nullable|string',
                'product' => 'nullable|string',
                'datasheet' => 'nullable|string',
            ]);

            $contacts = $this->getContacts();
            
            $newContact = [
                'name' => $validated['name']??'',
                'email' => $validated['email']??'',
                'phone' => $validated['phone']??'',
                'subject' => $validated['subject']??'',
                'message' => 'طلب تحميل كتالوج: ' . ($validated['product']??'') . ' (' . ($validated['datasheet']??'') . ')',
                'date' => now()->format('Y-m-d H:i:s'),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'status' => 'new',
                'type' => 'download_request'
            ];

            $contacts[] = $newContact;
            $this->saveContacts($contacts);

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ البيانات بنجاح'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى ملء جميع الحقول المطلوبة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حفظ البيانات: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getContacts()
    {
        $file = storage_path('app/contacts.json');
        
        if (file_exists($file)) {
            $data = file_get_contents($file);
            return json_decode($data, true) ?? [];
        }
        
        return [];
    }

    private function saveContacts($contacts)
    {
        $file = storage_path('app/contacts.json');
        file_put_contents($file, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

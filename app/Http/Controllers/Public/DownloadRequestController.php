<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CrmLeadIntakeService;

class DownloadRequestController extends Controller
{
    protected CrmLeadIntakeService $intake;

    public function __construct(CrmLeadIntakeService $intake)
    {
        $this->intake = $intake;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string',
            'datasheet' => 'nullable|string',
            'product_name' => 'nullable|string',
            'product' => 'nullable|string',
        ]);

        try {
            $this->intake->createFromProductPageDownload($validated);

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ البيانات بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حفظ البيانات'
            ], 500);
        }
    }
}

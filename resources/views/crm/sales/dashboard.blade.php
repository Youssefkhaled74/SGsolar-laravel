@extends('crm.layouts.sales')

@section('title', 'Sales Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded shadow-sm">
                <div class="text-sm text-gray-500">My Leads</div>
                <div class="mt-2 text-2xl font-semibold">—</div>
            </div>
            <div class="bg-white p-4 rounded shadow-sm">
                <div class="text-sm text-gray-500">Followups Today</div>
                <div class="mt-2 text-2xl font-semibold">—</div>
            </div>
            <div class="bg-white p-4 rounded shadow-sm">
                <div class="text-sm text-gray-500">Overdue Followups</div>
                <div class="mt-2 text-2xl font-semibold text-red-600">—</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <section class="bg-white p-4 rounded shadow-sm">
                <h3 class="text-sm font-semibold text-gray-700">Today Followups</h3>
                <div class="mt-3 text-sm text-gray-500">
                    <ul class="space-y-2">
                        <li class="p-3 border rounded">— Followup item placeholder</li>
                        <li class="p-3 border rounded">— Followup item placeholder</li>
                    </ul>
                </div>
            </section>

            <section class="bg-white p-4 rounded shadow-sm">
                <h3 class="text-sm font-semibold text-gray-700">My Recent Leads</h3>
                <div class="mt-3 text-sm text-gray-500">
                    <div class="w-full overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead>
                                <tr class="text-gray-500">
                                    <th class="py-2">Name</th>
                                    <th class="py-2">Phone</th>
                                    <th class="py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t">
                                    <td class="py-3">—</td>
                                    <td class="py-3">—</td>
                                    <td class="py-3">—</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

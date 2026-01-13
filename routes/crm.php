<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crm\Admin\DashboardController as CrmAdminDashboardController;
use App\Http\Controllers\Crm\Sales\DashboardController as CrmSalesDashboardController;

// CRM entry route: redirect users based on role or to login
Route::get('/crm', function () {
    $user = auth()->user();
    if (! $user) {
        if (Route::has('crm.login')) {
            return redirect()->route('crm.login');
        }
        return redirect('/');
    }

    $roleName = is_string($user->role) ? $user->role : ($user->role->name ?? null);
    if ($roleName === 'admin') {
        return redirect()->route('crm.admin.dashboard');
    }
    if ($roleName === 'sales') {
        return redirect()->route('crm.sales.dashboard');
    }

    return response()->view('crm.errors.403', [], 403);
})->name('crm.home');

Route::middleware(['web', 'crm.auth', 'crm.access', 'crm.role'])->group(function () {

    Route::get('/crm/admin', [CrmAdminDashboardController::class, 'index'])
        ->name('crm.admin.dashboard');

    Route::get('/crm/sales', [CrmSalesDashboardController::class, 'index'])
        ->name('crm.sales.dashboard');

    // Sales area routes
    Route::get('/crm/sales/leads', [
            App\Http\Controllers\Crm\Sales\LeadController::class,
            'index'
    ])->name('crm.sales.leads.index');

    Route::get('/crm/sales/leads/{lead}', [
            App\Http\Controllers\Crm\Sales\LeadController::class,
            'show'
    ])->name('crm.sales.leads.show');

    Route::post('/crm/sales/leads/{lead}/comments', [
            App\Http\Controllers\Crm\Sales\LeadController::class,
            'storeComment'
    ])->name('crm.sales.leads.comments.store');

    Route::post('/crm/sales/leads/{lead}/actions', [
            App\Http\Controllers\Crm\Sales\LeadController::class,
            'storeAction'
    ])->name('crm.sales.leads.actions.store');

    Route::post('/crm/sales/leads/{lead}/followups', [
            App\Http\Controllers\Crm\Sales\LeadController::class,
            'storeFollowup'
    ])->name('crm.sales.leads.followups.store');

    Route::patch('/crm/sales/followups/{followup}/done', [
            App\Http\Controllers\Crm\Sales\LeadController::class,
            'markFollowupDone'
    ])->name('crm.sales.followups.done');

    Route::get('/crm/sales/followups/today', [
            App\Http\Controllers\Crm\Sales\LeadController::class,
            'followupsToday'
    ])->name('crm.sales.followups.today');

    // Admin Leads (UI only)
    Route::get('/crm/admin/leads', [
            App\Http\Controllers\Crm\Admin\LeadController::class,
            'index'
    ])->name('crm.admin.leads.index');

    Route::get('/crm/admin/leads/{lead}', [
            App\Http\Controllers\Crm\Admin\LeadController::class,
            'show'
    ])->name('crm.admin.leads.show');

    // Lead actions
    Route::patch('/crm/admin/leads/{lead}/assign', [
        App\Http\Controllers\Crm\Admin\LeadController::class,
        'assign'
    ])->name('crm.admin.leads.assign');

    Route::patch('/crm/admin/leads/{lead}/status', [
        App\Http\Controllers\Crm\Admin\LeadController::class,
        'status'
    ])->name('crm.admin.leads.status');

    Route::post('/crm/admin/leads/{lead}/comments', [
        App\Http\Controllers\Crm\Admin\LeadController::class,
        'storeComment'
    ])->name('crm.admin.leads.comments.store');

    Route::post('/crm/admin/leads/{lead}/actions', [
        App\Http\Controllers\Crm\Admin\LeadController::class,
        'storeAction'
    ])->name('crm.admin.leads.actions.store');

    Route::post('/crm/admin/leads/{lead}/followups', [
        App\Http\Controllers\Crm\Admin\LeadController::class,
        'storeFollowup'
    ])->name('crm.admin.leads.followups.store');

    Route::patch('/crm/admin/followups/{followup}/done', [
            App\Http\Controllers\Crm\Admin\LeadController::class,
            'markFollowupDone'
    ])->name('crm.admin.followups.done');

    // Admin Users & Settings (UI only placeholders)
    Route::get('/crm/admin/users', [
            App\Http\Controllers\Crm\Admin\UserController::class,
            'index'
    ])->name('crm.admin.users.index');

        Route::delete('/crm/admin/users/{user}', [
            App\Http\Controllers\Crm\Admin\UserController::class,
            'destroy'
        ])->name('crm.admin.users.destroy');
    
            Route::patch('/crm/admin/users/{user}', [
                App\Http\Controllers\Crm\Admin\UserController::class,
                'update'
            ])->name('crm.admin.users.update');

    // Create new sales user
    Route::post('/crm/admin/users', [
        App\Http\Controllers\Crm\Admin\UserController::class,
        'store'
    ])->name('crm.admin.users.store');

    // Toggle active/inactive for a user (only sales users allowed)
    Route::patch('/crm/admin/users/{user}/toggle', [
        App\Http\Controllers\Crm\Admin\UserController::class,
        'toggle'
    ])->name('crm.admin.users.toggle');

    Route::get('/crm/admin/settings', [
            App\Http\Controllers\Crm\Admin\SettingsController::class,
            'index'
    ])->name('crm.admin.settings.index');

    // Settings - Statuses
    Route::post('/crm/admin/settings/statuses', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'storeStatus'
    ])->name('crm.admin.settings.statuses.store');

    Route::patch('/crm/admin/settings/statuses/{status}', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'updateStatus'
    ])->name('crm.admin.settings.statuses.update');

    Route::patch('/crm/admin/settings/statuses/{status}/toggle', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'toggleStatus'
    ])->name('crm.admin.settings.statuses.toggle');

    // Settings - Sources
    Route::post('/crm/admin/settings/sources', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'storeSource'
    ])->name('crm.admin.settings.sources.store');

    Route::patch('/crm/admin/settings/sources/{source}', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'updateSource'
    ])->name('crm.admin.settings.sources.update');

    Route::patch('/crm/admin/settings/sources/{source}/toggle', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'toggleSource'
    ])->name('crm.admin.settings.sources.toggle');

    // Settings - Action Types
    Route::post('/crm/admin/settings/action-types', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'storeActionType'
    ])->name('crm.admin.settings.actionTypes.store');

    Route::patch('/crm/admin/settings/action-types/{type}', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'updateActionType'
    ])->name('crm.admin.settings.actionTypes.update');

    Route::patch('/crm/admin/settings/action-types/{type}/toggle', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'toggleActionType'
    ])->name('crm.admin.settings.actionTypes.toggle');

});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crm\Admin\DashboardController as CrmAdminDashboardController;
use App\Http\Controllers\Crm\Sales\DashboardController as CrmSalesDashboardController;

Route::get('/crm/admin', [CrmAdminDashboardController::class, 'index'])
    ->name('crm.admin.dashboard')
    ->middleware(['crm.access', 'role:admin']);

Route::get('/crm/sales', [CrmSalesDashboardController::class, 'index'])
    ->name('crm.sales.dashboard')
    ->middleware(['crm.access', 'role:sales']);

// Sales area routes
Route::get('/crm/sales/leads', [
        App\Http\Controllers\Crm\Sales\LeadController::class,
        'index'
])->name('crm.sales.leads.index')
    ->middleware(['crm.access', 'role:sales']);

Route::get('/crm/sales/leads/{lead}', [
        App\Http\Controllers\Crm\Sales\LeadController::class,
        'show'
])->name('crm.sales.leads.show')
    ->middleware(['crm.access', 'role:sales']);

Route::post('/crm/sales/leads/{lead}/comments', [
        App\Http\Controllers\Crm\Sales\LeadController::class,
        'storeComment'
])->name('crm.sales.leads.comments.store')
    ->middleware(['crm.access', 'role:sales']);

Route::post('/crm/sales/leads/{lead}/actions', [
        App\Http\Controllers\Crm\Sales\LeadController::class,
        'storeAction'
])->name('crm.sales.leads.actions.store')
    ->middleware(['crm.access', 'role:sales']);

Route::post('/crm/sales/leads/{lead}/followups', [
        App\Http\Controllers\Crm\Sales\LeadController::class,
        'storeFollowup'
])->name('crm.sales.leads.followups.store')
    ->middleware(['crm.access', 'role:sales']);

Route::patch('/crm/sales/followups/{followup}/done', [
        App\Http\Controllers\Crm\Sales\LeadController::class,
        'markFollowupDone'
])->name('crm.sales.followups.done')
    ->middleware(['crm.access', 'role:sales']);

Route::get('/crm/sales/followups/today', [
        App\Http\Controllers\Crm\Sales\LeadController::class,
        'followupsToday'
])->name('crm.sales.followups.today')
    ->middleware(['crm.access', 'role:sales']);

// Admin Leads (UI only)
Route::get('/crm/admin/leads', [
        App\Http\Controllers\Crm\Admin\LeadController::class,
        'index'
])->name('crm.admin.leads.index')
    ->middleware(['crm.access', 'role:admin']);

Route::get('/crm/admin/leads/{lead}', [
        App\Http\Controllers\Crm\Admin\LeadController::class,
        'show'
])->name('crm.admin.leads.show')
    ->middleware(['crm.access', 'role:admin']);

// Lead actions
Route::patch('/crm/admin/leads/{lead}/assign', [
    App\Http\Controllers\Crm\Admin\LeadController::class,
    'assign'
])->name('crm.admin.leads.assign')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/leads/{lead}/status', [
    App\Http\Controllers\Crm\Admin\LeadController::class,
    'status'
])->name('crm.admin.leads.status')
    ->middleware(['crm.access', 'role:admin']);

Route::post('/crm/admin/leads/{lead}/comments', [
    App\Http\Controllers\Crm\Admin\LeadController::class,
    'storeComment'
])->name('crm.admin.leads.comments.store')
    ->middleware(['crm.access', 'role:admin']);

Route::post('/crm/admin/leads/{lead}/actions', [
    App\Http\Controllers\Crm\Admin\LeadController::class,
    'storeAction'
])->name('crm.admin.leads.actions.store')
    ->middleware(['crm.access', 'role:admin']);

Route::post('/crm/admin/leads/{lead}/followups', [
    App\Http\Controllers\Crm\Admin\LeadController::class,
    'storeFollowup'
])->name('crm.admin.leads.followups.store')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/followups/{followup}/done', [
    App\Http\Controllers\Crm\Admin\LeadController::class,
    'markFollowupDone'
])->name('crm.admin.followups.done')
    ->middleware(['crm.access', 'role:admin']);

// Admin Users & Settings (UI only placeholders)
Route::get('/crm/admin/users', [
        App\Http\Controllers\Crm\Admin\UserController::class,
        'index'
])->name('crm.admin.users.index')
    ->middleware(['crm.access', 'role:admin']);

// Create new sales user
Route::post('/crm/admin/users', [
    App\Http\Controllers\Crm\Admin\UserController::class,
    'store'
])->name('crm.admin.users.store')
    ->middleware(['crm.access', 'role:admin']);

// Toggle active/inactive for a user (only sales users allowed)
Route::patch('/crm/admin/users/{user}/toggle', [
    App\Http\Controllers\Crm\Admin\UserController::class,
    'toggle'
])->name('crm.admin.users.toggle')
    ->middleware(['crm.access', 'role:admin']);

Route::get('/crm/admin/settings', [
        App\Http\Controllers\Crm\Admin\SettingsController::class,
        'index'
])->name('crm.admin.settings.index')
    ->middleware(['crm.access', 'role:admin']);

// Settings - Statuses
Route::post('/crm/admin/settings/statuses', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'storeStatus'
])->name('crm.admin.settings.statuses.store')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/settings/statuses/{status}', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'updateStatus'
])->name('crm.admin.settings.statuses.update')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/settings/statuses/{status}/toggle', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'toggleStatus'
])->name('crm.admin.settings.statuses.toggle')
    ->middleware(['crm.access', 'role:admin']);

// Settings - Sources
Route::post('/crm/admin/settings/sources', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'storeSource'
])->name('crm.admin.settings.sources.store')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/settings/sources/{source}', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'updateSource'
])->name('crm.admin.settings.sources.update')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/settings/sources/{source}/toggle', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'toggleSource'
])->name('crm.admin.settings.sources.toggle')
    ->middleware(['crm.access', 'role:admin']);

// Settings - Action Types
Route::post('/crm/admin/settings/action-types', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'storeActionType'
])->name('crm.admin.settings.actionTypes.store')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/settings/action-types/{type}', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'updateActionType'
])->name('crm.admin.settings.actionTypes.update')
    ->middleware(['crm.access', 'role:admin']);

Route::patch('/crm/admin/settings/action-types/{type}/toggle', [
    App\Http\Controllers\Crm\Admin\SettingsController::class,
    'toggleActionType'
])->name('crm.admin.settings.actionTypes.toggle')
    ->middleware(['crm.access', 'role:admin']);

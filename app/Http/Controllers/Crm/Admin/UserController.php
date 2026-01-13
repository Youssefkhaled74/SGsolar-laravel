<?php

namespace App\Http\Controllers\Crm\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Lead;
use App\Http\Requests\Crm\StoreSalesUserRequest;
use App\Http\Requests\Crm\ToggleUserRequest;
use App\Http\Requests\Crm\UpdateSalesUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereHas('role', function ($q) {
            $q->where('name', 'sales');
        })->orderBy('created_at', 'desc')->get();

        return view('crm.admin.users.index', compact('users'));
    }

    public function store(StoreSalesUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $role = Role::where('name', 'sales')->first();
        if (! $role) {
            return back()->withErrors(['role' => 'Sales role not configured.']);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role_id' => $role->id,
            'is_active' => true,
        ]);

        return redirect()->route('crm.admin.users.index')->with('success', 'Sales user created.');
    }

    public function toggle(ToggleUserRequest $request, User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            abort(403, 'Cannot toggle admin accounts.');
        }

        // Only allow toggle for sales users
        if (! $user->isSales()) {
            abort(403, 'Can only toggle sales users.');
        }

        $user->is_active = ! (bool) $user->is_active;
        $user->save();

        return redirect()->route('crm.admin.users.index')->with('success', 'User status updated.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            abort(403, 'Cannot delete admin accounts.');
        }

        if (! $user->isSales()) {
            abort(403, 'Can only delete sales users.');
        }

        // Check for related leads (assigned or created)
        $hasLeads = Lead::where('assigned_to', $user->id)->exists() || Lead::where('created_by', $user->id)->exists();
        if ($hasLeads) {
            return redirect()->route('crm.admin.users.index')->with('error', 'Cannot delete user: user has leads assigned or created.');
        }

        $user->delete();

        return redirect()->route('crm.admin.users.index')->with('success', 'User deleted.');
    }

    public function update(UpdateSalesUserRequest $request, User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            abort(403, 'Cannot update admin accounts.');
        }

        if (! $user->isSales()) {
            abort(403, 'Can only update sales users.');
        }

        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? null;
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->save();

        return redirect()->route('crm.admin.users.index')->with('success', 'User updated.');
    }
}

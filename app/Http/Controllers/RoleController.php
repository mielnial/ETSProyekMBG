<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRoleRequest;
use App\Models\User;
use App\Services\RoleManagementService;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id_user')->get();

        return view('admin.users', compact('users'));
    }

    public function update(
        ChangeRoleRequest $request,
        User $user,
        RoleManagementService $service
    ): RedirectResponse {
        $data = $request->validated();

        $changed = $service->changeRole($request->user(), $user, $data['role']);

        return back()->with(
            'status',
            $changed ? 'Role diperbarui.' : 'Role tidak berubah (sudah sama).'
        );
    }
}
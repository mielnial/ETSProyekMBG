<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class RoleManagementService
{
    public function changeRole(User $actor, User $target, string $newRole): bool
    {
        // BR-04: tidak boleh ubah akun sendiri atau akun admin
        if ($actor->is($target) || $target->role === 'admin') {
            throw ValidationException::withMessages([
                'role' => 'Akun admin tidak dapat diubah di fitur ini.',
            ]);
        }

        // BR-05: role sama, tidak ada save sehingga Observer tidak terpicu
        if ($target->role === $newRole) {
            return false;
        }

        $target->role = $newRole;
        $target->save();

        return true;
    }
}
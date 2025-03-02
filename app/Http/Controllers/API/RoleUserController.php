<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
{
    public function store(StoreRoleUserRequest $request)
    {
        $validator = $request->validated();
        $user = User::query()->find($validator['user_id']);
        $user->roles()->attach($validator['role_id']);
        return response()->json(['success' => 'true'], 201);
    }

    public function update (UpdateRoleUserRequest $request, string $id)
    {
        $validator = $request->validated();
        $user = User::query()->find($id);

        $user->roles()->detach($validator['role_id']);

        return response()->json(['message' => 'Role detached from user successfully.']);
    }

    public function destroy(string $id,  Request $request)
    {
        $validator = $request->validate([
            'role_id' => 'required|exists:role,id',
            'user_id' => 'required|exists:user,id,'
        ]);
        $user = User::query()->find($id);
        $user->roles()->detach($validator['role_id']);
        return response()->json([
            'success' => 'true',
        ]);
    }
}

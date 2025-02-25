<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
{
    public function store (Request $request)
    {
        $validator = $request->validate([
            'role_id' =>  'required|exists:role,id',
            'user_id' => 'required|exists:users,id',
        ]);
        $user = User::query()->find($validator['user_id']);
        $user->roles()->attach($validator['role_id']);
        return response()->json(['message' => 'Group member added successfully.'], 201);
    }

    public function update (Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $validator = $request->validate([
            'role_id' => 'required|exists:role,id',
            'user_id' => 'required|exists:user,id,'
        ]);
        $user = User::query()->find($validator['user_id']);
        $user->roles()->detach($validator['role_id']);
        return response()->json([
            'success' => 'true',
        ]);
    }
}

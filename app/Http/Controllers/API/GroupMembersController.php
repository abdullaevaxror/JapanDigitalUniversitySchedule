<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupMembersController extends Controller
{
    /**
     * Barcha group_subjects yozuvlarini olish
     */
    public function index()
    {
        $groupMembers = DB::table('group_members')->get();
        return response()->json($groupMembers);
    }

    /**
     * Yangi group_subject qo'shish
     */
    public function store (Request $request)
    {
        $request->validate([
           'group_id' =>  'required|exists:groups,id',
            'member_id' => 'required|exists:members,id',
        ]);

        DB::table('group_members')->insert([
            'group_id' => $request->group_id,
            'members_id' => $request->members_id,
        ]);

        return response()->json(['message' => 'Group member added successfully.'], 201);
    }

    /**
     * Bitta group_subject ni olish
     */
    public function show($id)
    {
        $groupMembers = DB::table('group_members')->where('id', $id)->first();

        if (!$groupMembers) {
            return response()->json(['message' => 'Group member not found'], 404);
        }

        return response()->json($groupMembers);
    }

    /**
     * group_subject yangilash
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'group_id' =>  'sometimes|exists:groups,id',
            'member_id' =>  'sometimes|exists:members,id',
        ]);

        $updated = DB::table('group_members')->where('id', $id)->update([
            'group_id' => $request->group_id,
            'member_id' => $request->member_id,
        ]);

        if (!$updated) {
            return response()->json(['message' => 'Group Member Not Found.'], 404);
        }
        return response()->json(['message' => 'Group Member updated successfully.'], 201);
    }

    /**
     * group_subject ni o'chirish
     */
    public function destroy($id)
    {
        $deleted = DB::table('group_members')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Group Member Not Found.'], 404);
        }

        return response()->json(['message' => 'Group Member deleted successfully.'], 201);
    }
}

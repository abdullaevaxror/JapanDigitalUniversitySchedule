<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroupSubjectRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupSubjectController extends Controller
{
    public function store(StoreGroupSubjectRequest $request)
    {
        $validator = $request->validated();

        $group = Group::query()->findOrFail($validator['group_id']);
        $group->subject()->attach($validator['subject_id'], ['created_at' => now(), 'updated_at' => now()]);

        return response()->json(['message' => 'Subject added to group successfully.'], 201);
    }

    public function update(StoreGroupSubjectRequest $id, $request)
    {
        $validator = $request->validated();
        $group = Group::query()->findOrFail($id);

        $group->subject()->detach($validator['subject_id']);

        return response()->json(['message' => 'Subject update from group successfully.'], 200);
    }

    public function destroy(string $id, Request $request)
    {
        $validator = $request->validate([
            'group_id' => 'required|exists:groups,id',
            ]);
            $group = Group::query()->findOrfail($validator['group_id']);
            $group->subjects()->detach($id);

            return response()->json(['message',  'Group delete from group successfully.'], 200);
        }
}
// ****

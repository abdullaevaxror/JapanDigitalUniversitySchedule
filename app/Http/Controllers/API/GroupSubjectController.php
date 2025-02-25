<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupSubjectController extends Controller
{
    // **GET - Hammasini olish**
    public function index()
    {
        $grooupSubjects = DB::table('group_subjects')->get();
        return response()->json($grooupSubjects);
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|integer',
            'subject_id' => 'required|integer',
        ]);

        return response()->json(['message' => 'Group Subject added successfully.'], 201);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
            'subject_id' => 'required',
        ]);

        $deleted = DB::table('
        group_subjects')
            ->where('group_id', $request->group_id)
            ->where('subject_id', $request->subject_id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Group Subject deleted successfully.'], 201);
        }else{
            return response()->json(['message' => 'Group Subject not found'], 201);
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->has('sort')) {
            $query->where('sort', $request->get('rooms'));
        }

        $perPage = $request->get('per_page', 10);
        $rooms = $query->paginate($perPage);

        return response()->json($rooms);
    }

    public function show(Room $room)
    {
        return response()->json($room);
    }

    public function create(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
        ]);
        Room::query()->create($validator);
        return response()->json(['message' => 'Room created successfully.']);
    }

    public function update(Request $request, Room $room)
    {
        $validator = $request->validate([
            'name' => 'required',
        ]);
        $room->update($validator);
        return response()->json(['message' => 'Room updated successfully.']);
    }

    public function delete(Room $room)
    {
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully.']);
    }
}

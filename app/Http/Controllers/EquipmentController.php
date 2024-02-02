<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function store (Request $request)
    {
        $equipment = new Equipment();
        $equipment->name = $request->name;
        $equipment->user_id = $request->user_id;
        $equipment->save();
        return response()->json([
            'message' => 'Equipment created successfully',
            'equipment' => $equipment
        ], 201);

    }

    public function checkPermission(Request $request)
    {
        $tag = $request->input('rfid');

        // Find the RFID tag in the database
        $rfidTag = Equipment::where('rfid', $tag)->first();

        if ($rfidTag) {
            // Check if the tag is allowed
            if ($rfidTag->status) {
                return response()->json(['message' => 'Permission granted'], 200);
            } else {
                return response()->json(['message' => 'Permission denied'], 403);
            }
        } else {
            return response()->json(['message' => 'Tag not found'], 404);
        }
    }
}

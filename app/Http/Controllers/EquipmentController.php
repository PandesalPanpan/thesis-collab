<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Notifications\Notification;
use App\Models\Equipment;
use App\Models\Log;

class EquipmentController extends Controller
{
    public function store(Request $request)
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
                // Create logs entry
                $logs = new log();
                $logs->equipment_id = $rfidTag->id;
                $logs->rfid = $rfidTag->rfid;
                $logs->name = $rfidTag->name;
                $logs->status = "Permission Granted"; // Permission granted
                $logs->save();

                return response()->json(['message' => 'Permission granted'], 200);
            } else {
                // Create logs entry
                $logs = new log();
                $logs->equipment_id = $rfidTag->id;
                $logs->rfid = $rfidTag->rfid;
                $logs->name = $rfidTag->name;
                $logs->status = "Permission Denied"; // Permission denied
                $logs->save();

                return response()->json(['message' => 'Permission denied'], 403);
            }
        } else {
            return response()->json(['message' => 'Tag not found'], 404);
        }
    }


}

/*public function checkPermission(Request $request)
{
    $tag = $request->input('rfid');

    // Find the RFID tag in the database
    $rfidTag = Equipment::where('rfid', $tag)->first();

    if ($rfidTag) {
        // Check if the tag is allowed
        if ($rfidTag->status) {
            return response()->json(['message' => 'Permission granted'], 200);
            $logs = new logs();
            $logs->equipment_id = $rfidTag->id;
            $logs->user_id = $request->user_id;
            $logs->created_at = now();
            $logs->status = $staus;
            $logs->save();
        } else {
            return response()->json(['message' => 'Permission denied'], 403);
            $logs = new logs();
            $logs->equipment_id = $rfidTag->id;
            $logs->user_id = $request->user_id;
            $logs->created_at = now();
            $logs->status = $staus;
            $logs->save();
        }
    } else {
        return response()->json(['message' => 'Tag not found'], 404);
        
    }
}
}*/

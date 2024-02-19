<?php

namespace App\Http\Controllers;

use App\Events\EquipmentBroadcast;
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
    $requestData = $request->all();
    info('Received request data: ' . json_encode($requestData));

    // Retrieve 'rfids' parameter from the query string
    $tags = $request->query('rfids');

    // Ensure $tags is an array
    if (!is_array($tags)) {
        return response()->json(['error' => 'Missing or invalid rfids parameter'], 400);
    }

    $responses = [];

    foreach ($tags as $tag) {
        // Find the RFID tag in the database
        $rfidTag = Equipment::where('rfid', $tag)->first();

        if ($rfidTag) {
            // Check if the tag is allowed
            if ($rfidTag->status) {
                // Create logs entry
                $logs = new Log(); // Corrected class name to 'Log' assuming it's the correct one
                $logs->equipment_id = $rfidTag->id;
                $logs->rfid = $rfidTag->rfid;
                $logs->name = $rfidTag->name;
                $logs->status = "Permission Granted"; // Permission granted
                $logs->save();

                $responses[] = ['rfid' => $tag, 'message' => 'Permission granted'];
            } else {
                // Create logs entry
                $logs = new Log(); // Corrected class name to 'Log' assuming it's the correct one
                $logs->equipment_id = $rfidTag->id;
                $logs->rfid = $rfidTag->rfid;
                $logs->name = $rfidTag->name;
                $logs->status = "Permission Denied"; // Permission denied
                $logs->save();

                $responses[] = ['rfid' => $tag, 'message' => 'Permission denied'];
            }
        } else {
            $responses[] = ['rfid' => $tag, 'message' => 'Tag not found'];
        }
    }

    return response()->json($responses);
}


    /*public function checkPermission(Request $request)
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
}*/
}
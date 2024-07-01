<?php

namespace App\Http\Controllers;

use App\Events\FingerPrint;
use Illuminate\Http\Request;
use App\Models\FingerprintModel;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Events\FingerPrintReceived;
use Illuminate\Support\Facades\Validator;
class FingerPrintController extends Controller
{
    //

    public function index(Request $request)
    {
        $id = $request->input('id');

        if ($request->hasFile('fingerprint_image') && $request->file('fingerprint_image')->isValid()) {
            try {
                $image = $request->file('fingerprint_image');
                $imageData = file_get_contents($image->getRealPath());
                $ip = $request->input("ipaddress");
                $template = $request->input("template");

                event(new FingerPrint($imageData, $ip, $template));

                return response()->json(['message' => 'Fingerprint image received successfully'], 200);
            } catch (\Exception $e) {

                return response()->json(['message' => 'Failed to received fingerprint image', 'error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Invalid image upload'], 400);
        }
    }


    public function view(Request $request)
    {
        $id = $request->query('id');
        $fingerprintData = FingerprintModel::where('employee_id', $id)->first();
        return view('enroll', compact('id', 'fingerprintData'));
    }

    public function onReceived(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'ip' => 'required'
        ]);
        $id = $request->input('id');
        $ip = $request->input('ip');

        event(new FingerPrintReceived($id, $ip));

        return response()->json(['message' => 'Fingerprint image received successfully'], 200);
    }

    public function enroll(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'image_base64' => 'required',
            'template' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $id = $request->input('employee_id');
        $base64Image = $request->input('image_base64');

        $imageData = base64_decode($base64Image);

        try {

            $fingerprintModel = FingerprintModel::where('employee_id', $id)->first();

            if ($fingerprintModel) {

                $fingerprintModel->fingerprint_data = $imageData;
                $fingerprintModel->template = $request->input('template');
                $fingerprintModel->updated_at = now();
                $fingerprintModel->save();
                return response()->json(['message' => 'Fingerprint data update successfully'], 200);
            } else {

                $fingerprintModel = new FingerprintModel();
                $fingerprintModel->employee_id = $id;
                $fingerprintModel->fingerprint_data = $imageData;
                $fingerprintModel->template = $request->input('template');
                $fingerprintModel->created_at = now();
                $fingerprintModel->updated_at = now();
                $fingerprintModel->save();
                return response()->json(['message' => 'Fingerprint data saved successfully'], 200);
            }


        } catch (\Exception $e) {
            $errorMessage = mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8');

            return response()->json([
                'message' => 'Failed to save fingerprint data',
                'error' => $errorMessage
            ], 500);
        }
    }

    public function getData()
    {
        $data = DB::table('fingerprint_models')->get();


        foreach ($data as $item) {
            $item->fingerprint_data = base64_encode($item->fingerprint_data);
        }

        return response()->json($data);
    }
}

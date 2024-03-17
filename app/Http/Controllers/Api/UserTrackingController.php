<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserTrackingController extends Controller
{
    public function storeTrackingData(Request $request)
    {
        try {
            $requestDetails = $request->all();
            foreach ($requestDetails AS $requestDetail){
               $detail =  getTrackingDetailsByIp($requestDetail->user_agent, $requestDetail->ip);

            }
        }catch (Exception $e){
            $bug = $e->getMessage();
            Log::error("UserTrackingController (storeTrackingData) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return response()->json(['error' => true, 'code' => 400, 'message' => 'Something went wrong.'], 400);
        }
    }
}

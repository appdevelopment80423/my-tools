<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user_access', ['only' => ['index','update', 'getUserList', 'getUserEarningHistory', 'getUserWithdrawalHistory', 'getUserViewTeam', 'getUserViewReferral','getUserPurchaseHistory']]);

        $this->middleware('permission:user_approval_access', ['only' => ['updateStatus']]);

        $this->middleware('permission:user_activity_access', ['only' => ['usersLogs', 'usersLogsList', 'allusersLogsList']]);

        $this->middleware('permission:user_activity_delete', ['only' => ['deleteusersLogs']]);

    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function getUserList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortColumn = $request->input('sort_column', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $search = $request->input('search');

        $user_details = DB::table('users')
            ->leftjoin('users_details', 'users_details.user_id', '=', 'users.id')
            ->select('users.*', 'users.mobile as mobile_number', 'users_details.referral_code', 'users_details.dob','users_details.image','users_details.gender','users_details.pin');

        if ($search) {
            $user_details->Where('users.name', 'like', '%' . "$search" . '%')
                ->orWhere('users.email', 'like', '%' . "$search" . '%')
                ->orWhere('users_details.gender', 'like', '%' . "$search" . '%')
                ->orWhere('users_details.pin', 'like', '%' . "$search" . '%')
                ->orWhere('users_details.referral_code', 'like', '%' . "$search" . '%')
                ->orWhere('users_details.dob', 'like', '%' . "$search" . '%')
                ->orWhere('users.created_at', 'like', '%' . "$search" . '%')
                ->orWhere('users.mobile', 'like', '%' . "$search" . '%');
        }

        // Apply sorting
        $user_details->orderBy($sortColumn, $sortOrder);

        $data = $user_details->paginate($perPage);

        return response()->json($data);
    }

    public function updateStatus(Request $request)
    {
        try {
            $request = json_decode($request->getContent());
            $ids = $request->statusids;
            $status = $request->approveStatus;
            User::whereIn('id', $ids)->update(['status' => $status]);
            return response()->json(['success' => true, 'code' => 200, 'message' => 'User status updated successfully.'], 200);

        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("ClientController (updateStatus) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return response()->json(['error' => true, 'code' => 400, 'message' => 'No data found.'], 400);
        }
    }

    public function tracking()
    {
        return view('admin.users.tracking.index');
    }

    public function getUserTrackingList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortColumn = $request->input('sort_column', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $search = $request->input('search');

        $user_details = DB::table('users_tracking AS ut');

        if ($search) {
            $user_details->Where('ut.ip', 'like', '%' . "$search" . '%')
                ->orWhere('ut.country', 'like', '%' . "$search" . '%')
                ->orWhere('ut_details.country_code', 'like', '%' . "$search" . '%')
                ->orWhere('ut_details.region', 'like', '%' . "$search" . '%')
                ->orWhere('ut_details.region_name', 'like', '%' . "$search" . '%')
                ->orWhere('ut_details.city', 'like', '%' . "$search" . '%')
                ->orWhere('ut.lat', 'like', '%' . "$search" . '%')
                ->orWhere('ut.lon', 'like', '%' . "$search" . '%')
                ->orWhere('ut.timezone', 'like', '%' . "$search" . '%')
                ->orWhere('ut.isp', 'like', '%' . "$search" . '%')
                ->orWhere('ut.org', 'like', '%' . "$search" . '%')
                ->orWhere('ut.org_as', 'like', '%' . "$search" . '%')
                ->orWhere('ut.browser_name', 'like', '%' . "$search" . '%')
                ->orWhere('ut.browser_version', 'like', '%' . "$search" . '%')
                ->orWhere('ut.device_model', 'like', '%' . "$search" . '%')
                ->orWhere('ut.os_name', 'like', '%' . "$search" . '%')
                ->orWhere('ut.created_at', 'like', '%' . "$search" . '%');
        }

        // Apply sorting
        $user_details->orderBy($sortColumn, $sortOrder);

        $data = $user_details->paginate($perPage);

        return response()->json($data);
    }

    public function insertUserTrackingDetails(Request $request)
    {
        try {
            DB::beginTransaction();
            $records = $request->all();
            $result = [];
            foreach ($records as $record) {
                $result[] = getTrackingDetailsByIp($record['user_agent'], $record['ip'], $record['created_at']);
            }

            DB::table('users_tracking')->insert($result);
            DB::commit();
            return response()->json(['success' => true, 'code' => 200, 'message' => 'User tracking inserted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            Log::error("ClientController (insertUserTrackingDetails) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return response()->json(['error' => true, 'code' => 400, 'message' => 'Something went wrong.'], 400);
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllottedIp;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:security_access', ['only' => ['index', 'getIpList','store','edit','delete']]);

    }
    public function index(){
        return view('admin.security.ip_list');
    }
    public function getIpList(Request $request){

        $perPage = $request->input('per_page', 10);
        $sortColumn = $request->input('sort_column', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $search = $request->input('search');

        $data = AllottedIp::select(
            "id",
            "ip_address",
            "status",
            "created_at",
            "updated_at"
        );

        if ($search) {
            $data->Where('ip_address', 'like', '%' . "$search" . '%');
        }

        // Apply sorting
        $data->orderBy($sortColumn, $sortOrder);

        $data = $data->paginate($perPage);
        return response()->json($data);

    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            if ($request->id) {
                $validateArray = [
                    'ip_address' => ['required',
                    'regex:/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/',
                    'unique:allotted_ip,ip_address,'. $request->id],
                    'status' => 'required'
                ];
            } else {
                $validateArray = [
                    'ip_address' =>  ['required','regex:/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/','unique:allotted_ip,ip_address'],
                    'status' => 'required',
                ];
            }

            $validateMessage = [
                'ip_address.required' => 'Please enter settings type.',
                'status.required' => 'Please select status.'
            ];

            $validator = Validator::make($request->all(), $validateArray, $validateMessage);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $withdrawalData = AllottedIp::find($request->id);

                $output = AllottedIp::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'ip_address' => $request->ip_address,
                        'status' => $request->status,
                    ]
                );

                DB::commit();
                if ($output->wasRecentlyCreated) {
                    return redirect()->back()->with(['success' => 'ip address  created successfully!']);
                } else {
                    return redirect()->back()->with(['success' => 'ip address  updated successfully!']);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            Log::error("withdrawalTypeController (store : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with(['error' => $bug]);
        }
    }

    public function edit($id)
    {
        $data = AllottedIp::find($id);
        return response()->json($data);
    }

    public function delete($id)
    {
        $allottedIpStatus = AllottedIp::find($id);
        if ($allottedIpStatus->delete()) {
            return response()->json(['code' => 200, 'message' => 'Ip address deleted successfully.']);
        } else {
            return response()->json(['code' => 400, 'message' => 'Ip address not found.']);
        }
    }

    public function changePassword(){
        return view('admin.security.change_password');
    }

    public function newPasswordStore(Request $request){

        $validation = Validator::make($request->all(), [
            'currentPassword' => 'required',
            'newPassword' => 'min:8|required|required_with:confirmPassword|same:confirmPassword|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirmPassword' => 'min:8',
        ]);

        if ($validation->fails()) {
            return redirect()->route('admin.change-password')->with('error', $validation->errors()->first());
        } else
        {
            if(auth()->guard('admin')->check()){
                $userdata = Admin::where(['id'=>Auth::guard('admin')->user()->id])->first();
            }

            if($userdata){

                if (Hash::check($request->currentPassword, $userdata->password)) {
                    $userdata = $userdata->update(['password' => $request->newPassword]);
                    return redirect()->back()->with('success','Congratulations, Your password was changed.');
                }{
                    return redirect()->back()->with('error','The provided current password is incorrect.');
                }
            }
            else
            {
                return redirect()->back()->with(['error' => 'User not found.']);
            }
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AllottedIp;
use App\Models\GoogleAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:member_access', ['only' => ['index','getMemberList']]);

        $this->middleware('permission:member_create', ['only' => ['create','store']]);

        $this->middleware('permission:member_edit', ['only' => ['edit','update']]);

        $this->middleware('permission:member_delete', ['only' => ['delete']]);

    }

    public function index()
    {
      try{
          return view('admin.members.index');
      }catch (\Exception $e){
          $bug = $e->getMessage();
          Log::error("MemberController (index) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
          return redirect()->back()->with('error', $bug);
      }
    }

    public function create(){
      try{
          $role = Role::get();
          $allottedIp = AllottedIp::where('status',1)->get();
          return view('admin.members.create',compact('role','allottedIp'));
      }catch (\Exception $e){
          $bug = $e->getMessage();
          Log::error("MemberController (create) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
          return redirect()->back()->with('error', $bug);
      }
    }

    public function store(Request $request){
      try{
          $validateArray = [
            'name' => 'required',
             'email' => 'required|email|unique:admins,email',
            'password' => 'min:6|required|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
            'role' => 'required',
        ];
        $validateMessage = [
            'name.required' => 'Please enter name.',
            'email.unique' => 'The email address is already in use. Please choose a different one.',
            'email.required' => 'Please enter email.',
            'password.required' => 'Please enter password.',
            'role.required' => 'Please select role.'
        ];

          if ($request->input('ip_restriction') == 1) {
              $validateArray['allow_ip'] = 'required|array|min:1';
              $validateMessage['allow_ip.required'] = 'Please select at least one IP address.';
          }


          $validator = Validator::make($request->all(), $validateArray, $validateMessage);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            DB::beginTransaction();
            $allow_ip = NULL;
            $ip_restriction = $request->ip_restriction;
            if($request->allow_ip){
                $allow_ip = implode(',',$request->allow_ip);
            }
            $create = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'allow_ip' => $allow_ip,
                'ip_restriction' => $ip_restriction,
            ];
            $admin = Admin::create($create);
            $admin->assignRole($request->role);

            DB::commit();
            return redirect('admin/members')->with('success','New Member added successfully');
        }
      }catch (\Exception $e){
          DB::rollback();
          $bug = $e->getMessage();
          Log::error("MemberController (store) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
          return redirect()->back()->with('error', $bug);
      }
    }

    public function edit($id){
      try{
          $role = Role::get();
          $admin = Admin::find($id);
          $allottedIp = AllottedIp::where('status',1)->get();

          return view('admin.members.edit',compact('role','admin','allottedIp'));
      }catch (\Exception $e){
          $bug = $e->getMessage();
          Log::error("MemberController (edit) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
          return redirect()->back()->with('error', $bug);
      }
    }

    public function update(Request $request){
      try{
          $validateArray = [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ];
        $validateMessage = [
            'id.required' => 'Id is not get, please try again.',
            'name.required' => 'Please enter name.',
            'email.required' => 'Please enter email.',
            'role.required' => 'Please select role.'
        ];

          if ($request->input('ip_restriction') == 1) {
              $validateArray['allow_ip'] = 'required|array|min:1';
              $validateMessage['allow_ip.required'] = 'Please select at least one IP address.';
          }

        $validator = Validator::make($request->all(), $validateArray, $validateMessage);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
          DB::beginTransaction();
            $allow_ip = NULL;
            $ip_restriction = $request->ip_restriction;
            if($request->allow_ip){
              $allow_ip = implode(',',$request->allow_ip);
          }

          $update = [
            'name' => $request->name,
            'email' => $request->email,
            'allow_ip' => $allow_ip,
            'ip_restriction' => $ip_restriction,
          ];

          $admin = Admin::find($request->id);
          $admin->update($update);
          $admin->syncRoles($request->role);
          DB::commit();
          return redirect('admin/members')->with('success','Member Detail update successfully');
        }
      }catch (\Exception $e){
          DB::rollback();
          $bug = $e->getMessage();
          Log::error("MemberController (update) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
          return redirect()->back()->with('error', $bug);
      }
    }

    public function delete($id){
      try{
          $admin = Admin::where('id',$id)->first();
          $admin->delete();
          return $admin;
      }catch (\Exception $e){
          $bug = $e->getMessage();
          Log::error("MemberController (delete) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
          return redirect()->back()->with('error', $bug);
      }
    }

    public function getMemberList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortColumn = $request->input('sort_column', 'admins.id');
        $sortOrder = $request->input('sort_order', 'asc');
        $search = $request->input('search');

        $user_details = DB::table('admins')
            ->join('model_has_roles','model_has_roles.model_id','=','admins.id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->select('admins.id','admins.name','admins.email','roles.name AS role_name','admins.ip_restriction','admins.allow_ip');

        if ($search) {
            $user_details->Where('admins.name', 'like', '%' . "$search" . '%')
                ->orWhere('admins.email', 'like', '%' . "$search" . '%')
                ->orWhere('roles.name', 'like', '%' . "$search" . '%')
                ->orWhere('admins.id', 'like', '%' . "$search" . '%');
        }

        // Apply sorting
        $user_details->orderBy($sortColumn, $sortOrder);

        $data = $user_details->paginate($perPage);

        return response()->json($data);
    }

    public function updateIpRestriction(Request $request)
    {
        try {
            $ip_restriction = $request->input('ip_restriction');
            $id = $request->input('id');

            Admin::where('id', $id)->update(['ip_restriction' => $ip_restriction]);

            return response()->json(['success' => true, 'code' => 200, 'message' => 'Members ip restriction status updated successfully.'], 200);

        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("MemberController (updateIpRestriction) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return response()->json(['status' => 400, 'data' => ['message' => 'Something went wrong. Please try after sometime.', 'data' => '']]);
        }

    }

    public function changePassword(){
        return view('admin.members.change_password');
    }

    public function newPasswordStore(Request $request){
        $validation = Validator::make($request->all(), [
            'currentPassword' => 'required',
            'newPassword' => 'min:6|required|required_with:confirmPassword|same:confirmPassword',
            'confirmPassword' => 'min:6',
        ]);

        if ($validation->fails()) {
            return redirect()->route('admin.change-password')->with('error', $validation->errors()->first());
        }
        else
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

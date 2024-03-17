<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role_access', ['only' => ['index', 'getRoleList']]);

        $this->middleware('permission:role_create', ['only' => ['store']]);

        $this->middleware('permission:role_edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:role_delete', ['only' => ['delete']]);

    }

    public function index(Request $request)
    {
        try {
            $permissions = Permission::pluck('name', 'id');

            return view('admin.roles.index', compact('permissions'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("RoleController (index) : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function getRoleList(Request $request)
    {
        $data = Role::get();
        $hasManageRoles = Auth::user()->canany(['role_edit','role_delete']);
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('permissions', function ($data) {
                if ($data->name == 'Super Admin') {
                    return '<span class="badge bg-label-success me-1">All permissions</span>';
                }
                $badges = '';
                $roles = $data->permissions()->get();
                foreach ($roles as $key => $role) {
                    if ($key != 0 && $key % 7 == 0){
                        $badges .= '<span class="badge bg-label-primary me-1">' . $role->name . '</span><br>';
                    }else{
                        $badges .= '<span class="badge bg-label-primary me-1">' . $role->name . '</span>';
                    }
                }

                return $badges;


            })
            ->addColumn('action', function ($data) use ($hasManageRoles) {
                $output = '';
                $edit_url = route('admin.roles.edit', $data->id);
                $delete_url = route('admin.roles.delete', $data->id);
                if ($hasManageRoles && $data->name != 'Super Admin') {
                    $role_edit = '';
                    $role_delete = '';
                    if(Auth::user()->can('role_edit')){
                        $role_edit = '<a class="dropdown-item waves-effect" href="' . $edit_url . '"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                        ';
                    }
                    if(Auth::user()->can('role_delete')){
                        $role_delete = '<a class="dropdown-item waves-effect" onclick="deleteRecord(`' . $delete_url . '`,`.role_table`)" href="javascript:void(0);"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>';
                    }
                    $output = '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" style="">
                            '.$role_edit.$role_delete.'
                            </div>
                          </div>';
                }

                return $output;
            })
            ->rawColumns(['permissions', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            $validateArray = [
                'name' => 'required',
                'permissions' => 'present'
            ];
            $validateMessage = [
                'name.required' => 'Please enter role name.',
                'permissions.present' => 'Please select any permission'
            ];
            $validator = Validator::make($request->all(), $validateArray, $validateMessage);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $role = Role::create(['name' => $request->name]);
                $role->syncPermissions($request->permissions);

                if ($role) {
                    return redirect('admin/roles')->with('success', 'Role created successfully!');
                }
                return redirect('admin/roles')->with('error', 'Failed to create role! Try again.');
            }

        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("RoleController (store) : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        $role = Role::where('id', $id)->first();

        if ($role) {
            $role_permission = $role->permissions()->pluck('id')->toArray();

            $permissions = Permission::pluck('name', 'id');

            return view('admin.roles.edit', compact('role', 'role_permission', 'permissions'));
        }

        return redirect('404');
    }

    public function update(Request $request)
    {
        try {
            $validateArray = [
                'id' => 'required',
                'name' => 'required',
                'permissions' => 'present'
            ];
            $validateMessage = [
                'id.required' => 'Something Wrong!.Please try again',
                'name.required' => 'Please enter role name.',
                'permissions.present' => 'Please select any permission'
            ];
            $validator = Validator::make($request->all(), $validateArray, $validateMessage);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {

                $role = Role::find($request->id);

                $update = $role->update([
                    'name' => $request->name,
                ]);

                // Sync role permissions
                $role->syncPermissions($request->permissions);

                return redirect('admin/roles')->with('success', 'Role info updated successfully!');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("RoleController (update) : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function delete($id)
    {
        $permission = Role::find($id)->delete();
        return $permission;
    }
}

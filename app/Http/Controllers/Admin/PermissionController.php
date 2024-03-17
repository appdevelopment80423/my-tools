<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission_access', ['only' => ['index', 'getPermissionList', 'getPermissionBadgeByRole']]);

        $this->middleware('permission:permission_create', ['only' => ['store']]);

        $this->middleware('permission:permission_edit', ['only' => ['update']]);

        $this->middleware('permission:permission_delete', ['only' => ['delete']]);
    }

    /**
     * Show Role List
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $roles = Role::pluck('name', 'id');

            return view('admin.permissions.index', compact('roles'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("PermissionController (index) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Show Role List with associate permission
     * Server side list view using yajra datatables
     *
     * @param Request $request
     * @return mixed
     */

    public function getPermissionList(Request $request)
    {
        $data = Permission::get();
        $hasManagePermission = Auth::user()->can('permission_delete');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('roles', function ($data) {
                $roles = $data->roles()->get();
                $badges = '';
                foreach ($roles as $key => $role) {
                    $badges .= '<span class="badge bg-label-primary me-1">' . $role->name . '</span>';
                }

                return $badges;
            })
            ->addColumn('action', function ($data) use ($hasManagePermission) {
                $output = '';
                $delete_url = route('admin.permissions.delete', $data->id);
                if ($hasManagePermission) {
                    //$output = '<a href="' . url('admin/permission/delete/' . $data->id) . '"><button class="btn btn-danger" data-original-title="Delete" title="Delete"><i class="far fa-trash-alt"></i></button></a>';
                    $output = '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" style="">
                              <a class="dropdown-item waves-effect" onclick="deleteRecord(`' . $delete_url . '`,`.permission_table`)" href="javascript:void(0);"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
                            </div>
                          </div>';
                }

                return $output;
            })
            ->rawColumns(['roles', 'action'])
            ->make(true);
    }

    /**
     * Store new roles with assigned permission
     * Associate permissions will be stored in table
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(PermissionRequest $request): RedirectResponse
    {
        try {
            $validateArray = [
                'name' => 'required|unique:permissions,name',
            ];
            $validateMessage = [
                'name.required' => 'Please enter permission name.',
            ];
            $validator = Validator::make($request->all(), $validateArray, $validateMessage);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {

                $permission = Permission::create(['name' => $request->name]);
                if (isset($request->roles)) {
                    $permission->syncRoles($request->roles);
                }

                if ($permission) {
                    return redirect('admin/permissions')->with('success', 'Permission created succesfully!');
                }
                return redirect('admin/permissions')->with('error', 'Failed to create permission! Try again.');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("PermissionController (store) : ", ["Exception" =>$bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * delete permission
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $permission = Permission::find($id)->delete();
        return $permission;
    }

    /**
     * get permission badges by role
     *
     * @param Request $request
     * @return mixed
     */
    public function getPermissionBadgeByRole(Request $request)
    {
        $badges = '';
        if ($request->id) {
            $role = Role::find($request->id);
            $permissions = $role->permissions()->pluck('name', 'id');
            foreach ($permissions as $key => $permission) {
                $badges .= '<span class="badge badge-dark m-1">' . $permission . '</span>';
            }
        }

        if ($role->name == 'Super Admin') {
            $badges = ' Super Admin has all the permissions!';
        }

        return $badges;
    }
}

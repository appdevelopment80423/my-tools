<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SettingType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:setting_access', ['only' => ['index', 'getSettingsList','create', 'store','edit', 'update','delete']]);

        $this->middleware('permission:setting_type_access', ['only' => ['getSettingsTypeList','createSettingType', 'storeSettingsType','editType','deleteType']]);
    }
    public function index()
    {

        $type_data = SettingType::where('status',1)->get();

        return view('admin.generalSettings.index', compact('type_data'));
    }

    public function getSettingsList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $sortColumn = $request->input('sort_column', 'settings.created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $search = $request->input('search');
        $type = $request->input('type');

        $user_details = Setting::leftJoin('setting_types', 'settings.setting_type_id', '=', 'setting_types.id')
            ->select(
                "settings.id",
                "settings.key",
                "settings.value",
                "setting_types.type",
                "setting_types.id AS type_id",
                "settings.description",
                "settings.status",
                "settings.created_at"
            );

        if ($type != '') {
            $query = $user_details->where('setting_types.id', $type);
        } else {
            $query = $user_details;
        }

        if ($search) {
            $user_details->where(function ($query) use ($search) {
                $query->Where('settings.key', 'like', '%' . "$search" . '%')
                    ->orWhere('settings.value', 'like', '%' . "$search" . '%')
                    ->orWhere('setting_types.type', 'like', '%' . "$search" . '%')
                    ->orWhere('settings.description', 'like', '%' . "$search" . '%')
                    ->orWhere('settings.status', 'like', '%' . "$search" . '%');
            });
        }

        // Apply sorting
        $query->orderBy($sortColumn, $sortOrder);

        $data = $query->paginate($perPage);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $validateArray = [
                'setting_key' => 'required',
                'setting_value' => 'required',
                'status' => 'required',
                'type' => 'required'
            ];
            $validateMessage = [
                'setting_key.required' => 'Please enter setting name.',
                'setting_value.required' => 'Please enter setting value.',
                'status.required' => 'Please select status.',
                'type.required' => 'Please select settings type.'
            ];

            $validator = Validator::make($request->all(), $validateArray, $validateMessage);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {

                $output = Setting::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'key' => $request->setting_key,
                        'value' => $request->setting_value,
                        'description' => $request->descriptions,
                        'setting_type_id' => $request->type,
                        'status' => $request->status
                    ]
                );
                DB::commit();
                if ($output->wasRecentlyCreated) {
                    return redirect()->back()->with(['success' => 'Setting created successfully!']);
                } else {
                    return redirect()->back()->with(['success' => 'Setting updated successfully!']);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->getMessage();
            Log::error("SettingController (store) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with(['error' => $bug]);
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $data = Setting::leftJoin('setting_types', 'settings.setting_type_id', '=', 'setting_types.id')
            ->select(
                "settings.id",
                "settings.key",
                "settings.value",
                "setting_types.type",
                "setting_types.id AS type_id",
                "settings.description",
                "settings.status",
                "settings.created_at"
            )
            ->where('settings.id', $id)
            ->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($id)
    {
        $data = Setting::find($id);
        if ($data->delete()) {
            return response()->json(['code' => 200, 'message' => 'Setting deleted successfully.']);
        } else {
            return response()->json(['code' => 400, 'message' => 'Setting not found.']);
        }
    }

    /**
     * Create setting type
     */
    public function createSettingType()
    {
        return view('admin.generalSettings.setting-types');
    }

    /**
     * Store setting type value
     */
    public function storeSettingsType(Request $request)
    {
        try {

            DB::beginTransaction();
            if ($request->id) {
                $validateArray = [
                    'type_key' => 'required|unique:setting_types,type,' . $request->id,
                    'status' => 'required'
                ];
            } else {
                $validateArray = [
                    'type_key' => 'required|unique:setting_types,type',
                    'status' => 'required'
                ];
            }

            $validateMessage = [
                'type_key.required' => 'Please enter settings type.',
                'status.required' => 'Please select status.'
            ];

            $validator = Validator::make($request->all(), $validateArray, $validateMessage);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $output = SettingType::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'type' => $request->type_key,
                        'status' => $request->status
                    ]
                );
                DB::commit();
                if ($output->wasRecentlyCreated) {
                    return redirect()->back()->with(['success' => 'Setting type created successfully!']);
                } else {
                    return redirect()->back()->with(['success' => 'Setting type updated successfully!']);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            Log::error("SettingController (storeSettingsType) : ", ["Exception" => $bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with(['error' => $bug]);
        }
    }

    /**
     * Get setting type list
     */
    public function getSettingsTypeList(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $sortColumn = $request->input('sort_column', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $search = $request->input('search');

        $type_details = SettingType::select(
            "setting_types.id",
            "setting_types.type",
            "setting_types.status"
        );

        if ($search) {

            $type_details->Where('type', 'like', '%' . "$search" . '%');
        }

        // Apply sorting
        $type_details->orderBy($sortColumn, $sortOrder);

        $data = $type_details->paginate($perPage);

        return response()->json($data);
    }

    /**
     * Update setting type
     */
    public function editType($id)
    {
        $data = SettingType::find($id);
        return response()->json($data);
    }

    /**
     * Delete setting type
     */
    public function deleteType($id)
    {
        $data = SettingType::find($id);
        $setting_data_count = Setting::where('settings.setting_type_id', $id)->count();
        if ($setting_data_count) {
            return response()->json(['code' => 400, 'message' => "Setting in $setting_data_count record exits , please delete after setting type delete access."]);
        } else {
            if ($data->delete()) {
                return response()->json(['code' => 200, 'message' => 'Setting type deleted successfully.']);
            } else {
                return response()->json(['code' => 400, 'message' => 'Setting type not found.']);
            }
        }
    }
}

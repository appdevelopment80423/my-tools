<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Models\UserCart;
use App\Models\UserDetail;
use App\Models\UserEarningHistory;
use App\Models\UserEarningHistoryToday;
use App\Models\UserWallet;
use App\Models\UserWithdrawalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {

        return view('admin.dashboard.index');

    }

    public function earningReport(){
        try {
            return view('admin.admin-report.earning-report');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::error("DashboardController (earningReport) : ", ["Exception" =>$bug, "\nTraceAsString" => $e->getTraceAsString()]);
            return redirect()->back()->with('error', $bug);
        }
    }
        public function myEarning(Request $request){
            try {
                $perPage = $request->input('per_page', 10);
                $sortColumn = $request->input('sort_column', 'created_at');
                $sortOrder = $request->input('sort_order', 'desc');
                $search = $request->input('search');

                $adminTransferEarning =  DB::table('users_earning_history')
                    ->join('users', 'users.id', '=', 'users_earning_history.user_id')
                    ->join('products', 'products.id', '=', 'users_earning_history.product_id')
                    ->where('users_earning_history.status', 5)
                    ->select(
                        'users.name AS name',
                        'users.email AS email',
                        'users_earning_history.earning_amount AS amount',
                        'products.name as product_name',
                        DB::raw('"Admin transfer user earning" AS type'),
                        'users_earning_history.updated_at AS updated_at',
                        'users_earning_history.created_at AS created_at'
                    );

                if ($search) {
                    $adminTransferEarning->where(function ($query) use ($search) {
                        $query->where('products.name', 'like', '%' . $search . '%')
                             ->orWhere('users.name', 'like', '%' . "$search" . '%')
                            ->orWhere('users.email', 'like', '%' . "$search" . '%')
                            ->orWhere('users_earning_history.created_at', 'like', '%' . "$search" . '%')
                            ->orWhere('users_earning_history.earning_amount', 'like', '%' . "$search" . '%');
                    });
                }

                $productAdmin_charge =  DB::table('products')
                    ->join('clients', 'clients.id', '=', 'products.client_id')
                    ->join('clients_details', 'clients_details.client_id', '=', 'clients.id')
                    ->where('products.status', 2)
                    ->select(
                        'clients_details.first_name AS name',
                        'clients.email AS email',
                        'products.admin_charge AS amount',
                        'products.name as product_name',
                        DB::raw('"Add product" AS type'),
                        'products.updated_at AS updated_at',
                        'products.created_at AS created_at'
                    );

                if ($search) {
                    $productAdmin_charge->where(function ($query) use ($search) {
                        $query->where('products.name', 'like', '%' . $search . '%')
                            ->orWhere('clients.email', 'like', '%' . "$search" . '%')
                            ->orWhere('clients_details.first_name', 'like', '%' . "$search" . '%')
                            ->orWhere('products.created_at', 'like', '%' . "$search" . '%')
                            ->orWhere('products.admin_charge', 'like', '%' . "$search" . '%');
                    });
                }

                    $usersWthdrawalDetails = DB::table('users_withdrawal_history')
                        ->join('users', 'users.id', '=', 'users_withdrawal_history.user_id')
                        ->where('users_withdrawal_history.status', 4)
                        ->select(
                            'users.name AS name',
                            'users.email AS email',
                            'users_withdrawal_history.charge_ruppe AS amount',
                            DB::raw('"" AS product_name'),
                            DB::raw('"User withdrawal" AS type'),
                            'users_withdrawal_history.updated_at AS updated_at',
                            'users_withdrawal_history.created_at AS created_at'
                        );

                if ($search) {
                    $usersWthdrawalDetails->where(function ($query) use ($search) {
                        $query->where('users.name', 'like', '%' . $search . '%')
                            ->orWhere('users.email', 'like', '%' . "$search" . '%')
                            ->orWhere('users_withdrawal_history.created_at', 'like', '%' . "$search" . '%')
                            ->orWhere('users_withdrawal_history.charge_ruppe', 'like', '%' . "$search" . '%');
                    });
                }

                $purchase_product_list = $adminTransferEarning->unionAll($productAdmin_charge)->unionAll($usersWthdrawalDetails);

                $dataTotal = $purchase_product_list->get();

                $totalAmount = 0;
                if($dataTotal){
                    $dataTotal = collect($dataTotal);
                    $totalAmount = number_format($dataTotal->sum('amount'),2);
                }

                // Apply sorting
                $purchase_product_list->orderBy($sortColumn, $sortOrder);

                $data = $purchase_product_list->paginate($perPage);

                return response()->json(['status' => 200, 'data' => $data , 'totalAmount' => $totalAmount]);

            } catch (\Exception $e) {
                Log::error("DashboardController (myEarning) : ", ["Exception" => $e->getMessage(), "\nTraceAsString" => $e->getTraceAsString()]);
                return response()->json(['status' => 400, 'data' => ['message' => 'Something went wrong. Please try after sometime.', 'data' => json_decode('{}')]]);
            }



    }
}

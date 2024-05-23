<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;


use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show() : View{
        $user= auth()->user()->id;

        // count total sales
        $offering = DB::table('offering')
                    ->where('Farmer_Id', '=', $user)
                    ->where('status', '=', 'Complete')
                    ->count();
        $order = DB::table('orders')
                    ->where('Farmer_Id', '=', $user)
                    ->where('status', '=', 'Complete')
                    ->count();


        // calculate total sales
        $totalSales = $order + $offering;


        // count total revenue
        $off = DB::table('offering')
                    ->where('Farmer_Id', '=', $user)
                    ->where('status', '=', 'Complete')
                    ->sum('Offer_Price');
                   
        $ord = DB::table('orders')
                    ->where('Farmer_Id', '=', $user)
                    ->where('status', '=', 'Complete')
                    ->sum('Total_Price');
  
        // calculate the total revenue
        $totalRevenue = $off + $ord;


        // count orders data
        $today = Carbon::today()->format('Y-m-d');
        

        $ordData = DB::table('orders')
                    ->where('Farmer_Id', '=', $user)
                    ->whereDate('created_at', $today)
                    ->count();

        
        // count top selling product 
        $dataOrd = DB::table('harvests')
                ->select([
                    'harvests.id',
                    'harvests.Harv_ID',
                    'harvests.Image_Harv',
                    'harvests.Harv_Name',
                    // DB::raw('SUM(offering.Qty) as total_sales'),
                    DB::raw('SUM(orders.Qty) as total_sales')
                ])
                ->join('orders', 'orders.Harv_Id', '=', 'harvests.id')
                ->where('orders.status','Complete')
                ->groupBy('orders.Harv_Id', 'orders.Harv_Name', 'harvests.id',
                'harvests.Harv_Name', 'harvests.Harv_ID','harvests.Image_Harv')
                ->orderByDesc('total_sales')
                ->get();

        $dataOff = DB::table('harvests')
                ->select([
                    'harvests.id',
                    'harvests.Harv_ID',
                    'harvests.Image_Harv',
                    'harvests.Harv_Name',
                    DB::raw('SUM(offering.Qty) as total_sales'),
                    // DB::raw('SUM(orders.Qty) as total_sales'),
                ])
               
                ->join('offering', 'offering.Harv_Id', '=', 'harvests.id')
                ->where('offering.status','Complete')
                ->groupBy('offering.Harv_Id','offering.Harv_Name','harvests.id','harvests.Harv_Name', 'harvests.Harv_ID',
                'harvests.Image_Harv' )
                ->orderByDesc('total_sales')
                ->get();

                if(('offering.Harv_Name') > 1){
                    DB::raw('SUM(offering.Qty) as total_sales');
                    if(('offering.Harv_Name') === ('orders.Harv_Name')){
                        DB::raw('SUM(offering.Qty)(orders.Qty) as total_sales');
                    }
                }
                if(('orders.Harv_Name') > 1){
                    DB::raw('SUM(orders.Qty) as total_sales');
                    if(('orders.Harv_Name') === ('offering.Harv_Name')){
                        DB::raw('SUM(orders.Qty)(offering.Qty) as total_sales');
                    }
                }

            $allItem = $dataOrd->merge($dataOff)->take(5)->all();
                    
            return view('dashboard.index', [ 
                'title' => 'Dashboard',  
                'totalSales' => $totalSales,
                'totalRevenue' => $totalRevenue,
                'orderToday' =>  $ordData,
                'activity' =>  $allItem
            ]);
    }

    
    
   
}

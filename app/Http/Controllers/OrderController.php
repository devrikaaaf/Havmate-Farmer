<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Harvest;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sendOrder($id)
    {
        $ord = new Order();
        
        $harv = Harvest::find($id);
        
        $ord->Order_ID = IdGenerator::generate([
         'table' => 'orders',
         'field' => 'Order_ID',
         'length' => 7,
         'prefix' => 'ORD'
     ]);
        $ord->Dist_Id = auth()->user()->id;
        $ord->Dist_Name= auth()->user()->username;
        $ord->Farmer_Id = $harv->Farmer_Id;
        $ord->Farmer_Name = $harv->Farmer_Name;
        $ord->Harv_Id = $id;
        $ord->Harv_Name = $harv->Harv_Name;
        $ord->Qty= request('inputQty');
        $ord->Price= $harv->Harv_Price;
        $ord->Total_Price= request('inputTotalPrice');
        $ord->Notes= request('inputNotes');
        $ord->status= 'Waiting';

        // decrease the stock
        // collect the qty of product
        $qty = $ord->Qty; 
        // collect the current stock of product
        $harvStock = $harv->Harv_Stock;
        // product id
        $hrv_id = $harv->id;

        $current = $harvStock - $qty;

        // update the data on database
        DB::update('update harvests set Harv_Stock=? where id=?', [$current, $hrv_id]);

        $ord->save(); 
     return redirect('/dashboard/ordering/fromDistributor/index');
    }

    public function showToFarmer() : View
    {
        return view('/dashboard/ordering/index', [
            'title' => 'Incoming Orders',  
            'ordering' => Order::paginate(10),
        ]);
    }

    public function showForm($id)
    {
        return view('dashboard/ordering/order', [ 
            'title' => 'Send Order',  
            'product' => Harvest::find($id),
            'user' => User::all(),   
            ]);
    }

    public function deleteOrder($id)
    {   
        DB::table('orders')->where('id', '=', $id)->delete();

        return redirect()->back();
    }

    public function editOrder($id)
    {
        return view('/dashboard/ordering/editOrder', [
            'title' => 'Edit Order Data',
            'ord' => Order::find($id),
            'product' => Harvest::all(),
        ]);
    }
    public function updateOrder(Request $request, $id)
    {
        
        $ord = Order::find($id);

        $Dist_Name = $ord->Dist_Name; 
        $Harv_Name = $ord->Harv_Name; 
        $Qty = $request->input('inputHarvQty'); 
        $Total_Price = $request->input('inputTotalPrice'); 
        $Notes = $request->input('inputNotes'); 
        
        // update the data on database
        DB::update('update orders set Dist_Name=?, Harv_Name = ?,  Qty=?, Total_Price=?, Notes=? where id=?', [$Dist_Name, $Harv_Name, $Qty, $Total_Price, $Notes, $id]);

        return view('/dashboard/ordering/index', [
            'title' => 'Order Status',
            'ordering' => Order::all()
        ]);
    }

    public function showToDistributor() : View
    {
        return view('/dashboard/ordering/index', [
            'title' => 'Order Status',  
            'ordering' => Order::paginate(10),
        ]);
    }

    //  when the farmer accept the order
    public function acceptOrder($id): View
    {
        // update into order table
        DB::update('update orders set status=? where id=?', ["Accepted", $id]);

        return view('/dashboard/ordering/index', [
            'title' => 'Incoming Orders',  
            'ordering' => Order::paginate(10),
        ]);
    }
    //  when the farmer accept the order
    public function declineOrder($id): View
    {
        // update into order table
        DB::update('update orders set status=? where id=?', ["Declined", $id]);

        return view('/dashboard/ordering/index', [
            'title' => 'Incoming Orders',  
            'ordering' => Order::paginate(10),
        ]);
    }
    //  when the distributor return the order product
    public function returnOrder($id): View
    {
        // update into orders table
        DB::update('update orders set status=? where id=?', ["Return", $id]);

        return view('/dashboard/ordering/index', [
            'title' => 'Order Status',  
            'ordering' => Order::paginate(10),
        ]);
    }
    //  when the distributor complete the order
    public function completeOrder($id): View
    {
        // update into orders table
        DB::update('update orders set status=? where id=?', ["Complete", $id]);

        return view('/dashboard/ordering/index', [
            'title' => 'Order Status',  
            'ordering' => Order::paginate(10),
        ]);
    }
}

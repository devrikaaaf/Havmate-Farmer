<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OfferingNotification;
use App\Models\Harvest;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Offering;
use App\Models\Distributor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OfferingController extends Controller
{
    // when farmer send the offering to the distributor
    public function sendOffer($id)
    { 
        // create new offering
        $off = new Offering();
        
        // save the user id (farmer) in a variable
        $farm = auth()->user()->id;

        // find distributor data based on the id from the route
        $dist = Distributor::find($id);

        // find the farmer's product based on the harvest name
        $harv= Harvest::where('Harv_Name','=',request('inputHarvName'))->first();

        // generate Offer_ID
        $off->Offer_ID = IdGenerator::generate([
         'table' => 'offering',
         'field' => 'Offer_ID',
         'length' => 7,
         'prefix' => 'OFR'
     ]);
        $off->Dist_Id = $id;
        $off->Dist_Name= $dist->Dist_Name;
        $off->Farmer_Id = $farm;
        $off->Farmer_Name = auth()->user()->username;
        $off->Harv_Id = $harv->id; 
        $off->Harv_Name = request('inputHarvName');
        $off->Qty= request('inputHarvQty');
        $off->Offer_Price= request('inputTotalPrice');
        $off->Notes= request('inputNotes');
        $off->status= 'Waiting';

        $off->save(); 

        // decrease the stock
        // collect the qty of product
        $qty = $off->Qty; 
        // collect the current stock of product
        $harvStock = $harv->Harv_Stock;
        // product id
        $hrv_id = $harv->id;

        $current = $harvStock - $qty;

        // update the data on database
        DB::update('update harvests set Harv_Stock=? where id=?', [$current, $hrv_id]);

     return redirect('/dashboard/offering/fromFarmer/index');

    }

    // show offering form 
    public function showForm($id)
    {
        $prod = DB::table('harvests')->where('Harv_Stock', '>', 0)->get();

        return view('dashboard/offering/offer', [ 
            'title' => 'Send Offering',  
            'product' => $prod,
            'user' => User::all(),
            'dist' => Distributor::find($id)     
            ]);
    }
 
    // show all the offering to the farmer
    public function showToFarmer() : View
    {
        return view('/dashboard/offering/index', [
        'title' => 'Offering Status',  
        'offering' => Offering::paginate(10),
        ]);
    }

    // delete offering's data
    public function delete($id)
    { 
        DB::table('offering')->where('id', '=', $id)->delete();

        return redirect()->back();
    }

    // show the form to edit offering's data
    public function edit($id)
    {
        return view('/dashboard/offering/editOff', [
            'title' => 'Edit Offering data',
            'off' => Offering::find($id),
            'product' => Harvest::all(),
        ]);
    }

    // update the offering's data 
    public function update(Request $request, $id): View
    {
        
        $off = Offering::find($id);

        $Dist_Name = $off->Dist_Name; 
        $Harv_Name = $request->input('inputHarvName'); 
        $Qty = $request->input('inputHarvQty'); 
        $Offer_Price = $request->input('inputTotalPrice'); 
        $Notes = $request->input('inputNotes'); 
        
        // update the data on database
        DB::update('update offering set Dist_Name=?, Harv_Name = ?,  Qty=?, Offer_Price=?, Notes=? where id=?', [$Dist_Name, $Harv_Name, $Qty, $Offer_Price, $Notes, $id]);

        return view('/dashboard/offering/index', [
            'title' => 'Offering Status',
            'offering' => Offering::paginate(10)
        ]);
    }

    // show the incoming offers in distributor page
    public function showToDistributor(): View
    {
        return view('/dashboard/offering/index', [
            'title' => 'Incoming Offers',  
            'offering' => Offering::paginate(10),
        ]);
    }

    //  when the distributor acceptthe offering
    public function acceptOffering($id): View
    {
        // update into offering table
        DB::update('update offering set status=? where id=?', ["Accepted", $id]);

        return view('/dashboard/offering/index', [
            'title' => 'Incoming Offers',  
            'offering' => Offering::paginate(10),
        ]);
    }

    // when the distributor decline the offering
    public function declineOffering($id): View
    {
        // update into offering table
        DB::update('update offering set status=? where id=?', ["Declined", $id]);

        // restore the stock
        // find the offering's id
        $offering = Offering::find($id);
        // collect the qty of product from the offering's data
        $harv = $offering->Qty;
        // collect the product id from the offering's data                                                  
        $hrvId = $offering->Harv_Id;
        // find the product based on the id's on the harvests table
        $checkHrv = Harvest::find($hrvId);
        // latest stock 
        $stock = $checkHrv->Harv_Stock;

        // restore the products
        $restore = $harv + $stock;

        // update stock in the database
        DB::update('update harvests set Harv_Stock=? where id=?' , [$restore, $hrvId]);

        return view('/dashboard/offering/index', [
            'title' => 'Incoming Offers',  
            'offering' => Offering::paginate(10),
        ]);
    }

    //  when the distributor return the offering's product
    public function returnOffering($id): View
    {
        // update into offering table
        DB::update('update offering set status=? where id=?', ["Return", $id]);

        return view('/dashboard/offering/index', [
            'title' => 'Incoming Offers',  
            'offering' => Offering::paginate(10),
        ]);
    }

     //  when the distributor complete the offering
     public function completeOffering($id): View
     {
         // update into offering table
         DB::update('update offering set status=? where id=?', ["Complete", $id]);
 
         return view('/dashboard/offering/index', [
             'title' => 'Incoming Offers',  
             'offering' => Offering::paginate(10),
         ]);
     }
}

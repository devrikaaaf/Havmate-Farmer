
@extends('dashboard.layouts.main')

@section('container')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Edit your order data, {{ auth()->user()->username }}!</h5>

    <!-- Edit offering form -->
    <form action= "/dashboard/ordering/update/{{$ord->id }}" method="post" 
    enctype="multipart/form-data" class="row g-3">
      @csrf
      <div class="col-md-6">
        <label for="inputDistName">Distributor Name</label>
          <input type="text" name="inputDistName"class="form-control" id="inputDistName" value="{{$ord->Dist_Name }}" disabled>
      </div>

      <div class="col-md-6">
        <label for="inputHarvName">Product Name</label>
          <input type="text" name="inputHarvName"class="form-control" id="inputHarvName" value="{{$ord->Harv_Name }}" disabled>
      </div>


      <div class="col-md-6">
        <label for="inputHarvQty">Quantity (/kg)</label>
        <input type="text" value="{{number_format($ord->Qty) }}" name="inputHarvQty" class="form-control" id="inputHarvQty" placeholder="ex : 20" required>
      </div>

      <div class="col-md-6">
        <label for="inputTotalPrice">Total Price</label>
          <div class="input-group col-sm-10">
            <span class="input-group-text" id="inputGroupPrepend">Rp</span>
            <input type="text" value="{{number_format($ord->Total_Price) }}" name="inputTotalPrice" class="form-control" id="inputTotalPrice" placeholder="ex : 240000" required>
            <div class="invalid-feedback">Please input your product's price!</div>
          </div>
      </div>
      
      <div class="inputNotes col-md-6">
        <label for="inputNotes">Notes</label>
        <input type="text" value="{{$ord->Notes }}" name="inputNotes" class="form-control" id="inputNotes">
      </div>


      <div class="text-center mt-5">
        <button type="submit" class="btn btn-primary">Update Order</button>
      </div>

</form>

  </div>
</div>
@endsection



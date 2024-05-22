
@extends('dashboard.layouts.main')
@section('container')

@can('FarmerCheck')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Your Product</h5>
   
    <!-- Bordered Table -->
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th scope="col">Harvest Id</th>
          <th scope="col">Harvest Result</th>
          <th scope="col">Price (/kg)</th>
          <th scope="col">Stock (kg)</th>
          <th scope="col">Image</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $prod)
         @if(auth()->user()->username === $prod->Farmer_Name)
            <tr>
              <td>{{ $prod->Harv_ID}}</th>
              <td>{{ $prod->Harv_Name}}</td>
              <td>{{ $prod->Harv_Price}}</td>
              <td>{{ $prod->Harv_Stock}}</td>
              <td>
                <img src="{{ $prod->Image_Harv}}"
                style="height: 100px; width: 150px;">
              </td>
              <td>

                {{-- delete button --}}
                <a href="/dashboard/products/index/{{ $prod->id }}" class="btn btn-danger" style="color: white; text-decoration: none">
                  <i class="bi bi-trash3" style="color: white;text-decoration: none"></i> Delete
                </a>

                {{-- edit button --}}
                <a href="/dashboard/products/editProd/{{ $prod->id }}" class="btn btn-primary" style="color: white;text-decoration: none">
                  <i class="bi bi-pen" style="color: white;text-decoration: none"></i> Edit
                </a>
               
              </td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
    <!-- End Bordered Table -->
  </div>
</div>
@endcan


@can('DistributorCheck')

{{-- search bar --}}
<div class="row height d-flex justify-content-center align-items-center">

  <div class="col-md-8">
    <div class="search">
      <i class="fa fa-search"></i>
      <input type="text" class="form-control" placeholder="Search products here...">
      <button class="btn">Search</button>
    </div>
  </div>
</div>
<br>
<br>

{{-- Show the distributor lists from database --}}    
    <div class="flex-container" >  
       @foreach ($products as $prod) 
          <div class="card">
            <a href = "/dashboard/products/prod/{{ $prod->id}}"  style="text-decoration: none;">
              <img src="{{ $prod->Image_Harv }}" class="card-img-top" alt="..."  style="width:200; height: 120; margin-top: 20px">
              <div class="card-body">
                <h5 class="card-title"> {{ $prod->Harv_Name }}</h5>
                <p class="card-text">
                 Rp.{{ number_format($prod->Harv_Price )}} /kg
                </p>
              </div>
            </a>
          </div>
      @endforeach           
    </div>
@endcan

@endsection

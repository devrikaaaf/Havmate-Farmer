

@extends('dashboard.layouts.main')

{{-- Detail Product --}}
@section('container')

<a href="/dashboard/ordering/fromDistributor/index">
    <button type="button" class="btn mb-4" style="background: #0D261D; color: white; border: #0D261D; border-radius: 4px;" >
        <i class="ri-arrow-left-line"></i>
        Back
    </button>
</a>
<br>
<section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="{{ $products->Image_Harv }}" alt="Profile" style="height: 100px; width: 400px;">
            <h2>{{ $products->Harv_Name }}</h2><br>
            <span class="h6"><b>Price</b> Rp.{{ $products->Harv_Price}} | <b>Stock :</b> {{ $products->Harv_Stock}} kg</span> 
            <div class="social-links mt-2">
                <a href="/dashboard/ordering/order/{{ $products->id }}" >
                    <button type="button" class="btn-order">Order</button>
                </a>
                <a href="/chat/{{ $products->Farmer_ID }}">
                <button type="button" class="btn-chat" >Chat</button>
                </a>
              </div>  
          </div>
        </div>
      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">

            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
            </ul>

            {{-- overview --}}
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Product Details</h5>

                
                <div class="row">
                    <div class="col-lg-3 col-md-4 label">ID</div>
                    <div class="col-lg-9 col-md-8">{{ $products->Harv_ID}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Harvest Result Name </div>
                  <div class="col-lg-9 col-md-8">{{ $products->Harv_Name }}</div>
                </div>
          
                {{-- @if($products->Farmer_Id === $farmer->id) --}}
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Farmer Name</div>
                  <div class="col-lg-9 col-md-8">{{ $products->Farmer_Name}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Farmer Address</div>
                  <div class="col-lg-9 col-md-8">{{ $farmer->address }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8">{{ $farmer->phone}}</div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $farmer->email}}</div>
                </div>
                {{-- @endcan
                @endforeach --}}

              </div>

              {{-- Purchase Needs
                <div class="tab-pane fade profile-purchase" id="profile-purchase">
                  <h5 class="card-title">Purchase Needs</h5>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Purchase needs</div>
                    <div class="col-lg-9 col-md-8">{{ $product->Purchase_Needs }}</div>
                  </div>
                </div>
              
                {{-- Products --}}
                    {{-- <div class="tab-pane fade profile-product" id="profile-product">
                      <h5 class="card-title">Products</h5>
      
                      <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Product Name</div>
                        <div class="col-lg-9 col-md-8">{{ $product->DistProd_Name}}</div>
                      </div>
                    </div> --}} 
               
          </div><!-- End Bordered Tabs -->
        </div>

      </div>
    </div>
</section>


@endsection
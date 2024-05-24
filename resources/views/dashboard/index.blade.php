
@extends('dashboard.layouts.main')
@extends('dashboard.layouts.template')

@section('container')

@can('FarmerCheck')
<body>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Welcome back, {{ auth()->user()->username }} !</h1>

</div>
  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      {{-- <div class="col-lg-10"> --}}
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title"> Total Sales </h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6> {{ $totalSales }}</h6>
                  </div>
                </div>
              </div>
              
            </div>
          </div><!-- End Sales Card -->

          <!-- Orders Card -->
          <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">

              <div class="card-body">
                <h5 class="card-title">Orders <span>| <h7> Today </h7></h5></span>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $orderToday}}</h6>
                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Orders Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-7">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Revenue </h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>Rp. {{ number_format($totalRevenue) }}</h6>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Activity -->
          <div class="col-12">
            <div class="card top-selling overflow-auto">

              <div class="card-body pb-0">
                <h5 class="card-title">Top Product </h5>

                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th scope="col">Product</th>
                      <th scope="col">Product ID</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Sold</th>   
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($activity  as $i => $item)
                    <tr>
                      <td><img src="{{ $item->Image_Harv }}" style="height: 60px; width: 100px;"></td>
                          <td>{{ $item->Harv_ID }}</td>
                         <td> {{ $item->Harv_Name }} </td>
                         <td> {{ $item->total_sales }} kg</td>

                    </tr>
                  @endforeach
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Top Selling -->

        </div>
      </div><!-- End Left side columns -->

   

    </div>
  </section>
</body>
@endcan

@can('DistributorCheck')

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('208228a228e1f81fec76', {
    cluster: 'ap1'
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('offer-submitted', function(data) {
    if(data && data.offer && data.offer.farmer && data.offer.product && data.offer.qty){

      const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-right',
                  iconColor: '#0D261D',
                  showConfirmButton: false,
                  showCloseButton: true,
    
                  didOpen: (toast) => {
                  toast.onmouseenter = Swal.stopTimer;
                  toast.onmouseleave = Swal.resumeTimer;
                }
                });
               Toast.fire({
                  icon: 'warning',
                  title: 'New Offers!',
                  text: 'From : ' + data.offer.farmer +
                 ' ' + data.offer.product + ' ' + data.offer.qty + ' kg'
              });
    }else{
      console.error('Invalid data structure received : ' + data);
    }

  });
</script>

  
  @if( auth()->user()->role === 'Distributor')

  <body>
           <form action="/dashboard/notification/notif" method="post">
                    @csrf
                      <div class="form-group">
                        <label for="Purchase_Needs" class="form-label">Harvest Products That You Need </label>
                          <input type="text" id="Purchase_Needs" name="Purchase_Needs"  class="form-control" placeholder="Ex : Tomatoes, Potatoes, Spinach" required>
                      </div>
                      <div class="form-group">
                        <label for="CustProd_Name" class="form-label">Your Products</label>
                          <input type="text" id="CustProd_Name" name="CustProd_Name" class="form-control" placeholder="Ex : Potabee, Belibis Tomato" required>
                      </div>
                      <div class="form-group">
                        <label for="CustProd_Desc" class="form-label">Your Product's Description</label>
                          <input type="text" id="CustProd_Desc" name="CustProd_Desc"  class="form-control" placeholder="Ex : I need potato for Potabee's production" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
            </form>
  @endif
  </body> 
  @endcan
@endsection

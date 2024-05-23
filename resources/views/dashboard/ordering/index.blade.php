
@extends('dashboard.layouts.main')
@section('container')

<div class="card">
  <div class="card-body mt-4">

  @can('DistributorCheck')      
    {{-- Order Status --}}
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Order_ID</th>
          <th scope="col">Products</th>
          <th scope="col">Quantity (kg)</th>
          <th scope="col">Farmer Name</th>
          <th scope="col">Total Price</th>
          <th scope="col">Notes</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach ($ordering as $order)
          @if(auth()->user()->id === $order->Dist_Id)
          <tr>
              <td>{{ $order->Order_ID}}</td>
              <td>{{ $order->Harv_Name}}</td>
              <td>{{ $order->Qty}}</td>
              <td>{{ $order->Farmer_Name}}</td>
              <td>Rp.{{ number_format($order->Total_Price)}}</td>
              <td>{{ $order->Notes}}</td>
              <td>
     
                <div id="status">
                @if($order->status === 'Accepted')
                  <button class="btn btn-info" style="cursor:default;">Delivery Process</button>
                @endcan
                @if($order->status === 'Waiting')
                  <button class="btn btn-warning" style="cursor:default;">Waiting</button>
                @endcan
                @if($order->status === 'Declined')
                  <button class="btn btn-danger" style="cursor:default;">Declined</button>
                @endcan
                @if($order->status === 'Complete')
                  <button class="btn btn-success" style="cursor:default;">Complete</button>
                @endcan
                @if($order->status === 'Return')
                <button class="btn btn-secondary" style="cursor:default;">Return</button>
              @endcan
                </div>
              
              </td>
              <td>
                @if($order->status === 'Accepted')
                 {{-- delete button --}}
                 <a href="/dashboard/ordering/returnOrder/{{ $order->Farmer_Id }}" class="btn btn-secondary" style="color: white; text-decoration:none">
                  <i class="bi bi-arrow-counterclockwise" style="color: white;text-decoration:none"></i> Return
                </a>
                 {{-- delete button --}}
                 <a href="/dashboard/ordering/completeOrder/{{ $order->id }}" class="btn btn-success" style="color: white;text-decoration:none">
                  <i class="bi bi-bag-check" style="color: white;text-decoration:none"></i> Complete
                </a>
                @endcan

                @if($order->status === 'Waiting')
                {{-- delete button --}}
                <a href="/dashboard/ordering/index/{{ $order->id }}" class="btn btn-danger" style="color: white;text-decoration:none">
                  <i class="bi bi-trash3" style="color: white;text-decoration:none"></i> Delete
                </a>

                {{-- edit button --}}
                <a href="/dashboard/ordering/index/{{ $order->id }}" class="btn btn-primary" style="color: white;text-decoration:none">
                  <i class="bi bi-pen" style="color: white;text-decoration:none"></i> Edit
                </a>
                @endif
               
               
              </td>          
          </tr>
         @endif
         @endforeach
        
        </tr>
      </tbody>
    </table>
   @endcan


   @can('FarmerCheck')      
    {{-- Order Status --}}
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Order_ID</th>
          <th scope="col">Products</th>
          <th scope="col">Quantity (kg)</th>
          <th scope="col">Distributor Name</th>
          <th scope="col">Total Price</th>
          <th scope="col">Notes</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach ($ordering as $order)
          @if(auth()->user()->id === $order->Farmer_Id)
          <tr>
              <td>{{ $order->Order_ID}}</td>
              <td>{{ $order->Harv_Name}}</td>
              <td>{{ $order->Qty}}</td>
              <td>{{ $order->Dist_Name}}</td>
              <td>Rp.{{ number_format($order->Total_Price)}}</td>
              <td>{{ $order->Notes}}</td>
              <td>
                <div id="status">
                  @if($order->status === 'Accepted')
                    <button class="btn btn-info" style="cursor:default;">Delivery Process</button>
                  @endcan
                  @if($order->status === 'Waiting')
                    <button class="btn btn-warning" style="cursor:default;">Waiting</button>
                  @endcan
                  @if($order->status === 'Declined')
                    <button class="btn btn-danger" style="cursor:default;">Declined</button>
                  @endcan
                   @if($order->status === 'Complete')
                  <button class="btn btn-success" style="cursor:default;">Complete</button>
                @endcan
                @if($order->status === 'Return')
                <button class="btn btn-secondary" style="cursor:default;">Return</button>
              @endcan
                  </div>
              </td>
              <td>

                @if($order->status === 'Waiting')
                 {{-- accept button --}}
                 <a href="/dashboard/ordering/acceptOrder/{{ $order->id }}" class="btn btn-success" id= "btnAccept"  style="color: white; text-decoration:none;">
                  <i class="bi bi-check-circle" style="color: white;"></i> Accept
                </a>

                {{-- decline button --}}
                <a href="/dashboard/ordering/declineOrder/{{ $order->id }}" class="btn btn-danger" id= "btnDecline"  style="color: white; text-decoration:none;">
                  <i class="bi bi-ban" style="color: white;"></i> Decline
                </a> 
                @endcan
              </td>          
          </tr>
         @endif
         @endforeach
        
        </tr>
      </tbody>
    </table>
   @endcan

    {{-- pagination --}}
    <div class="page d-flex">
      {{ $ordering->links() }}
    </div>

  </div>
</div>

@endsection

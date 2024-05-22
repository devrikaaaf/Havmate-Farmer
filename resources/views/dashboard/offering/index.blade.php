
@extends('dashboard.layouts.main')
@section('container')

<div class="card">
  <div class="card-body mt-4">
   
    @can('FarmerCheck')
    {{-- Farmer Page --}}
    {{-- show all the offering status --}}
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Offer_ID</th>
          <th scope="col">Distributor</th>
          <th scope="col">Product</th>
          <th scope="col">Quantity (kg)</th>
          <th scope="col">Total Price</th>
          <th scope="col">Notes</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          @foreach ($offering as $off)
          {{-- check the user with their offering data --}}
          @if(auth()->user()->username === $off->Farmer_Name)
          <tr>
              <td>{{ $off->Offer_ID}}</td>
              <td>{{ $off->Dist_Name}}</td>
              <td>{{ $off->Harv_Name}}</td>
              <td>{{ $off->Qty}}</td>
              <td>Rp.{{ number_format($off->Offer_Price)}}</td>
              <td>{{ $off->Notes}}</td>
              <td>
                
                <div id="process">
                  @if($off->status === 'Accepted')
                    <button class="btn btn-success" style="cursor:default;">Accepted</button>
                  @endcan
                  @if($off->status === 'Waiting')
                    <button class="btn btn-warning" style="cursor:default;">Waiting</button>
                  @endcan
                  @if($off->status === 'Declined')
                    <button class="btn btn-danger" style="cursor:default;">Declined</button>
                  @endcan
                  {{-- if the status complete --}}
                  @if($off->status === 'Complete')
                  <button class="btn btn-success" style="cursor:default;">Complete</button>
                @endcan
                @if($off->status === 'Return')
                <button class="btn btn-secondary" style="cursor:default;">Return</button>
              @endcan
                  </div>
                
              </td> 
              <td>
                @if($off->status === 'Waiting')
                {{-- delete button --}}
                <a href="/dashboard/offering/index/{{ $off->id }}" class="btn btn-danger" id="btnDelete" style="color: white; text-decoration:none">
                  <i class="bi bi-trash3" style="color: white;"></i> Delete
                </a>

                {{-- edit button --}}
                <a href="/dashboard/offering/editOff/{{ $off->id }}" class="btn btn-primary" id="btnEdit" style="color: white;text-decoration:none">
                  <i class="bi bi-pen" style="color: white;"></i> Edit
                </a>
                @endif
                
              </td>  
             
          </tr>
         @endif
         @endforeach
        </tr>
      </tbody>
    @endcan


      
      @can('DistributorCheck')
      {{-- Distributor Page --}}
       {{-- show all the offering status --}}
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Offer_ID</th>
              <th scope="col">Farmer Name</th>
              <th scope="col">Product</th>
              <th scope="col">Quantity (kg)</th>
              <th scope="col">Total Price</th>
              <th scope="col">Notes</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              @foreach ($offering as $off)
              {{-- check the user with their offering data --}}
              @if(auth()->user()->username === $off->Dist_Name)
              <tr>
                  <td>{{ $off->Offer_ID}}</td>
                  <td>{{ $off->Farmer_Name}}</td>
                  <td>{{ $off->Harv_Name}}</td>
                  <td>{{ $off->Qty}}</td>
                  <td>Rp.{{ number_format($off->Offer_Price)}}</td>
                  <td>{{ $off->Notes}}</td>
                  <td>
                    <div id="status">
                      {{-- if the status accepted --}}
                      @if($off->status === 'Accepted')
                        <button class="btn btn-info" style="cursor:default;">Delivery Process</button>
                      @endcan
                      {{-- if the status waiting --}}
                      @if($off->status === 'Waiting')
                        <button class="btn btn-warning" style="cursor:default;">Waiting</button>
                      @endcan
                      {{-- if the status declined --}}
                      @if($off->status === 'Declined')
                        <button class="btn btn-danger" style="cursor:default;">Declined</button>
                      @endcan
                      {{-- if the status complete --}}
                      @if($off->status === 'Complete')
                      <button class="btn btn-success" style="cursor:default;">Complete</button>
                    @endcan
                    @if($off->status === 'Return')
                <button class="btn btn-secondary" style="cursor:default;">Return</button>
              @endcan
                      </div>
                  </td> 
                  <td>
                     {{-- if the status accepted, shows the return and complete buttons --}}
                    @if($off->status === 'Accepted')
                    {{-- return button --}}
                    <a href="/dashboard/offering/fromFarmer/returnOffering/{{ $off->Dist_Id}}" class="btn btn-secondary" style="color: white; text-decoration:none">
                      <i class="bi bi-arrow-counterclockwise" style="color: white;text-decoration:none"></i> Return
                    </a>
                    {{-- complete button --}}
                    <a href="/dashboard/offering/fromFarmer/completeOffering/{{ $off->id }}" class="btn btn-success" style="color: white;text-decoration:none">
                      <i class="bi bi-bag-check" style="color: white;text-decoration:none"></i> Complete
                    </a>
                    @endcan

                    {{-- if the status waiting, shows the accept and decline buttons --}}
                    @if($off->status === 'Waiting')
                    {{-- accept button --}}
                    <a href="/dashboard/offering/fromFarmer/acceptOffering/{{ $off->id }}" class="btn btn-success" id= "btnAccept"  style="color: white; text-decoration:none;">
                      <i class="bi bi-check-circle" style="color: white;"></i> Accept
                    </a>

                    {{-- decline button --}}
                    <a href="/dashboard/offering/fromFarmer/declineOffering/{{ $off->id }}" class="btn btn-danger" id= "btnDecline"  style="color: white; text-decoration:none;">
                      <i class="bi bi-ban" style="color: white;"></i> Decline
                    </a> 
                    @endif
                  </td>  
              </tr>
            @endif
            @endforeach
            </tr>
          </tbody>
      @endcan
    </table>
    <!-- End Default Table Example -->

        {{-- pagination --}}
        <div class="page d-flex">
          {{ $offering->links() }}
        </div>

  </div>
</div>
@endsection

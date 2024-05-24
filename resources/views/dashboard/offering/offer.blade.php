
@extends('dashboard.layouts.main')

@section('container')


<div class="card">
  <div class="card-body">
    <h5 class="card-title">Send your product, {{ auth()->user()->username }}!</h5>

    <!-- Offering Form -->
    <form action= "/dashboard/offering/index/{{ $dist->id }}" method="post" 
    enctype="multipart/form-data" class="row g-3">
      @csrf
      <div class="col-md-5">
        <label for="inputDistName">Distributor Name</label>
          <input type="text" name="inputDistName"class="form-control" id="inputDistName" value="{{ $dist->Dist_Name }}" readonly>
      </div>

      <div class="col-md-4">
        <label for="inputHarvName">Harvest Result</label>
        <div class="input-group" >
          <select class="form-select mt-0" id="floatingSelect" name="inputHarvName" aria-label="Harvest Type">
            <option id="inputHarvName" selected>Choose your product</option>
              @foreach($product as $item)
              {{-- check the user's product --}}
                  @if(auth()->user()->username === $item->Farmer_Name)
                      <option value="{{ $item->Harv_Name}}" data-stock="{{ $item->Harv_Stock }}" data-price="{{ $item->Harv_Price }}"
                        >{{ $item->Harv_Name }}</option>  

                  @endif
              @endforeach 
          </select>
        </div>
      </div>

      <div class="col-md-3">
        <label for="inputHarvStock">Stock (kg)</label>
        <input type="text" name="inputHarvStock" class="form-control" id="inputHarvStock"  readonly>
      </div>

      <div class="col-md-5">
        <label for="inputHarvPrice">Harvest Price (/kg)</label>
          <input type="text" name="inputHarvPrice"class="form-control" id="inputHarvPrice"  readonly>
      </div>

      
              
      <div class="col-md-6">
        <label for="inputHarvQty">Quantity (kg)</label>
        <input type="text" name="inputHarvQty" class="form-control" id="inputHarvQty" placeholder="ex : 20" required>
      </div>

      <div class="col-md-6">
        <label for="inputTotalPrice">Total Price</label>
          <div class="input-group col-sm-10">
            <span class="input-group-text" id="inputGroupPrepend">Rp</span>
            <input type="text" name="inputTotalPrice" class="form-control" id="inputTotalPrice"  readonly>
            
          </div>
      </div>
      
      <div class="inputNotes col-md-6">
        <label for="inputNotes">Notes</label>
        <input type="text" name="inputNotes" class="form-control" id="inputNotes">
      </div>


      <div class="text-center mt-5">
        <button type="submit" class="btn-offer" onclick="confirmationOffer(event)">Send offering</button>
      </div>

</form>

  </div>
</div>

<script>
  $(document).ready(function() {
      // fill the input field based on the selected product
      $('#floatingSelect').on('change', function(){
          // collect data from the selected prodcut
          const price = $('#floatingSelect option:selected').data('price');
          const stock = $('#floatingSelect option:selected').data('stock');
          
          // show data on the field
          $('[name=inputHarvPrice]').val(price);
          $('[name=inputHarvStock]').val(stock);   

           // when the inputTotalPrice onfocus, calculate the total price
           $('#inputTotalPrice').on('focus', function(){
            
              // collect the quantity value from user input
              const qty = document.getElementById('inputHarvQty').value;
              $('[name=inputHarvQty]').val(qty);

                    // if products are out-of-stock
                    if(qty > stock){
                      const needStock = qty - stock;
                        Swal.fire({
                        icon: "info",
                        title: "Out of Stock",
                        text: "You need " + needStock + " kg more!",
                        
                        }).then(
                            // set the number of qty = 0
                            $('#inputHarvQty').val(0)
                          
                        );
              
                    }else{
                      // calculate the total price based on the quantity
                      const totalPrice = parseInt(qty) * parseInt(price);
                      $('[name=inputTotalPrice]').val(totalPrice);
                    }
                    
            });
      });
           
           
  });
 

   
</script>

@endsection



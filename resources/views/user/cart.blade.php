@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- Cart Content -->
<div class="container py-4">
  <h3 class="mb-4">Your Cart</h3>

  @if(count($cartItems) > 0)

    
  @csrf
    <div class="table-responsive">
      <table class="table align-middle table-bordered bg-white">
        <thead class="table-light">
          <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>Product</th>
            <th>Name</th>
            <th>Price</th>
            <th style="width: 120px">Quantity</th>
            <th>Subtotal</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cartItems as $item)
          <tr>
            <td><input type="checkbox" class="item-checkbox" name="selectedItems[]" value="{{ $item->id }}" data-subtotal="{{ $item->product->productPrice * $item->quantity }}"></td>
            <td><img src="{{ asset('storage/app/public/' . $item->product->productImage) }}" width="60" class="img-thumbnail"></td>
            <td>{{ $item->product->productName }}</td>
            <td>₱ {{ number_format($item->product->productPrice, 2) }}</td>
            <td>
              <form method="POST" action="{{ route('cart.update', $item->id) }}">
                @csrf

                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->productQuantity }}" class="form-control form-control-sm">
              </form>
            </td>
            <td>₱ {{ number_format($item->product->productPrice * $item->quantity, 2) }}</td>
            <td>
              <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-end">
      <h5>Total Selected: <strong id="selectedTotal">₱ 0.00</strong></h5>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <button type="submit" class="btn btn-success">Proceed to Checkout</button>
    </div>
 
  @else
    <div class="alert alert-info">Your cart is currently empty.</div>
  @endif
</div>

@endsection

@push('scripts')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalDisplay = document.getElementById('selectedTotal');
    const selectAll = document.getElementById('selectAll');

    function updateTotal() {
      let total = 0;
      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          total += parseFloat(checkbox.getAttribute('data-subtotal'));
        }
      });
      totalDisplay.textContent = `₱ ${total.toFixed(2)}`;
    }

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', updateTotal);
    });

    selectAll.addEventListener('change', function () {
      checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
      });
      updateTotal();
    });

    updateTotal();
  });
</script>

@endpush
</body>
</html>

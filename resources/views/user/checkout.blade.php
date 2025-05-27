@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
          <h4 class="mb-4 text-center fw-semibold">Checkout Summary</h4>

          <form method="POST" action="{{ route('checkout.submit') }}">
            @csrf
            @php $total = 0; @endphp

            <ul class="list-group list-group-flush mb-3">
              @foreach($cartItems as $item)
                @php
                  $subtotal = $item->product->productPrice * $item->quantity;
                  $total += $subtotal;
                @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-2">
                  <div>
                    <strong>{{ $item->product->productName }}</strong>
                    <small class="text-muted d-block" style="font-weight:700;">Quantity: x {{ $item->quantity }}</small>
                  </div>
                  <span style="font-weight:700;">₱{{ number_format($subtotal, 2) }}</span>
                </li>
                <input type="hidden" name="checkoutItems[]" value="{{ $item->id }}">
              @endforeach
            </ul>

            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-4">
              <h5 class="mb-0 fw-semibold">Total:</h5>
              <h5 class="mb-0 fw-bold" style="color:#0E753F;">₱{{ number_format($total, 2) }}</h5>
            </div>

            <div class="text-end">
              <button type="submit" class="btn px-4 py-2 rounded-3" style="color:white;background-color: #0E753F;">Place Order</button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

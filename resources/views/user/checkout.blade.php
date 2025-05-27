@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
  <h3 class="mb-4">Checkout</h3>

  <form method="POST" action="">
    @csrf
    @php $total = 0; @endphp

<ul class="list-group">
  @foreach($cartItems as $item)
    @php
      $subtotal = $item->product->productPrice * $item->quantity;
      $total += $subtotal;
    @endphp
    <li class="list-group-item d-flex justify-content-between align-items-center">
      {{ $item->product->productName }} x {{ $item->quantity }}
      <span>₱ {{ number_format($subtotal, 2) }}</span>
    </li>
    <input type="hidden" name="checkoutItems[]" value="{{ $item->id }}">
  @endforeach
</ul>

<div class="mt-3 text-end">
  <h5>Total: <strong>₱ {{ number_format($total, 2) }}</strong></h5>
</div>


    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Place Order</button>
    </div>
  </form>
</div>
@endsection

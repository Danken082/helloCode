@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
  <h3 class="mb-4">Checkout</h3>

  <form method="POST" action="">
    @csrf
    <ul class="list-group">
      @foreach($cartItems as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          {{ $item->product->productName }} x {{ $item->quantity }}
          <span>₱ {{ number_format($item->product->productPrice * $item->quantity, 2) }}</span>
        </li>
        <input type="hidden" name="checkoutItems[]" value="{{ $item->id }}">
      @endforeach
    </ul>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">Place Order</button>
    </div>
  </form>
</div>
@endsection

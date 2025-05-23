<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-light bg-light px-4 py-3 shadow-sm">
  <a class="navbar-brand" href="/">EceP</a>
  <div class="d-flex align-items-center gap-2">
    <a href="/seller/center/" class="btn btn-outline-secondary me-2 d-flex align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
        <path d="M2.97 1a.5.5 0 0 0-.485.379L1.61 5H14.39l-.875-3.621A.5.5 0 0 0 13.03 1H2.97zM0 5.5A.5.5 0 0 1 .5 5h15a.5.5 0 0 1 .5.5V6c0 .42-.17.815-.445 1.1C15.274 7.753 14.5 8 13.5 8s-1.774-.247-2.055-.9A1.992 1.992 0 0 1 11 6H5a1.99 1.99 0 0 1-.445 1.1C4.274 7.753 3.5 8 2.5 8s-1.774-.247-2.055-.9A1.992 1.992 0 0 1 0 6v-.5z"/>
        <path d="M2.5 9A1.5 1.5 0 0 0 1 10.5v4a.5.5 0 0 0 .5.5H5v-5H2.5zm8.5 0v5h3.5a.5.5 0 0 0 .5-.5v-4A1.5 1.5 0 0 0 13.5 9H11z"/>
      </svg>
      <span class="ms-2 d-none d-md-inline">Seller Center</span>
    </a>

    <a href="{{ route('viewCart') }}">
      <button class="btn btn-outline-secondary me-2 d-flex align-items-center" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
          <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM3.14 6l1.25 6h8.22l1.25-6H3.14z"/>
          <path d="M5.5 16a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm7 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
        </svg>
        <span class="ms-2 d-none d-md-inline">Cart</span>
      </button>
    </a>

    <div class="d-flex" role="search">
      <input id="searchInput" class="form-control" type="search" placeholder="Search..." aria-label="Search" />
    </div>

    <div class="dropdown">
      <a class="btn btn-outline-secondary d-flex align-items-center gap-2" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
          <path d="M13.468 12.37C12.758 11.226 11.552 10.5 10 10.5s-2.758.726-3.468 1.87A6.987 6.987 0 0 1 1 8a7 7 0 1 1 14 0 6.987 6.987 0 0 1-1.532 4.37z"/>
          <path fill-rule="evenodd" d="M10 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0z"/>
        </svg>
        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
        <li><a class="dropdown-item" href="/profile">Profile</a></li>
        <li><hr class="dropdown-divider" /></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

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
            <td>${{ number_format($item->product->productPrice, 2) }}</td>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

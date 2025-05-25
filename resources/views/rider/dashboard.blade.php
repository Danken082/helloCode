<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f9fafb;
      font-family: 'Poppins', sans-serif;
      color: #111827;
    }

    .navbar-custom {
      background-color: #fff;
      border-bottom: 1px solid #e5e7eb;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      transition: 0.3s;
    }

    .card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .main-content {
      padding: 2rem;
    }

    .table-section {
      display: none;
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    table {
      font-size: 14px;
    }

    .table thead {
      background-color: #f3f4f6;
    }

    .table th, .table td {
      vertical-align: middle;
      border-bottom: 1px solid #e5e7eb;
    }

    .empty-message {
      padding: 2rem;
      text-align: center;
      color: #9ca3af;
      font-style: italic;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand fw-semibold" href="#">Hi! Rider {{ Auth::user()->name }}</a>
    <form method="POST" action="{{ route('logout') }}" class="d-flex">
      @csrf
      <button type="submit" class="btn btn-sm btn-danger">Logout</button>
    </form>
  </div>
</nav>

<div class="main-content">
  <div class="row mt-4">
    <div class="col-md-4">
      <a href="#" class="text-decoration-none show-section" data-target="#assign-orders">
        <div class="card text-dark bg-white mb-4">
          <div class="card-body text-center fw-semibold">
            <h5 class="card-title">Total Assign Orders</h5>
            <p class="card-text display-6">{{ $orderAssignCount }}</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="#" class="text-decoration-none show-section" data-target="#complete-orders">
        <div class="card text-dark bg-white mb-4">
          <div class="card-body text-center fw-semibold">
            <h5 class="card-title">Complete Orders</h5>
            <p class="card-text display-6">{{ $orderCompleteCount }}</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="#" class="text-decoration-none show-section" data-target="#unclaimed-orders">
        <div class="card text-dark bg-white mb-4">
          <div class="card-body text-center fw-semibold">
            <h5 class="card-title">Not Claimed Orders</h5>
            <p class="card-text display-6">{{ $orderFailedCount }}</p>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- Assign Orders Table -->
  <section id="assign-orders" class="table-section">
    <h4 class="mb-4">Assign Orders</h4>
    @if($assignOrders->isEmpty())
      <div class="empty-message">This is empty.</div>
    @else
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th><th>Order Code</th><th>Customer</th><th>Contact</th>
              <th>Shop</th><th>Product</th><th>Qty</th><th>Price</th><th>Status</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($assignOrders as $order)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->orderCode }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->contactNo }}</td>
                <td>{{ $order->user->regseller->bussinessName }}</td>
                <td>{{ $order->product->productName }}</td>
                <td>{{ $order->quantity }}</td>
                <td>₱ {{ number_format($order->totalPrice, 2) }}</td>
                <td>
                  <select class="form-select form-select-sm status-selector" data-order-id="{{ $order->id }}"
                    data-product-id="{{ $order->product->id }}"
                    data-order-code="{{ $order->orderCode }}"
                    data-order-seller="{{ $order->userID }}"
                    data-quantity="{{ $order->quantity }}"
                    data-total-price="{{ $order->totalPrice }}">
                    <option value="claimedByDeliveryPartner" selected disabled>Your Deliver</option>
                    <option value="notClaimed">Not Claimed</option>
                    <option value="Completed">Claimed</option>
                  </select>
                </td>
                <td><a href="#" class="btn btn-sm btn-outline-primary view-order-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#orderDetailModal"
                    data-order-code="{{ $order->orderCode }}"
                    data-customer="{{ $order->user->name }}"
                    data-contact="{{ $order->user->contactNo }}"
                    data-shop="{{ $order->user->regseller->bussinessName }}"
                    data-product="{{ $order->product->productName }}"
                    data-quantity="{{ $order->quantity }}"
                    data-price="₱ {{ number_format($order->totalPrice, 2) }}"
                    data-status="Your Deliver">
                    View
                  </a>
</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </section>

  <!-- Complete Orders Table -->
  <section id="complete-orders" class="table-section">
    <h4 class="mb-4">Complete Orders</h4>
    @if($completeOrders->isEmpty())
      <div class="empty-message">This is empty.</div>
    @else
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th><th>Order Code</th><th>Customer</th><th>Contact</th>
              <th>Shop</th><th>Product</th><th>Qty</th><th>Price</th><th>Status</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($completeOrders as $order)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->orderCode }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->contactNo }}</td>
                <td>{{ $order->user->regseller->bussinessName }}</td>
                <td>{{ $order->product->productName }}</td>
                <td>{{ $order->quantity }}</td>
                <td>₱ {{ number_format($order->totalPrice, 2) }}</td>
                <td><span class="badge bg-success">Completed</span></td>
                <td><a href="#" class="btn btn-sm btn-outline-primary view-order-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#orderDetailModal"
                    data-order-code="{{ $order->orderCode }}"
                    data-customer="{{ $order->user->name }}"
                    data-contact="{{ $order->user->contactNo }}"
                    data-shop="{{ $order->user->regseller->bussinessName }}"
                    data-product="{{ $order->product->productName }}"
                    data-quantity="{{ $order->quantity }}"
                    data-price="₱ {{ number_format($order->totalPrice, 2) }}"
                    data-status="{{ $order->status }}">
                    View
                  </a>
</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </section>

  <!-- Not Claimed Orders Table -->
  <section id="unclaimed-orders" class="table-section">
    <h4 class="mb-4">Not Claimed Orders</h4>
    @if($failedOrders->isEmpty())
      <div class="empty-message">This is empty.</div>
    @else
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th><th>Order Code</th><th>Customer</th><th>Contact</th>
              <th>Shop</th><th>Product</th><th>Qty</th><th>Price</th><th>Status</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($failedOrders as $order)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->orderCode }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->contactNo }}</td>
                <td>{{ $order->user->regseller->bussinessName }}</td>
                <td>{{ $order->product->productName }}</td>
                <td>{{ $order->quantity }}</td>
                <td>₱ {{ number_format($order->totalPrice, 2) }}</td>
                <td><span class="badge bg-danger">Not Claimed</span></td>
                <td><a href="#" class="btn btn-sm btn-outline-primary view-order-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#orderDetailModal"
                    data-order-code="{{ $order->orderCode }}"
                    data-customer="{{ $order->user->name }}"
                    data-contact="{{ $order->user->contactNo }}"
                    data-shop="{{ $order->user->regseller->bussinessName }}"
                    data-product="{{ $order->product->productName }}"
                    data-quantity="{{ $order->quantity }}"
                    data-price="₱ {{ number_format($order->totalPrice, 2) }}"
                    data-status="{{ $order->status }}">
                    View
                  </a>
</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </section>
</div>


<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Order Code:</strong> <span id="modalOrderCode"></span></p>
        <p><strong>Customer:</strong> <span id="modalCustomer"></span></p>
        <p><strong>Contact:</strong> <span id="modalContact"></span></p>
        <p><strong>Shop:</strong> <span id="modalShop"></span></p>
        <p><strong>Product:</strong> <span id="modalProduct"></span></p>
        <p><strong>Quantity:</strong> <span id="modalQuantity"></span></p>
        <p><strong>Price:</strong> <span id="modalPrice"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.show-section').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('data-target');
        document.querySelectorAll('.table-section').forEach(section => {
          section.style.display = 'none';
        });
        const targetSection = document.querySelector(targetId);
        if (targetSection) {
          targetSection.style.display = 'block';
          targetSection.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });

    document.querySelectorAll('.status-selector').forEach(function (selector) {
      selector.addEventListener('change', function () {
        const orderId = this.getAttribute('data-order-id');
        const productId = this.getAttribute('data-product-id');
        const orderCode = this.getAttribute('data-order-code');
        const quantity = this.getAttribute('data-quantity');
        const totalPrice = this.getAttribute('data-total-price');
        const userID = this.getAttribute('data-order-seller');
        const newStatus = this.value;

        fetch(`/orders/update-status/${orderId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            status: newStatus,
            orderCode: orderCode,
            productId: productId,
            quantity: quantity,
            totalPrice: totalPrice,
            userID: userID,
          })
        })
        .then(response => response.json())
        .then(data => {
          alert(data.message || 'Status updated!');
          location.reload();
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating status.');
        });
      });
    });
  });


  document.querySelectorAll('.view-order-btn').forEach(btn => {
  btn.addEventListener('click', function () {
    document.getElementById('modalOrderCode').textContent = this.dataset.orderCode;
    document.getElementById('modalCustomer').textContent = this.dataset.customer;
    document.getElementById('modalContact').textContent = this.dataset.contact;
    document.getElementById('modalShop').textContent = this.dataset.shop;
    document.getElementById('modalProduct').textContent = this.dataset.product;
    document.getElementById('modalQuantity').textContent = this.dataset.quantity;
    document.getElementById('modalPrice').textContent = this.dataset.price;
    document.getElementById('modalStatus').textContent = this.dataset.status;
  });
});

</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f9f9f9;
      font-family: "Segoe UI", sans-serif;
    }

    .navbar-custom {
      background-color: #ffffff;
      border-bottom: 1px solid #e0e0e0;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .main-content {
      padding: 2rem;
    }

    .table-section {
      display: none;
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Hi! Rider {{ Auth::user()->name }}</a>
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
        <div class="card text-dark bg-white mb-4 shadow rounded-4">
          <div class="card-body text-center fw-bold">
            <h5 class="card-title">Total Assign Orders</h5>
            <p class="card-text display-6">{{ $orderAssignCount }}</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="#" class="text-decoration-none show-section" data-target="#complete-orders">
        <div class="card text-dark bg-white mb-4 shadow rounded-4">
          <div class="card-body text-center fw-bold">
            <h5 class="card-title">Complete Orders</h5>
            <p class="card-text display-6">{{ $orderCompleteCount }}</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="#" class="text-decoration-none show-section" data-target="#unclaimed-orders">
        <div class="card text-dark bg-white mb-4 shadow rounded-4">
          <div class="card-body text-center fw-bold">
            <h5 class="card-title">Not Claimed Orders</h5>
            <p class="card-text display-6">{{ $orderFailedCount }}</p>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- Assign Orders Table -->
  <section id="assign-orders" class="table-section">
    <h3>Assign Orders</h3>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
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
                <select class="form-select status-selector" data-order-id="{{ $order->id }}">
                  <option value="claimedByDeliveryPartner" selected>Assign Rider</option>
                  <option value="notClaimed">Not Claimed</option>
                  <option value="Completed">Claimed</option>
                </select>
              </td>
              <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  <!-- Complete Orders Table -->
  <section id="complete-orders" class="table-section">
    <h3>Complete Orders</h3>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
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
              <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  <!-- Not Claimed Orders Table -->
  <section id="unclaimed-orders" class="table-section">
    <h3>Not Claimed Orders</h3>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
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
              <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Show section on card click
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

    // AJAX update for status
    document.querySelectorAll('.status-selector').forEach(function (selector) {
      selector.addEventListener('change', function () {
        const orderId = this.getAttribute('data-order-id');
        const newStatus = this.value;

        fetch(`/orders/update-status/${orderId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ status: newStatus })
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
</script>

</body>
</html>

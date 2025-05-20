<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Seller Dashboard - Static</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
   :root {
      --sidebar-bg: #e0f0ff;
      --sidebar-highlight: #c6e2ff;
      --sidebar-text: #333;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: var(--sidebar-bg);
      width: 240px;
      padding-top: 20px;
      transition: all 0.3s ease;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
      z-index: 999;
    }

    .sidebar a {
      padding: 12px 20px;
      display: block;
      text-decoration: none;
      color: var(--sidebar-text);
      transition: background 0.2s;
    }

    .sidebar a:hover {
      background-color: var(--sidebar-highlight);
    }

    .sidebar-header {
      text-align: center;
      padding: 10px 20px;
      border-bottom: 1px solid #ccc;
    }

    .sidebar-header img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .content {
      margin-left: 240px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    .mobile-nav {
      display: none;
    }

    .sidebar-close-btn {
      display: none;
    }

    @media (max-width: 768px) {
      .sidebar {
        left: -240px;
      }

      .sidebar.active {
        left: 0;
      }

      .content {
        margin-left: 0;
      }

      .mobile-nav {
        display: block;
        background-color: var(--sidebar-bg);
        padding: 10px 15px;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }

      .sidebar-close-btn {
        display: block;
        text-align: right;
        padding: 0 20px;
      }
    }

    #my-products {
    display: none;
  }

  .category-box {
      border: 2px solid #0d6efd;
      border-radius: 8px;
      padding: 30px;
      text-align: center;
      cursor: pointer;
      transition: 0.3s;
    }
    .category-box:hover {
      background-color: #e9f3ff;
    }
    .form-section {
      display: none;
    }

    .nav-link.active {
    background-color: var(--sidebar-highlight);
     font-weight: bold;
    }

  </style>
</head>
<body>

<!-- Mobile Navbar -->
<div class="mobile-nav d-md-none">
  <button class="btn btn-outline-light" id="toggleSidebar">&#9776; Menu</button>
</div>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-close-btn d-md-none">
    <button class="btn btn-sm btn-outline-secondary mt-2" id="closeSidebar">&times; Close</button>
  </div>
  <div class="sidebar-header">
    <!-- <img src="https://via.placeholder.com/60" alt="Profile Picture"> -->
    <div>Seller:<strong>{{ Auth::user()->name }}</strong></div>
    <small>{{ Auth::user()->email }}</small>
  </div>
    <a href="#" id="nav-dashboard" class="nav-link" onclick="setActive('dashboard')">Dashboard</a>
    <a href="#" id="nav-products" class="nav-link" onclick="setActive('products')">My Products</a>
    <a href="#" id="nav-orders" class="nav-link" onclick="setActive('orders')">Orders</a>
    <a href="#" id="nav-messages" class="nav-link">Messages</a>
    <a href="#" id="nav-profile" class="nav-link" onclick="setActive('profile')">Profile</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="dropdown-item">Logout</button>
      </form>
</div>


<!-- Page Content -->
<div class="content">
  <section id="dashboard">
    <h2>Welcome to Seller Dashboard</h2>
    <p>Manage your products, orders, and shop profile here.</p>

    <div class="row mb-3">
      <div class="col-md-6">
        <div class="card p-3 bg-light text-center">
          <h5>Total Products</h5>
          <h3>{{ $totalProducts}}</h3>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-3 bg-light text-center">
          <h5>Total Sales (Month)</h5>
          <h3>₱ {{$totalSales}}</h3>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-3 bg-light text-center">
          <h5>Total Pending Orders</h5>
          <h3>{{$totalPending}}</h3>
        </div>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Best Selling Products</h5>
      </div>
      <div class="card-body">
  @if($bestSellers->isEmpty())
    <ul class="list-group">
      <li class="list-group-item d-flex justify-content-between align-items-center">
      <p class="mb-0">No sales yet</p>
      </li>
    </ul>
  @else
    <ul class="list-group">
      @foreach($bestSellers as $best)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          {{ $best->productName}}
          <span class="badge bg-success rounded-pill">{{ $best->total_sold }}</span>
        </li>
      @endforeach
    </ul>
  @endif
</div>

  </section>


  <section id="my-orders" style="display:none;" class="mt-5">
  <div class="container">
    <h3 class="mb-4">Orders</h3>

    <!-- Orders Table -->
    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Order Code</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order) <!-- Assuming you're passing the orders from controller -->
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->orderCode }}</td>
            <td>{{ $order->product->productName }}</td> <!-- Assuming the product is linked to the order -->
            <td>{{ $order->quantity }}</td>
            <td>₱ {{ number_format($order->totalPrice, 2) }}</td>
            <td>
              @if($order->status == 'Pending')
              <select class="form-select status-selector" data-order-id="{{ $order->id }}"
          data-product-id="{{ $order->product->id }}"
          data-order-code="{{ $order->orderCode }}"
          data-quantity="{{ $order->quantity }}"
          data-total-price="{{ $order->totalPrice }}">
        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="claimedByDeliveryPartner" {{ $order->status == 'claimedByDeliveryPartner' ? 'selected' : '' }}> On Deliver</option>
         <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
      </select>

      @elseif($order->status == 'claimedByDeliveryPartner')
      <select class="form-select status-selector" data-order-id="{{ $order->id }}"
          data-product-id="{{ $order->product->id }}"
          data-order-code="{{ $order->orderCode }}"
          data-quantity="{{ $order->quantity }}"
          data-total-price="{{ $order->totalPrice }}">
          <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="claimedByDeliveryPartner" {{ $order->status == 'claimedByDeliveryPartner' ? 'selected' : '' }}> On Deliver</option>
      </select>


      @elseif($order->status == 'Completed')
    
      <span class="badge bg-success">Completed</span>
             
      @else
      <span class="badge bg-danger">Cancelled</span>
              @endif
            </td>
            <td>
              <!-- You can add action buttons like "View" or "Edit" here -->
              <a href="" class="btn btn-primary btn-sm">View</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>  
    </section>
  
  <!-- My Products Form Section -->
  <section id="my-products" class="mt-5">


<!-- Minimalist Button -->
<button class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addProducts">
  + Add Product
</button>
<br>
<br>
<div class="alert alert-info d-flex align-items-center gap-2 p-3 rounded shadow-sm" role="alert">
  <i class="bi bi-tags-fill"></i>
  <span class="fw-semibold">Your registered categories:</span>
</div>

  <div class="row g-3">

 
  
  @foreach($product as $prod)
    <div class="col-md-4">
    <a href="{{ route('viewProducts', $prod->productCategory)}}" style="text-decoration:none; font:black;">
      <div class="category-box" onclick="showForm('electronics')">
     
      {{$prod->productCategory}}
        
      </div>
      </a>
    </div>
    @endforeach

  </div>

  </section>

  <section id="my-profile" style="display:none;"class="mt-5">
    <div class="col-md-4">
      <div class="category-box" onclick="showForm('food')">
        🍔 Food Products
      </div>
    </div>
    <div class="col-md-4">
      <div class="category-box" onclick="showForm('clothing')">
        👕 Clothing
      </div>
    </div>
  </div>

  </section>

</div>


<!--modal for adding products-->

<!-- Add Product Modal -->
<div class="modal fade" id="addProducts" tabindex="-1" aria-labelledby="addProductsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm rounded">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addProductsLabel">Add New Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('addproduct')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="productName" required>
          </div>

          <div class="mb-3">
            <label for="productCategory" class="form-label">Category</label>
            <select name="productCategory" class="form-select" required>
              <option value="">Select Category</option>
              <option value="Electronics">Electronics</option>
              <option value="Food">Food</option>
              <option value="Clothing">Clothing</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="productDetails" class="form-label">Product Details</label>
        <textarea name="productDetails" class="form-control" id="" cols="30" rows="10"></textarea>
        </div>


          <div class="mb-3">
            <label for="productQuantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="productQuantity" min="1" required>
          </div>

          <div class="mb-3">
            <label for="productPrice" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" name="productPrice" required>
          </div>

          <div class="mb-3">
            <label for="productImage" class="form-label">Product Image</label>
            <input type="file" class="form-control" name="productImage" accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Product</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
 document.getElementById('toggleSidebar')?.addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
  });

  function showMyOrders() {

document.getElementById('dashboard').style.display = 'none';
document.getElementById('my-profile').style.display = 'none';
document.getElementById('my-products').style.display = 'none';
// Show the My Products section
document.getElementById('my-orders').style.display = 'block';

// Optionally scroll into view
    document.getElementById('my-orders').scrollIntoView({ behavior: 'smooth' });  
    }

  function showMyProducts() {

    document.getElementById('dashboard').style.display = 'none';
    document.getElementById('my-profile').style.display = 'none';
    document.getElementById('my-orders').style.display = 'none';
    
    // Show the My Products section
    document.getElementById('my-products').style.display = 'block';

    // Optionally scroll into view
    document.getElementById('my-products').scrollIntoView({ behavior: 'smooth' });
  }

  function showMyDashboard() {
    // Hide other sections if needed
    document.getElementById('my-products').style.display = 'none';
    document.getElementById('my-profile').style.display = 'none';
    document.getElementById('my-orders').style.display = 'none';
    
    // Show the My Products section
    document.getElementById('dashboard').style.display = 'block';

    // Optionally scroll into view
    document.getElementById('dashboard').scrollIntoView({ behavior: 'smooth' });
  }

  function showMyProfile() {
    // Hide other sections if needed
    document.getElementById('dashboard').style.display = 'none';
    document.getElementById('my-products').style.display = 'none';
    document.getElementById('my-orders').style.display = 'none';
    
    // Show the My Products section
    document.getElementById('my-profile').style.display = 'block';

    // Optionally scroll into view
    document.getElementById('my-profile').scrollIntoView({ behavior: 'smooth' });
  }


  document.getElementById('toggleSidebar')?.addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
  });

  function setActive(section) {
    // Remove active class from all nav links
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));

    // Hide all sections
    document.getElementById('dashboard').style.display = 'none';
    document.getElementById('my-products').style.display = 'none';
    document.getElementById('my-profile').style.display = 'none';
    document.getElementById('my-orders').style.display = 'none';

    // Show and activate selected section
    if (section === 'dashboard') {
      document.getElementById('dashboard').style.display = 'block';
      document.getElementById('nav-dashboard').classList.add('active');
    } else if (section === 'products') {
      document.getElementById('my-products').style.display = 'block';
      document.getElementById('nav-products').classList.add('active');
    } else if (section === 'profile') {
      document.getElementById('my-profile').style.display = 'block';
      document.getElementById('nav-profile').classList.add('active');
    }
    
    else if (section === 'orders') {
      document.getElementById('my-orders').style.display = 'block';
      document.getElementById('nav-orders').classList.add('active');
    }
  }

  window.onload = function () {
    setActive('dashboard');
  };


  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-selector').forEach(function (selector) {
        selector.addEventListener('change', function () {
            const orderId = this.getAttribute('data-order-id');
            const productId = this.getAttribute('data-product-id');
            const orderCode = this.getAttribute('data-order-code');
            const quantity = this.getAttribute('data-quantity');
            const totalPrice = this.getAttribute('data-total-price');
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
                    totalPrice: totalPrice
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Status updated successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating status.');
            });
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>

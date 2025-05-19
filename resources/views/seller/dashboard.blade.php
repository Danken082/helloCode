<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Seller Dashboard - Static</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    <a href="#" id="nav-orders" class="nav-link">Orders</a>
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
          <h3>42</h3>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-3 bg-light text-center">
          <h5>Total Sales (Month)</h5>
          <h3>$12,345.67</h3>
        </div>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Best Selling Products</h5>
      </div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Product A
            <span class="badge bg-success rounded-pill">120 sold</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Product B
            <span class="badge bg-success rounded-pill">95 sold</span>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- My Products Form Section -->
  <section id="my-products" class="mt-5">
  <div class="row g-3">
    <div class="col-md-4">
    <a href="/hello" style="text-decoration:none; font:black;">
      <div class="category-box" onclick="showForm('electronics')">
     
        📱 Electronics
        
      </div>
      </a>
    </div>

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

<script>
 document.getElementById('toggleSidebar')?.addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
  });

  function showMyProducts() {

    document.getElementById('dashboard').style.display = 'none';
    document.getElementById('my-profile').style.display = 'none';
    
    // Show the My Products section
    document.getElementById('my-products').style.display = 'block';

    // Optionally scroll into view
    document.getElementById('my-products').scrollIntoView({ behavior: 'smooth' });
  }

  function showMyDashboard() {
    // Hide other sections if needed
    document.getElementById('my-products').style.display = 'none';
    document.getElementById('my-profile').style.display = 'none';
    
    // Show the My Products section
    document.getElementById('dashboard').style.display = 'block';

    // Optionally scroll into view
    document.getElementById('dashboard').scrollIntoView({ behavior: 'smooth' });
  }

  function showMyProfile() {
    // Hide other sections if needed
    document.getElementById('dashboard').style.display = 'none';
    document.getElementById('my-products').style.display = 'none';
    
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
  }

  window.onload = function () {
    setActive('dashboard');
  };
</script>

</body>
</html>

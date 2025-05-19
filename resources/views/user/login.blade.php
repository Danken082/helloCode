<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login Modal + Products</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .modal-header {
      background-color: #37BAE2;
      color: white;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }

    .btn-login {
      background-color: #37BAE2;
      color: white;
    }

    .btn-login:hover {
      background-color: #2a91c4;
    }

    .form-control:focus {
      border-color: #37BAE2;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .navbar .form-inline {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* Product card hover */
    .card:hover {
      box-shadow: 0 8px 16px rgba(55, 186, 226, 0.3);
      transform: translateY(-5px);
      transition: all 0.3s ease;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-light px-4 py-3">
    <a class="navbar-brand" href="#">MyApp</a>

    <div class="d-flex align-items-center gap-2">

    <!-- Cart -->
    <button class="btn btn-outline-secondary me-2 d-flex align-items-center" type="button">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
    <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM3.14 6l1.25 6h8.22l1.25-6H3.14z"/>
    <path d="M5.5 16a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm7 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
  </svg>
  <span class="ms-2 d-none d-md-inline">Cart</span>
</button>

    <!-- Search Form -->
      <form class="d-flex" role="search" method="GET" action="/search">
        <input class="form-control me-2" type="search" placeholder="Search..." name="query" aria-label="Search" />
        <button class="btn btn-outline-primary" type="submit">Search</button>
      </form>

      <!-- Login Button -->
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
        Login
      </button>


    </div>
  </nav>

  <!-- Products Section -->
  <section class="container my-5">
    <h2 class="mb-4 text-center" style="color: #37BAE2;">Our Products</h2>

    <div class="row g-4">
      <!-- Product 1 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm rounded-3">
          <img src="https://via.placeholder.com/300x200?text=Product+1" class="card-img-top" alt="Product 1" />
          <div class="card-body">
            <h5 class="card-title">Product One</h5>
            <p class="card-text">A great product that fits your needs perfectly.</p>
            <button class="btn btn-login w-100">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm rounded-3">
          <img src="https://via.placeholder.com/300x200?text=Product+2" class="card-img-top" alt="Product 2" />
          <div class="card-body">
            <h5 class="card-title">Product Two</h5>
            <p class="card-text">Top quality product at an affordable price.</p>
            <button class="btn btn-login w-100">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 3 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm rounded-3">
          <img src="https://via.placeholder.com/300x200?text=Product+3" class="card-img-top" alt="Product 3" />
          <div class="card-body">
            <h5 class="card-title">Product Three</h5>
            <p class="card-text">Designed for excellence and durability.</p>
            <button class="btn btn-login w-100">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 4 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm rounded-3">
          <img src="https://via.placeholder.com/300x200?text=Product+4" class="card-img-top" alt="Product 4" />
          <div class="card-body">
            <h5 class="card-title">Product Four</h5>
            <p class="card-text">Reliable and efficient, perfect for everyday use.</p>
            <button class="btn btn-login w-100">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 5 -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm rounded-3">
          <img src="https://via.placeholder.com/300x200?text=Product+5" class="card-img-top" alt="Product 5" />
          <div class="card-body">
            <h5 class="card-title">Product Five</h5>
            <p class="card-text">Innovative design with superior performance.</p>
            <button class="btn btn-login w-100">Buy Now</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-3 shadow">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login to Your Account</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          @if ($errors->any())
              <div class="alert alert-danger py-2 small">
                  {{ $errors->first() }}
              </div>
          @endif

          <form method="POST" action="{{ route('login')}}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" id="email" required autofocus />
            </div>

            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required />
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-login">Login</button>
            </div>

            <div class="text-center mt-3">
              <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Don't have an account? Register</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Create a New Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('register') }}">
          @csrf

          <!-- Name -->
          <div class="mb-3">
            <label for="reg_name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="reg_name" required />
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="reg_email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="reg_email" required />
          </div>

          <!-- Phone Number (Corrected) -->
          <div class="mb-3">
            <label for="contact_number" class="form-label">Phone Number</label>
            <input
              type="tel"
              name="contactNo"
              class="form-control"
              id="contact_number"
              pattern="^09\d{9}$"
              placeholder="e.g. 09171234567"
              required
            />
            <small class="text-muted">Must be a valid mobile number starting with 09</small>
          </div>

          <!-- Password -->
          <div class="mb-4">
            <label for="reg_password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="reg_password" required />
          </div>

          <!-- Submit -->
          <div class="d-grid">
            <button type="submit" class="btn btn-login">Register</button>
          </div>

          <!-- Switch to Login -->
          <div class="text-center mt-3">
            <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
              Already have an account? Login
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

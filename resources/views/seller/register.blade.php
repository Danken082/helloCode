<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Home</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    html, body {
      height: 100%;
      margin: 0;
      background: #ECECEC;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow: hidden;
    }

    .full-height {
      height: 100vh;
    }

    .left-container, .right-container {
      background: rgba(255, 255, 255, 0.85);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      padding: 1rem;
      box-sizing: border-box;
    }

    .left-container img {
      max-width: 60%;
      max-height: 60%;
      object-fit: contain;
    }

    .right-container {
      border-left: 2px solid #ccc;
      flex-direction: column;
      gap: 1.5rem;
      color: #333;
    }

    .btn-warning {
      width: 100%;
      font-weight: 600;
      font-size: 1.2rem;
    }

    nav.navbar {
      background: #f8f9fa;
      box-shadow: 0 2px 4px rgb(0 0 0 / 0.05);
    }

    .dropdown-toggle::after {
      display: none;
    }
  </style>
</head>
<body>

<nav class="navbar px-4">
  <a class="navbar-brand fw-bold" href="#">EceP</a>

  <div class="dropdown ms-auto">
    <a href="#" class="d-flex align-items-center text-decoration-none btn btn-outline-secondary" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M13.468 12.37C12.758 11.226 11.552 10.5 10 10.5s-2.758.726-3.468 1.87A6.987 6.987 0 0 1 1 8a7 7 0 1 1 14 0 6.987 6.987 0 0 1-1.532 4.37z"/>
        <path fill-rule="evenodd" d="M10 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0z"/>
      </svg>
      <span class="ms-2 d-none d-md-inline">{{ Auth::user()->name }}</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
      <li><hr class="dropdown-divider" /></li>
      <li><a class="dropdown-item" href="/shop/home">Order Products</a></li>
      <li><hr class="dropdown-divider" /></li>
      <li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>

<div class="container-fluid full-height d-flex p-0">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3 position-absolute top-0 end-0" role="alert" style="z-index: 1055;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row flex-grow-1 g-0">
    <div class="col-md-6 left-container">
      <img src="{{ asset('storage/app/public/logo.png') }}" alt="Logo" />
    </div>

    <div class="col-md-6 right-container">
      @if(!isset($seller) || $seller === null)
        <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">Register to be a seller</button>
      @else
        <button class="btn btn-warning btn-lg" disabled>Your Account is under Review</button>
      @endif
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Create a New Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('regseller') }}" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label for="reg_Company" class="form-label">Business Name</label>
            <input type="text" name="shopName" class="form-control" id="reg_Company" required />
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" required />
          </div>

          <div class="mb-3">
            <label for="prod_prics" class="form-label">Products Photo</label>
            <input type="file" name="prodPics" class="form-control" id="prod_prics" required />
          </div>

          <div class="mb-3">
            <label for="shopAge" class="form-label">Business Age</label>
            <select name="shopAge" class="form-select" id="shopAge" required>
              <option value="" disabled selected>--Select--</option>
              <option value="lessthan 2 Years">Less than 2 Years</option>
              <option value="2-5 Years">2 to 5 Years</option>
              <option value="5-10 Years">5 to 10 Years</option>
              <option value="10-15 Years">10 to 15 Years</option>
              <option value="above 16 Years">Above 15 Years</option>
            </select>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-login">Apply</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) alert.classList.remove('show');
  }, 5000);
</script>

</body>
</html>

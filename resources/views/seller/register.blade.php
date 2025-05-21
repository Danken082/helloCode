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
      overflow: hidden; /* Prevent scrolling */
    }

    body {
      background-color:#ECECEC;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 100vh;
    }

    .full-height {
      height: 100vh;
    }

    .left-container {
      background-color: rgba(255, 255, 255, 0.8);
      height: 100%;
    }

    .right-container {
      height: 100%;
      border: 3px solid black;
      background-color: rgba(255, 255, 255, 0.8);
      color: white; /* text color inside right container */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo-img {
      max-width: 80%;
      max-height: 80%;
    }

    /* Override Bootstrap btn-primary colors inside black container */
    .right-container .btn-primary {
      background-color: #0d6efd;
      border-color: #0d6efd;
      color: white;
    }

    .right-container .btn-primary:hover {
      background-color: #0b5ed7;
      border-color: #0a58ca;
      color: white;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-light px-4 py-3">
    <a class="navbar-brand" href="#">MyApp</a>

    <div class="d-flex align-items-center gap-2">
      <!-- Profile Dropdown -->
      <div class="dropdown">
        <a class="btn btn-outline-secondary d-flex align-items-center gap-2" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <!-- Profile Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
            <path d="M13.468 12.37C12.758 11.226 11.552 10.5 10 10.5s-2.758.726-3.468 1.87A6.987 6.987 0 0 1 1 8a7 7 0 1 1 14 0 6.987 6.987 0 0 1-1.532 4.37z"/>
            <path fill-rule="evenodd" d="M10 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0z"/>
          </svg>

          <!-- User name visible on md+ screens -->
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="/profile">Shop Profile</a></li>
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
    </div>
  </nav>

  <div class="container-fluid full-height">
  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

    <div class="row h-100">
      <!-- Left side with logo -->
      <div class="col-md-6 d-flex justify-content-center align-items-center left-container">
        <img src="{{ asset('storage/logo.png')}}" alt="Logo" class="logo-img" />
      </div>

      <!-- Right side with button -->

      @if(!isset($seller) || $seller === null)
  <div class="col-md-6 right-container">
    <a href="#" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">
      Register to be a seller
    </a>
  </div>
@else
  <div class="col-md-6 right-container">
    <a href="#" class="btn btn-warning btn-lg">
      Your application is under Review
    </a>
  </div>
@endif

    </div>
  </div>


  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Create a New Account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('regseller') }}" enctype="multipart/form-data">
          @csrf


                    <!-- Email -->
            <div class="mb-3">
            <label for="reg_Company" class="form-label">Business Name</label>
            <input type="text" name="shopName" class="form-control" id="reg_Company" required />
          </div>

          <div class="mb-3">
            <label for="Address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" required />
          </div>

          <!-- Name -->
          <div class="mb-3">
            <label for="prod_prics" class="form-label">Products Photo</label>
            <input type="file" name="prodPics" class="form-control" id="prod_prics" required />
          </div>


          <div class="mb-3">
            <label for="shopAge" class="form-label">Business Age</label>
         <select name="shopAge" class="form-control" id="shopAge">
        <option disabled selected>--Select--</option>
         <option value="lessthan 2 Years">Lessthan 2 Years</option>
         <option value="2-5 Years">2 to 5 Years</option>
         <option value="5-10 Years">5 to 10 Years</option>
         <option value="10-15 Years">10 to 15 Years</option>
         <option value="above 16 Years">Above 15 Years</option></select>
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
    if (alert) {
      alert.classList.remove('show');
      alert.classList.add('hide');
    }
  }, 5000); // auto-dismiss after 5 seconds
</script>

</body>
</html>

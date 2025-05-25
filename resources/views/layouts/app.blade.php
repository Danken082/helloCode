<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>@yield('title', 'EceP')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />


  <link rel="icon" href="{{ asset('storage/app/public/logo.png') }}">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">



  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .modal-header {
      background-color: #0E753F;
      color: white;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }
    .btn-login {
      background-color: #0E753F;
      color: white;
    }
    .btn-login:hover {
      background-color: #2a91c4;
    }
    .form-control:focus {
      border-color: #0E753F;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .navbar .form-inline {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .card:hover {
      box-shadow: 0 8px 16px rgba(55, 186, 226, 0.3);
      transform: translateY(-5px);
      transition: all 0.3s ease;
    }
    .card-img-top {
      height: 180px;
      object-fit: cover;
    }
    .card {
      overflow: hidden;
      position: relative;
    }
    .view-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(55, 186, 226, 0.6);
      color: white;
      font-size: 1.25rem;
      font-weight: 500;
      opacity: 0;
      transition: opacity 0.3s ease;
      text-transform: uppercase;
    }
    .card:hover .view-overlay {
      opacity: 1;
    }
    .custom-navbar {
  background-color: #0E753F;
}

.brand {
  font-weight: 700;              /* Bold */
  font-size: 1.8rem;             /* Increase size (adjust as needed) */
  font-family: 'Poppins', sans-serif;  /* Change font style */
  letter-spacing: 1px;           /* Optional: more spacing between letters */
  color:white;
}


.icon-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 42px;
  height: 42px;
  border: 1px solid #fff;
  border-radius: 50%;
  color: #fff;
  background: transparent;
  position: relative;
  text-decoration: none;
  font-size: 20px;
  transition: background-color 0.2s ease;
}

.icon-btn:hover {
  background-color: rgba(255, 255, 255, 0.15);
}

.search-wrapper {
  position: relative;
}

.search-input {
  background-color: #111;
  color: #fff;
  padding-right: 40px;
  border: none;
  border-radius: 0;
  height: 42px;
  font-size: 14px;
  width: 200px;
}

.search-icon-btn {
  position: absolute;
  right: 10px;
  top: 8px;
  background: none;
  border: none;
  color: #ccc;
  font-size: 16px;
}

.cart-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background-color: white;
  color: #0E753F;
  font-size: 12px;
  font-weight: bold;
  border-radius: 50%;
  padding: 2px 6px;
}

  </style>

  @stack('styles')
</head>
<body>

  @include('partials.navbar')

  <main>
    @yield('content')
  </main>

  @includeIf('partials.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  @stack('scripts')
</body>
</html>

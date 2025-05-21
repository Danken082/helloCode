<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EceP</title>
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
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-light px-4 py-3">
    <a class="navbar-brand" href="#">EceP</a>

    <div class="d-flex align-items-center gap-2">

    <a href="/seller/center/" class="btn btn-outline-secondary me-2 d-flex align-items-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
      <path d="M2.97 1a.5.5 0 0 0-.485.379L1.61 5H14.39l-.875-3.621A.5.5 0 0 0 13.03 1H2.97zM0 5.5A.5.5 0 0 1 .5 5h15a.5.5 0 0 1 .5.5V6c0 .42-.17.815-.445 1.1C15.274 7.753 14.5 8 13.5 8s-1.774-.247-2.055-.9A1.992 1.992 0 0 1 11 6H5a1.99 1.99 0 0 1-.445 1.1C4.274 7.753 3.5 8 2.5 8s-1.774-.247-2.055-.9A1.992 1.992 0 0 1 0 6v-.5z"/>
      <path d="M2.5 9A1.5 1.5 0 0 0 1 10.5v4a.5.5 0 0 0 .5.5H5v-5H2.5zm8.5 0v5h3.5a.5.5 0 0 0 .5-.5v-4A1.5 1.5 0 0 0 13.5 9H11z"/>
    </svg>
    <span class="ms-2 d-none d-md-inline">Seller Center</span>
  </a>


    <!-- Cart -->
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


<!-- Profile Dropdown -->
<div class="dropdown">
  <a class="btn btn-outline-secondary d-flex align-items-center gap-2" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <!-- Profile Icon (Bootstrap Person Circle) -->
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
      <path d="M13.468 12.37C12.758 11.226 11.552 10.5 10 10.5s-2.758.726-3.468 1.87A6.987 6.987 0 0 1 1 8a7 7 0 1 1 14 0 6.987 6.987 0 0 1-1.532 4.37z"/>
      <path fill-rule="evenodd" d="M10 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0z"/>
    </svg>

    <!-- User name visible on md+ screens -->
    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
  </a>

  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
    <li><hr class="dropdown-divider" /></li>
    <li><a class="dropdown-item" href="/viewOrders">Orders</a></li>
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

  <!-- Products Section -->
  <section class="container my-5">

  <div class="mb-4 text-center">
  <select id="categoryFilter" class="form-select d-inline w-auto mx-auto" style="max-width: 200px;">
  <option value="all">All Categories</option>
  @foreach($categories as $category)
    <option value="{{ $category->productCategory }}">{{ $category->productCategory }}</option>
  @endforeach
</select>


</div>

    <h2 class="mb-4 text-center" style="color: #37BAE2;">Our Products</h2>

    <div class="row g-4">
      <!-- Product 1 -->

      @foreach($product as $prod)
  <div class="col-sm-6 col-md-4 col-lg-3 product-card" data-category="{{ $prod->productCategory }}">
  <a href="{{ route('productPreview', encrypt($prod->id)) }}" style="text-decoration:none;">

    <div class="card h-100 shadow-sm rounded-3 position-relative">
      
      <img src="{{ asset('storage/' . $prod->productImage) }}" class="card-img-top img-fluid" alt="{{ $prod->productName }}" />

      <!-- View Product overlay -->
      <div class="view-overlay d-none d-md-flex justify-content-center align-items-center">
        <span>View Product</span>
      </div>

      <div class="card-body">
        <h5 class="card-title">{{ $prod->productName }}</h5>
        <p class="card-text">{{ $prod->productDetails }}</p>
        <p class="card-text">Stocks: {{ $prod->productQuantity }}</p>
        <p class="card-text">₱ {{ $prod->productPrice }}</p>
        <p class="card-text">₱ {{ $prod->totalPrice  }}</p>
      </div>
    </div>
    </a>
  </div>
@endforeach

      </div>
  </section>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <script>
      document.getElementById('searchInput').addEventListener('input', filterProducts);
  document.getElementById('categoryFilter').addEventListener('change', function () {
    const selectedCategory = this.value;
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
      const cardCategory = card.getAttribute('data-category');
      if (selectedCategory === 'all' || cardCategory === selectedCategory) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });


  
  function filterProducts() {
    const selectedCategory = document.getElementById('categoryFilter').value.toLowerCase();
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
      const category = card.getAttribute('data-category').toLowerCase();
      const name = card.querySelector('.card-title').textContent.toLowerCase();
      const details = card.querySelector('.card-text').textContent.toLowerCase();

      const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
      const matchesSearch = name.includes(searchQuery) || details.includes(searchQuery);

      if (matchesCategory && matchesSearch) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  }
</script>

  </script>
</body>
</html>

<nav class="navbar custom-navbar navbar-expand-lg px-4 py-3">
  <a class="navbar-brand brand" href="/">EceP</a>

  <div class="d-flex align-items-center gap-3 ms-auto">
    

  <select id="categoryFilter" class="form-select d-inline w-auto mx-auto" style="max-width: 200px;">
      <option value="all">All Categories</option>
      @foreach($categories as $category)
        <option value="{{ $category->productCategory }}">{{ $category->productCategory }}</option>
      @endforeach
    </select>

    <!-- Search -->
    <div class="position-relative search-wrapper">
      <input id="searchInput" class="form-control search-input" type="search" placeholder="Search for products" aria-label="Search">
      <button class="btn search-icon-btn">
        <i class="bi bi-search"></i>
      </button>
    </div>

    
    @auth
      <!-- Seller Center -->
      <a href="/seller/center/" class="icon-btn" title="Seller Center">
        <i class="bi bi-shop"></i>
      </a>

      <!-- Cart -->
      <a href="{{ route('viewCart') }}" class="icon-btn" title="Cart">
        <i class="bi bi-cart"></i>
        <span class="cart-badge">0</span>
      </a>

      <!-- Profile Dropdown -->
      <a href="#" class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="/viewOrders">Orders</a></li>
        <li><hr class="dropdown-divider" /></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </li>
      </ul>
    @endauth
  @guest
  <button class="btn" style="color:white;" data-bs-toggle="modal" data-bs-target="#loginModal">
    Login
  </button>

    @endguest

  </div>
</nav>

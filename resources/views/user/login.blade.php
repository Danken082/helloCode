@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="container my-5">



</div>

<h2 class="mb-4" style="color: black; text-transform: uppercase; font-size: 25px; display: inline-block; border-bottom: 3px solid #0E753F; padding-bottom: 2px;">
  Products
</h2>


<select id="categoryFilter" class="form-select d-inline w-auto mx-auto" style="max-width: 200px;">
      <option value="all">All Categories</option>
      @foreach($categories as $category)
        <option value="{{ $category->productCategory }}">{{ $category->productCategory }}</option>
      @endforeach
    </select>

    <div class="row g-4">
      <!-- Product 1 -->

      @foreach($product as $prod)
  <div class="col-sm-6 col-md-4 col-lg-3 product-card" data-category="{{ $prod->productCategory }}">
  <a href="{{ route('productPreview', encrypt($prod->id)) }}"data-bs-toggle="modal" data-bs-target="#loginModal" style="text-decoration:none;">

    <div class="card h-100 shadow-sm rounded-3 position-relative">
      
      <img src="{{ asset('storage/app/public/'.$prod->productImage) }}" class="card-img-top img-fluid" alt="{{ $prod->productName }}" />

     
      <div class="card-body">
      <h5 class="card-title" style="font-weight: 550;">{{ $prod->productName }}</h5>
              <p class="card-text" style="color:#A5A5A5;">{{ $prod->productDetails }}</p>
              <p class="card-text" style="font-weight: 550; color:#0E753F;">₱ {{ $prod->productPrice }} Stocks: {{ $prod->productQuantity }}</p>
      </div>
    </div>
    </a>
  </div>
@endforeach

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
                    <!-- Address -->
          <div class="mb-3">
            <label for="Address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="Address" required />
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


@endsection

@push('scripts')
<script>
  document.getElementById('searchInput').addEventListener('input', filterProducts);
  document.getElementById('categoryFilter').addEventListener('change', function () {
    const selectedCategory = this.value;
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
      const cardCategory = card.getAttribute('data-category');
      card.style.display = (selectedCategory === 'all' || cardCategory === selectedCategory) ? 'block' : 'none';
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
      card.style.display = (matchesCategory && matchesSearch) ? 'block' : 'none';
    });
  }
</script>
@endpush

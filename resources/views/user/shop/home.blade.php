@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="container my-5">
 
<h2 class="mb-4" style="color: black; text-transform: uppercase; font-size: 25px; display: inline-block; border-bottom: 3px solid #0E753F; padding-bottom: 2px;">
  Products
</h2>


  <div class="row g-4">
    @foreach($product as $prod)
      <div class="col-sm-6 col-md-4 col-lg-3 product-card" data-category="{{ $prod->productCategory }}">
        <a href="{{ route('productPreview', encrypt($prod->id)) }}" style="text-decoration:none;">
          <div class="card h-100 shadow-sm rounded-3 position-relative">
            <img src="{{ asset('storage/app/public/' . $prod->productImage) }}" class="card-img-top img-fluid" alt="{{ $prod->productName }}" />
      
            <div class="card-body">
              <h5 class="card-title" style="font-weight: 550;">{{ $prod->productName }}</h5>
              <p class="card-text" style="color:#A5A5A5;">{{ $prod->productDetails }}</p>
              <p class="card-text" style="font-weight: 550;">₱ {{ $prod->productPrice }} Stocks: {{ $prod->productQuantity }}</p>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</section>
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

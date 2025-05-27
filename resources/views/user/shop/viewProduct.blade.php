<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $product->productName }} - Product Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .star-rating {
      color: gold;
      font-size: 1.2rem;
    }
    .custom-img {
      width: 100%;
      max-height: 300px;
      object-fit: cover;
    }
    .rating-bar {
      height: 1rem;
      background-color: #e0e0e0;
    }
    .rating-bar-fill {
      height: 100%;
      background-color: gold;
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">

<div class="mb-4">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">&larr; Back</a>
  </div>
  <div class="row">
    <!-- Product Details -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal">
          <img src="{{ asset('storage/app/public/' . $product->productImage) }}" class="card-img-top img-fluid" alt="{{ $product->productName }}">
        </a>

        <div class="card-body">
          <h4 class="card-title">{{ $product->productName }}</h4>
          <h5 class="text-success">₱{{ number_format($product->productPrice, 2) }}</h5>
          <p>Stock: {{ $product->productQuantity }}</p>

          <!-- Quantity Selector -->
          <div class="mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" class="form-control w-50" value="1" min="1" max="{{ $product->productQuantity }}" onchange="updateMainTotal()">
          </div>

          <!-- Total Price -->
          <div class="mb-3">
            <h6>Total: ₱<span id="mainTotal">{{ number_format($product->productPrice, 2) }}</span></h6>
          </div>

          <!-- Hidden Forms -->
          <form id="cartForm" method="POST" action="{{ route('addtocart') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="cartQuantity" value="1">
            <input type="hidden" name="totalPrice" id="totalPrice" value="{{ $product->productPrice }}">
          </form>

          <form id="buyForm" method="POST" action="{{ route('buyNow') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="userID" value="{{ $product->userID }}">
            <input type="hidden" name="quantity" id="buyQuantity" value="1">
            <input type="hidden" name="totalPrice" id="totalPriceOrder" value="{{ $product->productPrice }}">
          </form>

          <!-- Action Buttons -->
          <div class="d-flex gap-2 mt-3">
            <button class="btn btn-warning w-50" onclick="submitCartForm()">Add to Cart</button>
            <button class="btn btn-primary w-50" onclick="submitBuyForm()">Buy Now</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Review Section -->
    <div class="col-md-6">
      <h4>Customer Reviews</h4>
      @php
        $ratingsCount = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $totalRatings = 0;
        $sumRatings = 0;

        foreach ($feedBack as $fb) {
          $ratingsCount[$fb->ratings]++;
          $sumRatings += $fb->ratings;
          $totalRatings++;
        }

        $averageRating = $totalRatings > 0 ? round($sumRatings / $totalRatings, 1) : 0;
      @endphp

      <div class="mb-3">
        <h5 class="mb-0">Average Rating: {{ $averageRating }} / 5</h5>
        <div class="text-warning mb-2">
          @for($i = 1; $i <= 5; $i++)
            @if($i <= round($averageRating))
              ★
            @else
              ☆
            @endif
          @endfor
          ({{ $totalRatings }} reviews)
        </div>

        @for($i = 5; $i >= 1; $i--)
          @php
            $percent = $totalRatings > 0 ? ($ratingsCount[$i] / $totalRatings) * 100 : 0;
          @endphp
          <div class="d-flex align-items-center">
            <div style="width: 60px;">{{ $i }} star</div>
            <div class="progress flex-grow-1 me-2">
              <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%"></div>
            </div>
            <small>{{ $ratingsCount[$i] }}</small>
          </div>
        @endfor
      </div>

      <!-- Comments -->
      <div class="mt-4">
        @forelse($feedBack as $fb)
          <div class="border-bottom mb-3 pb-2">
            <div class="fw-bold">{{ $fb->user->name ?? 'Anonymous' }}</div>
            <div class="text-warning mb-1">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= $fb->ratings)
                  ★
                @else
                  ☆
                @endif
              @endfor
            </div>
            <p>{{ $fb->comment }}</p>
            @if($fb->complainImage)
              <img src="{{ asset('storage/' . $fb->complainImage) }}" alt="review-img" style="width: 100px; height: auto;" class="rounded border">
            @endif
          </div>
        @empty
          <p>No reviews yet for this product.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0 text-center">
        <img src="{{ asset('storage/app/public/' . $product->productImage) }}" class="img-fluid w-100" alt="preview">
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
  const unitPrice = {{ $product->productPrice }};
  const availableStock = {{ $product->productQuantity }};

  function updateMainTotal() {
    let quantity = parseInt(document.getElementById("quantity").value) || 1;
    if (quantity > availableStock) {
      alert("Unavailable stocks.");
      quantity = availableStock;
    } else if (quantity < 1) {
      quantity = 1;
    }
    document.getElementById("quantity").value = quantity;
    let total = unitPrice * quantity;
    document.getElementById("mainTotal").textContent = total.toFixed(2);
    document.getElementById("totalPrice").value = total.toFixed(2);
    document.getElementById("totalPriceOrder").value = total.toFixed(2);
  }

  function submitCartForm() {
    event.preventDefault();
    updateMainTotal();
    document.getElementById("cartQuantity").value = document.getElementById("quantity").value;
    document.getElementById("cartForm").submit();
  }

  function submitBuyForm() {
    event.preventDefault();
    updateMainTotal();
    document.getElementById("buyQuantity").value = document.getElementById("quantity").value;
    document.getElementById("buyForm").submit();
  }

  window.onload = updateMainTotal;
</script>
</body>
</html>
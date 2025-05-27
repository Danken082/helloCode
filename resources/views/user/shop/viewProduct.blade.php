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

  <div class="row g-4">
    <!-- Product Info -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <img src="{{ asset('storage/app/public/' . $product->productImage) }}" class="card-img-top custom-img" alt="{{ $product->productName }}">
        <div class="card-body">
          <h4 class="card-title">{{ $product->productName }}</h4>
          <h5 class="text-success">Price: ₱{{ number_format($product->productPrice, 2) }}</h5>
          <h6>Stocks: {{ $product->productQuantity }}</h6>
        </div>
      </div>
    </div>

    <!-- Review Summary -->
    <div class="col-md-6">
      <div class="card shadow-sm p-3">
        <h5>Customer Reviews</h5>
        @php
          $avgRating = $feedBack->avg('ratings');
          $totalReviews = $feedBack->count();
          $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
          foreach ($feedBack as $fb) {
            $ratingCounts[$fb->ratings]++;
          }
        @endphp

        <div class="mb-3">
          <h3 class="text-warning">{{ number_format($avgRating, 1) }}/5</h3>
          <p class="text-muted">Based on {{ $totalReviews }} review(s)</p>
        </div>

        @foreach(range(5, 1) as $star)
          @php $percent = $totalReviews ? ($ratingCounts[$star] / $totalReviews) * 100 : 0; @endphp
          <div class="d-flex align-items-center mb-2">
            <span class="me-2" style="width: 2rem;">{{ $star }}★</span>
            <div class="flex-grow-1 rating-bar">
              <div class="rating-bar-fill" style="width: {{ $percent }}%"></div>
            </div>
            <span class="ms-2">{{ $ratingCounts[$star] }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Reviews List -->
  <div class="mt-5">
    <h5>All Reviews</h5>
    @forelse($feedBack as $review)
      <div class="card my-3">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
            <span class="text-warning">{{ str_repeat('★', $review->ratings) }}{{ str_repeat('☆', 5 - $review->ratings) }}</span>
          </div>
          <p class="mt-2 mb-1">{{ $review->comment }}</p>
          @if($review->complainImage)
            <img src="{{ asset('storage/' . $review->complainImage) }}" alt="Review Image" class="img-fluid rounded" style="max-width: 200px;">
          @endif
        </div>
      </div>
    @empty
      <p class="text-muted">No reviews yet.</p>
    @endforelse
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
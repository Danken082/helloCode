<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .star-rating {
      color: gold;
    }
    .custom-img {
      width: 200px;
      height: auto;
      object-fit: cover;
    }

    .modal-body img {
      max-height: 80vh;
      object-fit: contain;
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">
<div class="mb-4">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">&larr; Back</a>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal">
          <img src="{{ asset('storage/' . $product->productImage) }}" 
               class="card-img-top img-fluid custom-img" 
               alt="{{ $product->name }}">
        </a>

        <div class="card-body">
          <h4 class="card-title">{{ $product->productName }}</h4>
          <h5 class="text-success">Unit Price: ₱<span id="unitPriceDisplay">{{ number_format($product->productPrice, 2) }}</span></h5>

          <div class="mb-2">
            <span class="star-rating">★★★★☆</span>
            <span class="text-muted">(4.2 average based on 5 reviews)</span>
          </div>

          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="number" class="form-control w-25" id="quantity" value="1" min="1" max="{{ $product->productQuantity }}" onchange="updateMainTotal()">

          </div>

          <div class="mb-3">
            <h6>Stocks: <span>{{ $product->productQuantity}}</span></h6>
          </div>


          <div class="mb-3">
            <h6>Total: ₱<span id="mainTotal">{{ number_format($product->productPrice, 2) }}</span></h6>
          </div>

          <!-- Hidden Forms -->
          <!-- Add to Cart Form -->
          <form id="cartForm" method="POST" action="{{ route('addtocart') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="cartQuantity" value="1">
            <input type="hidden" name="totalPrice" id="totalPrice" value="{{ $product->productPrice }}">
          </form>

          <!-- Buy Now Form -->
          <form id="buyForm" method="POST" action="{{ route('buyNow') }}"> 
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="buyQuantity" value="1">
            <input type="hidden" name="totalPrice" id="totalPriceOrder" value="{{ $product->productPrice }}">
          </form>

          <div class="d-flex gap-2">
            <button class="btn btn-warning w-50" onclick="submitCartForm()">Add to Cart</button>
            <button class="btn btn-primary w-50" onclick="submitBuyForm()">Buy Now</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content position-relative">
      <!-- ✅ Close button inside the modal content -->
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
      
      <div class="modal-body text-center p-0">
        <img src="{{ asset('storage/' . $product->productImage) }}" 
             alt="{{ $product->name }}" 
             class="img-fluid w-100">
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const unitPrice = {{ $product->productPrice }};
  const availableStock = {{ $product->productQuantity }}; 

  function updateMainTotal() {
  let quantity = parseInt(document.getElementById("quantity").value) || 1;

  if (quantity > availableStock) {
    alert("Unavailable stocks. Please contact the seller.");
    quantity = availableStock;
    document.getElementById("quantity").value = quantity;
  } else if (quantity < 1) {
    quantity = 1;
    document.getElementById("quantity").value = 1;
  }

  const total = unitPrice * quantity;
  document.getElementById("mainTotal").textContent = total.toFixed(2);
  document.getElementById("totalPrice").value = total.toFixed(2);
  document.getElementById("totalPriceOrder").value = total.toFixed(2);
}

  function submitCartForm() {
  event.preventDefault();
  const quantity = parseInt(document.getElementById("quantity").value) || 1;

  if (quantity > availableStock) {
    alert("Unavailable stocks. Please contact the seller.");
    return;
  }

  document.getElementById("cartQuantity").value = quantity;
  document.getElementById("cartForm").submit();
}

function submitBuyForm() {
  event.preventDefault();
  const quantity = parseInt(document.getElementById("quantity").value) || 1;

  if (quantity > availableStock) {
    alert("Unavailable stocks. Please contact the seller.");
    return;
  }

  document.getElementById("buyQuantity").value = quantity;
  document.getElementById("buyForm").submit();
}


  // Initialize total on page load
  updateMainTotal();
</script>

</body>
</html>

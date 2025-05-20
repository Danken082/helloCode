<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product List with Image Preview</title>
  <!-- Bootstrap CSS -->
<!-- Correct Bootstrap CSS (latest 5.x stable) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .table-wrapper {
      background: white;
      padding: 1rem;
      border-radius: 0.375rem;
      box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
      overflow-x: auto;
    }
    table img {
      max-width: 80px;
      height: auto;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="container my-5">
<a href="/seller/center" class="btn btn-secondary">Back</a>

  <h2 class="mb-4">Product List</h2>
  <div class="table-wrapper">
    <table class="table table-bordered table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">Quantity</th>
          <th scope="col">Product Name</th>
          <th scope="col">Product Image</th>
          <th scope="col">Price</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>

      @foreach($prod as $prod)
      <tbody>
        <tr>
          <td>{{$prod->productQuantity}}</td>
          <td>{{$prod->productName}}</td>
          <td>
          <img src="{{ asset('storage/' . $prod->productImage) }}" alt="{{ $prod->productImage ?? 'Product Image' }}"
            data-bs-toggle="modal" data-bs-target="#imageModal"
            data-bs-img="{{ asset('storage/' . $prod->productImage) }}" />
          </td>
          <td>{{ $prod->productPrice}}</td>
          <td>
          <button type="button" class="btn btn-primary btn-sm me-1">view</button>
          <button type="button" class="btn btn-success btn-sm me-1 edit-btn" 
        data-bs-toggle="modal" 
        data-bs-target="#editProductModal"
        data-id="{{ $prod->id }}"
        data-name="{{ $prod->productName }}"
        data-description="{{ $prod->productDetails }}"
        data-quantity="{{ $prod->productQuantity }}"
        data-price="{{ $prod->productPrice}}"
        data-sizes='@json($prod->sizes ?? [])'>
        Edit
        </button>

            <button type="button" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
        
      </tbody>

      @endforeach
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="img-fluid rounded" alt="Preview" />
      </div>
    </div>
  </div>
</div>


<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="editProductForm" method="POST" action="">
      @csrf
      @method('PUT')
      <input type="hidden" name="product_id" id="editProductId" />

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="editProductName" class="form-label">Product Name</label>
            <input type="text" name="productName" id="editProductName" class="form-control" required>
          </div>


          <div class="mb-3">
  <label for="editProductDescription" class="form-label">Product Description</label>
  <textarea name="productDescription" class="form-control" id="editProductDescription" cols="30" rows="5" required></textarea>
</div>


          <div class="mb-3">
            <label for="editProductQuantity" class="form-label">Quantity</label>
            <input type="number" name="productQuantity" id="editProductQuantity" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label for="editProductPrice" class="form-label">Price</label>
            <input type="number" name="productPrice" id="editProductPrice" class="form-control" step="0.01" min="0" required>
          </div>

          <!-- <div class="mb-3"> -->
        <!-- <label class="form-label">Product Sizes & Prices</label>
        <div id="sizesWrapper"> -->
            <!-- Size + price input groups will go here -->
        <!-- </div>
        <button type="button" id="addSizeBtn" class="btn btn-sm btn-outline-primary mt-2">Add Size</button>
        </div> -->


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>

    </form>
  </div>
</div>


<!-- Bootstrap JS Bundle -->
<!-- Correct Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
  // When modal is shown, update the image src based on clicked thumbnail's data-bs-img attribute
  const imageModal = document.getElementById('imageModal');
  imageModal.addEventListener('show.bs.modal', event => {
    const triggerImg = event.relatedTarget;
    const modalImg = document.getElementById('modalImage');
    modalImg.src = triggerImg.getAttribute('data-bs-img');
    modalImg.alt = triggerImg.alt || 'Preview';
  });



  document.querySelectorAll('.edit-btn').forEach(button => {
  button.addEventListener('click', event => {
    const btn = event.currentTarget;

    // Fill form inputs
    document.getElementById('editProductId').value = btn.dataset.id;
    document.getElementById('editProductName').value = btn.dataset.name;
    document.getElementById('editProductQuantity').value = btn.dataset.quantity;
    document.getElementById('editProductPrice').value = btn.dataset.price;
    document.getElementById('editProductDescription').value = btn.dataset.description;


    // Fill sizes
    const sizesWrapper = document.getElementById('sizesWrapper');
    sizesWrapper.innerHTML = ''; // Clear previous

    let sizes = [];
    try {
      sizes = JSON.parse(btn.dataset.sizes);
    } catch {
      sizes = [];
    }

    if (sizes.length === 0) {
      addSizeInput(''); // Add one empty input if no sizes
    } else {
      sizes.forEach(size => addSizeInput(size));
    }
  });
});

// Add size input function
function addSizeInput(size = '', price = '') {
  const sizesWrapper = document.getElementById('sizesWrapper');

  const div = document.createElement('div');
  div.className = 'row g-2 align-items-center mb-2';

  // Size input
  const sizeCol = document.createElement('div');
  sizeCol.className = 'col-5';
  const sizeInput = document.createElement('input');
  sizeInput.type = 'text';
  sizeInput.name = 'productSizes[][size]';
  sizeInput.className = 'form-control';
  sizeInput.placeholder = 'Size (e.g., Small)';
  sizeInput.value = size;
  sizeCol.appendChild(sizeInput);

  // Price input
  const priceCol = document.createElement('div');
  priceCol.className = 'col-5';
  const priceInput = document.createElement('input');
  priceInput.type = 'number';
  priceInput.name = 'productSizes[][price]';
  priceInput.className = 'form-control';
  priceInput.placeholder = 'Price';
  priceInput.step = '0.01';
  priceInput.value = price;
  priceCol.appendChild(priceInput);

  // Remove button
  const removeCol = document.createElement('div');
  removeCol.className = 'col-2';
  const btnRemove = document.createElement('button');
  btnRemove.type = 'button';
  btnRemove.className = 'btn btn-danger btn-sm w-100';
  btnRemove.innerText = '×';
  btnRemove.onclick = () => div.remove();
  removeCol.appendChild(btnRemove);

  div.appendChild(sizeCol);
  div.appendChild(priceCol);
  div.appendChild(removeCol);

  sizesWrapper.appendChild(div);
}
document.querySelectorAll('.edit-btn').forEach(button => {
  button.addEventListener('click', event => {
    const btn = event.currentTarget;

    document.getElementById('editProductId').value = btn.dataset.id;
    document.getElementById('editProductName').value = btn.dataset.name;
    document.getElementById('editProductQuantity').value = btn.dataset.quantity;
    document.getElementById('editProductPrice').value = btn.dataset.price;

    const sizesWrapper = document.getElementById('sizesWrapper');
    sizesWrapper.innerHTML = '';

    let sizes = [];
    try {
      sizes = JSON.parse(btn.dataset.sizes);
    } catch {
      sizes = [];
    }

    if (sizes.length === 0) {
      addSizeInput('', '');
    } else {
      sizes.forEach(sizeObj => {
        addSizeInput(sizeObj.size, sizeObj.price);
      });
    }
  });
});

document.getElementById('addSizeBtn').addEventListener('click', () => {
  addSizeInput('', '');
});


</script>

</body>
</html>

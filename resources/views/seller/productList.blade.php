<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product List with Image Preview</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background-color: #f8f9fa; }
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
  @if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

  <div class="table-wrapper">
    <table class="table table-bordered table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Quantity</th>
          <th>Product Name</th>
          <th>Product Image</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>

      @foreach($prod as $prod)
      <tbody>
        <tr>
          <td>{{ $prod->productQuantity }}</td>
          <td>{{ $prod->productName }}</td>
          <td>
            <img src="{{ asset('storage/app/public/' . $prod->productImage) }}" 
                 alt="Product Image" 
                 data-bs-toggle="modal" 
                 data-bs-target="#imageModal"
                 data-bs-img="{{ asset('storage/app/public/' . $prod->productImage) }}" />
          </td>
          <td>{{ $prod->productPrice }}</td>
          <td>
            <button type="button" class="btn btn-primary btn-sm me-1">View</button>
            <button type="button" class="btn btn-success btn-sm me-1 edit-btn" 
              data-bs-toggle="modal" 
              data-bs-target="#editProductModal"
              data-id="{{ $prod->id }}"
              data-name="{{ $prod->productName }}"
              data-description="{{ $prod->productDetails }}"
              data-quantity="{{ $prod->productQuantity }}"
              data-price="{{ $prod->productPrice }}"
              data-sizes='@json($prod->sizes ?? [])'
              data-image="{{ asset('storage/app/public/' . $prod->productImage) }}">
              Edit
            </button>
            <form action="{{ route('products.destroy', $prod->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </form>

          </td>
        </tr>
      </tbody>
      @endforeach
    </table>
  </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="img-fluid rounded" alt="Preview" />
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="editProductForm" method="POST" enctype="multipart/form-data" action="">
      @csrf
      @method('PUT')
      <input type="hidden" name="product_id" id="editProductId" />

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="productName" id="editProductName" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Product Description</label>
            <textarea name="productDescription" class="form-control" id="editProductDescription" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="productQuantity" id="editProductQuantity" class="form-control" min="0" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="productPrice" id="editProductPrice" class="form-control" step="0.01" min="0" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="productImage" id="editProductImage" class="form-control" accept="image/*">
            <div class="mt-2">
              <img id="previewProductImage" src="" class="img-thumbnail" style="max-width: 150px;">
            </div>
          </div>

          <!-- <div class="mb-3">
            <label class="form-label">Product Sizes</label>
            <div id="sizesWrapper"></div>
            <button type="button" id="addSizeBtn" class="btn btn-outline-primary btn-sm mt-2">Add Size</button>
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

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Preview image in modal
  document.getElementById('imageModal').addEventListener('show.bs.modal', event => {
    const img = event.relatedTarget;
    document.getElementById('modalImage').src = img.getAttribute('data-bs-img');
  });

  // Edit button logic
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
      const id = button.dataset.id;
      document.getElementById('editProductForm').action = `/products/${id}`;
      document.getElementById('editProductId').value = id;
      document.getElementById('editProductName').value = button.dataset.name;
      document.getElementById('editProductDescription').value = button.dataset.description;
      document.getElementById('editProductQuantity').value = button.dataset.quantity;
      document.getElementById('editProductPrice').value = button.dataset.price;
      document.getElementById('previewProductImage').src = button.dataset.image;
      document.getElementById('editProductImage').value = '';

      const sizes = JSON.parse(button.dataset.sizes || '[]');
      const sizesWrapper = document.getElementById('sizesWrapper');
      sizesWrapper.innerHTML = '';
      if (sizes.length === 0) {
        addSizeInput('', '');
      } else {
        sizes.forEach(size => addSizeInput(size.size, size.price));
      }
    });
  });

  // Live preview for uploaded image
  document.getElementById('editProductImage').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => document.getElementById('previewProductImage').src = e.target.result;
      reader.readAsDataURL(file);
    }
  });

  // Add size input field
  function addSizeInput(size = '', price = '') {
    const wrapper = document.getElementById('sizesWrapper');
    const div = document.createElement('div');
    div.className = 'row g-2 align-items-center mb-2';

    div.innerHTML = `
      <div class="col-5">
        <input type="text" name="productSizes[][size]" class="form-control" value="${size}" placeholder="Size (e.g. Small)">
      </div>
      <div class="col-5">
        <input type="number" name="productSizes[][price]" class="form-control" value="${price}" placeholder="Price" step="0.01">
      </div>
      <div class="col-2">
        <button type="button" class="btn btn-danger btn-sm w-100" onclick="this.closest('.row').remove()">×</button>
      </div>
    `;
    wrapper.appendChild(div);
  }

  document.getElementById('addSizeBtn').addEventListener('click', () => addSizeInput('', ''));
</script>

</body>
</html>

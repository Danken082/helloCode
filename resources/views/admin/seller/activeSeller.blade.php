<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
       body {
  background-color: #f9f9f9;
  font-family: "Segoe UI", sans-serif;
}

.navbar-custom {
  background-color: #ffffff;
  border-bottom: 1px solid #e0e0e0;
}

.navbar-custom .navbar-brand,
.navbar-custom .nav-link,
.navbar-custom .dropdown-item {
  color: #333333;
}

.navbar-custom .nav-link:hover,
.navbar-custom .dropdown-item:hover {
  color: #0d6efd;
}

.card {
  border: none;
  border-radius: 1rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s ease-in-out, box-shadow 0.2s;
}

.card:hover {
  transform: scale(1.02);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.card-body {
  padding: 2rem 1.5rem;
}

.card-title {
  font-size: 1rem;
  color: #555;
  margin-bottom: 0.5rem;
}

.card-text {
  font-size: 2rem;
  font-weight: bold;
  color: #000;
}

.table {
  background-color: #fff;
  border-radius: 0.5rem;
  overflow: hidden;
}

.table th {
  background-color: #f1f1f1;
  color: #333;
  font-weight: 600;
}

.table td, .table th {
  border: none;
  vertical-align: middle;
}

select.form-select {
  font-weight: 500;
  padding: 0.375rem 0.75rem;
}

.btn-sm {
  border-radius: 0.375rem;
}


    .main-content {
      padding: 2rem;
    }


    .pagination .page-link {
    font-weight: 500;
  }

  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">Hi! Admin {{ Auth::user()->name }}</a>

    <span class="text-white me-3">{{ Auth::user()->name }}</span>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="#">Dashboard</a>
        </li>
      </ul>

      <form method="POST" action="{{ route('logout') }}" class="d-flex">
        @csrf
        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
      </form>
    </div>
  </div>
</nav>


<!-- Main Content -->
<div class="main-content">
<a href="javascript:history.back()" class="btn btn-outline-secondary mb-4">
      &larr; Back
    </a>
  <section class="mt-5">
    <h3 class="mb-4">Sellers</h3>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Status</th>
            <th>Count of Products</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sellers as $seller)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $seller->user->name }}</td>
            <td>{{ $seller->user->email }}</td>
            <td>{{ $seller->address }}</td>
            
            
            <td>
              <select class="form-select status-selector"
                      data-user-id="{{ $seller->user->id }}">
                <option value="underReview" {{ $seller->shopStatus == 'underReview' ? 'selected' : '' }}>Under Review</option>
                <option value="shopAccepted" {{ $seller->shopStatus == 'shopAccepted' ? 'selected' : '' }}>Activate</option>
                <option value="Suspend" {{ $seller->shopStatus == 'Suspend' ? 'selected' : '' }}>Suspend</option>
              </select>
            </td>

            <td>
            <a href="#" class="btn btn-sm btn-outline-primary">
    View Products ({{ $seller->product_count }})
</a>

</td>

            <td>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewSellerModal{{ $seller->id }}">View</button>
            </td>
          </tr>

          <!-- Seller Details Modal -->
          <div class="modal fade" id="viewSellerModal{{ $seller->id }}" tabindex="-1" aria-labelledby="viewSellerModalLabel{{ $seller->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="viewSellerModalLabel{{ $seller->id }}">Seller Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                  <div class="col-md-6 text-center">
                    <img src="{{ asset('storage/' . $seller->productImage) }}" alt="Product Image" class="img-fluid rounded border" />
                  </div>
                  <div class="col-md-6">
                    <h5>Name: {{ $seller->user->name }}</h5>
                    <p><strong>Email:</strong> {{ $seller->user->email }}</p>
                    <p><strong>Address:</strong> {{ $seller->address }}</p>
                    <p><strong>Business Name:</strong> {{ $seller->bussinessName }}</p>
                    <p><strong>Business Age:</strong> {{ $seller->businessAge }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($seller->shopStatus) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @empty
          <tr>
            <td colspan="6" class="text-center text-muted">No pending sellers.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-selector').forEach(function (selector) {
      selector.addEventListener('change', function () {
        const userId = this.getAttribute('data-user-id');
        const newStatus = this.value;

        fetch(`/seller/update-status/${userId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
          alert(data.message || 'Status updated successfully!');
          window.location.href = "/dashboard";
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating status.');
        });
      });
    });
  });
</script>
</body>
</html>
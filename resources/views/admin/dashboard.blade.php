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

<!-- Top Navbar -->
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

@if(session('success'))
  <div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
@endif

<!-- Main Content -->
<div class="main-content">


  <div class="row mt-4">
  <div class="col-md-4">
  <a href="{{ route('sellerAccepted') }}" class="text-decoration-none">
    <div class="card text-dark bg-white mb-4 shadow rounded-4 border-0 hover-scale">
      <div class="card-body text-center fw-bold">
        <h5 class="card-title">Total Sellers</h5>
        <p class="card-text display-6">{{ $totalSellers }}</p>
      </div>
    </div>
  </a>
</div>

<div class="col-md-4">
  <a href="{{ route('sellerView') }}" class="text-decoration-none">
    <div class="card text-dark bg-white mb-4 shadow rounded-4 border-0 hover-scale">
      <div class="card-body text-center fw-bold">
        <h5 class="card-title">Pending Seller Applications</h5>
        <p class="card-text display-6">{{ $applyingSellers }}</p>
      </div>
    </div>
  </a>
</div>

<div class="col-md-4">
  <a href="/customer" class="text-decoration-none">
    <div class="card text-dark bg-white mb-4 shadow rounded-4 border-0 hover-scale">
      <div class="card-body text-center fw-bold">
        <h5 class="card-title">Total Customers</h5>
        <p class="card-text display-6">{{ $totalCustomers }}</p>
      </div>
    </div>
  </a>
</div>

<div class="col-md-4">
  <a href="{{ route('admin')}}" class="text-decoration-none">
    <div class="card text-dark bg-white mb-4 shadow rounded-4 border-0 hover-scale">
      <div class="card-body text-center fw-bold">
        <h5 class="card-title">Total Admin</h5>
        <p class="card-text display-6">{{ $totalAdmin }}</p>
      </div>
    </div>
  </a>
</div>

<div class="col-md-4">
  <a href="{{ route('sellerAccepted') }}" class="text-decoration-none">
    <div class="card text-dark bg-white mb-4 shadow rounded-4 border-0 hover-scale">
      <div class="card-body text-center fw-bold">
        <h5 class="card-title">Total Vendor Products</h5>
        <p class="card-text display-6">{{ $totalProducts }}</p>
      </div>
    </div>
  </a>
</div>

  <div class="col-md-4">
  <a href="{{ route('riders') }}" class="text-decoration-none">
    <div class="card text-dark bg-white mb-4 shadow rounded-4 border-0 hover-scale">
      <div class="card-body text-center fw-bold">
        <h5 class="card-title">Riders</h5>
        <p class="card-text display-6">{{ $totalRiders }}</p>
      </div>
    </div>
  </a>
</div>

<div class="col-md-4">
  <a href="{{ route('suspendSeller')}}" class="text-decoration-none">
    <div class="card text-dark bg-white mb-4 shadow rounded-4 border-0 hover-scale">
      <div class="card-body text-center fw-bold">
        <h5 class="card-title">Suspended Sellers</h5>
        <p class="card-text display-6">{{ $getsuspendSellers }}</p>
      </div>
    </div>
  </a>
</div>

  </div>

  <!-- Orders Table -->
  <section class="mt-5">
    <h3 class="mb-4">Sellers</h3>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Image</th>
            <th>Contact</th>
            <th>Business Name</th>
            <th>Business Age</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($getSellers as $seller)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $seller->user->name }}</td>
            <td>{{ $seller->address }}</td>
            <td>{{ $seller->user->email }}</td>
            <td>
              <img 
                src="{{ asset('storage/' . $seller->productImage) }}" 
                alt="Product Image" 
                style="width: 100px; height: auto; cursor: pointer;"
                data-bs-toggle="modal"
                data-bs-target="#imageModal{{ $seller->id }}"
              >
            </td>
            <td>{{ $seller->user->contactNo }}</td>
            <td>{{ $seller->bussinessName }}</td>
            <td>{{ $seller->businessAge }}</td>
            <td>
              <select class="form-select status-selector"
                data-user-id="{{ $seller->user->id }}"
                data-shop-status="{{ $seller->shopStatus }}">
                <option value="underReview" {{ $seller->shopStatus == 'underReview' ? 'selected' : '' }}>Under Review</option>
                <option value="shopAccepted" {{ $seller->shopStatus == 'shopAccepted' ? 'selected' : '' }}>Activate</option>
                <option value="suspend" {{ $seller->shopStatus == 'suspend' ? 'selected' : '' }}>Suspend</option>
              </select>
            </td>
          <td>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewSellerModal{{ $seller->id }}">View</button>
          </td>

          </tr>

          <!-- Modal -->
          <div class="modal fade" id="imageModal{{ $seller->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $seller->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="imageModalLabel{{ $seller->id }}">Product Image</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                  <img src="{{ asset('storage/' . $seller->productImage) }}" alt="Preview" style="max-width: 100%; height: auto;" />
                </div>
              </div>
            </div>
          </div>

          <!-- Seller Details Modal -->
<div class="modal fade" id="viewSellerModal{{ $seller->id }}" tabindex="-1" aria-labelledby="viewSellerLabel{{ $seller->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewSellerLabel{{ $seller->id }}">Seller Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-4">
            <img src="{{ asset('storage/' . $seller->productImage) }}" class="img-fluid rounded" alt="Product Image">
          </div>
          <div class="col-md-8">
            <p><strong>Name:</strong> {{ $seller->user->name }}</p>
            <p><strong>Email:</strong> {{ $seller->user->email }}</p>
            <p><strong>Contact:</strong> {{ $seller->user->contactNo }}</p>
            <p><strong>Address:</strong> {{ $seller->address }}</p>
            <p><strong>Business Name:</strong> {{ $seller->bussinessName }}</p>
            <p><strong>Business Age:</strong> {{ $seller->businessAge }}</p>
            <p><strong>Status:</strong> {{ ucfirst($seller->shopStatus) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

        @endforeach
        </tbody>
        <div class="d-flex justify-content-center mt-4">
    {{ $sellerPagenotations->links('pagination::bootstrap-5') }}
</div>

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
          body: JSON.stringify({
            status: newStatus
          })
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

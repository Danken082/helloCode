<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sellers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .navbar-custom {
      background-color: #343a40;
    }
  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Hi! Admin</a>
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

  <div class="container mt-3">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="btn btn-outline-secondary mb-4">
      &larr; Back
    </a>

    <h3 class="mb-4">Seller List</h3>

    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        @if($sellers->isEmpty())
        <tbody>
          <tr>
            <td colspan="6" class="text-center text-muted">No pending sellers.</td>
          </tr>
        </tbody>
        @else
          @foreach($sellers as $seller)
          <tbody>
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $seller->user->name }}</td>
              <td>{{ $seller->user->email }}</td>
              <td>{{ $seller->address }}</td>
              <td>


                <select class="form-select status-selector"
                        data-user-id="{{ $seller->user->id }}"
                        data-shop-status="{{ $seller->shopStatus }}">
                  <option value="underReview" {{ $seller->shopStatus == 'underReview' ? 'selected' : '' }}>Under Review</option>
                  <option value="shopAccepted" {{ $seller->shopStatus == 'shopAccepted' ? 'selected' : '' }}>Activate</option>
                  <option value="Suspend" {{ $seller->shopStatus == 'Suspend' ? 'selected' : '' }}>Suspend</option>
                </select>
              </td>
              <td>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewSellerModal{{ $seller->id }}">
                  View
                </button>
                <button class="btn btn-sm btn-warning">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>

          <!-- Modal for Seller View -->
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
          @endforeach
        @endif

      </table>
    </div>
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

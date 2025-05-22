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
<a href="/dashboad" class="btn btn-outline-secondary mb-4">
      &larr; Back
    </a>
  <section class="mt-5">
    <h3 class="mb-4">Admin</h3>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addRiderModal">
      + Add Admin
    </button>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Action</th>
          </tr>
        </thead>
        @foreach($admin as $user)
        <tbody>
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->contactNo }}</td>
            <td>
              <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editRiderModal{{ $user->id }}">
                Edit
              </button>
            </td>
         </tr>
        </tbody>
        @endforeach  
      </table>
    </div>
  </section>
</div>

<!-- Add Rider Modal -->
<div class="modal fade" id="addRiderModal" tabindex="-1" aria-labelledby="addRiderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('create.admin')}}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addRiderModalLabel">Add New Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
          </div>

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

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add Rider</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Edit Rider Modals --}}
@foreach($admin as $user)
<div class="modal fade" id="editRiderModal{{ $user->id }}" tabindex="-1" aria-labelledby="editRiderModalLabel{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('update.admin', $user->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editRiderModalLabel{{ $user->id }}">Edit Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="name{{ $user->id }}" class="form-label">Name</label>
            <input type="text" class="form-control" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" required>
          </div>

          <div class="mb-3">
            <label for="email{{ $user->id }}" class="form-label">Email</label>
            <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required>
          </div>

          <div class="mb-3">
            <label for="address{{ $user->id }}" class="form-label">Address</label>
            <textarea class="form-control" id="address{{ $user->id }}" name="address" rows="2" required>{{ $user->address }}</textarea>
          </div>

          <div class="mb-3">
            <label for="contact_number{{ $user->id }}" class="form-label">Phone Number</label>
            <input
              type="tel"
              name="contactNo"
              class="form-control"
              id="contact_number{{ $user->id }}"
              pattern="^09\d{9}$"
              value="{{ $user->contactNo }}"
              required
            />
            <small class="text-muted">Must be a valid mobile number starting with 09</small>
          </div>

          <div class="mb-3">
            <label for="status{{ $user->id }}" class="form-label">Status</label>
            <select class="form-select" id="status{{ $user->id }}" name="status" required>
              <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

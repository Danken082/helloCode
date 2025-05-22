<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            margin: 40px auto;
        }

        h2 {
            text-align: center;
            color: #37BAE2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
        }

        .status-pending {
            color: #d9534f;
            font-weight: bold;
        }

        .preview-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Navbar Styles */
        .navbar .form-inline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-secondary:hover {
            background-color: #e8e8e8;
        }

        .dropdown-menu-end {
            min-width: 180px;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-light px-4 py-3">
    <a class="navbar-brand fw-bold" href="/">EceP</a>

    <div class="d-flex align-items-center gap-2">

        <!-- Seller Center -->
        <a href="/seller/center/" class="btn btn-outline-secondary me-2 d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                 class="bi bi-shop" viewBox="0 0 16 16">
                <path d="M2.97 1a.5.5 0 0 0-.485.379L1.61 5H14.39l-.875-3.621A.5.5 0 0 0 13.03 1H2.97zM0 5.5A.5.5 0 0 1 .5 5h15a.5.5 0 0 1 .5.5V6c0 .42-.17.815-.445 1.1C15.274 7.753 14.5 8 13.5 8s-1.774-.247-2.055-.9A1.992 1.992 0 0 1 11 6H5a1.99 1.99 0 0 1-.445 1.1C4.274 7.753 3.5 8 2.5 8s-1.774-.247-2.055-.9A1.992 1.992 0 0 1 0 6v-.5z"/>
                <path d="M2.5 9A1.5 1.5 0 0 0 1 10.5v4a.5.5 0 0 0 .5.5H5v-5H2.5zm8.5 0v5h3.5a.5.5 0 0 0 .5-.5v-4A1.5 1.5 0 0 0 13.5 9H11z"/>
            </svg>
            <span class="ms-2 d-none d-md-inline">Seller Center</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('viewCart') }}" class="btn btn-outline-secondary me-2 d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                 class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zM3.14 6l1.25 6h8.22l1.25-6H3.14z"/>
                <path d="M5.5 16a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm7 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
            </svg>
            <span class="ms-2 d-none d-md-inline">Cart</span>
        </a>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <a class="btn btn-outline-secondary d-flex align-items-center gap-2" href="#" role="button"
               id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M13.468 12.37C12.758 11.226 11.552 10.5 10 10.5s-2.758.726-3.468 1.87A6.987 6.987 0 0 1 1 8a7 7 0 1 1 14 0 6.987 6.987 0 0 1-1.532 4.37z"/>
                    <path fill-rule="evenodd" d="M10 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0z"/>
                </svg>
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="/">Orders</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <h2>Pending Product Orders</h2>
    <table>
        <thead>
        <tr>
            <th>Image</th>
            <th>Order Code</th>
            <th>Product Name</th>
            <th>Shop Name</th>
            <th>Quantity</th>
            <th>Product Price</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order as $item)
            <tr>
                <td>
                    <img src="{{ asset('storage/app/public/' . $item->product->productImage) }}"
                         alt="Product Image"
                         class="preview-img"
                         data-bs-toggle="modal"
                         data-bs-target="#imageModal"
                         data-img="{{ asset('storage/app/public/' . $item->product->productImage) }}">
                </td>
                <td>{{ $item->orderCode }}</td>
                <td>{{ $item->product->productName }}</td>
                <td>{{ $item->user->regseller->bussinessName }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product->productPrice }}</td>
                <td>{{ $item->totalPrice }}</td>
                <td class="status-pending">{{ $item->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Full Image">
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    imageModal.addEventListener('show.bs.modal', event => {
        const trigger = event.relatedTarget;
        const imgSrc = trigger.getAttribute('data-img');
        modalImage.src = imgSrc;
    });
</script>
</body>
</html>

@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Main Content -->
<div class="container mt-5">
    <h2>Product Orders</h2>
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
            <td>{{ $item->product->user->regseller->bussinessName ?? 'N/A'}}</td>    
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->product->productPrice }}</td>
            <td>{{ $item->totalPrice }}</td>
            <td class="status-pending">
              
                @if($item->status === 'claimedByDeliveryPartner')
                <p>Out of Delivery</p>
                <p>Rider Name: <strong style="text-transform:uppercase;">{{ $item->rider->name }}</strong></p>
                @elseif($item->status === 'Completed')
                <p>Delivered</p>
               
                @elseif($item->status === 'Pending')
                    <form method="POST" action="{{ route('orders.cancel', $item->id) }}" class="d-inline-block ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                    </form>

                @else
                <p>Cancelled Order</p>
                @endif
            </td>
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

@endsection


@push('scripts')
<script>
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    imageModal.addEventListener('show.bs.modal', event => {
        const trigger = event.relatedTarget;
        const imgSrc = trigger.getAttribute('data-img');
        modalImage.src = imgSrc;
    });
</script>

@endpush


<style>
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

</style>
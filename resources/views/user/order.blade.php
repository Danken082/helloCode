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

    @if(isset($item->product) && $item->product->productImage)
    <img src="{{ asset('storage/app/public/' . $item->product->productImage) }}"
             alt="Product Image"
             class="preview-img"
             data-bs-toggle="modal"
             data-bs-target="#imageModal"
                    data-img="{{ asset('storage/app/public/' . $item->product->productImage) }}">
@else
<img src="{{ asset('storage/app/public/default.png') }}"
             alt="Product Image"
             class="preview-img"
             data-bs-toggle="modal"
             data-bs-target="#imageModal"
                    data-img="{{ asset('storage/app/public/default.png') }}">
@endif
        </td>
            <td>{{ $item->orderCode }}</td>
            <td>{{ $item->product->productName ?? 'N/A'}}</td>
            <td>{{ $item->product->user->regseller->bussinessName ?? 'N/A'}}</td>    
            <td>{{ $item->quantity ?? 'N/A'}}</td>
            <td>{{ $item->product->productPrice ?? 'N/A'}}</td>
            <td>{{ $item->totalPrice }}</td>
            <td class="status-pending">
              
                @if($item->status === 'claimedByDeliveryPartner')
                <p>Out of Delivery</p>
                <p>Rider Name: <strong style="text-transform:uppercase;">{{ $item->rider->name }}</strong></p>
                @elseif($item->status === 'Completed')
                <p>Delivered</p>
               

                <button type="button"
                class="btn btn-sm btn-success mt-2"
                data-bs-toggle="modal"
                data-bs-target="#reviewModal"
                data-productname="{{ $item->product->productName ?? 'N/A' }}"
                data-productid="{{ $item->product->id }}"
                data-orderid="{{ $item->id }}">
            Leave a Review
        </button>
        @elseif($item->status === 'CompleteWReview')
        <p>Complete</p>
        <p style="color:green;">Thank you for review</p>
                @elseif($item->status === 'Pending')
                
                    <form method="POST" action="{{ route('orders.cancel', $item->id) }}" class="d-inline-block ms-2">
                        @csrf
<span>Pending</span>
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


<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{route('review.product')}}">
            @csrf
            <input type="hidden" name="product_id" id="reviewProductId">
            <input type="hidden" name="order_id" id="reviewOrderId">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Leave a Review for <span id="reviewProductName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Your Review</label>
                        <textarea name="review" id="reviewText" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3"><label for="image" class="form-label">Received Product: </label><input type="file" name="complainImage" class="form-control"accept="image/*"></div>
                    <div class="mb-3">
    <label for="rating" class="form-label">Rating</label>
    <div class="star-rating">
        @for($i = 5; $i >= 1; $i--)
            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
            <label for="star{{ $i }}" title="{{ $i }} stars">&#9733;</label>
        @endfor
    </div>
</div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="color:white;background-color: #0E753F;">Submit Review</button>
                </div>
            </div>
        </form>
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


    const reviewModal = document.getElementById('reviewModal');
    reviewModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const productName = button.getAttribute('data-productname');
        const productId = button.getAttribute('data-productid');
        const orderId = button.getAttribute('data-orderid');

        document.getElementById('reviewProductName').textContent = productName;
        document.getElementById('reviewProductId').value = productId;
        document.getElementById('reviewOrderId').value = orderId;
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
        .star-rating {
            direction: rtl;
            display: inline-flex;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating input[type="radio"]:checked ~ label {
            color: #f5b301;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f5b301;
        }

</style>
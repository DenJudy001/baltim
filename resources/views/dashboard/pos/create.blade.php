@extends('dashboard.layouts.main')

@section('container')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="mb-2">
                <input
                    type="text"
                    class="form-control search"
                    placeholder="Search Product..."
                />
            </div>
            <div class="order-product product-search" style="display: flex;column-gap: 0.5rem;flex-wrap: wrap;row-gap: .5rem;">
                {{-- @foreach($products as $product)
                    <button type="button"
                        class="item"
                        style="cursor: pointer; border: none;"
                        value="{{ $product->id }}"
                    >
                        @if($product->image)
                        <img src="{{ $product->image->getUrl() }}" width="45px" height="45px" alt="test" />
                        @endif
                        <h6 style="margin: 0;">{{ $product->name }}</h6>
                        <span >(${{ $product->price }})</span>
                    </button>
                @endforeach --}}
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="user-cart">
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th class="text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <form action="/pos" method="post">
                @csrf 
                <div class="row mt-2">
                    <div class="col">Total:</div>
                    <div class="col text-right">
                        <input type="number" value="" name="total" readonly class="form-control total">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button
                            type="button"
                            class="btn btn-danger btn-block"
                        >
                            Cancel
                        </button>
                    </div>
                    <div class="col">
                        <button
                            type="submit"
                            class="btn btn-primary btn-block"
                        >
                            Pay
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection
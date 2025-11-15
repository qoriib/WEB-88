@extends('layouts.app')

@section('title', 'Edit Produk - OSS')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-4">Edit Produk</h1>
                    <form action="{{ route('seller.products.update', $product) }}" method="POST">
                        @method('PUT')
                        @include('seller.products._form')
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button class="btn btn-primary" type="submit">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

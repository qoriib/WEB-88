@extends('layouts.app')

@section('title', 'Tambah Produk - OSS')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-4">Tambah Produk Baru</h1>
                    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                        @include('seller.products._form')
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button class="btn btn-primary" type="submit">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

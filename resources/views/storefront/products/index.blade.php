@extends('layouts.app')

@section('title', 'Katalog Produk - OSS')

@section('content')
    <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
        <div>
            <p class="text-uppercase text-primary small mb-1">Katalog OSS</p>
            <h1 class="h3 mb-0">Produk Alat Kesehatan</h1>
            <p class="text-muted mb-0">Telusuri inventori resmi mitra OSS dan lakukan pemesanan secara daring.</p>
        </div>
        <a href="{{ route('register') }}" class="btn btn-outline-primary mt-3 mt-md-0">Daftar untuk membeli</a>
    </div>

    <form class="card shadow-sm border-0 mb-4" method="GET" action="{{ route('products.index') }}">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari produk</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nama atau SKU">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Toko</label>
                    <select name="store" class="form-select">
                        <option value="">Semua toko</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->slug }}" @selected(request('store') === $store->slug)>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-light">Reset</a>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    @if($products->isEmpty())
        <div class="alert alert-info">
            Belum ada produk yang cocok dengan pencarian Anda. Coba kriteria lainnya.
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        @if($product->thumbnail_path)
                            <img src="{{ asset('storage/' . $product->thumbnail_path) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <div class="bg-light text-center py-5">
                                <span class="text-muted small">Belum ada foto</span>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <span class="badge rounded-pill text-bg-light mb-2">{{ $product->store->category->name ?? 'Kategori' }}</span>
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="text-muted small mb-2">SKU: {{ $product->sku }}</p>
                            <p class="fw-bold text-primary fs-5 mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($product->description, 110) }}</p>
                            <div class="mt-3">
                                <p class="small text-muted mb-2">
                                    Toko: <span class="text-dark">{{ $product->store->name }}</span> ({{ $product->store->city }})
                                </p>
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary w-100">Lihat detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
@endsection

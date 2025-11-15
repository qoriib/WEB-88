@extends('layouts.app')

@section('title', $product->name . ' - OSS')

@section('content')
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            &larr; Kembali ke katalog
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <img
                    src="{{ $product->thumbnail_path ? asset('storage/' . $product->thumbnail_path) : 'https://placehold.co/800x500?text=OSS+Product' }}"
                    class="card-img-top"
                    alt="{{ $product->name }}"
                >
                <div class="card-body">
                    <p class="text-muted small mb-0">SKU: {{ $product->sku }}</p>
                    <p class="text-muted small mb-0">Stok tersedia: {{ $product->stock }} unit</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <span class="badge text-bg-light mb-2">{{ $product->store->category->name ?? 'Kategori' }}</span>
                    <h1 class="h3">{{ $product->name }}</h1>
                    <p class="fw-bold text-primary fs-3">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-muted flex-grow-1">{{ $product->description }}</p>
                    <div class="border-top pt-3 mt-3">
                        <h6 class="fw-semibold mb-1">{{ $product->store->name }}</h6>
                        <p class="text-muted small mb-2">{{ $product->store->address }} - {{ $product->store->city }}</p>
                        <p class="text-muted small mb-1">Kontak: {{ $product->store->contact_email ?? '-' }} | {{ $product->store->contact_phone ?? '-' }}</p>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 mt-3">Login / Registrasi untuk memesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->isNotEmpty())
        <div class="mt-5">
            <h2 class="h5 mb-3">Produk lain di {{ $product->store->name }}</h2>
            <div class="row g-3">
                @foreach($relatedProducts as $related)
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold">{{ \Illuminate\Support\Str::limit($related->name, 40) }}</h6>
                                <p class="text-muted small mb-2">Rp{{ number_format($related->price, 0, ',', '.') }}</p>
                                <a href="{{ route('products.show', $related->slug) }}" class="btn btn-outline-primary btn-sm w-100">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

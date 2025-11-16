@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="h4 mb-3">Keranjang Belanja</h1>
        </div>
    </div>

    @if($cart->items->isEmpty())
        <div class="alert alert-info">
            Keranjang Anda kosong. <a href="{{ route('products.index') }}">Lihat katalog produk</a>.
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item->product->thumbnail_path ? asset('storage/' . $item->product->thumbnail_path) : 'https://placehold.co/80x80?text=OSS' }}"
                                                     class="rounded" width="64" height="64" alt="{{ $item->product->name }}">
                                                <div>
                                                    <div class="fw-semibold">{{ $item->product->name }}</div>
                                                    <small class="text-muted">SKU: {{ $item->product->sku ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                        <td style="width: 160px;">
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm">
                                                <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
                                            </form>
                                        </td>
                                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus item ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-2">Ringkasan</h5>
                        <p class="mb-1">Total Item: {{ $cart->total_items }}</p>
                        <p class="mb-3">Subtotal: <strong>Rp{{ number_format($cart->total_amount, 0, ',', '.') }}</strong></p>
                        <a href="{{ route('checkout.create') }}" class="btn btn-primary w-100">Lanjut Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

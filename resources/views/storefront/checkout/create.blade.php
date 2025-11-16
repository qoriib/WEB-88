@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h4">Checkout</h1>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Alamat Pengiriman</h5>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                   value="{{ old('city', auth()->user()->city) }}" required>
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="shipping_address" rows="2" class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="prepaid" @selected(old('payment_method') === 'prepaid')>Prepaid (transfer/VA)</option>
                                <option value="cod" @selected(old('payment_method') === 'cod')>COD (kota sama)</option>
                            </select>
                            @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" rows="2" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Buat Order</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Ringkasan</h5>
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($cart->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $item->product->name }}</div>
                                    <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                </div>
                                <div>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</div>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mb-1">Subtotal: <strong>Rp{{ number_format($cart->total_amount, 0, ',', '.') }}</strong></p>
                    <p class="mb-1">Biaya kirim (flat): <strong>Rp25.000</strong></p>
                    <p class="mb-0">Total: <strong>Rp{{ number_format($cart->total_amount + 25000, 0, ',', '.') }}</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection

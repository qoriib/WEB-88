@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran - OSS')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="h4 mb-3">Bukti Pembayaran</h1>
                    <p class="text-muted mb-1">Order #: {{ $order->order_number }}</p>
                    <p class="text-muted mb-3">Total Tagihan: <strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                    <div class="alert alert-secondary">
                        <p class="mb-1 fw-semibold">Rekening Pembayaran Toko</p>
                        <p class="mb-0">
                            {{ $order->store->bank_name ?? 'Bank tidak tersedia' }}<br>
                            a.n {{ $order->store->bank_account_name ?? '-' }}<br>
                            {{ $order->store->bank_account_number ?? '-' }}
                        </p>
                    </div>
                    <p class="mb-0">Silakan transfer sesuai instruksi dan unggah bukti pembayaran agar pemilik toko dapat melakukan verifikasi.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('orders.payment.store', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Unggah Bukti Transfer</label>
                            <input type="file" name="payment_proof" class="form-control @error('payment_proof') is-invalid @enderror" required>
                            <small class="text-muted">Format diterima: JPG, PNG, PDF (maks. 4MB)</small>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan untuk penjual (opsional)</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $payment->meta['customer_note'] ?? '') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($payment->proof_path)
                            <div class="mb-3">
                                <p class="text-muted mb-2">Bukti sebelumnya:</p>
                                <a href="{{ asset('storage/' . $payment->proof_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm">Lihat bukti</a>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

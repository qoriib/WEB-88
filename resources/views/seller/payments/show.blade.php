@extends('layouts.app')

@section('title', 'Detail Pembayaran - ' . $payment->order->order_number)

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-1">Pembayaran Order {{ $payment->order->order_number }}</h1>
                <p class="text-muted mb-0">Dari: {{ $payment->order->user->name }}</p>
            </div>
            <a href="{{ route('seller.payments.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Detail Pembayaran</h2>
                    <p class="mb-1">Jumlah: <strong>Rp{{ number_format($payment->amount, 0, ',', '.') }}</strong></p>
                    <p class="mb-1">Status: <span class="badge text-bg-{{ $payment->status === 'confirmed' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">{{ ucfirst($payment->status) }}</span></p>
                    @if($payment->verification_note)
                        <p class="mb-1">Catatan Verifikasi: {{ $payment->verification_note }}</p>
                    @endif
                    @if($payment->meta['customer_note'] ?? false)
                        <p class="mb-0 text-muted">Catatan pelanggan: {{ $payment->meta['customer_note'] }}</p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">Bukti Transfer</h2>
                    @if($payment->proof_path)
                        @if(\Illuminate\Support\Str::endsWith($payment->proof_path, ['.pdf']))
                            <a href="{{ asset('storage/' . $payment->proof_path) }}" target="_blank" class="btn btn-outline-primary">Lihat Bukti (PDF)</a>
                        @else
                            <img src="{{ asset('storage/' . $payment->proof_path) }}" alt="Bukti pembayaran" class="img-fluid rounded">
                        @endif
                    @else
                        <p class="text-muted mb-0">Belum ada bukti pembayaran diunggah.</p>
                    @endif
                </div>
            </div>
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 mb-1">Laporan PDF</h2>
                        <p class="text-muted small mb-0">Unduh ringkasan order untuk arsip.</p>
                    </div>
                    <a href="{{ route('seller.orders.report', $payment->order) }}" class="btn btn-outline-primary btn-sm">Unduh PDF</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 mb-3">Aksi Verifikasi</h2>
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    @if($payment->status === 'pending')
                        <form action="{{ route('seller.payments.approve', $payment) }}" method="POST" class="mb-3">
                            @csrf @method('PATCH')
                            <div class="mb-2">
                                <label class="form-label">Catatan (opsional)</label>
                                <textarea name="verification_note" class="form-control" rows="2"></textarea>
                            </div>
                            <button class="btn btn-success w-100" type="submit">Setujui Pembayaran</button>
                        </form>
                        <form action="{{ route('seller.payments.reject', $payment) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="mb-2">
                                <label class="form-label">Alasan penolakan</label>
                                <textarea name="verification_note" class="form-control @error('verification_note') is-invalid @enderror" rows="2" required></textarea>
                                @error('verification_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-outline-danger w-100" type="submit">Tolak Pembayaran</button>
                        </form>
                    @else
                        <p class="text-muted mb-2">Pembayaran sudah berstatus {{ $payment->status }}.</p>
                        <p class="small mb-0">Diverifikasi oleh: {{ $payment->verifiedBy->name ?? '-' }} pada {{ optional($payment->verified_at)->format('d M Y H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

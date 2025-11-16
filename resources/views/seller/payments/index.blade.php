@extends('layouts.app')

@section('title', 'Pembayaran Masuk - OSS')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1">Pembayaran Pelanggan</h1>
            <p class="text-muted mb-0">Kelola bukti transfer yang masuk untuk toko Anda.</p>
        </div>
        <div class="d-flex gap-2">
            <form class="d-flex gap-2" method="GET">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua status</option>
                    <option value="pending" @selected(($filters['status'] ?? '') === 'pending')>Pending</option>
                    <option value="confirmed" @selected(($filters['status'] ?? '') === 'confirmed')>Dikonfirmasi</option>
                    <option value="failed" @selected(($filters['status'] ?? '') === 'failed')>Ditolak</option>
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
            <a href="{{ route('seller.reports.payments') }}" class="btn btn-outline-secondary btn-sm">Export PDF</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->order->order_number }}</td>
                            <td>{{ $payment->order->user->name }}</td>
                            <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge text-bg-{{ $payment->status === 'confirmed' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->updated_at->format('d M Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('seller.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                            <td class="text-end">
                                @if($loop->first)
                                    <a href="{{ route('seller.reports.payments') }}" class="btn btn-sm btn-outline-secondary">Export PDF</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $payments->links() }}
        </div>
    </div>
@endsection

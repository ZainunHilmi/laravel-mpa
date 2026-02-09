@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laporan Penjualan</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Laporan</a></div>
                    <div class="breadcrumb-item">Penjualan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <h2 class="section-title">Daftar Transaksi</h2>
                <p class="section-lead">
                    Lihat dan filter transaksi berdasarkan tanggal.
                </p>

                <!-- Filter Card -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Filter Tanggal</h4>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.order.index') }}">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="start_date">Mulai Tanggal</label>
                                                <input type="date" 
                                                       class="form-control" 
                                                       id="start_date" 
                                                       name="start_date" 
                                                       value="{{ $startDate ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="end_date">Sampai Tanggal</label>
                                                <input type="date" 
                                                       class="form-control" 
                                                       id="end_date" 
                                                       name="end_date" 
                                                       value="{{ $endDate ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-filter"></i> Filter
                                                    </button>
                                                    <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">
                                                        <i class="fas fa-undo"></i> Reset
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="far fa-money-bill-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Pendapatan</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-chart-bar"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Transaksi</h4>
                                </div>
                                <div class="card-body">
                                    {{ $orders->total() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Transaksi</h4>
                                @if($startDate && $endDate)
                                    <div class="card-header-action">
                                        <span class="badge badge-info">
                                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">No</th>
                                                <th>Nama Kasir</th>
                                                <th>Total Harga</th>
                                                <th>Total Item</th>
                                                <th>Tanggal Transaksi</th>
                                                <th class="text-center" style="width: 100px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $index => $order)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm bg-primary text-white mr-2">
                                                                {{ strtoupper(substr($order->kasir->name, 0, 1)) }}
                                                            </div>
                                                            {{ $order->kasir->name }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold text-success">
                                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ $order->total_item }} item
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($order->transaction_time)->format('d M Y H:i') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.order.show', $order->id) }}" 
                                                           class="btn btn-info btn-sm"
                                                           data-toggle="tooltip" 
                                                           title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <div class="empty-state">
                                                            <div class="empty-state-icon">
                                                                <i class="fas fa-inbox"></i>
                                                            </div>
                                                            <h2>Tidak ada data transaksi</h2>
                                                            <p class="lead">
                                                                Tidak ditemukan transaksi pada periode yang dipilih.
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="float-right mt-3">
                                    {{ $orders->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Set max date to today for both inputs
            var today = new Date().toISOString().split('T')[0];
            $('#start_date').attr('max', today);
            $('#end_date').attr('max', today);
            
            // Validate date range
            $('#start_date, #end_date').on('change', function() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                
                if (startDate && endDate && startDate > endDate) {
                    alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
                    $(this).val('');
                }
            });
        });
    </script>
@endpush
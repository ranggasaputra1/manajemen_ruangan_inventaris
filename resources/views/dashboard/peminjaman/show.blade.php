@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="page-inner">
            <!-- Message Alert -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="auto-hide-alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- End Message Alert -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Detail Peminjaman</h4>
                                <a class="btn btn-secondary btn-round ms-auto" href="{{ route('peminjaman.index') }}">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Peminjaman</label>
                                            <input type="text" class="form-control"
                                                value="{{ $peminjaman->tgl_peminjaman }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Pengembalian</label>
                                            <input type="text" class="form-control"
                                                value="{{ $peminjaman->tgl_pengembalian }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Peminjam</label>
                                    <input type="text" class="form-control" value="{{ $peminjaman->nama_peminjam }}"
                                        readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Barang yang Dipinjam</label>
                                    <ul class="list-group list-group-flush">
                                        @if ($peminjaman->kode_barang)
                                            @foreach (json_decode($peminjaman->kode_barang) as $barangId)
                                                <li class="list-group-item">
                                                    {{ \App\Models\DataBarang::find($barangId)->nama_barang ?? 'Data Barang tidak ditemukan' }}
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">-</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ruangan</label>
                                    <ul class="list-group list-group-flush">
                                        @if ($peminjaman->kode_ruangan)
                                            @foreach (json_decode($peminjaman->kode_ruangan) as $ruanganId)
                                                <li class="list-group-item">
                                                    {{ \App\Models\DataRuangan::find($ruanganId)->nama_ruangan ?? 'Data Ruangan tidak ditemukan' }}
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">-</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Jumlah</label>
                                            <input type="text" class="form-control" value="{{ $peminjaman->jumlah }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Status</label>
                                            <input type="text" class="form-control" value="{{ $peminjaman->status }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript for auto-hide alert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.getElementById('auto-hide-alert');
            if (alert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            }
        });
    </script>
@endsection

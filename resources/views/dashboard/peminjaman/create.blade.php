@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Peminjaman</h4>
                            @if ($errors->any())
                                <br>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                    id="auto-hide-alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action="{{ route('peminjaman.store') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="tgl_peminjaman">Tanggal Peminjaman</label>
                                    <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control"
                                        value="{{ old('tgl_peminjaman') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tgl_pengembalian">Tanggal Pengembalian</label>
                                    <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control"
                                        value="{{ old('tgl_pengembalian') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nama_peminjam">Nama Peminjam</label>
                                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control"
                                        value="{{ old('nama_peminjam') }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jenis_peminjaman">Jenis Peminjaman</label>
                                    <select name="jenis_peminjaman" id="jenis_peminjaman" class="form-select" required>
                                        <option value="">Pilih Jenis Peminjaman</option>
                                        <option value="barang">Barang</option>
                                        <option value="ruangan">Ruangan</option>
                                        <option value="barang_ruangan">Barang & Ruangan</option>
                                    </select>
                                </div>

                                <!-- Pilihan Barang (Multiple) -->
                                <div class="form-group mb-3" id="barang_section" style="display: none;">
                                    <label for="kode_barang">Kode Barang</label>
                                    <select name="kode_barang[]" id="kode_barang" class="form-select" multiple>
                                        @foreach ($dataBarangs as $barang)
                                            <option value="{{ $barang->id }}">
                                                {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Tekan CTRL (Windows) / CMD (Mac) untuk memilih lebih dari
                                        satu.</small>
                                </div>

                                <div class="form-group mb-3" id="ruangan_section" style="display: none;">
                                    <label for="kode_ruangan">Kode Ruangan</label>
                                    <select name="kode_ruangan[]" id="kode_ruangan" class="form-select" multiple>
                                        @foreach ($dataRuangan as $ruangan)
                                            <option value="{{ $ruangan->id }}">
                                                {{ $ruangan->kode_ruangan }} - {{ $ruangan->nama_ruangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Tekan CTRL (Windows) / CMD (Mac) untuk memilih lebih dari
                                        satu.</small>
                                </div>



                                <!-- Input Jumlah Barang -->
                                <div class="form-group mb-3" id="jumlah_section">
                                    <label for="jumlah">Jumlah Barang yang Dipinjam</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                                        value="{{ old('jumlah') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <input type="text" name="status" id="status" class="form-control"
                                        value="Dipinjam" readonly required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.getElementById('auto-hide-alert');
            if (alert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            }

            var jenisPeminjaman = document.getElementById('jenis_peminjaman');
            var barangSection = document.getElementById('barang_section');
            var ruanganSection = document.getElementById('ruangan_section');
            var jumlahSection = document.getElementById('jumlah_section');
            var kodeBarang = document.getElementById('kode_barang');
            var kodeRuangan = document.getElementById('kode_ruangan');
            var jumlahInput = document.getElementById('jumlah');

            jenisPeminjaman.addEventListener('change', function() {
                if (this.value === 'barang') {
                    barangSection.style.display = 'block';
                    ruanganSection.style.display = 'none';
                    jumlahSection.style.display = 'block';
                    kodeRuangan.value = '';
                    jumlahInput.required = true;
                } else if (this.value === 'ruangan') {
                    barangSection.style.display = 'none';
                    ruanganSection.style.display = 'block';
                    jumlahSection.style.display = 'none';
                    kodeBarang.value = '';
                    jumlahInput.required = false;
                } else if (this.value === 'barang_ruangan') {
                    barangSection.style.display = 'block';
                    ruanganSection.style.display = 'block';
                    jumlahSection.style.display = 'block';
                    jumlahInput.required = true;
                } else {
                    barangSection.style.display = 'none';
                    ruanganSection.style.display = 'none';
                    jumlahSection.style.display = 'none';
                    kodeBarang.value = '';
                    kodeRuangan.value = '';
                    jumlahInput.required = false;
                }
            });
        });
    </script>
@endsection

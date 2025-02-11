@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Peminjaman</h4>
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
                            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label for="tgl_peminjaman">Tanggal Peminjaman</label>
                                    <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control"
                                        value="{{ $peminjaman->tgl_peminjaman }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tgl_pengembalian">Tanggal Pengembalian</label>
                                    <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control"
                                        value="{{ $peminjaman->tgl_pengembalian }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nama_peminjam">Nama Peminjam</label>
                                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control"
                                        value="{{ $peminjaman->nama_peminjam }}" required>
                                </div>

                                @php
                                    $selectedJenis = $peminjaman->jenis_peminjaman;
                                    $selectedBarang = json_decode($peminjaman->kode_barang, true) ?? [];
                                    $selectedRuangan = json_decode($peminjaman->kode_ruangan, true) ?? [];
                                @endphp

                                <div class="form-group mb-3">
                                    <label for="jenis_peminjaman">Jenis Peminjaman</label>
                                    <select name="jenis_peminjaman" id="jenis_peminjaman" class="form-select" required>
                                        <option value="">Pilih Jenis Peminjaman</option>
                                        <option value="barang" {{ $selectedJenis == 'barang' ? 'selected' : '' }}>Barang
                                        </option>
                                        <option value="ruangan" {{ $selectedJenis == 'ruangan' ? 'selected' : '' }}>Ruangan
                                        </option>
                                        <option value="barang_ruangan"
                                            {{ $selectedJenis == 'barang_ruangan' ? 'selected' : '' }}>Barang & Ruangan
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group mb-3" id="barang_section">
                                    <label for="kode_barang">Kode Barang</label>
                                    <select name="kode_barang[]" id="kode_barang" class="form-select" multiple>
                                        @foreach ($dataBarangs as $barang)
                                            <option value="{{ $barang->id }}"
                                                {{ in_array($barang->id, $selectedBarang) ? 'selected' : '' }}>
                                                {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3" id="ruangan_section">
                                    <label for="kode_ruangan">Kode Ruangan</label>
                                    <select name="kode_ruangan[]" id="kode_ruangan" class="form-select" multiple>
                                        @foreach ($dataRuangan as $ruangan)
                                            <option value="{{ $ruangan->id }}"
                                                {{ in_array($ruangan->id, $selectedRuangan) ? 'selected' : '' }}>
                                                {{ $ruangan->kode_ruangan }} - {{ $ruangan->nama_ruangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3" id="jumlah_section">
                                    <label for="jumlah">Jumlah Barang yang Dipinjam</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                                        value="{{ $peminjaman->jumlah }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="Dipinjam"
                                            {{ $peminjaman->status === 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="Dikembalikan"
                                            {{ $peminjaman->status === 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
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
            var jumlahInput = document.getElementById('jumlah');

            function toggleSections() {
                var value = jenisPeminjaman.value;
                barangSection.style.display = (value === 'barang' || value === 'barang_ruangan') ? 'block' : 'none';
                ruanganSection.style.display = (value === 'ruangan' || value === 'barang_ruangan') ? 'block' : 'none';
                jumlahSection.style.display = (value !== 'ruangan') ? 'block' : 'none';

                // Hapus atau tambahkan required pada jumlah
                if (value === 'ruangan') {
                    jumlahInput.removeAttribute('required');
                } else {
                    jumlahInput.setAttribute('required', 'required');
                }
            }

            // Tunggu beberapa milidetik agar nilai dropdown terpilih dengan benar
            setTimeout(function() {
                toggleSections();
            }, 100);

            jenisPeminjaman.addEventListener('change', toggleSections);
        };
    </script>
@endsection

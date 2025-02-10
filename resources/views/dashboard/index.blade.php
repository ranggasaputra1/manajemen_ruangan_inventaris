@extends('dashboard.layouts.main')

@section('container')
    {{-- Main --}}
    <div class="page-inner"> <br><br><br>
        <!-- Welcome Message -->
        <div class="dashboard-welcome">
            <h1 class="welcome-text">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="welcome-subtext">Diskominfo Jawa Barat</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <a href="ruangan">
                            <h5 class="card-title">Tambah Data Ruangan</h5>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <a href="barang">
                            <h5 class="card-title">Tambah Data Barang</h5>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <a href="pengadaan">
                            <h5 class="card-title">Tambah Data Pengadaan</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profil Diskominfo Jawa Barat -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Profil Diskominfo Jawa Barat</h5>
            </div>
            <div class="card-body">
                <h6><strong>Visi</strong></h6>
                <p>Terwujudnya Jawa Barat Juara Lahir Batin Dengan Inovasi dan Kolaborasi</p>

                <h6><strong>Misi</strong></h6>
                <ul>
                    <li>Membentuk Manusia Pancasila yang Bertaqwa.</li>
                    <li>Melahirkan manusia yang berbudaya, berkualitas, bahagia dan produktif.</li>
                    <li>Mempercepat pertumbuhan dan pemerataan pembangunan berbasis lingkungan dan tata ruang yang
                        berkelanjutan.</li>
                    <li>
                        Meningkatkan produktivitas dan daya saing ekonomi umat yang sejahtera dan adil.</li>
                    <li>Mewujudkan tata kelola pemerintahan yang inovatif dan kepemimpinan yang kolaboratif antara
                        pemerintahan pusat, provinsi, dan kabupaten/kota</li>
                </ul>

                <h6><strong>Tugas dan Fungsi</strong></h6>
                <p>Diskominfo Jawa Barat bertanggung jawab dalam menyelenggarakan layanan komunikasi publik, pengelolaan
                    informasi pemerintahan, serta pembangunan dan pemeliharaan infrastruktur teknologi informasi untuk
                    mendukung e-Government.</p>

                <h6><strong>Sejarah</strong></h6>
                <p>Diskominfo Jawa Barat didirikan dengan tujuan untuk mengintegrasikan teknologi informasi dalam setiap
                    aspek pemerintahan dan pelayanan publik di Provinsi Jawa Barat. Sejak dibentuk, Diskominfo telah
                    mengimplementasikan berbagai inovasi digital untuk mendukung berbagai program pemerintah daerah dalam
                    memberikan pelayanan terbaik kepada masyarakat.</p>

                <h6><strong>Peran Diskominfo</strong></h6>
                <p>Diskominfo berperan sebagai fasilitator komunikasi antara Pemerintah Provinsi Jawa Barat dan masyarakat,
                    serta sebagai pengelola informasi yang penting dalam memastikan akses informasi yang cepat, tepat, dan
                    akurat. Selain itu, Diskominfo juga menjadi pionir dalam penerapan teknologi informasi untuk
                    meningkatkan efisiensi dan efektivitas kerja pemerintahan di seluruh Jawa Barat.</p>


            </div>
        </div>
    </div>
    {{-- End Main --}}
@endsection

@extends('layouts.main')

@section('container')

<div class="container my-5">
    <div class="card-header text-dark my-4 align-items-center">
      <h2 class="mb-0">Tutorial</h2>
    </div>

  <div class="card shadow-sm">
    <div class="card-body mx-4">

      <h5 class="mt-4">Daftar Isi</h5>
      <ul class="list-group list-group-flush mb-4 col-lg-6">
        <li class="list-group-item"><a href="#cara-registrasi">Cara Registrasi</a></li>
        <li class="list-group-item"><a href="#mendaftar-turnamen">Mendaftar Turnamen</a></li>
        <li class="list-group-item"><a href="#membuat-turnamen">Membuat Turnamen</a></li>
        <li class="list-group-item"><a href="#membuat-postingan">Membuat Postingan</a></li>
        <li class="list-group-item"><a href="#mengelola-bagan">Mengelola Bagan Pertandingan</a></li>
        <li class="list-group-item"><a href="#mengelola-peserta">Mengelola Peserta Turnamen</a></li>
        <li class="list-group-item"><a href="#membuat-bagan-otomatis">Membuat Bagan Pertandingan</a></li>
        <li class="list-group-item"><a href="#mengedit-profile">Mengedit Profile</a></li>
      </ul>

      {{-- Section Cara Registrasi --}}
        <h5 id="cara-registrasi" class="text-primary mt-5">
        <a class="text-decoration-none d-flex align-items-center"
            data-bs-toggle="collapse"
            href="#collapseCaraRegistrasi"
            role="button"
            aria-expanded="false"
            aria-controls="collapseCaraRegistrasi">
            Cara Registrasi
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
        <div class="collapse" id="collapseCaraRegistrasi">
            <ol class="mb-4">
                <li>Klik tombol <strong>Login</strong> di pojok kanan atas jika menggunakan desktop. Pada perangkat mobile, klik ikon tiga garis, lalu klik Login.</li>
                <br> <img src="{{ asset('storage/tutorial/login tree line.png') }}" alt="Login Tree Line" class="img-fluid rounded mb-3 shadow p-3 mb-5 bg-body rounded">
                <li>Klik <strong>Daftar sekarang</strong> di bawah tombol login.</li>
                <li>Pilih apakah Anda ingin mendaftar sebagai Panitia atau Peserta.</li>
                <li>Isi semua form pendaftaran lalu klik Daftar.</li>
                <li>Setelah berhasil daftar, Anda bisa login menggunakan akun yang sudah dibuat.</li>
            </ol>
        </div>


      {{-- Section Mendaftar Turnamen --}}
        <h5 id="mendaftar-turnamen" class="text-primary mt-5">
        <a class="text-decoration-none d-flex align-items-center"
            data-bs-toggle="collapse"
            href="#collapseMendaftarTurnamen"
            role="button"
            aria-expanded="false"
            aria-controls="collapseMendaftarTurnamen">
            Mendaftar Turnamen
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
      <div class="collapse" id="collapseMendaftarTurnamen">
        <ol class="mb-4">
          <li>Cari turnamen yang ingin Anda ikuti di halaman Turnamen.</li>
          <li>Klik <strong>Lihat Selengkapnya</strong> untuk melihat detail turnamen.</li>
          <li>Pada halaman detail turnamen, Anda akan melihat tombol untuk mendaftar turnamen jika masih dalam batas waktu pendaftaran.</li>
          <li>Anda juga bisa melihat detail bagan pertandingan jika turnamen sudah dimulai oleh Panitia.</li>
        </ol>
      </div>

      {{-- Section Membuat Turnamen --}}
        <h5 id="membuat-turnamen" class="text-primary mt-5">
        <a class="text-decoration-none d-flex align-items-center"
            data-bs-toggle="collapse"
            href="#collapseMembuatTurnamen"
            role="button"
            aria-expanded="false"
            aria-controls="collapseMembuatTurnamen">
            Membuat Turnamen
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
      <div class="collapse" id="collapseMembuatTurnamen">
        <ol class="mb-4">
          <li>Anda akan langsung diarahkan ke halaman Dashboard jika login sebagai Panitia.</li>
          <li>Di Dashboard, klik menu <strong>Turnamen</strong> di sisi kiri. Pada perangkat mobile, klik ikon tiga garis, lalu pilih <strong>Turnamen</strong>.</li>
          <br> <img src="{{ asset('storage/tutorial/membuat tour tree line.png') }}" alt="Login Tree Line" class="img-fluid rounded mb-3 shadow p-3 mb-5 bg-body rounded">
          <li>Klik <strong>Buat Turnamen Baru</strong>.</li>
          <li>Isi form sesuai rencana Anda. Slug akan terisi otomatis mengikuti judul turnamen, namun Anda tetap bisa mengubahnya selama belum digunakan turnamen lain. Klik <strong>Lanjut</strong> setelah semua terisi.</li>
          <li>Di halaman berikutnya, Anda akan diminta mengisi detail turnamen lagi.</li>
          <li>Klik <strong>Buat Bagan</strong> dan turnamen Anda sudah berhasil dibuat.</li>
          <br> <strong>Catatan : </strong> Jika Anda ingin orang mendaftar, Anda perlu membuat post agar orang dapat melihat turnamen yang Anda buat. Jangan lupa memulai turnamen Anda jika sudah waktunya, dengan memulai bagan pertandingan.
        </ol>
      </div>

      {{-- Section Membuat Postingan --}}
        <h5 id="membuat-postingan" class="text-primary mt-5">
        <a class="text-decoration-none d-flex align-items-center"
            data-bs-toggle="collapse"
            href="#collapseMembuatPostingan"
            role="button"
            aria-expanded="false"
            aria-controls="collapseMembuatPostingan">
            Membuat Postingan
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
      <div class="collapse" id="collapseMembuatPostingan">
        <ol class="mb-4">
          <li>Pastikan Anda sudah memiliki Turnamen yang akan diposting.</li>
          <br> <img src="{{ asset('storage/tutorial/membuat post page turnamen.png') }}" alt="Login Tree Line" class="img-fluid rounded mb-3 shadow p-3 mb-5 bg-body rounded">
          <li>Di Dashboard, klik menu <strong>Postingan</strong>.</li>
          <li>Klik <strong>Buat Post Baru</strong>.</li>
          <li>Isi deskripsi dan unggah gambar atau poster turnamen Anda.</li>
          <li>Klik <strong>Buat Post</strong>. Postingan turnamen Anda akan tampil di halaman depan.</li>
        </ol>
      </div>

      
      {{-- Section Mengelola Bagan --}}
        <h5 id="mengelola-bagan" class="text-primary mt-5">
        <a class="text-decoration-none d-flex align-items-center"
            data-bs-toggle="collapse"
            href="#collapseMengelolaBagan"
            role="button"
            aria-expanded="false"
            aria-controls="collapseMengelolaBagan">
            Mengelola Bagan Pertandingan
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
      <div class="collapse" id="collapseMengelolaBagan">
        <ol class="mb-4">
          <li>Setiap turnamen memiliki satu bagan pertandingan yang dapat dikelola.</li>
          <li>Klik menu <strong>Bagan Pertandingan</strong> di Dashboard, lalu pilih turnamen yang ingin Anda atur.</li>
          <li>Di halaman ini, Anda dapat mengubah kategori turnamen, mengelola peserta, dan membuat bagan secara otomatis.</li>
        </ol>
      </div>

            {{-- Section Mengelola Peserta --}}
        <h5 id="mengelola-peserta" class="text-primary mt-5">
        <a class="text-decoration-none d-flex align-items-center"
            data-bs-toggle="collapse"
            href="#collapseMengelolaPeserta"
            role="button"
            aria-expanded="false"
            aria-controls="collapseMengelolaPeserta">
            Mengelola Peserta Turnamen
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
      <div class="collapse" id="collapseMengelolaPeserta">
        <ol class="mb-4">
          <li>Klik <strong>Bagan Pertandingan</strong> di Dashboard, lalu pilih turnamen yang ingin Anda atur dengan tekan tombol <strong>Kelola</strong>.</li>
          <li>Pilih menu <strong>Peserta</strong> di sisi kiri (desktop). Pada perangkat mobile, klik ikon tiga garis, lalu pilih <strong>Peserta</strong>.</li>
          <li>Halaman akan menampilkan daftar user yang sudah menjadi peserta.</li>
          <li>Anda juga bisa menambah peserta secara manual untuk kepentingan pengujian aplikasi dengan mengisi bagian pencarian, lalu tambahkan user dengan klik tombol <strong>Tambah</strong>.</li>
          <li>Anda dapat mengatur peserta yang menjadi seed dengan klik <strong>Edit Seed</strong> dan mengisi urutan seed pada peserta yang Anda inginkan.</li>
        </ol>
      </div>

            {{-- Section Membuat Bagan Otomatis --}}
        <h5 id="membuat-bagan-otomatis" class="text-primary mt-5">
        <a class="text-decoration-none d-flex  align-items-center"
            data-bs-toggle="collapse"
            href="#collapseMembuatBaganOtomatis"
            role="button"
            aria-expanded="false"
            aria-controls="collapseMembuatBaganOtomatis">
            Membuat Bagan Pertandingan
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
      <div class="collapse" id="collapseMembuatBaganOtomatis">
        <ol>
          <li>Klik menu <strong>Bagan Pertandingan</strong> di Dashboard, lalu pilih turnamen yang ingin Anda atur.</li>
          <li>Pilih menu <strong>Tree / Bagan</strong> di sisi kiri (desktop). Pada mobile, klik ikon tiga garis, lalu pilih <strong>Tree / Bagan</strong>.</li>
          <li>Pastikan turnamen sudah memiliki peserta dengan mengeceknya di halaman <strong>Peserta</strong>.</li>
          <li>Klik <strong>Generate Tree</strong> untuk membuat bagan otomatis.</li>
          <li>Anda dapat mengisi skor pertandingan di sebelah nama peserta. Masukkan skor kedua peserta agar pemenang otomatis lanjut ke babak berikutnya.</li>
          <br> <img src="{{ asset('storage/tutorial/skor.png') }}" alt="Login Tree Line" class="img-fluid rounded mb-3 shadow p-3 mb-5 bg-body rounded">
          <li>Klik <strong>Update Tree</strong> untuk menyimpan skor.</li>
          <br>  <strong>Catatan:</strong> Anda tidak dapat mengedit skor yang sudah tersimpan. Jika ingin mengulang, klik <strong>Generate Tree</strong> lagi. Seluruh turnamen akan di-reset dan peserta akan teracak ulang. Penempatan seed dan bye tetap sesuai aturan PBSI.
        </ol>
      </div>

      {{-- Section Mengedit Profile --}}
        <h5 id="mengedit-profile" class="text-primary mt-5">
        <a class="text-decoration-none d-flex  align-items-center"
            data-bs-toggle="collapse"
            href="#collapseMengeditProfile"
            role="button"
            aria-expanded="false"
            aria-controls="collapseMengeditProfile">
            Mengedit Profile
            <span class="collapse-icon mx-3">
            <i class="bi bi-chevron-down"></i>
            </span>
        </a>
        </h5>
      <div class="collapse" id="collapseMengeditProfile">
        <ol>
          <li>Klik <strong>Gambar / Nama</strong> di pojok kanan atas jika kalian menggunakan desktop, atau klik dahulu tiga baris di pojok kanan atas lalu klik <strong>Gambar / Nama</strong> </li>
          <li>Pilih menu <strong>Profile</strong> dan kalian akan dibawa ke detail profile</li>
          <li>Klik edit profile jika ingin melakukan perubahan, termasuk ingin menambah foto profile <strong>Peserta</strong>.</li>
          <li>Isi sesuai keinginan anda lalu klik <strong>Simpan Perubahan</strong> </li>
        </ol>
      </div>

    </div>
  </div>

</div>
@endsection

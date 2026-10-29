<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');

// Uji kesalahan: lima kasus dalam satu halaman, masing-masing dibungkus try/catch

class Mahasiswa {
    public function __construct(
        public string $nim,
        public string $nama,
        public int $semester = 1
    ) {}
}

class MahasiswaDinamis {
    private array $atributTambahan = [];
    public function __construct(public string $nim, public string $nama) {}
    public function __set(string $key, mixed $value): void {
        $diizinkan = ['hobi', 'asalSekolah', 'agama'];
        if (!in_array($key, $diizinkan, true)) {
            throw new InvalidArgumentException('Atribut tidak diizinkan: ' . $key);
        }
        $this->atributTambahan[$key] = $value;
    }
}

class LaporanMahasiswa {
    public function __construct(private string $nama) {}
    public function __call(string $method, array $args): mixed {
        if ($method === 'cetakRingkas' && count($args) === 0) {
            return 'Mahasiswa: ' . $this->nama;
        }
        throw new BadMethodCallException('Method tidak tersedia: ' . $method);
    }
}

class DemoSiklus {
    public function __construct(private string $nama) {}
    public function __destruct() {
        echo "&nbsp;&nbsp;Destructor berjalan ({$this->nama})<br>";
    }
}

function aman(string $teks): string {
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}

function uji(string $judul, callable $kode): void {
    echo "<h3>" . aman($judul) . "</h3>";
    try {
        $kode();
    } catch (Throwable $e) {
        echo "&nbsp;&nbsp;" . aman(get_class($e)) . ": " . aman($e->getMessage()) . "<br>";
    }
}

uji('Kasus 1: jumlah parameter constructor salah', function () {
    $m = new Mahasiswa('231001');                 // parameter nama tidak diberikan
    echo "Tidak ada error<br>";
});

uji('Kasus 2: tipe parameter salah (strict_types)', function () {
    $m = new Mahasiswa('231001', 'Alya', 'empat'); // semester harus int
    echo "Tidak ada error<br>";
});

uji('Kasus 3: atribut dinamis tidak diizinkan', function () {
    $m = new MahasiswaDinamis('231001', 'Alya');
    $m->alamat = 'Sukabumi';                       // tidak ada di daftar yang diizinkan
    echo "Tidak ada error<br>";
});

uji('Kasus 4: method tidak dikenali oleh __call()', function () {
    $laporan = new LaporanMahasiswa('Alya');
    echo $laporan->cetakLengkap();                 // bukan cetakRingkas
});

uji('Kasus 5: unset satu referensi, masih ada alias', function () {
    $obj = new DemoSiklus('uji alias');
    $alias = $obj;
    unset($obj);
    echo "&nbsp;&nbsp;unset(\$obj) dijalankan. Destructor belum berjalan karena masih ada \$alias.<br>";
    unset($alias);
    echo "&nbsp;&nbsp;unset(\$alias) dijalankan.<br>";
});
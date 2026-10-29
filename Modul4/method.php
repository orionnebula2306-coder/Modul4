<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');

// Percobaan D + Latihan 5: overloading method dengan __call()
class LaporanMahasiswa {
    public function __construct(private string $nama) {}

    public function __call(string $method, array $args): mixed {
        if ($method === 'cetakRingkas' && count($args) === 0) {
            return 'Mahasiswa: ' . $this->nama;
        }
        throw new BadMethodCallException('Method tidak tersedia: ' . $method);
    }
}

// Pembanding: method public biasa yang dideklarasikan eksplisit
class LaporanBiasa {
    public function __construct(private string $nama) {}

    public function cetakRingkas(): string {
        return 'Mahasiswa: ' . $this->nama;
    }
}

function aman(string $teks): string {
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}

$laporan = new LaporanMahasiswa('Akbar jampang');
$biasa   = new LaporanBiasa('Akbar Nyalindung');

echo "<h3>1. cetakRingkas() lewat __call()</h3>";
echo aman($laporan->cetakRingkas()) . "<br>";

echo "<h3>2. cetakRingkas() sebagai method public biasa</h3>";
echo aman($biasa->cetakRingkas()) . "<br>";

echo "<h3>3. Method lain yang tidak diizinkan</h3>";
try {
    echo $laporan->cetakLengkap();
} catch (BadMethodCallException $e) {
    echo get_class($e) . ": " . aman($e->getMessage()) . "<br>";
}

echo "<h3>4. Nama benar tetapi memakai argumen</h3>";
try {
    echo $laporan->cetakRingkas('tambahan');
} catch (BadMethodCallException $e) {
    echo get_class($e) . ": " . aman($e->getMessage()) . "<br>";
}
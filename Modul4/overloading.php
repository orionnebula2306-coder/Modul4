<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');

// Percobaan C + Latihan 4: overloading property (__set, __get, __isset, __unset)
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

    public function __get(string $key): mixed {
        if (!array_key_exists($key, $this->atributTambahan)) {
            throw new OutOfBoundsException('Atribut tidak ditemukan: ' . $key);
        }
        return $this->atributTambahan[$key];
    }

    public function __isset(string $key): bool {
        return isset($this->atributTambahan[$key]);
    }

    public function __unset(string $key): void {
        unset($this->atributTambahan[$key]);
    }
}

function aman(string $teks): string {
    return htmlspecialchars($teks, ENT_QUOTES, 'UTF-8');
}

$mhs = new MahasiswaDinamis('231001', 'Alya');

echo "<h3>1. __set() dan __get()</h3>";
$mhs->hobi = 'Membaca';                          // memicu __set()
echo "Hobi: " . aman($mhs->hobi) . "<br>";        // memicu __get()

echo "<h3>2. __isset()</h3>";
echo "isset(\$mhs->hobi): " . var_export(isset($mhs->hobi), true) . "<br>";

echo "<h3>3. __unset()</h3>";
unset($mhs->hobi);                                // memicu __unset()
echo "Setelah unset, isset(\$mhs->hobi): " . var_export(isset($mhs->hobi), true) . "<br>";

echo "<h3>4. Membaca atribut yang tidak ada</h3>";
try {
    echo aman($mhs->hobi);
} catch (OutOfBoundsException $e) {
    echo get_class($e) . ": " . aman($e->getMessage()) . "<br>";
}

echo "<h3>5. Menulis atribut yang tidak diizinkan</h3>";
try {
    $mhs->alamat = 'Sukabumi';
} catch (InvalidArgumentException $e) {
    echo get_class($e) . ": " . aman($e->getMessage()) . "<br>";
}
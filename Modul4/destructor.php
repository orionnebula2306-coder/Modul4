<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');

// Percobaan B: destructor dan referensi object
class DemoSiklus {
    public function __construct(private string $nama) {
        echo "Object dibuat ({$this->nama})<br>";
    }
    public function tampil(): void {
        echo "Method dipanggil ({$this->nama})<br>";
    }
    public function __destruct() {
        echo "Destructor berjalan ({$this->nama})<br>";
    }
}

echo "<h3>Skenario 1: unset tanpa alias</h3>";
$obj = new DemoSiklus('skenario 1');
$obj->tampil();
unset($obj);                                  // referensi terakhir hilang -> destructor langsung jalan
echo "Program dilanjutkan setelah unset<br>";

echo "<h3>Skenario 2: unset dengan alias</h3>";
$obj2 = new DemoSiklus('skenario 2');
$alias = $obj2;                               // object punya dua referensi
unset($obj2);
echo "unset(\$obj2) sudah dijalankan, tetapi destructor belum karena masih ada \$alias<br>";
unset($alias);                                // referensi terakhir hilang -> destructor jalan
echo "unset(\$alias) sudah dijalankan<br>";

echo "<h3>Skenario 3: tanpa unset</h3>";
$obj3 = new DemoSiklus('skenario 3');
$obj3->tampil();
echo "Akhir skrip: destructor skenario 3 baru berjalan setelah baris ini<br>";
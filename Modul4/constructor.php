<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');

// Percobaan A + Latihan 1: constructor berparameter dan nilai default
class Mahasiswa {
    public function __construct(
        public string $nim,
        public string $nama,
        public int $semester = 1,                 // nilai default semester
        public string $fakultas = "Belum diisi"   // nilai default fakultas (Latihan 1)
    ) {}

    public function profil(): string {
        return "$this->nim - $this->nama (Semester $this->semester, Fakultas $this->fakultas)";
    }
}

echo "<h3>Percobaan A: nilai default semester</h3>";
$mhs1 = new Mahasiswa('231001', 'Alya', 3);   // semester diisi
$mhs2 = new Mahasiswa('231002', 'Budi');      // semester tidak diisi -> default 1
echo $mhs1->profil() . "<br>";
echo $mhs2->profil() . "<br>";

echo "<h3>Latihan 1: nilai default fakultas</h3>";
$mhs3 = new Mahasiswa('231003', 'Citra', 2, 'Sains dan Teknologi'); // fakultas diisi
$mhs4 = new Mahasiswa('231004', 'Dimas', 2);                         // fakultas default
echo $mhs3->profil() . "<br>";
echo $mhs4->profil() . "<br>";

// Uji TypeError (hilangkan tanda // di bawah, jalankan, screenshot error, lalu beri // lagi):
// $salah = new Mahasiswa('231005', 'Eka', 'empat');
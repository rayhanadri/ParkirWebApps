<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailParkir
{
    public $totalBiaya;
    public $hariParkir;
    public $jamParkir;
    public $menitParkir;
    public $waktuMasuk;
    public $waktuKeluar;
    public $nopol;
    public $jenisKendaraan;

    public function __construct($totalBiaya, $hariParkir, $jamParkir, $menitParkir, $waktuMasuk, $waktuKeluar, $nopol, $jenisKendaraan)
    {
        $this->totalBiaya = $totalBiaya;
        $this->hariParkir = $hariParkir;
        $this->jamParkir = $jamParkir;
        $this->menitParkir = $menitParkir;
        $this->waktuMasuk = $waktuMasuk;
        $this->waktuKeluar = $waktuKeluar;
        $this->nopol = $nopol;
        $this->jenisKendaraan = $jenisKendaraan;

    }
}
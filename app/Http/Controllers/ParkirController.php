<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\ConfigJenisKendaraan;
use App\Models\TiketConfig;
use App\Models\DetailParkir;
use App\Models\ParkirControl;
use App\Models\MonitorKendaraan;
use App\Models\Tiket;
use DB;
use Carbon\Carbon;

class ParkirController extends Controller
{
    //


    public function index()
    {
        return view('main');
    }

    public function masukParkir()
    {
        //$transaksi = Transaksi::all();
        $jenisKendaraan = ConfigJenisKendaraan::all();

        return view('transaksi.parkirMasuk', [
            'jenisKendaraan' => $jenisKendaraan,
        ]);
    }

    public function prosesMasukParkir(Request $request)
    {
        //get data from view
        $nopol = strtoupper($request->input('nopol'));
        $idJenisKendaraan = $request->input('jenisKendaraan');
        $current_time = $request->input('current_time');

        //get jenisKendaraan
        $configJenisKendaraan = ConfigJenisKendaraan::where('id', $idJenisKendaraan)
            ->orderBy('lastChangeDate', 'desc')
            ->first();
        $jenisKendaraan = $configJenisKendaraan->jenisKendaraan;

        //get transaksi masuk
        $masukIsFound = false; //variabel untuk cek apakah masuk ditemukan,  default false

        //check from monitor if transaksi masuk exist
        $dataExist = MonitorKendaraan::where('nomorPolisi', $nopol)
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        if ($dataExist != null) {
            if ($dataExist->status == "MASUK") {
                $masukIsFound = true;
            } else {
                $masukIsFound = false;
            }
        } else {
            $masukIsFound = false;
        }

        if ($masukIsFound == false) {
            //save data transaksi
            $transaksi = new Transaksi;
            $transaksi->waktu = $current_time;
            $transaksi->jenisKendaraan = $jenisKendaraan;
            $transaksi->nomorPolisi = $nopol;
            $transaksi->status = "MASUK";
            $transaksi->save();

            $detailParkir = new DetailParkir(0, 0, 0, 0, $current_time, null, $nopol, $jenisKendaraan);

            $parkirControl = ParkirControl::orderBy('lastChangeDate', 'desc')->first();
            $parkirTiketConfig = TiketConfig::where('jenisTiket', 'MASUK')->orderBy('lastChangeDate', 'desc')->first();

            //get tiket
            $tiket = $this->catakTiket('MASUK', $detailParkir);

            //save to monitor
            $dataExist = MonitorKendaraan::where('nomorPolisi', $transaksi->nomorPolisi)
                ->orderBy('lastChangeDate', 'desc')
                ->first();

            if ($dataExist != null) {
                $dataExist->waktuMasuk = $transaksi->waktu;
                $dataExist->waktuKeluar = null;
                $dataExist->jenisKendaraan = $transaksi->jenisKendaraan;
                $dataExist->status = $transaksi->status;
                $dataExist->lastChangeDate = $transaksi->waktu;
                $dataExist->save();
            } else {
                $dataNew = new MonitorKendaraan();
                $dataNew->waktuMasuk = $transaksi->waktu;
                $dataNew->waktuKeluar = null;
                $dataNew->jenisKendaraan = $transaksi->jenisKendaraan;
                $dataNew->nomorPolisi = $transaksi->nomorPolisi;
                $dataNew->status = $transaksi->status;
                $dataNew->lastChangeDate = $transaksi->waktu;
                $dataNew->save();
            }
            //save tiket to DB
            $dbTiket = new Tiket();
            $dbTiket->jenisTiket = "MASUK";
            $dbTiket->transactionIdMasuk = $transaksi->id;
            $dbTiket->transactionIdKeluar = null;
            $dbTiket->jenisKendaraan = $transaksi->jenisKendaraan;
            $dbTiket->parkirTiketConfigId = $parkirTiketConfig->id;
            $dbTiket->configControlId = $parkirControl->id;
            $dbTiket->totalBiaya = $detailParkir->totalBiaya;
            $dbTiket->tiketText = $tiket;
            $dbTiket->save();

            $jenisTiket = "KELUAR";
        } else {
            $strErrMsg = "WARNING!! Kendaraan anda masih terdaftar masuk dan belum proses keluar, silakan hubungi petugas";
            $tiket = $this->catakTiketError($strErrMsg);
            $jenisTiket = "ERROR";
        }
        return view('transaksi.tiket', [
            'tiket' => $tiket,
            'jenisTiket' => $jenisTiket,
        ]);
    }

    public function keluarParkir()
    {
        return view('transaksi.parkirKeluar');
    }
    public function prosesKeluarParkir(Request $request)
    {
        //get data from view
        $nopol = strtoupper($request->input('nopol'));
        $current_time = $request->input('current_time');

        //get transaksi masuk
        $masukIsFound = false; //variabel untuk cek apakah ditemukan masuk di monitor,  default false

        //check from monitor if transaksi masuk exist
        $dataExist = MonitorKendaraan::where('nomorPolisi', $nopol)
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        if ($dataExist != null) {
            if ($dataExist->status == "MASUK") {
                $masukIsFound = true;
            } else {
                $masukIsFound = false;
            }
        } else {
            $masukIsFound = false;
        }

        //jika tidak ada transaksi masuk dilanjut, jika tidak ada transaksi masuk
        if ($masukIsFound == true) {
            //get transaksi masuk
            $transaksiMasuk = Transaksi::where('nomorPolisi', $nopol)
                ->orderBy('waktu', 'desc')
                ->first();
            //data from transaksi masuk
            $jenisKendaraan = $transaksiMasuk->jenisKendaraan;

            //save data transaksi KELUAR
            $transaksiKeluar = new Transaksi;
            $transaksiKeluar->waktu = $current_time;
            $transaksiKeluar->jenisKendaraan = $jenisKendaraan;
            $transaksiKeluar->nomorPolisi = $nopol;
            $transaksiKeluar->status = "KELUAR";
            $transaksiKeluar->save();

            //call function hitung biaya lalu simpan hasilnya di detail parkir
            $detailParkir = $this->hitungBiayaParkir($transaksiMasuk, $transaksiKeluar);

            //echo "<br>" . "total bayar $detailParkir->totalBiaya ." . "Waktu parkir $detailParkir->hariParkir hari, $detailParkir->jamParkir jam, $detailParkir->menitParkir menit";
            //echo "<br>";
            //echo "jenisKendaraan: " . $jenisKendaraan . " | nopol:  " . $nopol . " | time_masuk : " . $jamMasuk;
            $tiket = $this->catakTiket('KELUAR', $detailParkir);

            //get from db
            $parkirControl = ParkirControl::orderBy('lastChangeDate', 'desc')->first();
            $parkirTiketConfig = TiketConfig::where('jenisTiket', 'KELUAR')->orderBy('lastChangeDate', 'desc')->first();

            //save to monitor
            $dbMonitor = MonitorKendaraan::where('nomorPolisi', $transaksiKeluar->nomorPolisi)
                ->orderBy('lastChangeDate', 'desc')
                ->first();
            $dbMonitor->waktuKeluar = $transaksiKeluar->waktu;
            $dbMonitor->status = $transaksiKeluar->status;
            $dbMonitor->lastChangeDate = $transaksiKeluar->waktu;
            $dbMonitor->save();


            //save tiket to DB
            $dbTiket = new Tiket();
            $dbTiket->jenisTiket = "KELUAR";
            $dbTiket->transactionIdMasuk = $transaksiMasuk->id;
            $dbTiket->transactionIdKeluar = $transaksiKeluar->id;
            $dbTiket->jenisKendaraan = $transaksiMasuk->jenisKendaraan;
            $dbTiket->parkirTiketConfigId = $parkirTiketConfig->id;
            $dbTiket->configControlId = $parkirControl->id;
            $dbTiket->totalBiaya = $detailParkir->totalBiaya;
            $dbTiket->tiketText = $tiket;
            $dbTiket->save();

            $jenisTiket = "MASUK";
        } else {
            $detailParkir = new DetailParkir(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
            $strErrMsg = "WARNING!! Parkir masuk tidak ditemukan atau parkir keluar telah diproses, silakan hubungi petugas";

            $tiket = $this->catakTiketError($strErrMsg);
            //$tiket = "WARNING!! Parkir masuk tidak ditemukan atau parkir keluar telah diproses, silakan hubungi petugas";
            $jenisTiket = "ERROR";
        }
        return view('transaksi.tiket', [
            'tiket' => $tiket,
            'jenisTiket' => $jenisTiket,
        ]);
    }

    private function hitungBiayaParkir(Transaksi $transaksiMasuk, Transaksi $transaksiKeluar)
    {
        //data masuk
        $datetime_masuk = $transaksiMasuk->waktu;
        $jenisKendaraan = $transaksiMasuk->jenisKendaraan;
        $nopol = $transaksiMasuk->nomorPolisi;

        //data keluar
        $datetime_keluar = $transaksiKeluar->waktu;

        //config biaya dari jenis kendaraan
        $configJenisKendaraan = ConfigJenisKendaraan::where('jenisKendaraan', $jenisKendaraan)
            ->orderBy('lastChangeDate', 'desc')->first();
        $jenisKendaraan = $configJenisKendaraan->jenisKendaraan;

        //config parkir control
        $parkirControl = ParkirControl::orderBy('lastChangeDate', 'desc')->first();

        //biaya
        $biayaPerJam = $configJenisKendaraan->biayaPerJam;
        $maxBiaya = $configJenisKendaraan->maxBiaya;
        $minMenitStlh1Jam = $parkirControl->minMenitStlh1Jam;

        //diff
        $diffMinute = Carbon::parse($datetime_masuk)->diffInMinutes(Carbon::parse($datetime_keluar));

        //hitung biaya
        $totalMenit = $diffMinute;
        $hariParkir = intval($totalMenit / 1440);
        $jamParkir = intval($totalMenit / 60);
        $menitParkir = intval($totalMenit % 60);

        //total biaya
        $totalBiaya = 0;
        if ($jamParkir == 0) {
            $totalBiaya += $biayaPerJam;
        } else if ($menitParkir >= $minMenitStlh1Jam) {
            $totalBiaya += $jamParkir * $biayaPerJam; //biaya perjam saja
            $totalBiaya += $biayaPerJam; //tambah biaya per jam karena 10 menit atau lewat
        } else {
            $totalBiaya += $jamParkir * $biayaPerJam; //biaya perjam saja
        }

        //max dan lewat hari 24 jam
        if ($hariParkir == 0 && $totalBiaya > $maxBiaya) { //kalau masih kurang dari 24 jam dan lebih dari max biaya
            $totalBiaya = 0; //reset total biaya
            $totalBiaya += $maxBiaya; //gunakan biaya max
        }
        if ($hariParkir > 0) { //lebih dari 24 jam
            $totalBiaya = 0; //reset total biaya
            $totalBiaya += $hariParkir * $maxBiaya; //hari parkir * max biaya harian

            $biayaLastDay = 0;
            $sisaJam = intval(($totalMenit % 1440) / 60);
            $sisaMenit = intval(($totalMenit % 1440) % 60);

            if ($sisaJam < 1 && $sisaMenit >= $minMenitStlh1Jam) {
                $biayaLastDay += $biayaPerJam; //tambah biaya per jam karena lebih menit namun total sisa belum 1 jam
            } else if ($sisaJam >= 1 && $sisaMenit >= $minMenitStlh1Jam) {
                $biayaLastDay += $sisaJam * $biayaPerJam; //biaya perjam saja
                $biayaLastDay += $biayaPerJam; //tambah biaya per jam lebih menit
            } else { //tdk tambah biaya perjam karena tidak lebih menit
                $biayaLastDay += $sisaJam * $biayaPerJam; //biaya perjam saja
            }

            if ($biayaLastDay > $maxBiaya) { //kalau biaya last day lebih dari max tambah biaya max saja
                $totalBiaya += $maxBiaya;
            } else {
                $totalBiaya += $biayaLastDay;
            }

        }

        if ($hariParkir > 0) {
            $detailParkir = new DetailParkir($totalBiaya, $hariParkir, $sisaJam, $sisaMenit, $datetime_masuk, $datetime_keluar, $nopol, $jenisKendaraan);

        } else {
            $detailParkir = new DetailParkir($totalBiaya, $hariParkir, $jamParkir, $menitParkir, $datetime_masuk, $datetime_keluar, $nopol, $jenisKendaraan);
        }

        return $detailParkir;
    }

    private function catakTiket(string $jenisTiket, DetailParkir $detailParkir)
    {
        $tiketConfig = TiketConfig::where('jenisTiket', $jenisTiket)
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        $tiket = $tiketConfig->tiketTextTemplate;

        if ($jenisTiket == 'KELUAR') {
            if ($detailParkir->hariParkir > 0) {
                $strTotalWaktu = "$detailParkir->hariParkir hari, $detailParkir->jamParkir jam, $detailParkir->menitParkir menit";
            } else {
                $strTotalWaktu = "$detailParkir->jamParkir jam, $detailParkir->menitParkir menit";
            }

            //replace
            $tiket = str_replace('@@DATE_MASUK@@', $detailParkir->waktuMasuk, $tiket);
            $tiket = str_replace('@@DATE_KELUAR@@', $detailParkir->waktuKeluar, $tiket);
            $tiket = str_replace('@@NOPOL@@', $detailParkir->nopol, $tiket);
            $tiket = str_replace('@@JENIS_KENDARAAN@@', $detailParkir->jenisKendaraan, $tiket);
            $tiket = str_replace('@@TOTAL_BIAYA@@', $detailParkir->totalBiaya, $tiket);
            $tiket = str_replace('@@TOTAL_WAKTU@@', $strTotalWaktu, $tiket);
        }
        if ($jenisTiket == 'MASUK') {
            //replace
            $tiket = str_replace('@@DATE_MASUK@@', $detailParkir->waktuMasuk, $tiket);
            $tiket = str_replace('@@NOPOL@@', $detailParkir->nopol, $tiket);
            $tiket = str_replace('@@JENIS_KENDARAAN@@', $detailParkir->jenisKendaraan, $tiket);
        }

        return $tiket;
    }

    private function catakTiketError(string $ErrMsg)
    {
        $tiketConfig = TiketConfig::where('jenisTiket', 'ERROR')
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        $tiket = $tiketConfig->tiketTextTemplate;
        $tiket = str_replace('@@ERR_MSG@@', $ErrMsg, $tiket);

        return $tiket;
    }

    public function menuLaporan()
    {
        return view('laporan.menuLaporan');
    }

    public function kendaraanDiLokasi()
    {
        //$transaksi = Transaksi::all();
        $jenisKendaraan = ConfigJenisKendaraan::all();

        return view('laporan.kendaraanDiLokasi', [
            'jenisKendaraan' => $jenisKendaraan,
        ]);
    }

    public function resultKendaraanDiLokasi(Request $request)
    {
        $dateStart = Carbon::parse($request->input('dateStart'));
        $dateEnd = Carbon::parse($request->input('dateEnd'));
        $jenisKendaraan = $request->input('jenisKendaraan');

        if ($jenisKendaraan == '*') {
            $monitorKendaraan = MonitorKendaraan::where('waktuMasuk', '>=', $dateStart)
                ->where('waktuMasuk', '<=', $dateEnd)
                ->where('status', 'MASUK')
                ->get();

            $summaryKendaraan = MonitorKendaraan::select('jenisKendaraan', DB::raw('count(jenisKendaraan) as subtotal'))
                ->where('waktuMasuk', '>=', $dateStart)
                ->where('waktuMasuk', '<=', $dateEnd)
                ->where('status', 'MASUK')
                ->groupBy('jenisKendaraan')
                ->get();
        } else {
            $monitorKendaraan = MonitorKendaraan::where('waktuMasuk', '>=', $dateStart)
                ->where('waktuMasuk', '<=', $dateEnd)
                ->where('status', 'MASUK')
                ->where('jenisKendaraan', $jenisKendaraan)
                ->get();

            $summaryKendaraan = MonitorKendaraan::select('jenisKendaraan', DB::raw('count(jenisKendaraan) as subtotal'))
                ->where('waktuMasuk', '>=', $dateStart)
                ->where('waktuMasuk', '<=', $dateEnd)
                ->where('status', 'MASUK')
                ->where('jenisKendaraan', $jenisKendaraan)
                ->groupBy('jenisKendaraan')
                ->get();
        }

        return view('laporan.resultKendaraanDiLokasi', [
            'monitorKendaraan' => $monitorKendaraan,
            'summaryKendaraan' => $summaryKendaraan,
        ]);
    }

    public function kendaraanMasukKeluar()
    {
        //$transaksi = Transaksi::all();
        $jenisKendaraan = ConfigJenisKendaraan::all();

        return view('laporan.kendaraanMasukKeluar', [
            'jenisKendaraan' => $jenisKendaraan,
        ]);
    }

    public function resultKendaraanMasukKeluar(Request $request)
    {
        $dateStart = Carbon::parse($request->input('dateStart'));
        $dateEnd = Carbon::parse($request->input('dateEnd'));
        $jenisKendaraan = $request->input('jenisKendaraan');

        if ($jenisKendaraan == '*') {
            $masukKeluarKendaraan = DB::select(DB::raw("SELECT Tiket.jenisTiket, TransMasuk.waktu as waktuMasuk, TransKeluar.waktu as waktuKeluar, TransKeluar.nomorPolisi, TransKeluar.jenisKendaraan
                         FROM ParkirTiket_TT Tiket 
                         JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                         JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                         WHERE Tiket.jenisTiket = 'KELUAR'
                         AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                         AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s');"));

            $summaryKendaraan = DB::select(DB::raw("SELECT TransKeluar.jenisKendaraan, count(TransKeluar.jenisKendaraan) as subtotal
                        FROM ParkirTiket_TT Tiket 
                        JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                        JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                        WHERE Tiket.jenisTiket = 'KELUAR'
                        AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                        AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s')
                        GROUP BY TransKeluar.jenisKendaraan
                        "));

        } else {
            $masukKeluarKendaraan = DB::select(DB::raw("SELECT Tiket.jenisTiket, TransMasuk.waktu as waktuMasuk, TransKeluar.waktu as waktuKeluar, TransKeluar.nomorPolisi, TransKeluar.jenisKendaraan
                         FROM ParkirTiket_TT Tiket 
                         JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                         JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                         WHERE Tiket.jenisTiket = 'KELUAR'
                         AND Tiket.jenisKendaraan = '$jenisKendaraan'
                         AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                         AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s')
                         "));

            $summaryKendaraan = DB::select(DB::raw("SELECT TransKeluar.jenisKendaraan, count(TransKeluar.jenisKendaraan) as subtotal
                        FROM ParkirTiket_TT Tiket 
                        JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                        JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                        WHERE Tiket.jenisTiket = 'KELUAR'
                        AND Tiket.jenisKendaraan = '$jenisKendaraan'
                        AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                        AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s')
                        GROUP BY TransKeluar.jenisKendaraan
                        "));
        }

        return view('laporan.resultKendaraanMasukKeluar', [
            'masukKeluarKendaraan' => $masukKeluarKendaraan,
            'summaryKendaraan' => $summaryKendaraan,
        ]);
    }

    public function pendapatan()
    {
        $jenisKendaraan = ConfigJenisKendaraan::all();

        return view('laporan.pendapatan', [
            'jenisKendaraan' => $jenisKendaraan,
        ]);
    }

    public function resultPendapatan(Request $request)
    {
        $dateStart = Carbon::parse($request->input('dateStart'));
        $dateEnd = Carbon::parse($request->input('dateEnd'));
        $jenisKendaraan = $request->input('jenisKendaraan');

        if ($jenisKendaraan == '*') {
            $masukKeluarKendaraan = DB::select(DB::raw("SELECT DATE(TransKeluar.waktu) as tanggal, TransKeluar.nomorPolisi, TransKeluar.jenisKendaraan, Tiket.totalBiaya,
                        concat(
                            FLOOR(MOD(TIMESTAMPDIFF(SECOND, TransMasuk.waktu, TransKeluar.waktu), 86400) / 3600),
                            ' jam, ',
                            FLOOR(MOD(TIMESTAMPDIFF(SECOND, TransMasuk.waktu, TransKeluar.waktu), 3600) / 60),
                            ' menit'
                        ) as time_difference
                         FROM ParkirTiket_TT Tiket 
                         JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                         JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                         WHERE Tiket.jenisTiket = 'KELUAR'
                         AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                         AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s');"));

            $summaryKendaraan = DB::select(DB::raw("SELECT TransKeluar.jenisKendaraan, count(TransKeluar.jenisKendaraan) as subtotal, sum(Tiket.totalBiaya) as sumTotalBiaya
                        FROM ParkirTiket_TT Tiket 
                        JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                        JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                        WHERE Tiket.jenisTiket = 'KELUAR'
                        AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                        AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s')
                        GROUP BY TransKeluar.jenisKendaraan
                        "));

        } else {
            $masukKeluarKendaraan = DB::select(DB::raw("SELECT DATE(TransKeluar.waktu) as tanggal, TransKeluar.nomorPolisi, TransKeluar.jenisKendaraan, Tiket.totalBiaya,
                         concat(
                             FLOOR(MOD(TIMESTAMPDIFF(SECOND, TransMasuk.waktu, TransKeluar.waktu), 86400) / 3600),
                             ' jam, ',
                             FLOOR(MOD(TIMESTAMPDIFF(SECOND, TransMasuk.waktu, TransKeluar.waktu), 3600) / 60),
                             ' menit'
                         ) as time_difference                         
                         FROM ParkirTiket_TT Tiket 
                         JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                         JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                         WHERE Tiket.jenisTiket = 'KELUAR'
                         AND Tiket.jenisKendaraan = '$jenisKendaraan'
                         AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                         AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s')
                         
                         "));

            $summaryKendaraan = DB::select(DB::raw("SELECT TransKeluar.jenisKendaraan, count(TransKeluar.jenisKendaraan) as subtotal, sum(Tiket.totalBiaya) as sumTotalBiaya
                        FROM ParkirTiket_TT Tiket 
                        JOIN ParkirTransaction_TT TransMasuk ON Tiket.transactionIdMasuk = TransMasuk.id
                        JOIN ParkirTransaction_TT TransKeluar ON Tiket.transactionIdKeluar = TransKeluar.id
                        WHERE Tiket.jenisTiket = 'KELUAR'
                        AND Tiket.jenisKendaraan = '$jenisKendaraan'
                        AND TransKeluar.waktu >= STR_TO_DATE('$dateStart', '%Y-%m-%d %H:%i:%s')
                        AND TransKeluar.waktu <= STR_TO_DATE('$dateEnd', '%Y-%m-%d %H:%i:%s')
                        GROUP BY TransKeluar.jenisKendaraan
                        "));
        }


        return view('laporan.resultPendapatan', [
            'masukKeluarKendaraan' => $masukKeluarKendaraan,
            'summaryKendaraan' => $summaryKendaraan,
        ]);
    }

    public function menuPengaturan()
    {
        return view('pengaturan.menuPengaturan');
    }

    public function configKendaraan()
    {
        $configKendaraan = ConfigJenisKendaraan::all();

        return view('pengaturan.configKendaraan', [
            'configKendaraan' => $configKendaraan
        ]);
    }

    public function formConfigKendaraan(Request $request)
    {
        $configId = $request->route('configId');

        $configKendaraan = ConfigJenisKendaraan::where('id', $configId)
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        return view('pengaturan.formConfigKendaraan', [
            'configKendaraan' => $configKendaraan
        ]);
    }

    public function prosesConfigKendaraan(Request $request)
    {
        $id = $request->input('id');
        $jenisKendaraan = $request->input('jenisKendaraan');
        $biayaPerJam = $request->input('biayaPerJam');
        $maxBiaya = $request->input('maxBiaya');
        $lastChangeDate = $request->input('lastChangeDate');

        $configKendaraan = ConfigJenisKendaraan::where('id', $id)
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        $configKendaraan->jenisKendaraan = $jenisKendaraan;
        $configKendaraan->biayaPerJam = $biayaPerJam;
        $configKendaraan->maxBiaya = $maxBiaya;
        $configKendaraan->lastChangeDate = $lastChangeDate;
        $configKendaraan->save();

        return redirect()->route('configKendaraan');
    }


    public function configMinMenit()
    {
        $configParkirControl = ParkirControl::all();

        return view('pengaturan.configMinMenit', [
            'configParkirControl' => $configParkirControl
        ]);
    }

    public function formConfigMinMenit(Request $request)
    {
        $configId = $request->route('configId');

        $parkirControlConfig = ParkirControl::where('id', $configId)
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        return view('pengaturan.formConfigMinMenit', [
            'parkirControlConfig' => $parkirControlConfig
        ]);
    }

    public function prosesConfigMinMenit(Request $request)
    {
        $id = $request->input('id');
        $minMenitStlh1Jam = $request->input('minMenitStlh1Jam');
        $lastChangeDate = $request->input('lastChangeDate');

        $configKendaraan = ParkirControl::where('id', $id)
            ->orderBy('lastChangeDate', 'desc')
            ->first();

        $configKendaraan->minMenitStlh1Jam = $minMenitStlh1Jam;
        $configKendaraan->lastChangeDate = $lastChangeDate;
        $configKendaraan->save();

        return redirect()->route('configMinMenit');
    }
}
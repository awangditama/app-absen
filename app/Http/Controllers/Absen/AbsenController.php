<?php

namespace App\Http\Controllers\Absen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Absen;
use Illuminate\Support\Facades\DB;


class AbsenController extends Controller
{
    //
    public function dashboard()
    {
        $grafik = DB::table('user_absens')
            ->select(DB::raw('DISTINCT
        COUNT(IF(user_absens.status_masuk = 1,
                user_absens.status_masuk,
                NULL)) AS tepat_waktu,
        COUNT(IF(user_absens.status_masuk = 2,
                user_absens.status_masuk,
                NULL)) AS terlambat,
        COUNT(IF(user_absens.status_keluar = 1,
                user_absens.status_keluar,
                NULL)) AS pulang_normal,
        COUNT(IF(user_absens.status_keluar = 2,
                user_absens.status_keluar,
                NULL)) AS pulang_cepat'))
            ->where('user_id', auth()->user()->id)    
            ->first();
        $data = Absen::where('user_id', auth()->user()->id)->get();
        return view('user.dashboard', ['data' => $data, 'grafik' => $grafik]);
    }

    public function view_absen_masuk()
    {
        $tanggal = Carbon::now()->toDateString();
        return view('user.absen_masuk',['tanggal' => $tanggal]);
    }

    public function view_absen_pulang()
    {    
        $tanggal = Carbon::now()->toDateString();
        return view('user.absen_pulang',['tanggal' => $tanggal]);
    }

    public function process_absen_masuk(Request $request)
    {
        $data['user_id'] = auth()->user()->id;
        $data['jam_masuk'] = Carbon::now()->toTimeString();
        $data['tanggal'] = Carbon::now()->toDateString();

        $cekDate = Absen::where(['tanggal' => $data['tanggal'], 'user_id' => $data['user_id']])->first();
        if ($cekDate) {
            return back()->withErrors([
                'error' => 'Sudah Melakukan Absen Masuk'
            ]);
        } else {
            $batasWaktuAbsenMasuk = Carbon::createFromTimeString('09:00:00', 'Asia/Jakarta');
            $cekBataWaktu = $batasWaktuAbsenMasuk->lessThanOrEqualTo(now());
            if ($cekBataWaktu) {
                $data['status_masuk'] = '2';
            } else {
                $data['status_masuk'] = '1';
            }
            Absen::create($data);
            return redirect()->route('user.absen.masuk')->with('success', "Berhasil Abesn Masuk");
        }
    }

    public function process_absen_pulang(Request $request)
    {
        $data['user_id'] = auth()->user()->id;
        $data['jam_keluar'] = Carbon::now()->toTimeString();
        $data['tanggal'] = Carbon::now()->toDateString();

        $cekDate = Absen::where(['tanggal' => $data['tanggal'], 'user_id' => $data['user_id']])->first();
        if ($cekDate) {
            if ($cekDate->jam_keluar == null) {
                $batasWaktuAbsenPulang = Carbon::createFromTimeString('17:00:00', 'Asia/Jakarta');
                $cekBataWaktu = $batasWaktuAbsenPulang->greaterThanOrEqualTo(now());
                if ($cekBataWaktu) {
                    $data['status_keluar'] = '2';
                } else {
                    $data['status_keluar'] =  '1';
                }
                Absen::where('id', $cekDate->id)->update(['jam_keluar' => $data['jam_keluar'], 'status_keluar' => $data['status_keluar']]);
                return redirect()->route('user.absen.pulang')->with('success', "Berhasil Abesn Pulang");
            } else {
                return back()->withErrors([
                    'error_pulang' => 'Sudah Melakukan Absen Pulang'
                ]);
            }
        } else {
            return back()->withErrors([
                'error_belum_absen_masuk' => 'Belum Melakukan Abesn Masuk !!!'
            ]);
        }
    }
}

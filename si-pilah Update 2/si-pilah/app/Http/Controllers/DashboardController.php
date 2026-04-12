<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import Model yang dibutuhkan berdasarkan PBI
use App\Models\Waste;
use App\Models\Reward;
use App\Models\Report;
use App\Models\Schedule;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        
        $userId = Auth::id();

        
        $laporanTerbaru = Report::where('user_id', $userId)->latest()->first();
        $jumlahLaporanAktif = Report::where('user_id', $userId)
                                    ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                                    ->count();

        
        $jadwalTerdekat = Schedule::where('waktu_jemput', '>=', now())
                                  ->orderBy('waktu_jemput', 'asc')
                                  ->first();

        
        $pengumumanTerbaru = Announcement::latest()->first();

        
        $data = [
            
            'total_sampah'     => Waste::where('user_id', $userId)->sum('weight') ?? 0, 
            'poin_reward'      => Reward::where('user_id', $userId)->sum('points') ?? 0,
            'energi_surya_kwh' => Waste::where('user_id', $userId)->sum('energy_generated') ?? 0,
            
            
            'laporan_aktif'  => $jumlahLaporanAktif,
            'status_laporan' => $laporanTerbaru ? $laporanTerbaru->status : 'Tidak ada laporan', 

            
            'jadwal_terdekat' => [
                'hari'    => $jadwalTerdekat ? \Carbon\Carbon::parse($jadwalTerdekat->waktu_jemput)->translatedFormat('l, d F Y - H:i') : 'Belum ada jadwal',
                'jenis'   => $jadwalTerdekat ? $jadwalTerdekat->kategori : '-',
                'petugas' => $jadwalTerdekat ? $jadwalTerdekat->nama_petugas : '-'
            ],

            
            'pengumuman' => $pengumumanTerbaru ? $pengumumanTerbaru->konten : 'Belum ada pengumuman terbaru.'
        ];
        
        

        return view('user.dashboard', compact('data')); 
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Waste;
use App\Models\Report;
use App\Models\Reward;
use App\Models\Schedule;
use App\Models\Announcement;
use App\Models\Education;

class AdminDashboardController extends Controller
{
    // ==================== DASHBOARD ====================

    public function index()
    {
        $data = [
            'total_users'       => User::count(),
            'total_sampah'      => Waste::sum('weight') ?? 0,
            'total_energi'      => Waste::sum('result') ?? 0,
            'total_poin'        => Reward::sum('points') ?? 0,
            'total_laporan'     => Report::count(),
            'laporan_aktif'     => Report::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count(),
            'total_jadwal'      => Schedule::count(),
            'total_pengumuman'  => Announcement::count(),
        ];

        $laporanTerbaru = Report::with('user')->latest()->take(5)->get();
        $wastesTerbaru  = Waste::latest()->take(5)->get();

        return view('admin.dashboard', compact('data', 'laporanTerbaru', 'wastesTerbaru'));
    }

    // ==================== USERS ====================

    public function users(Request $request)
    {
        $query = User::latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $query->paginate(15)->withQueryString();
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'is_admin' => $request->has('is_admin'),
        ]);

        return back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // ==================== WASTES ====================

    public function wastes(Request $request)
    {
        $query = Waste::with('user')->latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('tps', 'like', "%{$search}%");
            });
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        $wastes = $query->paginate(15)->withQueryString();
        return view('admin.wastes', compact('wastes'));
    }

    public function deleteWaste(Waste $waste)
    {
        $waste->delete();
        return back()->with('success', 'Data sampah berhasil dihapus.');
    }

    // ==================== REPORTS ====================

    public function reports(Request $request)
    {
        $query = Report::with('user')->latest();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $reports = $query->paginate(15)->withQueryString();
        return view('admin.reports', compact('reports'));
    }

    public function updateReportStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Dibatalkan',
        ]);

        $report->update(['status' => $request->status]);
        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    // ==================== REWARDS ====================

    public function rewards()
    {
        $rewards = Reward::with('user')->latest()->paginate(15);
        $users   = User::orderBy('name')->get();
        return view('admin.rewards', compact('rewards', 'users'));
    }

    public function storeReward(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points'  => 'required|integer|min:1',
        ]);

        Reward::create([
            'user_id' => $request->user_id,
            'points'  => $request->points,
        ]);

        return back()->with('success', 'Reward berhasil ditambahkan.');
    }

    public function deleteReward(Reward $reward)
    {
        $reward->delete();
        return back()->with('success', 'Reward berhasil dihapus.');
    }

    // ==================== SCHEDULES ====================

    public function schedules()
    {
        $schedules = Schedule::latest()->paginate(15);
        return view('admin.schedules', compact('schedules'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'waktu_jemput'  => 'required|date',
            'kategori'      => 'required|string|max:255',
            'nama_petugas'  => 'required|string|max:255',
        ]);

        Schedule::create($request->only('waktu_jemput', 'kategori', 'nama_petugas'));
        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $request->validate([
            'waktu_jemput'  => 'required|date',
            'kategori'      => 'required|string|max:255',
            'nama_petugas'  => 'required|string|max:255',
        ]);

        $schedule->update($request->only('waktu_jemput', 'kategori', 'nama_petugas'));
        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    // ==================== ANNOUNCEMENTS ====================

    public function announcements()
    {
        $announcements = Announcement::latest()->paginate(15);
        return view('admin.announcements', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'konten' => 'required|string',
        ]);

        Announcement::create(['konten' => $request->konten]);
        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $request->validate([
            'konten' => 'required|string',
        ]);

        $announcement->update(['konten' => $request->konten]);
        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

        

    // ==================== EDUCATIONS ====================

    public function educations()
    {
        $educations = Education::latest()->paginate(15);
        return view('admin.educations', compact('educations'));
    }

    public function storeEducation(Request $request)
    {
        // ===== VALIDASI =====
        $request->validate([
            'title'     => 'required|string|max:255',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_pdf'  => 'required|mimes:pdf|max:2048',
        ]);

        $coverName = null;
        $pdfName   = null;

        // ===== UPLOAD COVER =====
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . $cover->getClientOriginalName();
            $cover->move(public_path('cover'), $coverName);
        }

        // ===== UPLOAD PDF =====
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $pdfName = time() . '_pdf_' . $file->getClientOriginalName();
            $file->move(public_path('pdf'), $pdfName);
        }

        // ===== SIMPAN =====
        Education::create([
            'title'     => $request->title,
            'cover'     => $coverName,
            'file_pdf'  => $pdfName,
        ]);

        return back()->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function deleteEducation(Education $education)
    {
        // ===== HAPUS PDF =====
        if ($education->file_pdf && file_exists(public_path('pdf/' . $education->file_pdf))) {
            unlink(public_path('pdf/' . $education->file_pdf));
        }

        // ===== HAPUS COVER =====
        if ($education->cover && file_exists(public_path('cover/' . $education->cover))) {
            unlink(public_path('cover/' . $education->cover));
        }

        $education->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}
    
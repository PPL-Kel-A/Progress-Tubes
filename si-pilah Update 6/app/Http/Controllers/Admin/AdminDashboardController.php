<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return back()->with('error', 'Tidak bisa hapus akun sendiri.');
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

    public function updateWasteStatus(Request $request, Waste $waste)
    {
        $request->validate([
            'status' => 'required|in:Pending,Proses,Selesai',
        ]);

        $waste->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diupdate');
    }

    public function deleteWaste(Waste $waste)
    {
        $waste->delete();
        return back()->with('success', 'Data sampah dihapus.');
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
        return back()->with('success', 'Status diperbarui.');
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

        Reward::create($request->only('user_id', 'points'));

        return back()->with('success', 'Reward ditambahkan.');
    }

    public function deleteReward(Reward $reward)
    {
        $reward->delete();
        return back()->with('success', 'Reward dihapus.');
    }

    // ==================== SCHEDULE ====================

    public function schedules()
    {
        $schedules = Schedule::latest()->paginate(15);
        return view('admin.schedules', compact('schedules'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'waktu_jemput' => 'required|date',
            'kategori'     => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
        ]);

        Schedule::create($request->only('waktu_jemput', 'kategori', 'nama_petugas'));

        return back()->with('success', 'Jadwal ditambahkan.');
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $request->validate([
            'waktu_jemput' => 'required|date',
            'kategori'     => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
        ]);

        $schedule->update($request->only('waktu_jemput', 'kategori', 'nama_petugas'));

        return back()->with('success', 'Jadwal diupdate.');
    }

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }

    // ==================== ANNOUNCEMENT ====================

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

        return back()->with('success', 'Pengumuman ditambahkan.');
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $request->validate([
            'konten' => 'required|string',
        ]);

        $announcement->update(['konten' => $request->konten]);

        return back()->with('success', 'Pengumuman diupdate.');
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }

    // ==================== EDUCATION ====================

    public function educations()
    {
        $educations = Education::latest()->paginate(15);
        return view('admin.educations', compact('educations'));
    }

    public function storeEducation(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $coverName = null;
        $pdfName   = null;

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time().'_cover_'.$cover->getClientOriginalName();
            $cover->move(public_path('cover'), $coverName);
        }

        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $pdfName = time().'_pdf_'.$file->getClientOriginalName();
            $file->move(public_path('pdf'), $pdfName);
        }

        Education::create([
            'title'    => $request->title,
            'cover'    => $coverName,
            'file_pdf' => $pdfName,
        ]);

        return back()->with('success', 'Artikel ditambahkan.');
    }

    public function deleteEducation(Education $education)
    {
        if ($education->file_pdf && file_exists(public_path('pdf/'.$education->file_pdf))) {
            unlink(public_path('pdf/'.$education->file_pdf));
        }

        if ($education->cover && file_exists(public_path('cover/'.$education->cover))) {
            unlink(public_path('cover/'.$education->cover));
        }

        $education->delete();

        return back()->with('success', 'Artikel dihapus.');
    }

    public function edit(Education $education)
    {
        return view('admin.educations_edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('cover')) {

            if ($education->cover && file_exists(public_path('cover/'.$education->cover))) {
                unlink(public_path('cover/'.$education->cover));
            }

            $cover = $request->file('cover');
            $coverName = time().'_cover_'.$cover->getClientOriginalName();
            $cover->move(public_path('cover'), $coverName);

            $education->cover = $coverName;
        }

        if ($request->hasFile('file_pdf')) {

            if ($education->file_pdf && file_exists(public_path('pdf/'.$education->file_pdf))) {
                unlink(public_path('pdf/'.$education->file_pdf));
            }

            $file = $request->file('file_pdf');
            $pdfName = time().'_pdf_'.$file->getClientOriginalName();
            $file->move(public_path('pdf'), $pdfName);

            $education->file_pdf = $pdfName;
        }

        $education->title = $request->title;
        $education->save();

        return redirect()->route('admin.educations')
            ->with('success', 'Artikel diupdate.');
    }
}
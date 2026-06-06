<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-description', 'Ringkasan data dan statistik Si-Pilah'); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">👥</div>
            <span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-full">Users</span>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e(number_format($data['total_users'])); ?></p>
        <p class="text-xs text-gray-400 mt-1">Total pengguna terdaftar</p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">♻️</div>
            <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-full">Sampah</span>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e(number_format($data['total_sampah'], 1)); ?> <span class="text-sm font-normal text-gray-400">Kg</span></p>
        <p class="text-xs text-gray-400 mt-1">Total sampah terkumpul</p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-yellow-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">⚡</div>
            <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">Energi</span>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e(number_format($data['total_energi'], 1)); ?> <span class="text-sm font-normal text-gray-400">kWh</span></p>
        <p class="text-xs text-gray-400 mt-1">Energi surya dihasilkan</p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">🎁</div>
            <span class="text-xs font-bold text-purple-500 bg-purple-50 px-2 py-1 rounded-full">Reward</span>
        </div>
        <p class="text-2xl font-bold text-gray-800"><?php echo e(number_format($data['total_poin'])); ?> <span class="text-sm font-normal text-gray-400">Pts</span></p>
        <p class="text-xs text-gray-400 mt-1">Poin reward tersalurkan</p>
    </div>
</div>


<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center text-xl">📋</div>
        <div>
            <p class="text-xl font-bold text-gray-800"><?php echo e($data['laporan_aktif']); ?> <span class="text-sm font-normal text-gray-400">/ <?php echo e($data['total_laporan']); ?></span></p>
            <p class="text-xs text-gray-400">Laporan aktif / total</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-11 h-11 bg-teal-50 rounded-xl flex items-center justify-center text-xl">📅</div>
        <div>
            <p class="text-xl font-bold text-gray-800"><?php echo e($data['total_jadwal']); ?></p>
            <p class="text-xs text-gray-400">Jadwal penjemputan</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-11 h-11 bg-orange-50 rounded-xl flex items-center justify-center text-xl">📢</div>
        <div>
            <p class="text-xl font-bold text-gray-800"><?php echo e($data['total_pengumuman']); ?></p>
            <p class="text-xs text-gray-400">Pengumuman aktif</p>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Laporan Terbaru</h3>
            <a href="<?php echo e(route('admin.reports')); ?>" class="text-xs text-sipilah-700 font-semibold hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Judul</th>
                        <th class="px-6 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $laporanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-gray-700"><?php echo e($laporan->user->name ?? '-'); ?></td>
                        <td class="px-6 py-3 text-gray-600 truncate max-w-[150px]"><?php echo e($laporan->judul); ?></td>
                        <td class="px-6 py-3">
                            <?php
                                $colors = ['Menunggu' => 'yellow', 'Diproses' => 'blue', 'Selesai' => 'green', 'Dibatalkan' => 'red'];
                                $c = $colors[$laporan->status] ?? 'gray';
                            ?>
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-<?php echo e($c); ?>-100 text-<?php echo e($c); ?>-700"><?php echo e($laporan->status); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada laporan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Setoran Sampah Terbaru</h3>
            <a href="<?php echo e(route('admin.wastes')); ?>" class="text-xs text-sipilah-700 font-semibold hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Tipe</th>
                        <th class="px-6 py-3 text-left">Berat</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $wastesTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-gray-700"><?php echo e($waste->name ?? '-'); ?></td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-bold <?php echo e($waste->type === 'organic' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'); ?>">
                                <?php echo e(ucfirst($waste->type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600"><?php echo e(number_format($waste->weight, 1)); ?> Kg</td>
                        <td class="px-6 py-3 text-gray-400 text-xs"><?php echo e($waste->created_at->format('d/m/Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data sampah</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
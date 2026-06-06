<?php $__env->startSection('title', 'Laporan'); ?>
<?php $__env->startSection('page-title', 'Kelola Laporan'); ?>
<?php $__env->startSection('page-description', 'Kelola semua laporan dari pengguna'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h3 class="font-bold text-gray-800">Daftar Laporan (<?php echo e($reports->total()); ?>)</h3>
        <form method="GET" action="<?php echo e(route('admin.reports')); ?>" class="flex gap-2 flex-wrap">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari judul atau deskripsi..." class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none w-48">
            <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-700 transition">🔍 Cari</button>
            <?php if(request('search') || request('status')): ?>
                <a href="<?php echo e(route('admin.reports')); ?>" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">✕</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Judul</th>
                    <th class="px-6 py-3 text-left">Deskripsi</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Ubah Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50">
                    <td class="px-6 py-3 text-gray-400"><?php echo e($report->id); ?></td>
                    <td class="px-6 py-3 font-medium text-gray-700"><?php echo e($report->user->name ?? '-'); ?></td>
                    <td class="px-6 py-3 text-gray-700 font-medium"><?php echo e($report->judul); ?></td>
                    <td class="px-6 py-3 text-gray-500 truncate max-w-[200px]" title="<?php echo e($report->deskripsi); ?>"><?php echo e(Str::limit($report->deskripsi, 50)); ?></td>
                    <td class="px-6 py-3">
                        <?php
                            $colors = ['Menunggu' => 'yellow', 'Diproses' => 'blue', 'Selesai' => 'green', 'Dibatalkan' => 'red'];
                            $c = $colors[$report->status] ?? 'gray';
                        ?>
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-<?php echo e($c); ?>-100 text-<?php echo e($c); ?>-700"><?php echo e($report->status); ?></span>
                    </td>
                    <td class="px-6 py-3 text-gray-400 text-xs"><?php echo e($report->created_at->format('d/m/Y H:i')); ?></td>
                    <td class="px-6 py-3 text-center">
                        <form method="POST" action="<?php echo e(route('admin.reports.status', $report)); ?>" class="flex items-center justify-center gap-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <select name="status" class="border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                                <?php $__currentLoopData = ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s); ?>" <?php echo e($report->status === $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="submit" class="bg-sipilah-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada laporan</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        <?php echo e($reports->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/reports.blade.php ENDPATH**/ ?>
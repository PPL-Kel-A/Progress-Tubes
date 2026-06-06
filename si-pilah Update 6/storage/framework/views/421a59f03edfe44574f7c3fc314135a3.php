<?php $__env->startSection('title', 'Data Sampah'); ?>
<?php $__env->startSection('page-title', 'Data Sampah'); ?>
<?php $__env->startSection('page-description', 'Semua data setoran sampah pengguna'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h3 class="font-bold text-gray-800">Data Sampah (<?php echo e($wastes->total()); ?>)</h3>
        <form method="GET" action="<?php echo e(route('admin.wastes')); ?>" class="flex gap-2 flex-wrap">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama, kategori, TPS..." class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none w-48">
            <select name="type" class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                <option value="">Semua Tipe</option>
                <option value="organic" <?php echo e(request('type') === 'organic' ? 'selected' : ''); ?>>Organic</option>
                <option value="inorganic" <?php echo e(request('type') === 'inorganic' ? 'selected' : ''); ?>>Inorganic</option>
            </select>
            <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                <option value="">Semua Status</option>
                <option value="Pending" <?php echo e(request('status') === 'Pending' ? 'selected' : ''); ?>>Pending</option>

                <option value="Diproses" <?php echo e(request('status') === 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                <option value="Selesai" <?php echo e(request('status') === 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                <option value="Dibatalkan" <?php echo e(request('status') === 'Dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-700 transition">🔍 Cari</button>
            <?php if(request('search') || request('type') || request('status')): ?>
                <a href="<?php echo e(route('admin.wastes')); ?>" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">✕</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Tipe</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Berat</th>
                    <th class="px-6 py-3 text-left">TPS</th>
                    <th class="px-6 py-3 text-left">Hasil (L)</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $wastes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50">
                    <td class="px-6 py-3 text-gray-400"><?php echo e($waste->id); ?></td>
                    <td class="px-6 py-3 text-gray-600"><?php echo e($waste->user->name ?? '-'); ?></td>
                    <td class="px-6 py-3 font-medium text-gray-700"><?php echo e($waste->name ?? '-'); ?></td>
                    <td class="px-6 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-bold <?php echo e($waste->type === 'organic' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'); ?>">
                            <?php echo e(ucfirst($waste->type)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-3 text-gray-600"><?php echo e($waste->category); ?></td>
                    <td class="px-6 py-3 text-gray-800 font-semibold"><?php echo e(number_format($waste->weight, 2)); ?> Kg</td>
                    <td class="px-6 py-3 text-gray-600"><?php echo e($waste->tps); ?></td>
                    <td class="px-6 py-3 text-gray-600"><?php echo e(number_format($waste->result, 2)); ?></td>
                    <td class="px-6 py-3">
                        <?php
                            $statusColors = [
                                'Pending'    => 'bg-yellow-100 text-yellow-700',

                                'Diproses'   => 'bg-blue-100 text-blue-700',
                                'Selesai'    => 'bg-green-100 text-green-700',
                                'Dibatalkan' => 'bg-red-100 text-red-700',
                            ];
                            $color = $statusColors[$waste->status] ?? 'bg-gray-100 text-gray-600';
                        ?>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold <?php echo e($color); ?>">
                            <?php echo e($waste->status ?? 'Pending'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-3 text-gray-400 text-xs"><?php echo e($waste->created_at->format('d/m/Y H:i')); ?></td>
                    <td class="px-6 py-3">
                        <div class="flex items-center justify-center gap-2">
                            
                            <form method="POST" action="<?php echo e(route('admin.wastes.status', $waste)); ?>" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none cursor-pointer bg-white hover:bg-gray-50 transition">
                                    <option value="Pending" <?php echo e(($waste->status ?? '') === 'Pending' ? 'selected' : ''); ?>>⏳ Pending</option>

                                    <option value="Diproses" <?php echo e(($waste->status ?? '') === 'Diproses' ? 'selected' : ''); ?>>🔄 Diproses</option>
                                    <option value="Selesai" <?php echo e(($waste->status ?? '') === 'Selesai' ? 'selected' : ''); ?>>✅ Selesai</option>
                                    <option value="Dibatalkan" <?php echo e(($waste->status ?? '') === 'Dibatalkan' ? 'selected' : ''); ?>>❌ Dibatalkan</option>
                                </select>
                            </form>
                            
                            <form method="POST" action="<?php echo e(route('admin.wastes.delete', $waste)); ?>" onsubmit="return confirm('Yakin hapus data sampah ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="11" class="px-6 py-8 text-center text-gray-400">Belum ada data sampah</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        <?php echo e($wastes->links()); ?>

    </div>
</div>

<?php if(session('success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Brief visual feedback
        const msg = document.createElement('div');
        msg.className = 'fixed top-4 right-4 z-50 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-semibold';
        msg.textContent = '<?php echo e(session("success")); ?>';
        document.body.appendChild(msg);
        setTimeout(() => { msg.style.transition = 'opacity 0.5s'; msg.style.opacity = '0'; setTimeout(() => msg.remove(), 500); }, 2500);
    });
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/wastes.blade.php ENDPATH**/ ?>
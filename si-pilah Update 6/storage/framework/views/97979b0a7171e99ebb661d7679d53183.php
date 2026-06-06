<?php $__env->startSection('title', 'Reward'); ?>
<?php $__env->startSection('page-title', 'Kelola Reward'); ?>
<?php $__env->startSection('page-description', 'Tambah dan kelola poin reward pengguna'); ?>

<?php $__env->startSection('content'); ?>


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4">➕ Tambah Reward Baru</h3>
    <form method="POST" action="<?php echo e(route('admin.rewards.store')); ?>" class="flex flex-wrap items-end gap-4">
        <?php echo csrf_field(); ?>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Pilih User</label>
            <select name="user_id" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                <option value="">-- Pilih User --</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->email); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="w-40">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Poin</label>
            <input type="number" name="points" min="1" required placeholder="100" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm">Tambah Reward</button>
    </form>
</div>


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Reward (<?php echo e($rewards->total()); ?>)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Poin</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $rewards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50">
                    <td class="px-6 py-3 text-gray-400"><?php echo e($reward->id); ?></td>
                    <td class="px-6 py-3 font-medium text-gray-700"><?php echo e($reward->user->name ?? '-'); ?></td>
                    <td class="px-6 py-3 text-gray-800 font-bold"><?php echo e(number_format($reward->points)); ?> <span class="text-xs font-normal text-gray-400">Pts</span></td>
                    <td class="px-6 py-3 text-gray-400 text-xs"><?php echo e($reward->created_at->format('d/m/Y H:i')); ?></td>
                    <td class="px-6 py-3 text-center">
                        <form method="POST" action="<?php echo e(route('admin.rewards.delete', $reward)); ?>" onsubmit="return confirm('Yakin hapus reward ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada reward</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        <?php echo e($rewards->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/rewards.blade.php ENDPATH**/ ?>
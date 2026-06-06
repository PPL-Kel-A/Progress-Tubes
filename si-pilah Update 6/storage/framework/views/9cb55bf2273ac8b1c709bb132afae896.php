<?php $__env->startSection('title', 'Pengumuman'); ?>
<?php $__env->startSection('page-title', 'Kelola Pengumuman'); ?>
<?php $__env->startSection('page-description', 'Buat dan kelola pengumuman untuk pengguna'); ?>

<?php $__env->startSection('content'); ?>


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4">➕ Buat Pengumuman Baru</h3>
    <form method="POST" action="<?php echo e(route('admin.announcements.store')); ?>" class="space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Konten Pengumuman</label>
            <textarea name="konten" required rows="3" placeholder="Tulis konten pengumuman di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none"></textarea>
        </div>
        <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm">Publikasikan</button>
    </form>
</div>


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Pengumuman (<?php echo e($announcements->total()); ?>)</h3>
    </div>
    <div class="divide-y divide-gray-50">
        <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="px-6 py-4 hover:bg-gray-50/50 transition" x-data="{ editing: false }">
            
            <div x-show="!editing" class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <p class="text-sm text-gray-700 leading-relaxed"><?php echo e($announcement->konten); ?></p>
                    <p class="text-xs text-gray-400 mt-2">📅 <?php echo e($announcement->created_at->translatedFormat('d F Y, H:i')); ?></p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button @click="editing = true" class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-100 transition">Edit</button>
                    <form method="POST" action="<?php echo e(route('admin.announcements.delete', $announcement)); ?>" onsubmit="return confirm('Yakin hapus pengumuman ini?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                    </form>
                </div>
            </div>

            
            <div x-show="editing" style="display:none;">
                <form method="POST" action="<?php echo e(route('admin.announcements.update', $announcement)); ?>" class="space-y-3">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <textarea name="konten" required rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none"><?php echo e($announcement->konten); ?></textarea>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-sipilah-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Simpan</button>
                        <button type="button" @click="editing = false" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Batal</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="px-6 py-8 text-center text-gray-400">Belum ada pengumuman</div>
        <?php endif; ?>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        <?php echo e($announcements->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/announcements.blade.php ENDPATH**/ ?>
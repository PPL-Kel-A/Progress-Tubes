<?php $__env->startSection('title', 'Jadwal'); ?>
<?php $__env->startSection('page-title', 'Kelola Jadwal'); ?>
<?php $__env->startSection('page-description', 'Atur jadwal penjemputan sampah'); ?>

<?php $__env->startSection('content'); ?>


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4">➕ Tambah Jadwal Baru</h3>
    <form method="POST" action="<?php echo e(route('admin.schedules.store')); ?>" class="flex flex-wrap items-end gap-4">
        <?php echo csrf_field(); ?>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Waktu Jemput</label>
            <input type="datetime-local" name="waktu_jemput" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
            <input type="text" name="kategori" required placeholder="Sampah Plastik" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Petugas</label>
            <input type="text" name="nama_petugas" required placeholder="Truk Tim A" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm">Tambah Jadwal</button>
    </form>
</div>


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Jadwal (<?php echo e($schedules->total()); ?>)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Waktu Jemput</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Petugas</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50" x-data="{ editing: false }">
                    
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-400"><?php echo e($schedule->id); ?></td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-700 font-medium">
                            <?php echo e(\Carbon\Carbon::parse($schedule->waktu_jemput)->translatedFormat('l, d F Y - H:i')); ?>

                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-600"><?php echo e($schedule->kategori); ?></td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-600"><?php echo e($schedule->nama_petugas); ?></td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editing = true" class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-100 transition">Edit</button>
                                <form method="POST" action="<?php echo e(route('admin.schedules.delete', $schedule)); ?>" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </template>

                    
                    <template x-if="editing">
                        <td colspan="5" class="px-6 py-3">
                            <form method="POST" action="<?php echo e(route('admin.schedules.update', $schedule)); ?>" class="flex flex-wrap items-center gap-3">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="datetime-local" name="waktu_jemput" value="<?php echo e(\Carbon\Carbon::parse($schedule->waktu_jemput)->format('Y-m-d\TH:i')); ?>" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                                <input type="text" name="kategori" value="<?php echo e($schedule->kategori); ?>" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Kategori">
                                <input type="text" name="nama_petugas" value="<?php echo e($schedule->nama_petugas); ?>" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Petugas">
                                <button type="submit" class="bg-sipilah-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Simpan</button>
                                <button type="button" @click="editing = false" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Batal</button>
                            </form>
                        </td>
                    </template>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada jadwal</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        <?php echo e($schedules->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/schedules.blade.php ENDPATH**/ ?>
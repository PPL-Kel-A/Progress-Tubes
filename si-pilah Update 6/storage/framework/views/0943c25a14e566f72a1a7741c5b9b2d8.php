<?php $__env->startSection('title', 'Kelola Users'); ?>
<?php $__env->startSection('page-title', 'Kelola Users'); ?>
<?php $__env->startSection('page-description', 'Daftar semua pengguna terdaftar'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h3 class="font-bold text-gray-800">Daftar Users (<?php echo e($users->total()); ?>)</h3>
        <form method="GET" action="<?php echo e(route('admin.users')); ?>" class="flex gap-2">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama atau email..." class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none w-52">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-700 transition">🔍 Cari</button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.users')); ?>" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">✕</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Terdaftar</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50" x-data="{ editing: false }">
                    
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-400"><?php echo e($user->id); ?></td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 font-medium text-gray-700"><?php echo e($user->name); ?></td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-600"><?php echo e($user->email); ?></td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3">
                            <?php if($user->is_admin): ?>
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">Admin</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">User</span>
                            <?php endif; ?>
                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-400 text-xs"><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editing = true" class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-100 transition">Edit</button>
                                <?php if($user->id !== Auth::id()): ?>
                                <form method="POST" action="<?php echo e(route('admin.users.delete', $user)); ?>" onsubmit="return confirm('Yakin hapus user ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </template>

                    
                    <template x-if="editing">
                        <td colspan="6" class="px-6 py-3">
                            <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" class="flex flex-wrap items-center gap-3">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="text" name="name" value="<?php echo e($user->name); ?>" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Nama">
                                <input type="email" name="email" value="<?php echo e($user->email); ?>" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Email">
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="is_admin" <?php echo e($user->is_admin ? 'checked' : ''); ?> class="rounded text-sipilah-600 focus:ring-sipilah-500">
                                    Admin
                                </label>
                                <button type="submit" class="bg-sipilah-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Simpan</button>
                                <button type="button" @click="editing = false" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Batal</button>
                            </form>
                        </td>
                    </template>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada user</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        <?php echo e($users->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/users.blade.php ENDPATH**/ ?>
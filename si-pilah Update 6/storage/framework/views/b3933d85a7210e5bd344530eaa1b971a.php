<?php $__env->startSection('title', 'Edukasi'); ?>
<?php $__env->startSection('page-title', 'Manajemen Edukasi'); ?>
<?php $__env->startSection('page-description', 'Kelola artikel edukasi untuk pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-green-700">Manajemen Edukasi</h2>
        <p class="text-gray-500">
            Tambahkan artikel edukasi berupa PDF + cover
        </p>
    </div>

    <!-- SUCCESS -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- ERROR GLOBAL -->
    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul class="text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>• <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <div class="bg-white p-6 rounded-xl shadow mb-10 border border-green-100">
        <h3 class="text-lg font-semibold mb-4 text-green-700">Upload Artikel</h3>

        <form action="<?php echo e(route('admin.educations.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- TITLE -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Judul Artikel</label>
                <input type="text" name="title"
                    value="<?php echo e(old('title')); ?>"
                    class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-green-400"
                    placeholder="Contoh: Cara Mengelola Sampah">

                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- COVER -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Cover (Opsional)</label>
                <input type="file" name="cover" accept="image/*"
                    class="border p-3 w-full rounded-lg">

                <?php $__errorArgs = ['cover'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- PDF -->
            <div class="mb-4">
                <label class="block font-medium mb-1">File PDF</label>
                <input type="file" name="file_pdf" accept="application/pdf"
                    class="border p-3 w-full rounded-lg">

                <?php $__errorArgs = ['file_pdf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                Upload
            </button>
        </form>
    </div>

    <!-- LIST -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <?php $__empty_1 = true; $__currentLoopData = $educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden border border-gray-100">

                <!-- COVER -->
                <?php if($edu->cover): ?>
                    <img src="<?php echo e(asset('cover/' . $edu->cover)); ?>"
                         class="w-full h-32 object-cover">
                <?php else: ?>
                    <div class="w-full h-32 bg-green-100 flex items-center justify-center text-green-700 text-sm">
                        Tidak ada cover
                    </div>
                <?php endif; ?>

                <div class="p-4">

                    <!-- TITLE -->
                    <h3 class="text-base font-semibold text-gray-800 mb-2 line-clamp-2">
                        <?php echo e($edu->title); ?>

                    </h3>

                    <!-- PDF -->
                    <?php if($edu->file_pdf): ?>
                        <a href="<?php echo e(asset('pdf/' . $edu->file_pdf)); ?>"
                           target="_blank"
                           class="inline-block text-sm font-medium text-green-600 hover:underline">
                            📄 Buka PDF
                        </a>
                    <?php endif; ?>

                    <!-- DATE -->
                    <p class="text-xs text-gray-400 mt-2">
                        <?php echo e($edu->created_at->format('d M Y')); ?>

                    </p>

                    <!-- ACTION -->
                    <div class="flex justify-between items-center mt-4">

                        <!-- EDIT -->
                        <a href="<?php echo e(route('admin.educations.edit', $edu->id)); ?>"
                           class="text-blue-500 text-sm hover:underline">
                            Edit
                        </a>

                        <!-- DELETE -->
                        <form action="<?php echo e(route('admin.educations.delete', $edu->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="text-red-500 text-sm hover:underline">
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-16">
                <div class="text-4xl mb-3">📭</div>
                <p class="text-gray-500">Belum ada artikel edukasi</p>
            </div>
        <?php endif; ?>

    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        <?php echo e($educations->links()); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/admin/educations.blade.php ENDPATH**/ ?>
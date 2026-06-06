<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="max-w-6xl mx-auto px-6 py-10">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-green-800 mb-2">
                📚 Edukasi Lingkungan
            </h1>
            <p class="text-gray-500">
                Pelajari cara menjaga lingkungan dengan artikel pilihan 🌱
            </p>
        </div>

        <!-- LIST -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php $__empty_1 = true; $__currentLoopData = $educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="bg-white rounded-2xl border border-green-100 
                            shadow-sm hover:shadow-xl hover:-translate-y-1 
                            transition duration-300 overflow-hidden">

                    <!-- COVER (FIX UKURAN) -->
                    <?php if($edu->cover): ?>
                        <div class="w-full h-40 bg-green-50 flex items-center justify-center overflow-hidden">
                            <img src="<?php echo e(asset('cover/' . $edu->cover)); ?>"
                                 class="w-full h-full object-cover">
                        </div>
                    <?php else: ?>
                        <div class="w-full h-40 bg-green-50 flex items-center justify-center text-green-600 text-sm">
                            🌿 Tidak ada cover
                        </div>
                    <?php endif; ?>

                    <!-- CONTENT -->
                    <div class="p-5">

                        <!-- TITLE -->
                        <h2 class="text-base font-semibold text-gray-800 mb-2 line-clamp-2">
                            <?php echo e($edu->title); ?>

                        </h2>

                        <!-- DATE -->
                        <p class="text-xs text-gray-400 mb-4">
                            <?php echo e($edu->created_at->format('d M Y')); ?>

                        </p>

                        <!-- BUTTON -->
                        <?php if($edu->file_pdf): ?>
                            <a href="<?php echo e(asset('pdf/' . $edu->file_pdf)); ?>"
                               target="_blank"
                               class="w-full inline-flex items-center justify-center gap-2 text-sm font-semibold 
                                      bg-green-600 text-white px-4 py-2 rounded-lg 
                                      shadow-md hover:bg-green-700 hover:shadow-lg 
                                      active:scale-95 transition duration-200">

                                📄 Baca Artikel
                            </a>
                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <!-- EMPTY STATE -->
                <div class="col-span-full text-center py-20">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-lg font-semibold text-gray-700">
                        Belum ada edukasi
                    </h3>
                    <p class="text-gray-500 mt-2">
                        Konten edukasi akan segera tersedia.
                    </p>
                </div>

            <?php endif; ?>

        </div>

        <!-- PAGINATION -->
        <div class="mt-12">
            <?php echo e($educations->links()); ?>

        </div>
        <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\si-pilah Update 6\resources\views/education/index.blade.php ENDPATH**/ ?>
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
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-green-700 leading-tight">
            Profile
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-lime-100 py-10">

        <!-- HERO SECTION -->
        <div class="max-w-5xl mx-auto mb-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-green-700 via-emerald-600 to-green-500 p-8 shadow-xl">

                <!-- overlay -->
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>

                <div class="relative flex flex-col gap-3 text-white">

                    <!-- Nama -->
                    <h2 class="text-2xl font-bold">
                        Halo, <?php echo e(auth()->user()->name); ?> 👋
                    </h2>

                    <!-- Status (AMAN, NO FAKE DATA) -->
                    <p class="text-sm opacity-90">
                        🌱 Eco Warrior • Mari jaga bumi bersama
                    </p>

                    <!-- Tips -->
                    <p class="text-sm bg-white/20 px-4 py-2 rounded-xl inline-block w-fit backdrop-blur-md">
                        ♻️ Tips: Pisahkan sampah organik & anorganik untuk mempermudah daur ulang
                    </p>

                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="max-w-5xl mx-auto space-y-6">

            <!-- PROFILE CARD -->
            <div class="bg-gradient-to-br from-white to-green-50 rounded-3xl shadow-lg p-6 border border-green-100 hover:shadow-xl transition">
                <h3 class="text-lg font-semibold text-green-700 mb-4">
                    👤 Informasi Profil
                </h3>

                <div class="max-w-xl">
                    <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <!-- PASSWORD CARD -->
            <div class="bg-gradient-to-br from-white to-emerald-50 rounded-3xl shadow-lg p-6 border border-emerald-100 hover:shadow-xl transition">
                <h3 class="text-lg font-semibold text-emerald-700 mb-4">
                    🔒 Keamanan Akun
                </h3>

                <div class="max-w-xl">
                    <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <!-- DELETE CARD -->
            <div class="bg-gradient-to-br from-red-50 to-white rounded-3xl shadow-lg p-6 border border-red-200 hover:shadow-xl transition">
                <h3 class="text-lg font-semibold text-red-600 mb-4">
                    ⚠️ Hapus Akun
                </h3>

                <div class="max-w-xl">
                    <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

        </div>
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
<?php endif; ?><?php /**PATH /Users/710201/Downloads/Progress-Tubes-main-2/si-pilah Update 3/si-pilah/resources/views/profile/edit.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Home -->
    <div class='content'>
        <h2>Home</h2>
        <p>Hello <?php echo e(Auth::user()->full_name); ?></p>
        <p>Welcome to Health Care Management </p>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/HealthCareManagement/laravel-app/resources/views/index.blade.php ENDPATH**/ ?>
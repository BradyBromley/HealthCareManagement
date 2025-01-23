<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Profile -->
    <div class='content'>
        <h2>Profile</h2>
        <div class='accountField'>
            <span class='accountFieldLabel'>First Name</span>
            <span class='accountFieldValue'><?php echo e($user->first_name); ?></span>
        </div>
        
        <div class='accountField'>
            <span class='accountFieldLabel'>Last Name</span>
            <span class='accountFieldValue'><?php echo e($user->last_name); ?></span>
        </div>

        <div class='accountField'>
            <span class='accountFieldLabel'>Address</span>
            <span class='accountFieldValue'><?php echo e($user->address); ?></span>
        </div>

        <div class='accountField'>
            <span class='accountFieldLabel'>City</span>
            <span class='accountFieldValue'><?php echo e($user->city); ?></span>
        </div>

        <div class='accountField'>
            <span class='accountFieldLabel'>Role</span>
            <span id='role' class='accountFieldValue'><?php echo e($user->role->role_name); ?></span>
        </div>

        <!-- Only show if the user being viewed is a physician-->
        <?php if($user->role->role_name == 'physician'): ?>
            <div id='availabilityHTML'>
                <div class='accountField'>
                    <span class='accountFieldLabel'>Start Time</span>
                    <span class='accountFieldValue'><?php echo e(App\Common\Helpers::localTime($user->startTime())->format('h:i A')); ?></span>
                </div>
                <div class='accountField'>
                    <span class='accountFieldLabel'>End Time</span>
                    <span class='accountFieldValue'><?php echo e(App\Common\Helpers::localTime($user->endTime())->format('h:i A')); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <a class='btn btn-secondary' href='<?php echo e(URL::to('users/' . $user->id . '/edit')); ?>'>Edit</a>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/HealthCareManagement/laravel-app/resources/views/users/show.blade.php ENDPATH**/ ?>
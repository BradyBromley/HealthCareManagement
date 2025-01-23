<?php $__env->startSection('title', 'Edit Profile'); ?>

<?php $__env->startSection('content'); ?>
<!-- Edit Profile -->
<div class='content'>
    <div id='user_id' value='<?php echo e($user->id); ?>'></div>
    <h2>Edit Profile</h2>
    <form method='POST' id='editProfileForm' action='<?php echo e(URL::to('users/' . $user->id)); ?>'>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class='form-group formInput'>
            <label for='first_name'>First Name</label>
            <input id='first_name' name='first_name' type='text' class='form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' value='<?php echo e($user->first_name); ?>' placeholder='First Name'>
            <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class='invalid-feedback'><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class='form-group formInput'>
            <label for='last_name'>Last Name</label>
            <input id='last_name' name='last_name' type='text' class='form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' value='<?php echo e($user->last_name); ?>' placeholder='Last Name'>
            <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class='invalid-feedback'><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class='form-group formInput'>
            <label for='address'>Address</label>
            <input id='address' name='address' type='text' class='form-control' value='<?php echo e($user->address); ?>' placeholder='Address'>
        </div>

        <div class='form-group formInput'>
            <label for='city'>City</label>
            <input id='city' name='city' type='text' class='form-control' value='<?php echo e($user->city); ?>' placeholder='City'>
        </div>

        <div class='form-group formInput'>
            <label for='timezone'>Timezone</label>
            <select class='form-select' id='timezone' name='timezone'>
                <?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value='<?php echo e($timezone); ?>' <?php echo e($timezone == $user->timezone ? ' selected' : ''); ?>><?php echo e($timezone); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class='invalid-feedback'><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <?php if(Auth::user()->hasPermissionTo('admin')): ?>
            <div class='form-group formInput'>
                <label for='role_id'>Role</label>
                <select class='form-select' id='role_id' name='role_id'>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role_key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($role->id === $user->role_id): ?>
                        <option value='<?php echo e($role->id); ?>' selected><?php echo e($role->role_name); ?></option>
                    <?php else: ?>
                        <option value='<?php echo e($role->id); ?>'><?php echo e($role->role_name); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        <?php else: ?>
            <div class='form-group formInput' hidden>
                <label for='role_id'>Role</label>
                <select class='form-select' id='role_id' name='role_id'>
                    <option value='<?php echo e($user->role_id); ?>' selected><?php echo e($user->role->role_name); ?></option>
                </select>
            </div>
        <?php endif; ?>

        <!-- Only show if the user being edited is a physician-->
        <div id='start_time_select_list' class='form-group formInput'></div>
        <div id='end_time_select_list' class='form-group formInput'></div>

        <button id='submit' type='submit' class='btn btn-success'>Submit</button>
    </form>

    <script src='/js/editProfile.js'></script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/HealthCareManagement/laravel-app/resources/views/users/edit.blade.php ENDPATH**/ ?>
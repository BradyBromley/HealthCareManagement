<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Login -->
    <div class='content'>
        <h2>Login</h2>
        <form method='POST' id='loginForm' action='<?php echo e(URL::to('auth/login')); ?>'>
            <?php echo csrf_field(); ?>
            <div class='form-group formInput'>
                <label for='email'>Email</label>
                <input id='email' name='email' type='text' class='form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder='Email' value='<?php echo e(old('email')); ?>'>
                <?php $__errorArgs = ['email'];
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
                <label for='password'>Password</label>
                <input id='password' name='password' type='password' class='form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>' placeholder='Password'>
                <?php $__errorArgs = ['password'];
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

            <button id='submit' type='submit' class='btn btn-success'>Submit</button>

            <p>Don't have an account? <a href='<?php echo e(URL::to('auth/register')); ?>'>Sign up now.</a></p>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.authLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/HealthCareManagement/laravel-app/resources/views/auth/login.blade.php ENDPATH**/ ?>
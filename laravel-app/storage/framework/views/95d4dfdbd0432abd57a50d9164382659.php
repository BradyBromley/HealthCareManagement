<?php $__env->startSection('title', 'Book Appointment'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Book Appointment -->
    <div class='content'>
        <h2>Book Appointment</h2>

        <form method='POST' id='bookAppointmentForm' class='needs-validation' action='<?php echo e(URL::to('appointments/')); ?>'>
            <?php echo csrf_field(); ?>

            <!-- Physician List -->
            <div class='form-group formInput'>
                <label for='physician_id'>Physician</label>
                <select class='form-select' id='physician_id' name='physician_id'>
                <?php $__currentLoopData = $physicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $physician_key => $physician): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value='<?php echo e($physician->id); ?>'><?php echo e($physician->full_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Calendar input for selecting appointment date -->
            <div class='form-group formInput'>
                <label for='appointment_date'>Appointment date</label>
                <input id='appointment_date' name='appointment_date' type='date' class='form-control' required/>
            </div>

            <!-- Dropdown input for selecting appointment time -->
            <div id='appointment_time_select_list' class='form-group formInput'></div>

            <div class='form-group formTextArea'>
                <label for='reason'>Reason for appointment</label>
                <textarea id='reason' name='reason' rows='3' class='form-control' placeholder='Enter reason'></textarea>
            </div>

            <div id='submit_button'>
                <button id='submit' type='submit' class='btn btn-success'>Submit</button>
            </div>
        </form>

        <script src='/js/bookAppointment.js'></script>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/HealthCareManagement/laravel-app/resources/views/appointments/create.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Appointments'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Appointments -->
    <div class='content'>
        <h2>Appointments</h2>
        <table class='table table-striped table-bordered sortable appointment_listing'>
            <thead>
                <tr>
                    <!-- Patient ID and name show up for admins and physicians -->
                    <?php if(Auth::user()->hasPermissionTo('physicianAppointmentListing')): ?>
                        <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('patient_id', 'Patient ID'));?></th>
                        <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('patient.full_name', 'Patient Name'));?></th>
                    <?php endif; ?>

                    <!-- Physician ID shows up for admins -->
                    <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                        <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('physician_id', 'Physician ID'));?></th>
                    <?php endif; ?>

                    <!-- Physician name shows up for admins and patients -->
                    <?php if(Auth::user()->hasPermissionTo('patientAppointmentListing')): ?>
                        <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('physician.full_name', 'Physician Name'));?></th>
                    <?php endif; ?>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('start_time', 'Start Time'));?></th>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('end_time', 'End Time'));?></th>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('reason', 'Reason'));?></th>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('status', 'Status'));?></th>

                    <!-- Admins and physicians can change appointment status -->
                    <?php if(Auth::user()->hasPermissionTo('physicianAppointmentListing')): ?>
                        <th>Change Status</th>
                    <?php endif; ?>

                    <th>Cancel Appointment</th>
                </tr>
            </thead>
            <tbody>
                <?php if($appointments->count() == 0): ?>
                    <tr>
                        <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                            <td colspan="10">No appointments to display.</td>
                        <?php elseif(Auth::user()->hasPermissionTo('physicianAppointmentListing')): ?>
                            <td colspan="8">No appointments to display.</td>
                        <?php else: ?>
                            <td colspan="6">No appointments to display.</td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Auth::user()->hasPermissionTo('admin') || (Auth::user()->id == $value->patient_id) || (Auth::user()->id == $value->physician_id)): ?>
                        <tr class='<?php echo e($value->status); ?>'>
                            <!-- Patient ID and name show up for admins and physicians -->
                            <?php if(Auth::user()->hasPermissionTo('physicianAppointmentListing')): ?>
                                <td><?php echo e($value->patient_id); ?></td>
                                <td><?php echo e($value->patient->full_name); ?></td>
                            <?php endif; ?>

                            <!-- Physician ID shows up for admins -->
                            <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                                <td><?php echo e($value->physician_id); ?></td>
                            <?php endif; ?>

                            <!-- Physician name shows up for admins and patients -->
                            <?php if(Auth::user()->hasPermissionTo('patientAppointmentListing')): ?>
                                <td><?php echo e($value->physician->full_name); ?></td>
                            <?php endif; ?>

                            <td><?php echo e(App\Common\Helpers::localDateTime($value->start_time)->format('M j Y, g:i A')); ?></td>
                            <td><?php echo e(App\Common\Helpers::localDateTime($value->end_time)->format('M j Y, g:i A')); ?></td>
                            <td><?php echo e($value->reason); ?></td>
                            <td><?php echo e($value->status); ?></td>

                            <!-- Admins and physicians can change appointment status -->
                            <?php if(Auth::user()->hasPermissionTo('physicianAppointmentListing')): ?>
                                <td><a type='button' class='btn btn-secondary' data-bs-toggle='modal' href='#change_status_modal' data-bs-id='<?php echo e($value->id); ?>' data-status='<?php echo e($value->status); ?>'><i class='fa-solid fa-pen-to-square'></i></a></td>
                            <?php endif; ?>

                            <!-- Appointments can be canceled if the time has not passed -->
                            <?php if(strtotime($value->start_time) > time()): ?>
                                <td><a type='button' class='btn btn-danger' data-bs-toggle='modal' href='#cancel_appointment_modal' data-bs-id='<?php echo e($value->id); ?>'><i class='fa-solid fa-ban'></i></a></td>
                            <?php else: ?>
                                <td></td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php echo e($appointments->links('pagination::bootstrap-5')); ?>


        <!-- Change Status Modal -->
        <div class='modal fade' id='change_status_modal' tabindex='-1' aria-labelledby='change_status_modal_label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='change_status_modal_label'>Change Status</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <select class='form-select'  id='status' name='status'>
                            <option value='Scheduled'>Scheduled</option>
                            <option value='No-Show'>No-Show</option>
                            <option value='Finished'>Finished</option>
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                        <a type='button' id='change_status_button' class='btn btn-success'>Change Status</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancel Appointment Modal -->
        <div class='modal fade' id='cancel_appointment_modal' tabindex='-1' aria-labelledby='cancel_appointment_modal_label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='cancel_appointment_modal_label'>Cancel Appointment</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        Are you sure you want to cancel this appointment?
                    </div>
                    <div class='modal-footer'>
                        <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                        <form method='POST' id='cancel_appointment_form'>
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button id='submit' type='submit' class='btn btn-danger'>Cancel Appointment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src='/js/appointments.js'></script>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/HealthCareManagement/laravel-app/resources/views/appointments/index.blade.php ENDPATH**/ ?>
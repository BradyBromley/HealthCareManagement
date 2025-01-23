<?php $__env->startSection('title', 'Users'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Users -->
    <div class='content'>
        <h2>Users</h2>
        <table class='table table-striped table-bordered sortable userListing'>
            <thead>
                <tr>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('id', 'ID'));?></th>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('first_name', 'First Name'));?></th>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('last_name', 'Last Name'));?></th>
                    <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('email', 'Email'));?></th>
                    <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                        <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('role.role_name', 'Role'));?></th>
                    <?php endif; ?>
                    <th>View</th>
                    <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                        <th>Deactivate</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if($users->count() == 0): ?>
                    <tr>
                        <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                            <td colspan="7">No users to display.</td>
                        <?php else: ?>
                            <td colspan="5">No users to display.</td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Auth::user()->hasPermissionTo('admin') || ($value->role->role_name == 'patient')): ?>
                        <tr>
                            <td><?php echo e($value->id); ?></td>
                            <td><?php echo e($value->first_name); ?></td>
                            <td><?php echo e($value->last_name); ?></td>
                            <td><?php echo e($value->email); ?></td>
                            <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                                <td><?php echo e($value->role->role_name); ?></td>
                            <?php endif; ?>
                            <td><a type='button' class='btn btn-secondary' href='<?php echo e(URL::to('users/' . $value->id)); ?>'><i class='fa-solid fa-newspaper'></i></a></td>
                            <?php if(Auth::user()->hasPermissionTo('admin')): ?>
                                <td><a type='button' class='btn btn-danger' data-bs-toggle='modal' href='#deactivateUserModal' data-bs-id='<?php echo e($value->id); ?>'><i class='fa-solid fa-ban'></i></a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php echo e($users->links('pagination::bootstrap-5')); ?>        

        <!-- Deactivate User Modal -->
        <div class='modal fade' id='deactivateUserModal' tabindex='-1' aria-labelledby='deactivateUserModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='deactivateUserModalLabel'>Deactivate User</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        Are you sure you want to deactivate this user?
                    </div>
                    <div class='modal-footer'>
                        <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                        <form method='POST' id='deactivateUserForm'>
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button id='submit' type='submit' class='btn btn-danger'>Deactivate User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src='/js/users.js'></script>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/HealthCareManagement/laravel-app/resources/views/users/index.blade.php ENDPATH**/ ?>
<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Your Workers</h2>
        <a href="<?= base_url('shopkeeper/workers/add'); ?>" class="btn btn-success">Add New Worker</a>
    </div>

    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact number</th>
                <th>Date of Birth</th>
                <th>Role</th>
                <th>Date of Joining</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($workers)): ?>
                <?php $counter = 1; foreach ($workers as $worker): ?>
                <tr>
                    <td><?= $counter++; ?></td>
                    <td><?= html_escape($worker['user_name']); ?></td>
                    <td><?= html_escape($worker['email']); ?></td>
                    <td><?= html_escape($worker['mobile']); ?></td>
                    <td><?= html_escape($worker['dob']); ?></td>
                    <td><?= html_escape($worker['role']); ?></td>
                    <td><?= html_escape($worker['joined_on']); ?></td>
                    <td>
                        <a href="<?= base_url('shopkeeper/workers/edit/' . $worker['w_id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="<?= base_url('shopkeeper/workers/delete/' . $worker['w_id']); ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this worker?');">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No workers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('layouts/footer'); ?>

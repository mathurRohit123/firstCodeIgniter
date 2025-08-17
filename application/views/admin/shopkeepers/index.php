<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>All Shopkeepers</h2>
        <a href="<?= base_url('admin/shopkeepers/add'); ?>" class="btn btn-success">Add New Shopkeeper</a>
    </div>

    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact number</th>
                <th>Date of birth</th>
                <th>Shop Name</th>
                <th>Registration number</th>
                <th>Location</th>
                <th>Total Workers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($shopkeepers)): ?>
                <?php $count = 1; foreach ($shopkeepers as $shopkeeper): ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= html_escape($shopkeeper['name']); ?></td>
                    <td><?= html_escape($shopkeeper['email']); ?></td>
                    <td><?= html_escape($shopkeeper['mobile']); ?></td>
                    <td><?= html_escape($shopkeeper['dob']); ?></td>
                    <td><?= html_escape($shopkeeper['shop_name']); ?></td>
                    <td><?= html_escape($shopkeeper['reg_id']); ?></td>
                    <td><?= html_escape($shopkeeper['location']); ?></td>
                    <td><?= html_escape($shopkeeper['total_workers']); ?></td>
                    <td>
                        <a href="<?= base_url('admin/shopkeepers/edit/' . $shopkeeper['u_id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        
                        <form action="<?= base_url('admin/shopkeepers/delete/' . $shopkeeper['u_id']); ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this shopkeeper?');">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No shopkeepers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('layouts/footer'); ?>

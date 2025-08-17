<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Your Product Categories</h2>
        <a href="<?= base_url('shopkeeper/categories/add'); ?>" class="btn btn-success">Add New Category</a>
    </div>

    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name of Product Category</th>
                <th>Added On</th>
                <th>Added By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php $counter = 1; foreach ($categories as $category): ?>
                <tr>
                    <td><?= $counter++; ?></td>

                    <td><?= html_escape($category['category_name']); ?></td>

                    <td><?= html_escape($category['added_at']); ?></td>

                    <td><?= html_escape($category['created_by_name']); ?></td>
                    <!-- <td><?= html_escape($category['mobile']); ?></td>
                    <td><?= html_escape($category['dob']); ?></td>
                    <td><?= html_escape($category['role']); ?></td>
                    <td><?= html_escape($category['joined_on']); ?></td> -->
                    <td>
                        <a href="<?= base_url('shopkeeper/categories/edit/' . $category['c_id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="<?= base_url('shopkeeper/categories/delete/' . $category['c_id']); ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No categories found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('layouts/footer'); ?>

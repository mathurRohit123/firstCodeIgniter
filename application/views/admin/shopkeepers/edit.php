<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <h2 class="mt-4">Edit Shopkeeper</h2>
    <hr>
    <?php if (isset($shopkeeper)): ?>
    <form action="<?= base_url('admin/shopkeepers/edit/' . $shopkeeper['u_id']); ?>" method="post">
        
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= html_escape($shopkeeper['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= html_escape($shopkeeper['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value="<?= html_escape($shopkeeper['password']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact number</label>
            <input type="text" name="mobile" class="form-control" value="<?= html_escape($shopkeeper['mobile']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Shop Name</label>
            <input type="text" name="shop_name" class="form-control" value="<?= html_escape($shopkeeper['shop_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Shop Registration ID</label>
            <input type="text" name="reg_id" class="form-control" value="<?= html_escape($shopkeeper['reg_id']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="<?= html_escape($shopkeeper['location']); ?>" required>
        </div>

        <a href="<?= base_url('admin/shopkeepers'); ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-warning">Update Shopkeeper</button>
    </form>
    <?php else: ?>
        <div class="alert alert-danger">Shopkeeper not found.</div>
    <?php endif; ?>
</div>

<?php $this->load->view('layouts/footer'); ?>

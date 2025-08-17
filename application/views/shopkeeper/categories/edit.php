<?php $this->load->view('layouts/header'); 
// print_r($category);
// die();
?>

<div class="container">
    <h2 class="mt-4">Edit category</h2>
    <hr>
    <?php if (isset($category)): ?>
    <form action="<?= base_url('shopkeeper/categories/edit/' . $category['c_id']); ?>" method="post">
        <div class="mb-3">
            <label class="form-label">New name of category</label>
            <input type="text" name="category_name" class="form-control" value="<?= html_escape($category['category_name']); ?>" required>
        </div>

        <!-- <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= html_escape($category['email']); ?>" required>
        </div> -->

        <!-- <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value="<?= html_escape($category['password']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact number</label>
            <input type="text" name="mobile" class="form-control" value="<?= html_escape($category['mobile']); ?>" required>
        </div> -->

        <!-- <div class="mb-3">
            <label class="form-label">Shop Name</label>
            <input type="text" name="shop_name" class="form-control" value="<?= html_escape($category['shop_name']); ?>" required>
        </div> -->
<!-- 
        <div class="mb-3">
            <label class='form-label' for="role">category Role</label>
            <select class='form-select' name="role" id="role" required>
                <option value="Helper" <?= ($category['role'] === 'Helper') ? 'selected' : '' ?> >Helper</option>
                <option value="SalesMan" <?= ($category['role'] === "SalesMan") ? 'selected' : ''?> >SalesMan</option>
            </select>
        </div> -->

        
        <a href="<?= base_url('shopkeeper/categories'); ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-warning">Update category</button>
    </form>
    <?php else: ?>
        <div class="alert alert-danger">Category not found.</div>
    <?php endif; ?>
</div>

<?php $this->load->view('layouts/footer'); ?>


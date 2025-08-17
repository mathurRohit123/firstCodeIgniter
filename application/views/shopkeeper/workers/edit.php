<?php $this->load->view('layouts/header'); 
// print_r($worker);
// die();
?>

<div class="container">
    <h2 class="mt-4">Edit Worker</h2>
    <hr>
    <?php if (isset($worker)): ?>
    <form action="<?= base_url('shopkeeper/workers/edit/' . $worker['w_id']); ?>" method="post">

        <div class="mb-3">
            <input type="hidden" name="worker_id" class="form-control" value="<?= html_escape($worker['worker_id']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= html_escape($worker['user_name']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= html_escape($worker['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value="<?= html_escape($worker['password']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact number</label>
            <input type="text" name="mobile" class="form-control" value="<?= html_escape($worker['mobile']); ?>" required>
        </div>

        <div class="mb-3">
            <label class='form-label' for="role">Worker Role</label>
            <select class='form-select' name="role" id="role" required>
                <option value="Helper" <?= ($worker['role'] === 'Helper') ? 'selected' : '' ?> >Helper</option>
                <option value="SalesMan" <?= ($worker['role'] === "SalesMan") ? 'selected' : ''?> >SalesMan</option>
            </select>
        </div>

        
        <a href="<?= base_url('shopkeeper/workers'); ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-warning">Update worker</button>
    </form>
    <?php else: ?>
        <div class="alert alert-danger">worker not found.</div>
    <?php endif; ?>
</div>

<?php $this->load->view('layouts/footer'); ?>

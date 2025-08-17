<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <h2 class="mt-4">Worker Dashboard</h2>
    <p>Welcome, <?= html_escape($user['name']); ?>!</p>
    <?php if ($worker): ?>
        <h4 class="text-light">Shop: <?= html_escape($worker['shop_name']); ?></h4>
        <p>Your Role: <strong><?= html_escape($worker['role']); ?></strong></p>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Manage Product Categories</div>
                <div class="card-body">
                    <h5 class="card-title"><?= isset($categories_count) ? $categories_count : 'N/A'; ?> Categories</h5>
                    <p class="card-text">You can only view product categories.</p>
                    <a href="<?= base_url('worker/categories'); ?>" class="btn btn-light">View present Categories</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Manage Products</div>
                <div class="card-body">
                    <h5 class="card-title"><?= isset($products_count) ? $products_count : 'N/A'; ?> Products</h5>
                    <p class="card-text">Add or update products in the inventory.</p>
                    <a href="<?= base_url('worker/products'); ?>" class="btn btn-light">Manage Products</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
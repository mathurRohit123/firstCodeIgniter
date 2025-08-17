<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <h2 class="mt-4">Shopkeeper Dashboard</h2>
    <p>Welcome, <?= html_escape($shopkeeper['name']); ?>!</p>
    <?php if ($shop): ?>
        <h4 class="text-light">Shop: <?= html_escape($shop['shop_name']); ?> (<?= html_escape($shop['location']); ?>)</h4><br>
        <h4 class="text-light">Registration ID: <?= html_escape($shop['reg_id']); ?></h4>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Workers</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $workers_count; ?></h5>
                    <p class="card-text">Manage your shop workers.</p>
                    <a href="<?= base_url('shopkeeper/workers'); ?>" class="btn btn-light">Manage Workers</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Product Categories</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $categories_count; ?></h5>
                    <p class="card-text">Organize your products into categories.</p>
                    <a href="<?= base_url('shopkeeper/categories'); ?>" class="btn btn-light">Manage Categories</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $products_count; ?></h5>
                    <p class="card-text">Manage your product inventory.</p>
                    <a href="<?= base_url('shopkeeper/products'); ?>" class="btn btn-light">Manage Products</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
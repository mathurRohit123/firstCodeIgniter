<?php $this->load->view('layouts/header'); 
// print_r($product);
// die();
?>

<div class="container">
    <h2 class="mt-4">Edit product</h2>
    <hr>
    <?php if (isset($product)): ?>
    <form action="<?= base_url('shopkeeper/products/edit/' . $product['p_id']); ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Name of product</label>
            <input type="text" name="name" class="form-control" value="<?= html_escape($product['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New price of product</label>
            <input type="number" step='0.01' name="price" class="form-control" value="<?= html_escape($product['price']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Stock</label>
            <input type="number" name="quantity" class="form-control" value="<?= html_escape($product['quantity']); ?>" required>
        </div>

        <!-- <div class="mb-3">
            <label class="form-label">Contact number</label>
            <input type="text" name="mobile" class="form-control" value="<?= html_escape($product['mobile']); ?>" required>
        </div> -->

        <!-- <div class="mb-3">
            <label class="form-label">Shop Name</label>
            <input type="text" name="shop_name" class="form-control" value="<?= html_escape($product['shop_name']); ?>" required>
        </div> -->
<!-- 
        <div class="mb-3">
            <label class='form-label' for="role">product Role</label>
            <select class='form-select' name="role" id="role" required>
                <option value="Helper" <?= ($product['role'] === 'Helper') ? 'selected' : '' ?> >Helper</option>
                <option value="SalesMan" <?= ($product['role'] === "SalesMan") ? 'selected' : ''?> >SalesMan</option>
            </select>
        </div> -->

        
        <a href="<?= base_url('shopkeeper/products'); ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-warning">Update Product</button>
    </form>
    <?php else: ?>
        <div class="alert alert-danger">Product not found.</div>
    <?php endif; ?>
</div>

<?php $this->load->view('layouts/footer'); ?>

<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Your Shop Products</h2>
        <a href="<?= base_url('shopkeeper/products/add'); ?>" class="btn btn-success">Add New Product</a>
    </div>

    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name of Product</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Product Category</th>
                <th>Added By</th>
                <th>Added On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php $counter = 1; foreach ($products as $product): ?>
                <tr>
                    <td><?= $counter++; ?></td>

                    <td><?= html_escape($product['name']); ?></td>

                    <td><?= html_escape($product['price']); ?></td>

                    <td><?= html_escape($product['quantity']); ?></td>

                    <td><?= html_escape($product['category_name']); ?></td>

                    <td><?= html_escape($product['created_by_name']); ?></td>

                    <td><?= html_escape($product['created_at']); ?></td>

                    <!-- <td><?= html_escape($product['mobile']); ?></td>
                    <td><?= html_escape($product['dob']); ?></td>
                    <td><?= html_escape($product['role']); ?></td>
                    <td><?= html_escape($product['joined_on']); ?></td> -->
                    <td>
                        <a href="<?= base_url('shopkeeper/products/edit/' . $product['p_id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        
                        <form action="<?= base_url('shopkeeper/products/delete/' . $product['p_id']); ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('layouts/footer'); ?>

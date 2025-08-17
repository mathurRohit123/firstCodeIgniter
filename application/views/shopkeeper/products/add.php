<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <h2 class="mt-4">Add New Product</h2>
    <hr>
    <form action="<?= base_url('shopkeeper/products/add'); ?>" method="post">

        <div class="mb-3">
            <label class="form-label">Name of the product</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price of product</label>
            <input type="number" id='price' name="price" step='0.01' class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <!-- <div class="mb-3">
            <label class="form-label">Contact number</label>
            <input type="text" name="mobile" class="form-control" required>
        </div> -->

        <!-- <div class="mb-3">
            <label class="form-label">Gender</label><br>

            <div class="form-check form-check-inline">
                <input class='form-check-input' type="radio" name="gender" id="Male" value='Male' required>
                <label class='form-check-label' for="Male">Male</label>
            </div>

            <div class="form-check form-check-inline">
                <input class='form-check-input' type="radio" name="gender" id="Female" value='Female' required>
                <label class='form-check-label' for="Female">Female</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="dob" class='form-label'>Date of Birth</label>
            <input class='form-control' type="date" name="dob" id="dob" required pattern='\d{4}-\d{2}-\d{2}'>
        </div> -->

        <div class="mb-3">
            <label class='form-label' for="category_id">Select category</label>
            <select name="category_id" class='form-select' id="category_name" required>
                <option value="" disabled selected>Select Category</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['c_id']?>"><?= $category['category_name']?></option>
                <?php endforeach; ?>
            </select>
            
        </div>

        <!-- <div class="mb-3">
            <label for="dob" class='form-label'>Date of Joining</label>
            <input class='form-control' type="date" name="joined_on" id="joined_on" required pattern='\d{4}-\d{2}-\d{2}'>
        </div> -->

        <!-- <div class="mb-3">
            <label class="form-label">Shop Name</label>
            <input type="text" name="shop_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Shop Registration ID</label>
            <input type="text" name="reg_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div> -->

        <a href="<?= base_url('shopkeeper/products'); ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-success">Add product</button>
    </form>
</div>

<?php $this->load->view('layouts/footer'); ?>
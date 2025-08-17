<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <h2 class="mt-4">Add New Shopkeeper</h2>
    <hr>
    <form action="<?= base_url('admin/shopkeepers/add'); ?>" method="post">

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact number</label>
            <input type="text" name="mobile" class="form-control" required>
        </div>

        <div class="mb-3">
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
        </div>

        <div class="mb-3">
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
        </div>

        <a href="<?= base_url('admin/shopkeepers'); ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-success">Add Shopkeeper</button>
    </form>
</div>

<?php $this->load->view('layouts/footer'); ?>

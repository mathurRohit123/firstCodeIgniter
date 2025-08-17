<?php $this->load->view('layouts/header'); ?>

<div class="container">
    <h2 class="mt-4">Admin Dashboard</h2>
    <p>Welcome, <?= $this->session->userdata('name'); ?>!</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Manage Shopkeepers</div>
                <div class="card-body">
                    <p class="card-text">Add, view, update, or remove shopkeepers and their shops.</p>
                    <a href="<?= base_url('admin/shopkeepers'); ?>" class="btn btn-light">Go to Shopkeepers</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Register New User</div>
                <div class="card-body">
                    <p class="card-text">Use the registration form to create new users with specific roles.</p>
                    <a href="<?= base_url('admin/shopkeepers/add'); ?>" class="btn btn-light">Register User</a>
                </div>
            </div>
        </div>
        </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
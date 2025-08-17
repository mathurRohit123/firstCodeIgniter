<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #121212;
            color: #d1d5db; /* Light gray text for better readability */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
        }
        .navbar {
            background-color: #1f2937 !important; /* Darker navy blue */
            border-bottom: 1px solid #374151; /* Dark border */
        }
        .navbar-brand {
            font-weight: 700;
            color: #ffffff;
        }
        .nav-link {
            color: #9ca3af;
        }
        .nav-link:hover {
            color: #ffffff;
        }
        .card {
            background-color: #1f2937;
            border: 1px solid #374151;
            color: #d1d5db;
        }
        .card-header {
            background-color: #374151;
            border-bottom: 1px solid #4b5563;
        }
        .btn-light {
            background-color: #4b5563;
            color: #ffffff;
            border: none;
        }
        .btn-light:hover {
            background-color: #6b7280;
            color: #ffffff;
        }
        .table-dark {
            --bs-table-bg: #1f2937;
            --bs-table-color: #d1d5db;
            --bs-table-border-color: #374151;
        }
        .form-control, .form-select {
            background-color: #374151;
            color: #d1d5db;
            border: 1px solid #4b5563;
        }
        .form-control:focus, .form-select:focus {
            background-color: #4b5563;
            border-color: #60a5fa;
            color: #d1d5db;
            box-shadow: 0 0 0 0.25rem rgba(96, 165, 250, 0.25);
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url(); ?>">
            <?php
            $role = $this->session->userdata('role');
            if ($role === 'Admin') echo 'Admin Dashboard';
            else if ($role === 'Shopkeeper') echo 'Shopkeeper Dashboard';
            else if ($role === 'Worker') echo 'Worker Dashboard';
            else echo 'Welcome';
            ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($this->session->userdata('role') === 'Admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/shopkeepers'); ?>">Shopkeepers</a>
                    </li>
                <?php elseif ($this->session->userdata('role') === 'Shopkeeper'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('shopkeeper/workers'); ?>">Workers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('shopkeeper/categories'); ?>">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('shopkeeper/products'); ?>">Products</a>
                    </li>
                <?php elseif ($this->session->userdata('role') === 'Worker'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('worker/categories'); ?>">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('worker/products'); ?>">Products</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <span class="navbar-text me-3">
                        Welcome, <?= html_escape($this->session->userdata('name')); ?>
                    </span>
                    <a href="<?= base_url('logout/' . $this->session->userdata('u_id')); ?>" class="btn btn-danger">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('login'); ?>" class="btn btn-outline-light">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success mt-3"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger mt-3"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

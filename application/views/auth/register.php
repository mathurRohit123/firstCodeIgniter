<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #121212; color: #fff; }
        .form-control, .form-select { background-color: #1e1e1e; color: #fff; border: 1px solid #555; }
    </style>
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Register New User</h2>
    <form action="<?= base_url('register') ?>" method="post">

        <!-- Basic Details -->

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-select" required>
                <option value="">--Select--</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="dob" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for='role'>Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">--Select Role--</option>
                <option value="Admin">Admin</option>
                <option value="Shopkeeper">Shopkeeper</option>
                <option value="Worker">Worker</option>
            </select>
        </div>

        <!-- Shop Details (Only for Shopkeeper) -->
        <div id="shopFields" style="display:none;">
            <div class="mb-3">
                <label>Shop Name</label>
                <input type="text" name="shop_name" class="form-control">
            </div>
            <div class="mb-3">
                <label>Shop Registration ID</label>
                <input type="text" name="reg_id" class="form-control">
            </div>
            <div class="mb-3">
                <label>Location</label>
                <input type="text" name="location" class="form-control">
            </div>
        </div>

        <!-- Worker Details (Only for Worker) -->
        <div id="workerFields" style="display:none;">
            <div class="mb-3">
                <label>Date of Joining</label>
                <input type="date" name="date_of_joining" class="form-control">
            </div>
            <div class="mb-3">
                <label>Worker Type</label>
                <select name="worker_type" class="form-select">
                    <option value="">--Select--</option>
                    <option value="Helper">Helper</option>
                    <option value="Salesman">Salesman</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Register</button>
    </form>
</div>

<script>
document.getElementById('role').addEventListener('change', function() {
    let shopFields = document.getElementById('shopFields');
    let workerFields = document.getElementById('workerFields');

    shopFields.style.display = 'none';
    workerFields.style.display = 'none';

    if (this.value === 'Shopkeeper') {
        shopFields.style.display = 'block';
    } else if (this.value === 'Worker') {
        workerFields.style.display = 'block';
    }
});
</script>

</body>
</html>

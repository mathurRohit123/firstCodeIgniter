<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register Worker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#0f1720; color:#e6eef8; }
    .card { background:#111827; border:none; color:#fff; }
    .form-control { background:#0b1220; color:#e6eef8; border:1px solid #233044; }
  </style>
</head>
<body>
  <div class="container vh-100 d-flex align-items-center">
    <div class="card p-4 mx-auto" style="width:480px;">
      <h4 class="mb-3">Register Worker</h4>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
      <?php endif; ?>

      <form method="post" action="<?= site_url('shopkeeper/register-worker') ?>">
        <div class="mb-2">
          <input class="form-control" type="text" name="name" placeholder="Full name" required>
        </div>
        <div class="mb-2">
          <input class="form-control" type="email" name="email" placeholder="Email" required>
        </div>
        <div class="mb-2">
          <input class="form-control" type="text" name="mobile" placeholder="Mobile" required>
        </div>
        <div class="mb-2">
          <select class="form-select" name="gender" required>
            <option value="">Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label small">Date of Birth</label>
          <input class="form-control" type="date" name="dob" required>
        </div>
        <div class="mb-2">
          <label class="form-label small">Date of Joining</label>
          <input class="form-control" type="date" name="date_of_joining" required>
        </div>
        <div class="mb-2">
          <select class="form-select" name="worker_type" required>
            <option value="">Worker Type</option>
            <option value="Helper">Helper</option>
            <option value="Salesman">Salesman</option>
          </select>
        </div>

        <!-- optional: shop_id if you want to override session's shop id -->
        <div class="mb-2">
          <input class="form-control" type="text" name="shop_id" placeholder="Shop ID (optional)">
        </div>

        <div class="mb-2">
          <input class="form-control" type="password" name="password" placeholder="Password (set for worker login)" required>
        </div>

        <div class="d-grid">
          <button class="btn btn-primary" type="submit">Create Worker</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

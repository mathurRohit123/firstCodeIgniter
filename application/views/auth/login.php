<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>

  <!-- Bootstrap CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background:#0f1720; color:#e6eef8; }
    .card { background:#111827; border: none; border-radius:12px; }
    .form-control { background:#0b1220; color:#e6eef8; border: 1px solid #233044; }
    .btn-primary { background:#2563eb; border: none; }
    .card-title { color:#fff; }
    a { color:#9fbff5; }
  </style>
</head>
<body>
  <div class="container d-flex vh-100">
    <div class="row justify-content-center align-self-center w-100">
      <div class="col-sm-10 col-md-6 col-lg-4">
        <div class="card p-4 shadow-sm">
          <h4 class="card-title text-center mb-3">Sign in</h4>

          <!-- galat request par div bana rehata tha is this one only -->
          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger small"><?= $this->session->flashdata('error') ?></div>
          <?php endif; ?>

          <form method="post" action="<?= base_url('login') ?>">
            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="d-grid mb-2">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="text-center">
              <small>Need an account? <a href="<?= base_url('/register') ?>">Sign up</a></small>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Logout</title>

  <!-- Bootstrap CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background:#0f1720; color:#e6eef8; }
    .card { background:#111827; border: none; border-radius:12px; }
    .btn-primary { background:#2563eb; border: none; }
    .card-title { color:#fff; }
    a { color:#9fbff5; }
  </style>
</head>
<body>
  <div class="container d-flex vh-100">
    <div class="row justify-content-center align-self-center w-100">
      <div class="col-sm-10 col-md-6 col-lg-4">
        <div class="card p-4 shadow-sm text-center">
          <h4 class="card-title mb-3">You have been logged out</h4>

          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success small"><?= $this->session->flashdata('success') ?></div>
          <?php endif; ?>

          <p class="mb-4">Thank you for visiting. Click below to log in again.</p>

          <a href="<?= base_url('login') ?>" class="btn btn-primary w-100">Go to Login</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Завдання та проекти | Вхід</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="static/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="static/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="static/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="index.php" class="h1">Завдання та проекти</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Увійдіть для доступу до своїх задач</p>

        <form action="authorization.php" method="post">
          <div class="input-group mb-3">
            <input name="login" type="email" placeholder="Email" class="form-control
            <?= !empty($input_errors['login']) ? ' is-invalid' : ''?>" 
            value="<?=htmlspecialchars($myinputs['login'])?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <?= !empty($input_errors['login']) ?
                  '<span id="login_Er" class="error invalid-feedback">' .
                  htmlspecialchars($input_errors['login']) . '</span>'
                  : ''
            ?>
          </div>
          <div class="input-group mb-3">
            <input name="password" type="password" placeholder="Password" class="form-control
            <?= !empty($input_errors['password']) || !empty($input_errors['checkpassword']) ? ' is-invalid' : ''?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <?= !empty($input_errors['password']) ?
                  '<span id="pass_Er" class="error invalid-feedback">' .
                  htmlspecialchars($input_errors['password']) . '</span>'
                  : ''
            ?>
            <?= empty($input_errors['password']) && !empty($input_errors['checkpassword']) ?
                  '<span id="checkpass_Er" class="error invalid-feedback">' .
                  htmlspecialchars($input_errors['checkpassword']) . '</span>'
                  : ''
            ?>
          </div>
          <div class="row">
            <div class="col-4 offset-4">
              <button name="login_btn" type="submit" class="btn btn-primary btn-block">Вхід</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-0">
          <a href="register.php" class="text-center">Зареєструватися</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>

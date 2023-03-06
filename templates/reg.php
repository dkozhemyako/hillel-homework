<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Завдання та проекти | Реєстрація нового користувача</title>

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

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="index.php" class="h1">Завдання та проекти</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Зареєструватися</p>

        <form action="register.php" method="post">
          <div class="input-group mb-3">
            <input name="reg_name" type="text" placeholder="Повне ім'я" class="form-control
            <?= !empty($input_errors['reg_name']) ? ' is-invalid' : ''?>" 
            value="<?=htmlspecialchars($myinputs['reg_name'])?>">

            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <?= !empty($input_errors['reg_name']) ?
                  '<span id="reg_name_Er" class="error invalid-feedback">' .
                  htmlspecialchars($input_errors['reg_name']) . '</span>'
                  : ''
            ?>
          </div>
          <div class="input-group mb-3">
            <input name="reg_email" type="email" placeholder="Email" class="form-control
            <?= !empty($input_errors['reg_email']) ? ' is-invalid' : ''?>"
            value="<?=htmlspecialchars($myinputs['reg_email'])?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <?= !empty($input_errors['reg_email']) ?
                  '<span id="reg_email_Er" class="error invalid-feedback">' .
                  htmlspecialchars($input_errors['reg_email']) . '</span>'
                  : ''
              ?>
          </div>
          <div class="input-group mb-3">
            <input name="reg_password" type="password" placeholder="Пароль" class="form-control
            <?= !empty($input_errors['reg_password']) ? ' is-invalid' : ''?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <?= !empty($input_errors['reg_password']) ?
                  '<span id="reg_password_Er" class="error invalid-feedback">' .
                  htmlspecialchars($input_errors['reg_password']) . '</span>'
                  : ''
              ?>
          </div>
          <div class="input-group mb-3">
            <input name="reg_password_check" type="password" placeholder="Повторіть пароль" class="form-control
            <?= !empty($input_errors['reg_password_check']) ? ' is-invalid' : ''?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <?= !empty($input_errors['reg_password_check']) ?
                  '<span id="reg_password_check_Er" class="error invalid-feedback">' .
                  htmlspecialchars($input_errors['reg_password_check']) . '</span>'
                  : ''
              ?>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="icheck-primary">
                <input name="reg_agreTerms" type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms" 
                <?= !empty($input_errors['reg_agreTerms']) ? 'style="color: red;"' : ''?>
                >
                <?= !empty($input_errors['reg_agreTerms']) ? htmlspecialchars($input_errors['reg_agreTerms']) : 'Я згоден(а) з '?>
                  <a href="#">умовами</a>
                </label>

              </div>
            </div>
            <!-- /.col -->
          </div>
          
          <div class="row">
            <div class="col-8 offset-2">
              <div style="color: grey; text-align: center; "> 
                <?= !empty($input_errors['error']) ? htmlspecialchars($input_errors['error']) : ''?>
              </div>
                <button name="reg_btn" type="submit" class="btn btn-primary btn-block">Зареєструватися</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="authorization.php" class="text-center">В мене вже є аккаунт</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>

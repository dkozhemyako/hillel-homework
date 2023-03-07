
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h1>Додати проект</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Додати проект</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <form action="add-proj.php" method="post">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">General</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName">Назва проекту</label>
                    <input name="inputName" type="text" id="inputName" class="form-control
                    <?= !empty($input_errors['inputName']) ? ' is-invalid' : ''?>"
                    value="<?=htmlspecialchars($myinputs['inputName'])?>">
                    <?= !empty($input_errors['inputName']) ?
                    '<span id="inputNameEr" class="error invalid-feedback">' .
                    htmlspecialchars($input_errors['inputName']) . '</span>'
                    : ''?>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <a href="index.php" class="btn btn-secondary">Відмінити</a>
              <input name="btn_project_add" type="submit" value="Створити новий проект" class="btn btn-success">
            </div>
          </div>
        </form>
      </section>
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h1>Додати завдання</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Додати завдання</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <form action="add.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Основні</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputName">Назва задачі</label>
                    <input type="text" id="inputName" name="inputName" class="form-control 
                    <?= !empty($input_errors['inputName']) ? ' is-invalid' : ''?>" 
                    value="<?=htmlspecialchars($myinputs['inputName'])?>">
                    <?= !empty($input_errors['inputName']) ?
                    '<span id="inputNameEr" class="error invalid-feedback">' .
                    htmlspecialchars($input_errors['inputName']) . '</span>'
                    : ''?>
                  </div>
                  <div class="form-group">
                    <label for="inputDescription">Опис задачі</label>
                    <textarea id="inputDescription" name="inputDescription" class="form-control
                    <?= !empty($input_errors['inputDescription']) ? ' is-invalid' : ''?>"rows="4">
                    <?=htmlspecialchars($myinputs['inputDescription'])?></textarea>
                    <?= !empty($input_errors['inputDescription']) ?
                    '<span id="inputDescriptionEr" class="error invalid-feedback">' .
                    htmlspecialchars($input_errors['inputDescription']) . '</span>'
                    : ''?>
                  </div>
                  <div class="form-group">
                    <label for="selectProject">Оберіть проект</label>
                    <select class="form-control 
                    <?= !empty($input_errors['selectProject']) ? ' is-invalid' : ''?>"
                    id="selectProject" name="selectProject">
                    <option></option>
                    
                    <?php foreach ($drop_projects as $project) : ?>
                      <option value="<?= htmlspecialchars($project['id'])?>" 
                         <?=$project['id'] == $myinputs['selectProject'] ? ' selected' : '' ?>>
                         <?= htmlspecialchars($project['name'])?></option>   
                    <?php endforeach; ?>

                    </select>
                    <?= !empty($input_errors['selectProject']) ?
                    '<span id="selectProjectEr" class="error invalid-feedback">' .
                    htmlspecialchars($input_errors['selectProject']) . '</span>'
                    : ''?>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <div class="col-md-6">
              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Додаткові</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="inputDate">Дата виконання</label>
                    <input type="date" id="inputDate" name="inputDate" class="form-control  

                    <?= !empty($input_errors['inputDate']) ? ' is-invalid' : '' ?>" 
                
                    value ="<?=htmlspecialchars($myinputs['inputDate'])?>">

                    <?= !empty($input_errors['inputDate']) ?
                    '<span id="inputDateEr" class="error invalid-feedback">' .
                    htmlspecialchars($input_errors['inputDate']) . '</span>'
                    : ''?>
                  </div>
                  <div class="form-group">
                    <label for="inputTaskFile">Прикріпити файл</label>
                    <input type="file" id="inputTaskFile" name="inputTaskFile" class="form-control">
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <a href="#" class="btn btn-secondary">Cancel</a>
              <input type="submit" value="Create new Task" class="btn btn-success" name="btn_task_add">
            </div>
          </div>
        </form>
      </section>
    </div>


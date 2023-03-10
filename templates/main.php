<div class="content-wrapper kanban">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h1>Назва проекту</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Назва проекту</li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <div class="row">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">

                  <a type="button" href="index.php?id=<?=$id?>&filter=all"
                  class="<?=$active_filter == 'all' ? 'btn btn-secondary active' : 'btn btn-default'?>">
                  Усі завдання</a>

                  <a type="button" href="index.php?id=<?=$id?>&filter=today"
                  class="<?=$active_filter == 'today' ? 'btn btn-secondary active' : 'btn btn-default'?>">
                  Порядок денний</a>

                  <a type="button" href="index.php?id=<?=$id?>&filter=tomorrow"
                  class="<?=$active_filter == 'tomorrow' ? 'btn btn-secondary active' : 'btn btn-default'?>">
                  Завтра</a>

                  <a type="button" href="index.php?id=<?=$id?>&filter=overdue"
                  class="<?=$active_filter == 'overdue' ? 'btn btn-secondary active' : 'btn btn-default'?>">
                  Прострочені</a>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="content pb-3">
        <div class="container-fluid h-100">
          <div class="card card-row card-secondary">
            <div class="card-header">
              <h3 class="card-title">
                Беклог
              </h3>
            </div>
            <div class="card-body connectedSortable" data-status="backlog">
         
          <?php foreach ($tasks as $task) : ?>
              <?php if ($task['status'] === 'back-log') : ?>
                    <?=renderTemplate('card.php', ['task' => $task])?>
              <?php endif; ?>
          <?php endforeach; ?>
          
  
            </div>
          </div>
          <div class="card card-row card-primary">
            <div class="card-header">
              <h3 class="card-title">
                Зробити
              </h3>
            </div>
            <div class="card-body connectedSortable" data-status="to-do">
              
          <?php foreach ($tasks as $task) : ?>
                <?php if ($task['status'] === 'to-do') : ?>
                      <?=renderTemplate('card.php', ['task' => $task])?>
                <?php endif; ?>
          <?php endforeach; ?>

            </div>
          </div>
          <div class="card card-row card-default">
            <div class="card-header bg-info">
              <h3 class="card-title">
                В процесі
              </h3>
            </div>
            <div class="card-body connectedSortable" data-status="in-progress">
              
          <?php foreach ($tasks as $task) : ?>
                  <?php if ($task['status'] === 'in-progress') : ?>
                         <?=renderTemplate('card.php', ['task' => $task])?>
                  <?php endif; ?>
          <?php endforeach; ?>

            </div>
          </div>
          <div class="card card-row card-success">
            <div class="card-header">
              <h3 class="card-title">
                Готово
              </h3>
            </div>
            <div class="card-body connectedSortable" data-status="done">
              
          <?php foreach ($tasks as $task) : ?>
                    <?php if ($task['status'] === 'done') : ?>
                        <?=renderTemplate('card.php', ['task' => $task])?>
                    <?php endif; ?>
          <?php endforeach; ?>

            </div>
          </div>
        </div>
      </section>
    </div>
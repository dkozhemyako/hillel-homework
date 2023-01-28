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
                  <a type="button" href="#" class="btn btn-secondary active">Усі завдання</a>
                  <a type="button" href="#" class="btn btn-default">Порядок денний</a>
                  <a type="button" href="#" class="btn btn-default">Завтра</a>
                  <a type="button" href="#" class="btn btn-default">Прострочені</a>
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
            <?=$card_backlog?>
          </div>
          <div class="card card-row card-primary">
            <div class="card-header">
              <h3 class="card-title">
                Зробити
              </h3>
            </div>
            <div class="card-body connectedSortable" data-status="to-do">
            <?=$card_to_do?>
            </div>
          </div>
          <div class="card card-row card-default">
            <div class="card-header bg-info">
              <h3 class="card-title">
                В процесі
              </h3>
            </div>
            <div class="card-body connectedSortable" data-status="in-progress">
            <?=$card_in_progress?>
            </div>
          </div>
          <div class="card card-row card-success">
            <div class="card-header">
              <h3 class="card-title">
                Готово
              </h3>
            </div>
            <div class="card-body connectedSortable" data-status="done">
            <?=$card_done?>
            </div>
          </div>
        </div>
      </section>
    </div>
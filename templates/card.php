            <div class="card card-info card-outline" data-task-id=<?=htmlspecialchars($task['id'])?>>
                <div class="card-header">
                  <h5 class="card-title"><?=htmlspecialchars($task['name'])?></h5>
                  <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-link">#<?=htmlspecialchars($task['id'])?></a>
                    <a href="#" class="btn btn-tool">
                      <i class="fas fa-pen"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <p>
                    <?=htmlspecialchars($task['body'])?>
                  </p>
                  <a href="<?=htmlspecialchars($task['data_set'])?>" class="btn btn-tool">
                    <i class="fas fa-file"></i>
                  </a>
                  <?php if (!empty($task['date_deadline'])) : ?>
                  <small class="badge badge-<?=htmlspecialchars(differenceDateH($task['date_deadline'])['badge'])?>">
                    <i class="far fa-clock"></i>
                        <?=htmlspecialchars(differenceDateH($task['date_deadline'])['calc'])?>
                  </small>

                  <?php endif; ?>

                  </div>
              </div>
              
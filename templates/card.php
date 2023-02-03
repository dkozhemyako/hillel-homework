            <div class="card card-info card-outline" data-task-id=<?=$task['id']?>>
                <div class="card-header">
                  <h5 class="card-title"><?=htmlentities($task['header'])?></h5>
                  <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-link">#3</a>
                    <a href="#" class="btn btn-tool">
                      <i class="fas fa-pen"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <p>
                    <?=htmlentities($task['body'])?>
                  </p>
                  
                  <small <?php if(empty($task['deadline_date'])){echo 'style="display:none"';}?> class="badge badge-<?=differenceDateH($task['deadline_date'])['badge'];?>"><i class="far fa-clock"></i><?=" ".differenceDateH($task['deadline_date'])['calc'];?></small>
                </div>
              </div>
            
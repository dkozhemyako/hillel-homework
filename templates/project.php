<li class="nav-item">
    <a href="index.php?id=<?=$project['id']?>" class="nav-link<?=$project['active'] === true ? ' active' : ''?>">
        <i class="nav-icon fas fa-columns"></i>
        <p>
        <?=htmlentities($project['name_project'])?>
        <span class="badge badge-info right"><?=$project['count_task_in_project']?></span>
        </p>
    </a>
</li>
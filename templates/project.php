<li class="nav-item">
    <a href="index.php?id=<?=htmlspecialchars($project['id'])?>" class="nav-link <?=$activProject === $project['id'] ? ' active' : ''?>">
        <i class="nav-icon fas fa-columns"></i>
        <p>
        <?=htmlspecialchars($project['name'])?>
        <span class="badge badge-info right"><?=htmlspecialchars($project['count'])?></span>
        </p>
    </a>
</li>
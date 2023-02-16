<li class="nav-item">
    <a href="index.php?id=<?=$project['id']?>" class="nav-link">
        <i class="nav-icon fas fa-columns"></i>
        <p>
        <?=htmlentities($project['name'])?>
        <span class="badge badge-info right"><?=$project['count']?></span>
        </p>
    </a>
</li>
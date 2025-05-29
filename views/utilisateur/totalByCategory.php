<h2><?= htmlspecialchars($title) ?></h2>
<ul>
    <?php foreach ($totalCategory as $cat): ?>
        <li>
            <?= htmlspecialchars($cat['categorieType']) ?> : <?= htmlspecialchars($cat['totalMontant']) ?> €
        </li>
    <?php endforeach; ?>
</ul>
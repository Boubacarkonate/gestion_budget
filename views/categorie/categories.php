<h1><?= htmlspecialchars($title) ?></h1>
<ul>
    <?php foreach ($categories as $cat) : ?>
        <p> le nom de catégorie est <?= $cat['type'] ?> </p>
    <?php endforeach; ?>
    <?php foreach ($items as $cat) : ?>
        <p> le nom de item est <?= $cat['nom'] ?> : <?= $cat['montant'] ?></p>
    <?php endforeach; ?>
</ul>
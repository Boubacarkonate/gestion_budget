<h2><?= htmlspecialchars($title) ?></h2>

<ul>
    <?php foreach ($data as $element) : ?>
        <li>
            <h3><?= $element['category'] ?></h3>
            <?php foreach ($element['item_list'] as $elementListeItem) : ?>
                <p><?= $elementListeItem['nomDeItem'] ?> : <?= $elementListeItem['montantItem'] ?></p>
            <?php endforeach  ?>
        </li>
    <?php endforeach  ?>
</ul>
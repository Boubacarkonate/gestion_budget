<h2><?= htmlspecialchars($title) ?></h2>

<?php if (empty($items)) : ?>
    <p>Aucun item trouvé pour cet utilisateur.</p>
<?php else : ?>
    <ul>
        <?php foreach ($items as $item): ?>
            <li>
                <?= htmlspecialchars($item['item_nom']) ?> : <?= number_format($item['item_montant'], 2) ?> €
            </li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Total général :</strong> <?= number_format($totalGeneral, 2) ?> €</p>
<?php endif; ?>
<h1><?= htmlspecialchars($title) ?></h1>
<?php var_dump($totalByCategoryItems); ?>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?= htmlspecialchars($user['nom']) ?> - <?= htmlspecialchars($user['email']) ?>
            |
            <a href="/gestion_budget/public/utilisateur/update/<?= $user['id'] ?>">Modifier</a>
            |
            <a href="/gestion_budget/public/utilisateur/delete/<?= $user['id'] ?>">Supprimer</a>
            <a href="/gestion_budget/public/utilisateur/visionGeneral/<?= $user['id'] ?>">compte</a>
        </li>
    <?php endforeach; ?>
</ul>

<div>
    <a href="/gestion_budget/public/utilisateur/create">Créer un utilisateur</a>
</div>
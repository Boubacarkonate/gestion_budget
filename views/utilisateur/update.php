<h2><?= htmlspecialchars($title) ?></h2>

<form method="post">
    <input type="hidden" name="<?= htmlspecialchars($user['id']) ?>">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
    <br>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    <br>

    <label for="password">Mot de passe (laisser vide pour ne pas changer) :</label>
    <input type="password" name="password" id="password" value="<?= htmlspecialchars($user['password']) ?>">
    <br>

    <button type="submit">Mettre à jour</button>
</form>
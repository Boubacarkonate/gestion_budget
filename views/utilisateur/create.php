<h2><?= htmlspecialchars($title) ?></h2>

<form action="" method="post">
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Envoyer</button>
</form>
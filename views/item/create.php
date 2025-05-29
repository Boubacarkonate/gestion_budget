<form action="/items/create" method="POST">
    <label for="nom">Nom de l'item :</label>
    <input type="text" id="nom" name="nom" required>

    <label for="montant">Montant :</label>
    <input type="number" step="0.01" id="montant" name="montant" required>

    <label for="categorie_id">Catégorie :</label>
    <select id="categorie_id" name="categorie_id" required>
        <!-- Ici tu mets les options categories, par ex: -->
        <option value="1">Revenus</option>
        <option value="2">Dépenses fixes</option>
        <option value="2">Dépenses variable</option>
        <!-- Génère ça dynamiquement dans la vue -->
    </select>

    <button type="submit">Ajouter l’item</button>
</form>
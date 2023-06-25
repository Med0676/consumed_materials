<?php
require_once 'config.php';

// Connect to the database
$connection = mysqli_connect('localhost', 'root', '', 'material_monitoring_db');

// Check the connection
if (!$connection) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Check if the form is submitted to add a material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_material'])) {
    $materialName = $_POST['material_name'];
    $quantity = $_POST['quantity'];

    // Insert the material into the database
    $query = "INSERT INTO materials (material_name, quantity) VALUES ('$materialName', $quantity)";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<script>alert('Matériel ajouté avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors de l'ajout du matériel : " . mysqli_error($connection). "');</script>";
    }
}

// Check if the form is submitted to record consumed material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_consumed'])) {
    $materialId = $_POST['material'];
    $quantityConsumed = $_POST['quantity_consumed'];
    $dateConsumed = $_POST['date_consumed'];

    // Insert the consumed material into the database
    $query = "INSERT INTO consumed_materials (material_id, quantity_consumed, date_consumed) VALUES ($materialId, $quantityConsumed, '$dateConsumed')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<script>alert('Matériel enregistré avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors de l'enregistrement de la consommation : " . mysqli_error($connection) . "');</script>";
    }
}

// Retrieve the list of materials for the dropdowns
$query = "SELECT * FROM materials";
$materialResult = mysqli_query($connection, $query);

// Close the database connection
mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Système de surveillance des matériaux - Accueil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Système de surveillance des matériaux</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="availability.php">Disponibilité des matériaux</a></li>
            <li><a href="consumed_materials.php">Liste des matériaux consommés</a></li>
        </ul>
    </nav>
    <section>
        <h2>Ajouter un matériau</h2>
        <form id="addMaterialForm" method="POST">
            <label for="material_name">Nom du matériau :</label>
            <input type="text" name="material_name" id="material_name" required><br><br>
            <label for="quantity">Quantité :</label>
            <input type="number" name="quantity" id="quantity" required><br><br>
            <button type="submit" name="add_material">Ajouter un matériau</button>
        </form>
    </section>
    <section>
        <h2>Enregistrer un matériau consommé</h2>
        <form id="recordConsumedForm" method="POST">
            <label for="material">Matériau :</label>
            <select name="material" id="material" required>
            <option value="select">sélectionner</option>

                <?php while ($row = mysqli_fetch_assoc($materialResult)) : ?>
                    <option value="<?php echo $row['material_id']; ?>"><?php echo $row['material_name']; ?></option>
                <?php endwhile; ?>
            </select> <br><br>
            <label for="quantity_consumed">Quantité consommée :</label>
            <input type="number" name="quantity_consumed" id="quantity_consumed" required><br><br>
            <label for="date_consumed">Date de consommation :</label>
            <input type="date" name="date_consumed" id="date_consumed" required><br><br>
            <button type="submit" name="record_consumed">Enregistrer le matériau consommé</button>
        </form>
    </section>
    <footer>
    <p>© 2023 Système de surveillance des matériaux. BY ZAHIRA GUELLABI.</p>
    </footer>
</body>
</html>

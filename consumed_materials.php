<?php
require_once 'config.php';

// Check if the form is submitted to record consumed material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_consumed'])) {
    $materialId = $_POST['material'];
    $quantityConsumed = $_POST['quantity_consumed'];
    $dateConsumed = $_POST['date_consumed'];

    // Insert the consumed material into the database
    $query = "INSERT INTO consumed_materials (material_id, quantity_consumed, date_consumed)
              VALUES ('$materialId', '$quantityConsumed', '$dateConsumed')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Matériau consommé enregistré avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement du matériau consommé : " . mysqli_error($connection);
    }
}

// Check if the form is submitted to delete a consumed material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_consumed_material'])) {
    $consumedMaterialId = $_POST['material_id'];

    // Delete the consumed material from the database
    $query = "DELETE FROM consumed_materials WHERE material_id = $consumedMaterialId";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<script>alert('Matériau consommé supprimé avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression du matériau consommé : " . mysqli_error($connection) . "');</script>";
    }
}

// Get the list of consumed materials
$query = "SELECT c.*, m.material_name
          FROM consumed_materials c
          JOIN materials m ON c.material_id = m.material_id";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Système de surveillance des matériaux - Liste des matériaux consommés</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
    footer{
    margin-top:12cm;
    
}
button {
  background-color: #333;
  color: #fff;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
}

button:hover {
  background-color: #555;
}
</style>
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
        <h2>Liste des matériaux consommés</h2>
        <table>
            <tr>
                <th>Matériau</th>
                <th>Quantité consommée</th>
                <th>Date de consommation</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['material_name']; ?></td>
                    <td><?php echo $row['quantity_consumed']; ?></td>
                    <td><?php echo $row['date_consumed']; ?></td>
                    <td>
                        <form class="delete-form" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce matériau consommé ?')">
                            <input type="hidden" name="material_id" value="<?php echo $row['material_id']; ?>">
                            <button type="submit" name="delete_consumed_material">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
    <footer>
        <p>© 2023 Système de surveillance des matériaux. BY ZAHIRA GUELLABI.</p>
    </footer>
</body>
</html>

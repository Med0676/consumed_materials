<?php
require_once 'config.php';

// Connect to the database
$connection = mysqli_connect('localhost', 'root', '', 'material_monitoring_db');

// Check the connection
if (!$connection) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Check if the form is submitted to delete a material
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_material'])) {
    $materialId = $_POST['material_id'];

    // Delete the material from the database
    $query = "DELETE FROM materials WHERE material_id = $materialId";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<script>alert('Matériau supprimé avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression du matériau : " . mysqli_error($connection) . "');</script>";
    }
}

// Retrieve the list of materials
$query = "SELECT * FROM materials";
$result = mysqli_query($connection, $query);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Système de surveillance des matériaux - Disponibilité des matériaux</title>
</head>
<style>
    /* Styles for Material Availability page */
section {
  margin-top: 20px;
}
footer{
    margin-top:10cm
}
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

header {
  background-color: #333;
  color: #fff;
  padding: 20px;
}

h1 {
  margin: 0;
}

nav {
  background-color: #f2f2f2;
  padding: 10px;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

li {
  display: inline;
  margin-right: 10px;
}

a {
  color: #333;
  text-decoration: none;
}

section {
  margin: 20px;
}

h2 {
  color: #333;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
  color: #333;
}

form {
  margin-bottom: 10px;
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
        <h2>Disponibilité des matériaux</h2>
        <table>
            <tr>
                <th>Matériau</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['material_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce matériau ?')">
                            <input type="hidden" name="material_id" value="<?php echo $row['material_id']; ?>">
                            <button type="submit" name="delete_material">Supprimer</button>
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
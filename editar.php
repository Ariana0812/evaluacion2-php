<?php

try {
    $conexion = new PDO("mysql:host=localhost;dbname=gestion_usuarios", "root", "");
} catch(PDOException $error) {
    echo "Error: " . $error->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];

    
    if (!empty($nombre) && !empty($correo)) {
        
        $query = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $statement = $conexion->prepare($query);
        $statement->execute([
            'nombre' => $nombre,
            'email' => $correo,
            'id' => $id
        ]);
        header("Location: index.php"); 
    }
} else {
    
    if (isset($_GET['editar'])) {
        $idEditar = $_GET['editar'];

        
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $statement = $conexion->prepare($query);
        $statement->execute(['id' => $idEditar]);
        $usuario = $statement->fetch();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Editar Usuario</title>
</head>
<body>
  <h1>Editar Usuario</h1>

  <form action="editar.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
    <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" placeholder="Nombre" required>
    <input type="email" name="email" value="<?php echo $usuario['email']; ?>" placeholder="Correo Electrónico" required>
    <button type="submit">Guardar Cambios</button>
  </form>

  <a href="index.php">Volver a la lista de usuarios</a>
</body>
</html>

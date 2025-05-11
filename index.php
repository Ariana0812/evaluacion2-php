<?php

try{
    $conexion = new PDO("mysql:host=localhost;dbname=gestion_usuarios", "root", "");

  } catch(PDOException $error){
    echo "Error: " . $error->getMessage();
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
  
    if (!empty($nombre) && !empty($correo)) {
      $query = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$correo')";
      $conexion->exec($query); 
    }
  }
  
if (isset($_GET['eliminar'])) {
    $idEliminar = $_GET['eliminar'];

    $query = "DELETE FROM usuarios WHERE id = :id";
    $statement = $conexion->prepare($query);
    $statement->execute(['id' => $idEliminar]);
    header("Location: index.php");
}


  $usuarios = $conexion->query("SELECT * FROM usuarios ORDER BY id ASC")->fetchAll();


require "index.view.php"
?>
<?php
session_start();
require 'val/funciones.php';
$code = '';
$prod = '';
$price = '';
$error_code = '';
$error_prod = '';
$error_price = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST['send'])) {
    $flag = false;
    $codeVal = validate('code', 'codigo', 5, 60);
    if ($codeVal['error']) {
        $error_code = $codeVal['msg'];
        $flag = true;
    } else {
        $code = $codeVal['campo2'];
    }
    $prodVal = validate('prod', 'producto', 5, 60);
    if ($prodVal['error']) {
        $error_prod = $prodVal['msg'];
        $flag = true;
    } else {
        $prod = $prodVal['campo2'];
    }
    $priceVal = validate('price', 'precio', 5, 1000);
    if ($priceVal['error']) {
        $error_price = $priceVal['msg'];
        $flag = true;
    } else {
        $price = $priceVal['campo2'];
    }
    if ($flag === false) {
        try {
            #conexion a la db
            $conndb = new PDO('mysql:host=localhost;dbname=altas', 'root', '');
            $conndb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            #fin conexion a la db
            $consulta = $conndb->prepare("SELECT * FROM productos WHERE codigo = :codigo");
            $consulta->bindParam(':codigo', $code);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                $error_code = 'Ya existe';
            } else {
                $stmt = $conndb->prepare("INSERT INTO productos (codigo,producto,precio) 
                VALUES (:codigo, :producto, :precio)");
                $stmt->bindParam(':codigo', $code);
                $stmt->bindParam(':producto', $prod);
                $stmt->bindParam(':precio', $price);
                if ($stmt->execute()) {
                    $_SESSION['prod'] = $prod;
                    header('location: exitos.php');
                    exit;
                } else {
                    echo 'error en la query ' . $e->errorInfo()[2];
                }
            }
        } catch (PDOException $e) {
            echo 'Error en la conexion' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="https://cdn.pixabay.com/photo/2013/07/12/14/42/education-148605_1280.png"
        type="image/x-icon">
    <title>Alta de productos</title>
</head>

<body>
    <div class="container">
        <div class="black-f">
            <div class="form-container">
                <h1>Alta</h1>
                <form action="" method="post">
                    <input type="text" name="code" placeholder="codigo" value="<?= $code ?>" required autofocus
                        autocomplete="off">
                    <output class="msg_error"><?= $error_code ?></output>
                    <input type="text" name="prod" placeholder="producto" value="<?= $prod ?>" required autofocus
                        autocomplete="off">
                    <output class="msg_error"><?= $error_prod ?></output>
                    <input type="number" step="0.01" name="price" placeholder="precio" value="<?= $price ?>" required
                        autofocus autocomplete="off">
                    <output class="msg_error"><?= $error_price ?></output>
                    <button type="submit" class="btn" name="send">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
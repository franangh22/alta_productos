<?php
function validate($campo, $campoNombre, $min, $max)
{
    $msg = '';
    $error = false;
    $campo2 = '';
    if (!isset($_POST[$campo])) {
        $msg = $campoNombre . ' no existe!';
        $error = true;
    } else {
        $campo2 = trim($_POST[$campo]);
        if (empty($campo2)) {
            $msg = $campoNombre . ' no puede estar vacio!';
            $error = true;
        }
        if (strlen($campo2) < $min || strlen($campo2) > $max) {
            $msg = 'tiene que estar entre ' . $min . ' y ' . $max . ' caracteres';
            $error = true;
        }
    }
    $resultado['msg'] = $msg;
    $resultado['error'] = $error;
    $resultado['campo2'] = $campo2;
    return $resultado;
}
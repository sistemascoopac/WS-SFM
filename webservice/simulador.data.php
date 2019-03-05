<?php

require_once '../negocio/Simulador.clase.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'token.validar.php';

if (! isset($_POST["token"])){
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_POST["token"];
$p_producto = $_POST["p_producto"];
$p_monto = $_POST["p_monto"];
$p_ncuotas = $_POST["p_ncuotas"];
$p_indicador=$_POST["p_indicador];
try {
    
        $obj = new Simulador();
        $resultado = $obj->GetData($p_producto, $p_monto, $p_ncuotas,$p_indicador);
        Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

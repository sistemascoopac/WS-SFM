<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'token.validar.php';

if (! isset($_POST["token"])){
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_POST["token"];
$p_ccod_cliente = $_POST["p_ccod_cliente"];
try {
    if(validarToken($token)){
        $obj = new Cliente();
        $resultado = $obj->cargarDatosClienteCodigo($p_ccod_cliente);
         $foto = $obj->obtenerFoto($p_ccod_cliente);
        $resultado["foto"] = $foto;
        Funciones::imprimeJSON(200, "", $resultado);
    }
    
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

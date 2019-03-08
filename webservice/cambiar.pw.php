<?php

require_once '../negocio/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["usuario"])){
    Funciones::imprimeJSON(500, "No se especificó usuario", "");
    exit();
}
if (! isset($_POST["clave"])){
    Funciones::imprimeJSON(500, "Ingrese clave", "");
    exit();
}
if (! isset($_POST["nclave"])){
    Funciones::imprimeJSON(500, "Ingrese la clave nueva", "");
    exit();
}
$usuario = $_POST["usuario"];
$clave = $_POST["clave"];
$nclave = $_POST["nclave"];


try {
    $objSesion = new Sesion();
    $objSesion->setUsuario($usuario);
    $objSesion->setClave($clave);
    $objSesion->setN_clave($nclave);
    
    $resultado = $objSesion->cambiarpw();
    
    
    
    //gg
    if($resultado["estado"] == 200){
        Funciones::imprimeJSON(200, "", $resultado);
    }else{
        Funciones::imprimeJSON(500, $resultado["dato"], "");
        
        //
    }
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

<?php

require_once '../negocio/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';


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
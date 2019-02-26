<?php

require_once '../negocio/Categoria.clase.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'token.validar.php';

//if (! isset($_POST["token"])){
  //  Funciones::imprimeJSON(500, "Debe especificar un token", "");
    //exit();
//}

//$token = $_POST["token"];
try {
    //if(validarToken($token)){
        $obj = new Categoria();
        $resultado = $obj->listar();
        
        Funciones::imprimeJSON(200, "", $resultado);
   // }
    
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

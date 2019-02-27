<?php

require_once '../negocio/Producto.clase.php';
require_once '../util/funciones/Funciones.clase.php';




$cat = $_POST["p_cat"];
try {
    //if(validarToken($token)){
        $obj = new Producto();
        $resultado = $obj->listar($cat);
        
        Funciones::imprimeJSON(200, "", $resultado);
   // }
    
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
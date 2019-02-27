<?php

require_once '../negocio/Categoria.clase.php';
require_once '../util/funciones/Funciones.clase.php';



try {
    //if(validarToken($token)){
        $obj = new Categoria();
        $resultado = $obj->listar();
        
        Funciones::imprimeJSON(200, "", $resultado);
   // }
    
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

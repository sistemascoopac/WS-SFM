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
        
    //if(validarToken($token)){
        $obj = new Cliente();
        
        $resultado = $obj->Listar($p_ccod_cliente);
        $listaSocio = array();
        
        for($i = 0; $i < count($resultado); $i++){
            $foto = $obj->obtenerFoto($resultado[$i]["ccod_cliente"]);
            
        $datosSocios = array(
            "ccod_cliente" => $resultado[$i]["ccod_cliente"],
            "nombre_completo" => $resultado[$i]["nombre_completo"],            
            "cdni_cliente" => $resultado[$i]["Cdni_cliente"],
            "cdir_cliente" => $resultado[$i]["Cdir_cliente"],
            "ctel_cliente" => $resultado[$i]["Ctel_cliente"],
            "dependientes" => $resultado[$i]["Cdependientes_cliente"],
            "ingresos" => $resultado[$i]["Cingreso_cliente"],
             "lat_dir" => $resultado[$i]["latitud"],
            "long_dir" => $resultado[$i]["longitud"],
            "foto" => $foto
          );  
            
            $listaSocio[$i] = $datosSocios;
        }
    
        Funciones::imprimeJSON(200, "", $listaSocio);
       
    //}
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

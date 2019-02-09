<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'token.validar.php';

if (! isset($_POST["token"])){
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_POST["token"];
$p_nombre = $_POST["p_nombre"];
try {
    if(validarToken($token)){
        $obj = new Cliente();
        $resultado = $obj->cargarDatosClienteNombre($p_nombre);
        $listaSocio = array();
        
        for($i = 0; $i < count($resultado); $i++){
            $foto = $obj->obtenerFoto($resultado[$i]["Ccod_cliente"]);
        
        $datosSocios = array(
            "ccod_cliente" => $resultado[$i]["Ccod_cliente"],
            "nombre_completo" => $resultado[$i]["nombre_completo"],
            "ccod_cliente" => $resultado[$i]["Ccod_cliente"],
            "cdni_cliente" => $resultado[$i]["Cdni_cliente"],
            "cdir_cliente" => $resultado[$i]["Cdir_cliente"],
            "ctel_cliente" => $resultado[$i]["Ctel_cliente"],
            "dependientes" => $resultado[$i]["cdependientes_cliente"],
            "ingresos" => $resultado[$i]["cingreso_cliente"],
             "lat_dir" => $resultado[$i]["latitud"],
            "long_dir" => $resultado[$i]["longitud"],
            "foto" => $foto
          );  
            
            $listaSocio[$i] = $datosSocios;
        }
    
        Funciones::imprimeJSON(200, "", $listaSocio);
       
    }
    
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

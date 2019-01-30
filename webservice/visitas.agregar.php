<?php
require_once 'token.validar.php';
require_once '../negocio/Visitas.clase.php';
require_once '../util/funciones/Funciones.clase.php';

//if (! isset($_POST["token"])){
    //Funciones::imprimeJSON(500, "Debe especificar un token", "");
   // exit();
//}

$token = $_POST["token"];

try {
  // if(validarToken($token)){ //token válido
       
                $ccod_visitas = $_POST["ccod_visitas"];
                $ccod_cliente = $_POST["ccod_cliente"];
                $lat_dir = $_POST["lat_dir"];
                $long_dir = $_POST["long_dir"];
                $foto= $_POST["foto"];
                $ccod_empleado= $_POST["ccod_empleado"];
         
     
     $obj = new Visitas();
     $obj->setCcod_visitas($ccod_visitas);
     $obj->setCcod_cliente($ccod_cliente);
     $obj->setLat_dir($lat_dir);
     $obj->setLong_dir($long_dir);
     $obj->setFoto($foto);
     $obj->setCcod_empleado($ccod_empleado);
     
     
     $resultado=$obj->agregar_visitas();
             
     
    
       Funciones::imprimeJSON(200, "venta_agregar_ok_ntbs", $resultado);
       
  // }
} catch (Exception $exc) {
    $mensajeError = $exc ->getMessage();
    $position = strpos($mensajeError, "Raise exception");
    if($position>0){
        $mensajeError = substr($mensajeError, $position+27, strlen($mensajeError));
    }
    
    Funciones::imprimeJSON(500, $mensajeError, "");
}

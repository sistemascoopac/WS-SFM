<?php
require_once 'token.validar.php';
require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["token"])){
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_POST["token"];

try {
  // if(validarToken($token)){ //token válido
     $p_dir=$_POST["p_dir"];
     $p_ctel=$_POST["p_ctel"];
     $p_ing=$_POST["p_ing"];
     $p_dep=$_POST["p_dep"];
     $p_lati=$_POST["p_lati"];
     $p_longi=$_POST["p_longi"];
     $p_cod=$_POST["p_cod"];
     
     
     
     $obj = new Cliente();
     $obj->setCdir_cliente($p_dir);
     $obj->setCtel_cliente($p_ctel);
     $obj->setIngresos($p_ing);
     $obj->setDependientes($p_dep);
     $obj->setLatitud($p_lati);
     $obj->setLongitud($p_longi);
     $obj->setCcod_cliente($p_cod);
     
    
     
     $resultado=$obj->editar_socio();
             
     if($resultado=true){
         Funciones::imprimeJSON(200, "cliente_editar_ok_ntbs", $resultado);
     }else{
      Funciones::imprimeJSON(500, "cliente_no_se_edito", $resultado);   
     }
       
    
       
       
  // }
} catch (Exception $exc) {
    $mensajeError = $exc ->getMessage();
    $position = strpos($mensajeError, "Raise exception");
    if($position>0){
        $mensajeError = substr($mensajeError, $position+27, strlen($mensajeError));
    }
    //Funciones::imprimeJSON(500, "poque", "asas1");
    Funciones::imprimeJSON(500, $mensajeError, "asas");
}

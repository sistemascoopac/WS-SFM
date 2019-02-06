<?php

require_once '../datos/Conexion.clase.php';

class Sesion extends Conexion {

    private $usuario;
    private $clave;

    function getUsuario() {
        return $this->usuario;
    }

    function getClave() {
        return $this->clave;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    
     public function validarSesion() {
        try {
            
            $procedure_params = array(
     array(&$myparams['p_usuario'], SQLSRV_PARAM_OUT),
     array(&$myparams['p_clave'], SQLSRV_PARAM_OUT)
            );
            
           $sql = " exec prc_inicio_sesion @p_usuario=? , @p_clave=? ";
            //$sentencia = $this->dblink->prepare($sql);
            $sentencia= $this->dblink->sqlsrv_prepare($sql,$procedure_params);
            
            
           // $usuario= $this->getUsuario();
            //$clave= $this->getClave();
            
           // $sentencia->bindParam(":p_usuario", $usuario);
           // $sentencia->bindParam(":p_clave", $clave);
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC);
            
            
            
        } catch (Exception $exc) {
            throw $exc->getTraceAsString();
        }
    }
    
    public function  obtenerFoto($dni){
        $foto = "../imagenes-usuario/".$dni;
        if(file_exists($foto.".jpg")){
            $foto = $foto.".jpg";
        }else{
            if(file_exists($foto.".png")){
                $foto = $foto.".png";
            }else{
                $foto = "none";
            }
        }
        if($foto == "none"){
            return $foto;
        }else{
            return Funciones::$DIRECCION_WEB_SERVICE.$foto;
        }
    }
}

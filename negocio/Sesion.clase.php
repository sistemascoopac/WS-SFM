<?php

require_once '../datos/Conexion.clase.php';

class Sesion extends Conexion {

    private $usuario;
    private $clave;
    private $n_clave;
    
    function getN_clave() {
        return $this->n_clave;
    }

    function setN_clave($n_clave) {
        $this->n_clave = $n_clave;
    }

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
            
          
            
           $sql=" SET NOCOUNT ON exec bd_sfm_astudio2.dbo.prc_inicio_sesion @p_usuario=:p_usuario , @p_clave=:p_clave ";
            
            $sentencia = $this->dblink->prepare($sql);
           
           
            
            $usuario= $this->getUsuario();
            $clave= $this->getClave();
           // mssql_bind($sp, "@p_usuario", $usuario, SQLVARCHAR);
           // mssql_bind($sp, "@p_clave", $clave, SQLVARCHAR);
            $sentencia->bindParam(":p_usuario", $usuario);
            $sentencia->bindParam(":p_clave", $clave);
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC);
          // return $data = mssql_fetch_row(mssql_execute($sp));
            
            
            
        } catch (Exception $exc) {
            throw $exc->getTraceAsString();
        }
    }
    
    public function cambiarpw(){
         try {
        $sql=" SET NOCOUNT ON exec bd_sfm_astudio2.dbo.prc_cambiarpw @p_usuario=:p_usuario , @p_clave=:p_clave , @p_nclave=:p_nclave ";
            
            $sentencia = $this->dblink->prepare($sql);
           
           
            
            $usuario= $this->getUsuario();
            $clave= $this->getClave();
            $nclave=$this->getN_clave();
           // mssql_bind($sp, "@p_usuario", $usuario, SQLVARCHAR);
           // mssql_bind($sp, "@p_clave", $clave, SQLVARCHAR);
            $sentencia->bindParam(":p_usuario", $usuario);
            $sentencia->bindParam(":p_clave", $clave);
            $sentencia->bindParam(":p_nclave",$nclave);
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC);
          // return $data = mssql_fetch_row(mssql_execute($sp));
            
            
            
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

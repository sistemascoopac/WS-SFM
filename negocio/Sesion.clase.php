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
            
          
            
           $sql=" select 
                    e.Ccod_emp,
                    e.lbaja,
                    u.pasword,
                    e.Cnom_emp--,
                    --u.login
                    --into #v_registro
                from EMPLEADO e inner join USUARIO u on (e.Ccod_emp=u.Ccod_emp)
                where (u.login=:p_usuario) ";
            
            $sentencia = $this->dblink->prepare($sql);
           
           
            
            $usuario= $this->getUsuario();
            $clave= $this->getClave();
           // mssql_bind($sp, "@p_usuario", $usuario, SQLVARCHAR);
           // mssql_bind($sp, "@p_clave", $clave, SQLVARCHAR);
            $sentencia->bindParam(":p_usuario", $usuario);
            //$sentencia->bindParam(":p_clave", $clave);
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

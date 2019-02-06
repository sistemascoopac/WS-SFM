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
            
            $serverName = "190.233.55.167";
    $connectionInfo = array( "Database"=>"bd_sfm_astudio", "UID"=>"sa", "PWD"=>"CSFM_2018*");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false )
    {
        echo "Could not connect.\n";
        print('<pre>');
        die( print_r( sqlsrv_errors(), true));
        print('</pre>');
    }
            
            $tsql_callSP = "{call prc_inicio_sesion(?,?)}";
            
            
            
             $usuario= $this->getUsuario();
            $clave= $this->getClave();
            
            $params = array(
                array($usuario, SQLSRV_PARAM_IN),
                array($clave, SQLSRV_PARAM_IN)
                            );
           
      $stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params);
    if( $stmt3 === false )
    {
        echo "Error in executing statement 3.\n";
        die( print_r( sqlsrv_errors(), true));
    }
        return $stmt3;
    /*Free the statement and connection resources. */
    //sqlsrv_free_stmt($stmt3);
    sqlsrv_close($conn);
            
            
           //$sql=" call bd_sfm_astudio.dbo.prc_inicio_sesion @p_usuario='rperez' , @p_clave='202cb962ac59075b964b07152d234b70' ";
            
           // $sentencia = $this->dblink->prepare($sql);
           
           /* 
            
            $usuario= $this->getUsuario();
            $clave= $this->getClave();
            mssql_bind($sp, "@p_usuario", $usuario, SQLVARCHAR);
            mssql_bind($sp, "@p_clave", $clave, SQLVARCHAR);
            //$sentencia->bindParam(":p_usuario", $usuario);
           // $sentencia->bindParam(":p_clave", $clave);
            //$sentencia->execute();
            //return $sentencia->fetch(PDO::FETCH_ASSOC);
           return $data = mssql_fetch_row(mssql_execute($sp));
            
            */
            
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

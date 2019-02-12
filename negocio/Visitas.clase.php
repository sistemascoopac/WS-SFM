<?php

require_once '../datos/Conexion.clase.php';

class Visitas extends Conexion {
   
    private $ccod_visitas;
    private $ccod_cliente;    
    private $lat_dir;
    private $long_dir;
    private $foto;
    private $ccod_empleado;
    
    
    function getCcod_visitas() {
        return $this->ccod_visitas;
    }

    function getCcod_cliente() {
        return $this->ccod_cliente;
    }

    function getLat_dir() {
        return $this->lat_dir;
    }

    function getLong_dir() {
        return $this->long_dir;
    }

    function getFoto() {
        return $this->foto;
    }

    function getCcod_empleado() {
        return $this->ccod_empleado;
    }

    function setCcod_visitas($ccod_visitas) {
        $this->ccod_visitas = $ccod_visitas;
    }

    function setCcod_cliente($ccod_cliente) {
        $this->ccod_cliente = $ccod_cliente;
    }

    function setLat_dir($lat_dir) {
        $this->lat_dir = $lat_dir;
    }

    function setLong_dir($long_dir) {
        $this->long_dir = $long_dir;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setCcod_empleado($ccod_empleado) {
        $this->ccod_empleado = $ccod_empleado;
    }

    
   
    
    public function agregar_visitas() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "SET NOCOUNT ON exec bd_sfm_astudio2.dbo.f_generar_correlativo('VISITAS') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoArticulo = $resultado["nc"];
                $this->setCcod_visitas($nuevoCodigoArticulo);
                
                $sql = "
                        INSERT INTO VISITAS
                    (
                        Ccod_visitas,
                        Ccod_cliente,
                          lat_dir,
                           long_dir,                           
                             Ccod_empleado
                     )
                        VALUES (
                       :p_ccod_visitas,
                         :p_ccod_cliente,
                          :p_lat_dir,
                           :p_long_dir,                            
                             :p_ccod_empleado
                             );

                            ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //$ccod_visitas = $this->ccod_visitas();
                 $ccod_cliente = $this->getCcod_cliente();
                $lat_dir = $this->getLat_dir();
                $long_dir = $this->getLong_dir();
               
                $ccod_empleado= $this->getCcod_empleado();
                
                
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_ccod_visitas", $nuevoCodigoArticulo);
                $sentencia->bindParam(":p_ccod_cliente", $ccod_cliente);
                $sentencia->bindParam(":p_lat_dir", $lat_dir);
                $sentencia->bindParam(":p_long_dir", $long_dir);                
                $sentencia->bindParam(":p_ccod_empleado", $ccod_empleado);
                
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'VISITAS'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla visitas");
//                return true;
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
   
    
    
}



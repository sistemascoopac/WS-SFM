<?php

require_once '../datos/Conexion.clase.php';
class Categoria extends Conexion{
   
    private $Ccod_categoria_producto;
    private $Cdes_categoria_producto;
    
    function getCcod_categoria_producto() {
        return $this->Ccod_categoria_producto;
    }

    function getCdes_categoria_producto() {
        return $this->Cdes_categoria_producto;
    }

    function setCcod_categoria_producto($Ccod_categoria_producto) {
        $this->Ccod_categoria_producto = $Ccod_categoria_producto;
    }

    function setCdes_categoria_producto($Cdes_categoria_producto) {
        $this->Cdes_categoria_producto = $Cdes_categoria_producto;
    }
public function listar(){
    try{
        
    $sql = "
                select * from CATEGORIA_PRODUCTO


                    ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
}

}

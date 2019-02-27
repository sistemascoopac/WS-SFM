<?php

require_once '../datos/Conexion.clase.php';
class Producto extends Conexion{
    
    private $Ccod_categoria_producto;
    private $Ccod_producto;
    private $Cdes_producto;
    private $Cestado;
    
    function getCcod_categoria_producto() {
        return $this->Ccod_categoria_producto;
    }

    function getCcod_producto() {
        return $this->Ccod_producto;
    }

    function getCdes_producto() {
        return $this->Cdes_producto;
    }

    function getCestado() {
        return $this->Cestado;
    }

    function setCcod_categoria_producto($Ccod_categoria_producto) {
        $this->Ccod_categoria_producto = $Ccod_categoria_producto;
    }

    function setCcod_producto($Ccod_producto) {
        $this->Ccod_producto = $Ccod_producto;
    }

    function setCdes_producto($Cdes_producto) {
        $this->Cdes_producto = $Cdes_producto;
    }

    function setCestado($Cestado) {
        $this->Cestado = $Cestado;
    }

public function listar($cat){
    try{
        
    $sql = "
                SELECT      Ccod_categoria_producto, Ccod_producto, Cdes_producto
                FROM         PRODUCTO
                where Cestado=1 and Ccod_categoria_producto=:p_cat

                    ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_cat", $cat);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
          
           
            
        } catch (Exception $exc) {
            throw $exc;
        }
}
    
}

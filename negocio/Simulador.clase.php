<?php

require_once '../datos/Conexion.clase.php';
class Simulador extends Conexion{
    
    private $nro_cuota;
    private $capital;
    private $interes;
    private $cuota_mes;
    private $saldo;
    
    private $p_producto;
    private $p_monto;
    private $p_ncuotas;
    
    function getP_producto() {
        return $this->p_producto;
    }

    function getP_monto() {
        return $this->p_monto;
    }

    function getP_ncuotas() {
        return $this->p_ncuotas;
    }

    function setP_producto($p_producto) {
        $this->p_producto = $p_producto;
    }

    function setP_monto($p_monto) {
        $this->p_monto = $p_monto;
    }

    function setP_ncuotas($p_ncuotas) {
        $this->p_ncuotas = $p_ncuotas;
    }

        function getNro_cuota() {
        return $this->nro_cuota;
    }

    function getCapital() {
        return $this->capital;
    }

    function getInteres() {
        return $this->interes;
    }

    function getCuota_mes() {
        return $this->cuota_mes;
    }

    function getSaldo() {
        return $this->saldo;
    }

    function setNro_cuota($nro_cuota) {
        $this->nro_cuota = $nro_cuota;
    }

    function setCapital($capital) {
        $this->capital = $capital;
    }

    function setInteres($interes) {
        $this->interes = $interes;
    }

    function setCuota_mes($cuota_mes) {
        $this->cuota_mes = $cuota_mes;
    }

    function setSaldo($saldo) {
        $this->saldo = $saldo;
    }


    public function GetData($producto,$monto,$ncuotas,$indicador){
        
        try {
             $sql=" SET NOCOUNT ON exec bd_sfm_astudio2.dbo.prc_generar_cronograma @p_producto=:p_producto , @p_monto=:p_monto , @p_ncuotas=:p_ncuotas ,@p_indicador=:p_indicador";
            
            $sentencia = $this->dblink->prepare($sql);
           
           
            
            
            
           // mssql_bind($sp, "@p_usuario", $usuario, SQLVARCHAR);
           // mssql_bind($sp, "@p_clave", $clave, SQLVARCHAR);
            $sentencia->bindParam(":p_producto", $producto);
            $sentencia->bindParam(":p_monto", $monto);
            $sentencia->bindParam(":p_ncuotas", $ncuotas);
            $sentencia->bindParam(":p_indicador", $indicador);
            
            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
    
}

<?php

require_once '../datos/Conexion.clase.php';

class Cliente extends Conexion {
   
    private $ccod_cliente;
    private $cnom_cliente;
    private $capp_cliente;
    private $capm_cliente;
    private $cdni_cliente;
    private $csexo;
    private $cdir_cliente;
    private $ctel_cliente;
    private $lbaja;
    private $lat_dir;
    private $long_dir;
    private $ingresos;
    private $dependientes;
    private $latitud;
    private $longitud;
    
    
    
    function getIngresos() {
        return $this->ingresos;
    }

    function getDependientes() {
        return $this->dependientes;
    }

    
    
    function getCcod_cliente() {
        return $this->ccod_cliente;
    }

    function getCnom_cliente() {
        return $this->cnom_cliente;
    }

    function getCapp_cliente() {
        return $this->capp_cliente;
    }

    function getCapm_cliente() {
        return $this->capm_cliente;
    }

    function getCdni_cliente() {
        return $this->cdni_cliente;
    }

    function getCsexo() {
        return $this->csexo;
    }

    function getCdir_cliente() {
        return $this->cdir_cliente;
    }

    function getCtel_cliente() {
        return $this->ctel_cliente;
    }

    function getLbaja() {
        return $this->lbaja;
    }

    function getLat_dir() {
        return $this->lat_dir;
    }

    function getLong_dir() {
        return $this->long_dir;
    }
	
    function getLatitud() {
        return $this->latitud;
    }

    function getLongitud() {
        return $this->longitud;
    }	
	
	
    function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    function setLongitud($longitud) {
        $this->longitud = $longitud;
    }	

    function setCcod_cliente($ccod_cliente) {
        $this->ccod_cliente = $ccod_cliente;
    }

    function setCnom_cliente($cnom_cliente) {
        $this->cnom_cliente = $cnom_cliente;
    }

    function setCapp_cliente($capp_cliente) {
        $this->capp_cliente = $capp_cliente;
    }

    function setCapm_cliente($capm_cliente) {
        $this->capm_cliente = $capm_cliente;
    }

    function setCdni_cliente($cdni_cliente) {
        $this->cdni_cliente = $cdni_cliente;
    }

    function setCsexo($csexo) {
        $this->csexo = $csexo;
    }

    function setCdir_cliente($cdir_cliente) {
        $this->cdir_cliente = $cdir_cliente;
    }

    function setCtel_cliente($ctel_cliente) {
        $this->ctel_cliente = $ctel_cliente;
    }

    function setLbaja($lbaja) {
        $this->lbaja = $lbaja;
    }

    function setLat_dir($lat_dir) {
        $this->lat_dir = $lat_dir;
    }

    function setLong_dir($long_dir) {
        $this->long_dir = $long_dir;
    }
	
	function setIngresos($ingresos) {
        $this->ingresos = $ingresos;
    }

    function setDependientes($dependientes) {
        $this->dependientes = $dependientes;
    }

            
    public function listar( $p_ccod_cliente) {
        try {
            $sql = "
                select 
                ccod_cliente,
                (cnom_cliente ||' '||capp_cliente||' '||capm_cliente ) ::character varying as nombre_completo,
                cdni_cliente,
                cdir_cliente,
                ctel_cliente,
		ingreso,
		latitud,
		longitud,
		dependientes
                from
                cliente  
		where 
                lbaja='0' and ccod_cliente = :p_ccod_cliente


                    ";
            $sentencia = $this->dblink->prepare($sql);
	   $sentencia->bindParam(":p_ccod_cliente", $p_ccod_cliente);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar( $p_id_cliente ){
        $this->dblink->beginTransaction();
        try {
            $sql = "update cliente set estado = 2 where id_cliente = :p_id_cliente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_id_cliente", $p_id_cliente);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
	
		
	public function editar_socio(){
		$this->dblink->beginTransaction();
         try{
		 
              $sql="UPDATE public.cliente "
                     . " SET  "
                     . " cdir_cliente= :p_dir,"
                     . " ctel_cliente= :p_ctel,"
                     . " ingreso= :p_ing,"
                     . " dependientes= :p_dep,"
                     . " latitud= :p_lati, "
                     . " longitud= :p_longi"
                     . " WHERE ccod_cliente= :p_cod ";
             
             $sentencia = $this->dblink->prepare($sql);
             
             $p_dir = $this->getCdir_cliente();
             $p_ctel = $this->getCtel_cliente();
             $p_ing = $this->getIngresos();
             $p_dep = $this->getDependientes();
             $p_lati = $this->getLatitud();
             $p_longi = $this->getLongitud();
             $p_cod = $this->getCcod_cliente();  
                          
             
            $sentencia->bindParam(":p_dir", $p_dir);
            $sentencia->bindParam(":p_ctel", $p_ctel);
            $sentencia->bindParam(":p_ing", $p_ing);
            $sentencia->bindParam(":p_dep", $p_dep);
            $sentencia->bindParam(":p_lati", $p_lati);
            $sentencia->bindParam(":p_longi", $p_longi);
            $sentencia->bindParam(":p_cod", $p_cod);
            
            $sentencia->execute();
            
           // $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
             $this->dblink->commit();
                
                return true;
             
         } catch (Exception $exc) {
		 $this->dblink->rollBack();
             throw $exc;
         }
        }
	
	
	
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('cliente') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoArticulo = $resultado["nc"];
                $this->setId_cliente($nuevoCodigoArticulo);
                
                $sql = "
                        INSERT INTO cliente
                        (
                                id_cliente, 
                                apellidos, 
                                nombres, 
                                direccion, 
                                telef_fijo,
                                num_cel1,
                                email,
                                clave,
                                estado,
                                tipo_usuario
                        )
                        VALUES 
                        (
                                :p_id_cliente, 
                                :p_apellidos, 
                                :p_nombres, 
                                :p_direccion, 
                                :p_telef_fijo,
                                :p_num_cel1,
                                :p_email,
                                :p_clave,
                                :p_estado,
                                :p_tipo_usuario
                                
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_id_cliente", $this->getId_cliente());
                $sentencia->bindParam(":p_apellidos", $this->getApellidos());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_direccion", $this->getDireccion());
                $sentencia->bindParam(":p_telef_fijo", $this->getTelef_fijo());
                $sentencia->bindParam(":p_num_cel1", $this->getNum_cel1());
                $sentencia->bindParam(":p_email", $this->getEmail());
                $sentencia->bindParam(":p_clave", $this->getClave());
                $sentencia->bindParam(":p_estado", $this->getEstado());
                $sentencia->bindParam(":p_tipo_usuario", $this->getTipo_usuario());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'cliente'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla artículo");
//                return true;
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function cargarDatosClienteNombre($nombre) {
        try {
            $sql = "
		select 
                ccod_cliente,
                (cnom_cliente ||' '||capp_cliente||' '||capm_cliente ) ::character varying as nombre_completo,
                cdni_cliente,
                cdir_cliente,
                ctel_cliente ,
		ingreso,
		latitud,
		longitud,
		dependientes
                from
                cliente  
		where 
                lbaja='0' and
		    lower(cnom_cliente ||' '||capp_cliente||' '||capm_cliente ) like :p_nombre ";
            
            $sentencia = $this->dblink->prepare($sql);
            $nombre = '%'.  strtolower($nombre).'%';
            $sentencia->bindParam(":p_nombre", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    public function cargarDatosClienteCodigo($cod) {
        try {
            $sql = "
		select 
                ccod_cliente,
                (cnom_cliente ||' '||capp_cliente||' '||capm_cliente ) ::character varying as nombre_completo,
                cdni_cliente,
                cdir_cliente,
                ctel_cliente,
		ingreso,
		latitud,
		longitud,
		dependientes
                from
                cliente  
		where 
                lbaja='0' and
		    lower(ccod_cliente) like :p_cod ";
            
            $sentencia = $this->dblink->prepare($sql);
            $cod = '%'.  strtolower($cod).'%';
            $sentencia->bindParam(":p_cod", $cod);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
	
	
	public function  obtenerFoto($ccod){
        $foto = "../imagenes_socios/".$ccod;
        if(file_exists($foto.".JPG")){
            $foto = $foto.".JPG";
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



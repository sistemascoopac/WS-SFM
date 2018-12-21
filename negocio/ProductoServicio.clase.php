<?php

require_once '../datos/Conexion.clase.php';

class ProductoServicio extends Conexion {
    private $id_producto_servicio;
    private $descripcion;
    private $tipo;
    private $precio;
    private $id_categoria;
    private $stock;
    private $estado;
   
    
    function getId_producto_servicio() {
        return $this->id_producto_servicio;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getId_categoria() {
        return $this->id_categoria;
    }

    function getStock() {
        return $this->stock;
    }

    function setId_producto_servicio($id_producto_servicio) {
        $this->id_producto_servicio = $id_producto_servicio;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

        public function listar() {
        try {
            $sql = "
               select ps.id_producto_servicio, ps.descripcion, 
                (case when ps.tipo = 1 then 'producto' else 'servicio' end)as tipo, 
                ps.precio, 
                c.descripcion as categoria, 
                coalesce(ps.stock, 0) as stock
                from producto_servicio ps
                inner join categoria c on (c.id_categoria = ps.id_categoria)
                where ps.estado = 1


                    ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function listar_for_cliente() {
        try {
            $sql = "
                  select 
		id_producto_servicio,
		descripcion,
		precio
                 from producto_servicio
                  where estado = 1 and tipo=2


                    ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
  public function eliminar( $p_id_producto_servicio ){
        $this->dblink->beginTransaction();
        try {
            $sql = "update producto_servicio set estado = 2 where id_producto_servicio = :p_id_producto_servicio";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_id_producto_servicio", $p_id_producto_servicio);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('producto_servicio') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoArticulo = $resultado["nc"];
                $this->setId_producto_servicio($nuevoCodigoArticulo);
                
                $sql = "
                        INSERT INTO producto_servicio
                        (
                                id_producto_servicio, 
                                descripcion,
                                tipo,
                                precio,
                                id_categoria,
                                stock,
                                estado
                                
                                
                        )
                        VALUES 
                        (
                                :p_id_producto_servicio, 
                                :p_descripcion,
                                :p_tipo,
                                :p_precio,
                                :p_id_categoria,
                                :p_stock,
                                :p_estado
                                
                                
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
             $desc = $this->getDescripcion();
            $tipo = $this->getTipo();
            $precio=$this->getPrecio();
            $id_categoria= $this->getId_categoria();
            $stock =$this->getStock();
            $id=$this->getId_producto_servicio();
            $estado= $this->getEstado();
            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_id_producto_servicio", $nuevoCodigoArticulo);
            $sentencia->bindParam(":p_descripcion", $desc);
            $sentencia->bindParam(":p_tipo", $tipo);
            $sentencia->bindParam(":p_precio", $precio);
            $sentencia->bindParam(":p_id_categoria", $id_categoria);
            $sentencia->bindParam(":p_stock", $stock);
            $sentencia->bindParam(":p_estado", $estado);
            
            
                
               
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'producto_servicio'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla p_s");
//                return true;
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
      
  public function cargarDatosPoS($nombre) {
        try {
            $sql = "
		 select ps.id_producto_servicio, ps.descripcion, 
                (case when ps.tipo = 1 then 'producto' else 'servicio' end)as tipo, 
                ps.precio, 
                c.descripcion as categoria, 
                coalesce(ps.stock, 0) as stock
                from producto_servicio ps
                inner join categoria c on (c.id_categoria = ps.id_categoria)
                where ps.estado = 1 and ps.tipo=2 and
		    lower(ps.descripcion ) like :p_nombre";
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
    
    
     public function leerDatos($p_id_producto_servicio) {
        try {
            $sql = "
                    
                    select
                            a.*,
                            c.descripcion
                    from
                            producto_servicio a 
                            inner join categoria c on ( a.id_categoria = c.id_categoria )
                    where
                            a.id_producto_servicio = :p_id_producto_servicio
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_id_producto_servicio", $p_id_producto_servicio);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = " 
                    update producto_servicio set
                        descripcion              = :p_descripcion,
                        tipo        = :p_tipo,
                        precio    = :p_precio,
                        id_categoria        = :p_id_categoria
                        stock        = :p_stock
                    where
                        id_producto_servicio     = :p_id_producto_servicio
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            $desc = $this->getDescripcion();
            $tipo = $this->getTipo();
            $precio=$this->getPrecio();
            $id_categoria= $this->getId_categoria();
            $stock =$this->getStock();
            $id=$this->getId_producto_servicio();
            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_descripcion", $desc);
            $sentencia->bindParam(":p_tipo", $tipo);
            $sentencia->bindParam(":p_precio", $precio);
            $sentencia->bindParam(":p_id_categoria", $id_categoria);
            $sentencia->bindParam(":p_stock", $stock);
            
            $sentencia->bindParam(":p_id_producto_servicio", $id);

            //Ejecutar la sentencia preparada
            $sentencia->execute();
            
            
            $this->dblink->commit();
                
            return true;
            
        } catch (Exception $exc) {
           $this->dblink->rollBack();
           throw $exc;
        }
        
        return false;
            
    }
    
    
}



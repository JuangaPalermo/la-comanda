<?php


require_once './constants/estadoPedidos.php';

class Pedido{
    public $pedidoID;
    public $pedidoCodigo;
    public $pedidoEmpleadoID; //este se le asigna cuando lo toma un empleado.
    public $pedidoProductoID;
    public $pedidoMesaID;
    public $pedidoCliente;
    public $pedidoEstado; //esto lo puedo poner desde el codigo, no hace falta que lo mande por PostMan
    public $pedidoFechaCreacion; //lo obtengo desde el codigo
    public $pedidoFechaTomado; //lo seteo cuando lo toma el empleado que lo cocina/sirve
    public $pedidoFechaEstimadaEntrega; //lo setea el empleado cuando lo toma tambien
    public $pedidoFechaEntregado; //se setea cuando se cambia de estado
    public $pedidoFechaFinalizacion; //se setea cuando se concluye el pedido.
    public $pedidoImagen; // se setea desde el codigo, se envia desde postman.
    public $pedidoCalificacion; //lo pone el cliente al terminar el pedido
    public $pedidoComentario; //lo pone el cliente al terminar el pedido

    //Alta
    public function crearPedido(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedido (pedidoCodigo, pedidoProductoID, pedidoMesaID, pedidoCliente, pedidoEstado, pedidoFechaCreacion, pedidoImagen) VALUES (:pedidoCodigo, :pedidoProductoID, :pedidoMesaID, :pedidoCliente, :pedidoEstado, :pedidoFechaCreacion, :pedidoImagen)");

        $consulta->bindValue(':pedidoCodigo', $this->pedidoCodigo, PDO::PARAM_INT);
        $consulta->bindValue(':pedidoProductoID', $this->pedidoProductoID, PDO::PARAM_INT);
        $consulta->bindValue(':pedidoMesaID', $this->pedidoMesaID, PDO::PARAM_INT);
        $consulta->bindValue(':pedidoCliente', $this->pedidoCliente, PDO::PARAM_STR);
        $consulta->bindValue(':pedidoEstado', $this->pedidoEstado, PDO::PARAM_STR);
        $consulta->bindValue(':pedidoFechaCreacion', $this->pedidoFechaCreacion, PDO::PARAM_STR);
        $consulta->bindValue(':pedidoImagen', $this->pedidoImagen, PDO::PARAM_STR);
        
        if(!$consulta->execute()){
            throw new Exception("Error al realizar la consulta.");
        }

        return $objAccesoDatos->obtenerUltimoId();
    }

    //Baja (no tengo que eliminarlos, tengo que cambiarles el estado).
        public static function borrarPedido($pedidoCodigo, $pedidoMesaID)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE pedido SET 
                                                          pedidoFechaFinalizacion = :pedidoFechaFinalizacion,
                                                          pedidoEstado = :pedidoEstado
                                                          WHERE pedidoCodigo = :pedidoCodigo 
                                                          AND pedidoMesaID = :pedidoMesaID
                                                          AND pedidoEstado NOT LIKE '%concluido%'");
            $consulta->bindValue(':pedidoCodigo', $pedidoCodigo, PDO::PARAM_INT);
            $consulta->bindValue(':pedidoMesaID', $pedidoMesaID, PDO::PARAM_INT);
            $consulta->bindValue(':pedidoFechaFinalizacion', date("Y-m-d H:i:s"));
            $consulta->bindValue(':pedidoEstado', PEDIDO_CONCLUIDO, PDO::PARAM_STR);
            if(!$consulta->execute()){
                throw new Exception("Error al realizar la consulta.");
            } else if ($consulta->rowCount() == 0){
                throw new Exception("No hay pedidos con ese ID para dar de baja.");
            }
        }

    //Modificacion
        public function modificarPedidoPorId($idPedido)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE pedido 
                                                        SET pedidoCodigo = :pedidoCodigo, 
                                                        pedidoProductoID = :pedidoProductoID,
                                                        pedidoMesaID = :pedidoMesaID,
                                                        pedidoCliente = :pedidoCliente,
                                                        pedidoEstado = :pedidoEstado,
                                                        pedidoCalificacion = :pedidoCalificacion,
                                                        pedidoComentario = :pedidoComentario
                                                        WHERE pedidoID = :idPedido");
            $consulta->bindValue(':pedidoCodigo', $this->pedidoCodigo, PDO::PARAM_INT);
            $consulta->bindValue(':pedidoProductoID', $this->pedidoProductoID, PDO::PARAM_INT);
            $consulta->bindValue(':pedidoMesaID', $this->pedidoMesaID, PDO::PARAM_INT);
            $consulta->bindValue(':pedidoCliente', $this->pedidoCliente, PDO::PARAM_STR);
            $consulta->bindValue(':pedidoEstado', $this->pedidoEstado, PDO::PARAM_STR);
            $consulta->bindValue(':pedidoCalificacion', $this->pedidoCalificacion, PDO::PARAM_INT);
            $consulta->bindValue(':pedidoComentario', $this->pedidoComentario, PDO::PARAM_STR);
            $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
            if(!$consulta->execute()){
                throw new Exception("Error al realizar la consulta.");
            } else if ($consulta->rowCount() == 0){
                throw new Exception("No hay pedidos con ese ID.");
            }
        }
    
    //Listar
        //Uno
            public static function obtenerPedido($pedidoCodigo)
            {
                $objAccesoDatos = AccesoDatos::obtenerInstancia();
                $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedido 
                                                               WHERE pedidoCodigo = :pedidoCodigo
                                                               AND pedidoEstado NOT LIKE '%concluido%'");
                $consulta->bindValue(':pedidoCodigo', $pedidoCodigo, PDO::PARAM_INT);
                if(!$consulta->execute()){
                    throw new Exception("Error al realizar la consulta.");
                } else if ($consulta->rowCount() == 0){
                    throw new Exception("No hay pedidos con ese ID.");
                }
                
                return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
            }
        //Todos
            public function obtenerTodos()
            {
                $objAccesoDatos = AccesoDatos::obtenerInstancia();
                $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedido");
                if(!$consulta->execute()){
                    throw new Exception("Error al realizar la consulta.");
                }

                return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
            }
        //PorTipoEmpleado
        //PorMesa
        //PorEstado

    //Utils
        public function guardarImagenVenta($files)
        {
            //obtengo el cuerpo del mail
            $cuerpoMail = explode("@",$this->pedidoCliente);
            //obtengo la extension del archivo
            $path = $files['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            //seteo el nombre de la imagen
            $nombreImagen = $this->pedidoCodigo . "-" . $this->pedidoMesaID . "-" . $cuerpoMail[0] . "." . $ext;
            //dictamino el destino
            $destino = "./ImagenesDeLosPedidos/".$nombreImagen;
            //la envio
            move_uploaded_file($files["tmp_name"], $destino);
            $this->pedidoImagen = $destino;
        }

    //Validations
        public function Validate()
        {
            switch($this->pedidoEstado)
            {
                case PEDIDO_EN_ESPERA:
                case PEDIDO_EN_PREPARACION:
                case PEDIDO_LISTO_PARA_SERVIR:
                case PEDIDO_CONCLUIDO:
                    break;
                default:
                    throw new Exception ("El estado para el pedido no es valido.");
            }

            switch($this->pedidoCalificacion)
            {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                    break;
                default:
                    throw new Exception ("La calificacion no es valida, debe ser entre 1 y 5.");
            }
        }
}


?>
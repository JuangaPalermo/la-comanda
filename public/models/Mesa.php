<?php

class Mesa {

    public $mesaID;
    public $mesaEstado;

    //Alta
        public function crearMesa()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesa (mesaEstado) VALUES (:mesaEstado)");

            $consulta->bindValue(':mesaEstado', $this->mesaEstado, PDO::PARAM_STR);
            
            if(!$consulta->execute()){
                throw new Exception("Error al realizar la consulta.");
            }

            return $objAccesoDatos->obtenerUltimoId();
        }

    //Baja
        public static function borrarMesa($idMesa)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("DELETE FROM mesa WHERE mesaID = :id");

            $consulta->bindValue(':id', $idMesa, PDO::PARAM_INT);

            if(!$consulta->execute()){
                throw new Exception("Error al realizar la consulta.");
            } else if ($consulta->rowCount() == 0){
                throw new Exception("No hay mesas con ese ID para dar de baja.");
            }
        }
    //Modificacion
        public function modificarMesaPorId($idMesa)
        {
            $objAccesoDato = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDato->prepararConsulta("UPDATE mesa 
                                                          SET mesaEstado = :mesaEstado
                                                          WHERE mesaID = :id");

            $consulta->bindValue(':mesaEstado', $this->mesaEstado, PDO::PARAM_STR);
            $consulta->bindValue(':id', $idMesa, PDO::PARAM_INT);

            if(!$consulta->execute()){
                throw new Exception("Error al realizar la consulta.");
            } else if ($consulta->rowCount() == 0){
                throw new Exception("No hay mesas con ese ID.");
            }
        }
        //Listado
        //uno
            public static function obtenerMesa($idMesa)
            {
                $objAccesoDatos = AccesoDatos::obtenerInstancia();
                $consulta = $objAccesoDatos->prepararConsulta("SELECT mesaID as mesaID, 
                                                                      mesaEstado as mesaEstado
                                                                      FROM mesa 
                                                                      WHERE mesaID = :idMesa");
                $consulta->bindValue(':idMesa', $idMesa, PDO::PARAM_STR);
                if(!$consulta->execute()){
                    throw new Exception("Error al realizar la consulta.");
                } else if ($consulta->rowCount() == 0){
                    throw new Exception("No hay mesas con ese ID.");
                }
                
                return $consulta->fetchObject('Mesa');
            }
        //por estado
        //todos
            public static function obtenerTodos()
            {
                $objAccesoDatos = AccesoDatos::obtenerInstancia();
                $consulta = $objAccesoDatos->prepararConsulta("SELECT mesaID as mesaID, 
                                                                      mesaEstado as mesaEstado
                                                                      FROM mesa");
                if(!$consulta->execute()){
                    throw new Exception("Error al realizar la consulta.");
                }

                return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
            }
    
    //validations
            public function Validate()
            {
                switch($this->mesaEstado)
                {
                    case MESA_CERRADA:
                    case MESA_ESPERANDO:
                    case MESA_COMIENDO:
                    case MESA_PAGANDO:
                        break;
                    default:
                        throw new Exception("El estado ingresado para la mesa no es valido.");
                }
            }
}


?>
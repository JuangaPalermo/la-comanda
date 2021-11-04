<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->crearUsuario();

        $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usr = $args['usuario'];
        
        try {
          $usuario = Usuario::obtenerUsuario($usr);
          $payload = json_encode($usuario);
        } catch (Exception $e) {
          $payload = json_encode($e->getMessage());
        }

        $response->getBody()->write($payload);
          return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        //obtengo el usuario por id
        $usr = Usuario::obtenerUsuarioPorId($parametros['usuarioId']);

        //actualizo los parametros
        $usr->usuario = $parametros['nombre'];
        $usr->clave = $parametros['clave'];

        //modifico el usuairo en la base
        $usr->modificarUsuario();

        $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $parametros['usuarioId'];
        Usuario::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function LogearUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();

      //creo el usuario con los datos
      $usr = new Usuario();
      $usr->usuario = $parametros['nombre'];
      $usr->clave = $parametros['clave'];

      //defino el payload
      $payload = json_encode(array("mensaje" => $usr->logearUsuario()));
      //retorno el response
      $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
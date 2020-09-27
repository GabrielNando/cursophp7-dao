<?php 

require_once("config.php");

/*
$sql = new Sql(); // Inicia a conexao com o banco pelo __construct()

$usuarios = $sql->select("SELECT * FROM tb_usuarios");

echo json_encode($usuarios);
*/

//Carrega um usuário
//$root = new Usuario();
//$root->loadById(3);
//echo $root;

//Carrega uma list de usuarios
//$lista = Usuario::getList();
//echo json_encode($lista);

//Carrega uma lista de usuários buscando pelo login
//$search = Usuario::search("jo");
//echo json_encode($search);

//Carrega um usuario usando login e senha
$usuario = new Usuario();
$usuario->login("user", "12345");
echo $usuario;

 ?>
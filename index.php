<?php 

require_once("config.php");

/*
$sql = new Sql(); // Inicia a conexao com o banco pelo __construct()

$usuarios = $sql->select("SELECT * FROM tb_usuarios");

echo json_encode($usuarios);
*/

$root = new Usuario();

$root->loadById(3);

echo $root;
 ?>
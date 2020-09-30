<?php 

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdusuario() {
		    return $this->idusuario;
		}
		
		public function setIdusuario($value) {
		    return $this->idusuario = $value;
		}	

		public function getDeslogin()
		{
		    return $this->deslogin;
		}
		
		public function setDeslogin($value)
		{
		    return $this->deslogin = $value;
		}

		public function getDessenha()
		{
		    return $this->dessenha;
		}
		
		public function setDessenha($value)
		{
		    return $this->dessenha = $value;
		}

		public function getDtcadastro()
		{
		    return $this->dtcadastro;
		}
		
		public function setDtcadastro($value)
		{
		    return $this->dtcadastro = $value;
		}

		public function loadById($id) {

			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
				':ID'=>$id
			));

			if (count($results) > 0) {

				$this->setData($results[0]);

			}

		}

		public static function getList() {

			$sql = new Sql();

			return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

		}

		public static function search($login) {
			$sql = new Sql();

			return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
				':SEARCH'=>"%".$login."%"
			)); //O operador LIKE é usado em uma cláusula WHERE para pesquisar um padrão especificado em uma coluna.
		//Existem dois curingas geralmente usados ​​em conjunto com o operador LIKE:
			// % - o sinal de porcentagem representa zero, um ou vários caracteres
			// _ - O sublinhado representa um único caractere
		}

		public function login($login, $password) {


			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
				":LOGIN"=>$login,
				":PASSWORD"=>$password
			));

			if (count($results) > 0) {

				$this->setData($results[0]);

			}else {

				throw new Exception("Login e/ou senha inválidos");
				
			}

		}

		public function setData($data) {

				$this->setIdusuario($data['idusuario']);
				$this->setDeslogin($data['deslogin']);
				$this->setDessenha($data['dessenha']);
				$this->setDtcadastro(new DateTime($data['dtcadastro']));

		}

		public function insert() {

			$sql = new Sql();
			// No Mysql, para chamar a Procedure, usa-se a palavra CALL, se fosse no SQL Server, seria EXECUTE.
			$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
				':LOGIN'=>$this->getDeslogin(),
				':PASSWORD'=>$this->getDessenha()
			));
			// Uma stored procedure é um conjunto de comandos SQL que podem ser armazenados no servidor.
			// Uma vez que isto tenha sido feito, os clientes não precisam reenviar os comandos individuais, mas pode fazer referência às stored procedures. 
			if(count($results) > 0) {

				$this->setData($results[0]);
			}

		}

		public function update($login, $password) {

			$this->setDeslogin($login); // Pega o login e a senha informados pelo usua-
			$this->setDessenha($password);// rio, e da um set para definir os tais para esse escopo, assim quando for carrega-los no get, será os informados pelo usuario.

			$sql = new Sql();

			$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
				':LOGIN'=>$this->getDeslogin(),
				':PASSWORD'=>$this->getDessenha(),
				':ID'=>$this->getIdusuario()
			));

		}

		public function __construct($login= "", $password= "") {

			$this->setDeslogin($login);
			$this->setDessenha($password);

		}

		public function __toString() {

			//return feito no formato de um json(mais recomendado para trabalhar os dados)
			return json_encode(array(
				"idusuario"=>$this->getIdusuario(),
				"deslogin"=>$this->getDeslogin(),
				"dessenha"=>$this->getDessenha(),
				"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));

			// return feito com uma frase 

			/*return "O Id do usuario é ". $this->getIdusuario() . ", seu login é " . $this->getDeslogin() . ", sua senha é " . $this->getDessenha() . " e a data de cadastro foi : " . $this->getDtcadastro()->format("d/m/Y H:i:s");
			*/
		}
}



 ?>
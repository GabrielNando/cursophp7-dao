<?php 

class Sql extends PDO { // A classe extend da classe PDO que ja é nativa do sistema, entao tudo o que a classe pdo faz, a Sql tambem sabe fazer.
	private $conn;

	public function __construct() { // Quando instanciar a classe Sql, ele ja vai conectar nesse banco direto. Caso tenha outros bancos, pode-se passar os parametros de conexao do banco como parametros do construct, dai quando for instancia a classe, passaria os dados de conexao do banco

		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "1234");

	}

	private function setParams($statement, $parameters = array()) {

		foreach ($parameters as $key => $value) { // Faz um loop com todos os parametros que tiver dentro do array, chamando o metodo setParam, e fazendo o bind la dentro de todos os key=>values.
			
			$this->setParam($statement, $key, $value);
		}

	}

	private function setParam($statement, $key, $value) {

		$statement->bindParam($key, $value); // Pega os dados de key e value de algum array, e insere o valor na respectiva chave.
	}

	public function query($rawQuery, $params = array()) { // Para executar um comando, vai receber 2 parametro: $rawQuery(É uma query que voce vai tratar ela depois, ou comando sql) e $params(vai ser por padrao um array, pois serao nossos dados que vamos receber)
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params); // Pega o stmt(que fez o prepare), juntamente com os params informados pelo usuario(ou outro metodo), e envia para o set params para fazer o bind com os demais metodos na logica

		$stmt->execute(); // Executa o stmt

		return $stmt; //

}

	public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->query($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

}
 ?>
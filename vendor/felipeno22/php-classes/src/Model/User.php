<?php 

namespace felipeno22\Model;

use \felipeno22\Model;
use \felipeno22\DB\Sql;
use \felipeno22\Mailer;

class User extends Model {

	const SESSION = "User";
	
	//CHAVE´PARA CRIPTOGRAFAR E DESCRIPTOGRAFAR obs: deve ter no minimo 16 caracteres é uma regra
	//NUNCA SUBA ESSA CHAVE NO GITHUB NO REPOSITORIO PUBLICO SE NAO PODEM USAR ELA PARA DESCRIPTOGRAFAR
	const KEY_SECRET="lojaracao_secret";
	const KEY_SECRET_II = "lojaracao_secret_2";


	protected $fields = [
		"iduser", "idperson","desperson","desemail","nrphone" ,"deslogin", "despassword", "inadmin", "dtergister"
	];

	public static function login($login, $password):User
	{

		$db = new Sql();

		$results = $db->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));

		if (count($results) === 0) {
			throw new \Exception("Não foi possível fazer login.");
		}

		$data = $results[0];

		if (password_verify($password, $data["despassword"])) {

			$user = new User();
			$user->setData($data);

			
			$_SESSION[User::SESSION] = $user->getValues();
			
			

			return $user;

		} else {

			throw new \Exception("Não foi possível fazer login.");

		}

	}

	public static function logout()
	{
		
		$_SESSION[User::SESSION] = NULL;
		

	}

public static function verifyLogin($inadmin = true)
	{

		if (
			!isset($_SESSION[User::SESSION])
			|| 
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0
			||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
		) {
			
			header("Location: /admin/login");
			exit;

		}

	}
	
	
	
public static function listAll(){

	$sql=new Sql();
	


return $sql->select('
SELECT * FROM tb_users u
inner join tb_persons p 
on p.idperson=u.idperson  order by u.idperson;
 ');


}



//para salvar user usando procedure	
public  function save(){

	


	$sql=new Sql();

	$sql->select("call sp_users_save(
		:desperson, 
		:deslogin, 
		:despassword, 
		:desemail, 
		:nrphone, 
		:inadmin)",array(":desperson"=>utf8_decode($this->getdesperson()),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>password_hash($this->getdespassword(), PASSWORD_DEFAULT,['cost'=>12]),//md5($this->getdespassword()),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()));
	
	

	}



//reponsavel por pegar os dados atraves do id do user
	public  function get($iduser){

	$sql=new Sql();

$result=$sql->select('SELECT * FROM tb_users u
inner join tb_persons p 
on p.idperson=u.idperson  where u.iduser= :iduser',array("iduser"=>$iduser));

		
	$this->setData($result[0]);

	
	}



public  function update(){

	

	$sql=new Sql();

	$result=$sql->select("call sp_usersupdate_save(
		:piduser,
		:pdesperson, 
		:pdeslogin, 
		:pdespassword, 
		:pdesemail, 
		:pnrphone, 
		:pinadmin)",array(":piduser"=>$this->getiduser(),
			":pdesperson"=>utf8_decode($this->getdesperson()),
			":pdeslogin"=>$this->getdeslogin(),
			":pdespassword"=>$this->getdespassword(),
			":pdesemail"=>$this->getdesemail(),
			":pnrphone"=>$this->getnrphone(),
			":pinadmin"=>$this->getinadmin()));
	
	

	}



public  function delete($iduser){

	
	$sql=new Sql();

	$result=$sql->select("call sp_users_delete(
		:iduser)",array(":iduser"=>$iduser));
	
	

	}
	
	
	  public static function getForgot($email, $inadmin = true){

  	

  		$sql=new Sql();


  		//verica se email esta cadastrado
	$results=$sql->select("select * from tb_persons p inner join tb_users using(idperson) where p.desemail= :email",array(":email"=>$email));


//se nao tiver resultado
	if(count($results)===0){

			throw new \Exception ("Não foi possivel recuperar a senha!"); 

	}else{//se tiver
			

			$data=$results[0];//obtem dados da consulta anteriro

//chama procedure (passando os parametros iduser e o ip do usuario) que faz o cadastrado na tabela userspasswordsrecoveries(recuperção de senhas)
//assim gerando um id do registro na tabela de recupeção de senha
			$results2=$sql->select("call sp_userspasswordsrecoveries_create(
		:iduser,
		:desip 
		)",array(":iduser"=>$data["iduser"],
			":desip"=>$_SERVER['REMOTE_ADDR']
			));


			//essa procedure traz por fim os dados da tabela de recuperação de senha
			if(count($results2)===0){

			throw new \Exception ("Não foi possivel recuperar a senha!"); 

			}else{
						
				$data2=$results2[0];

					
				//base64_encode() transforma  codigos em texto/caracteres legiveis
				$code = base64_encode($data2['idrecovery']);

				
				//gerando um código criptografado do id_recovery da tabela de recuperação de senha 
			
				/*mcrypt_encrypt() é uma função q faz a criptografia obs: essa função é obssoleta apartir php 7.1
				
				$code=base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128,User::KEY_SECRET, $data2['id_recovery'],MCRYPT_MODE_ECB));

				*/

				//vamos usar a função openssl_encrypt() para criptografar
				openssl_encrypt($code, 'AES-128-CBC', pack("a16",User::KEY_SECRET), 0, pack("a16", User::KEY_SECRET_II));

				//link para enviar por email usando php mailer para que usuario acesse 
				//nosso sistema para digitar a nova senha
				if ($inadmin === true) {
					
					$link="http://www.lojaracao.com.br/admin/forgot/reset?code=$code";

				} else {

					$link="http://www.lojaracao.com.br/forgot/reset?code=$code";


				}



				
				//chamando a classe criada phpMailer para fazer o envio  do email usando PHPMAILER
				$mailer= new Mailer($data['desemail'],$data['desperson'],"Redefinir senha da Loja Ração","forgot",array("name"=>$data['desperson'],"link"=>$link));

				//fazedendo o envio do email
				$mailer->send();

				return $data;
			}





	}
	


  }

public static function validForgotDecrypt($code)
	{

		//converte de codigo para texto
		$code = base64_decode($code);


		

		$idrecovery = openssl_decrypt($code, 'AES-128-CBC', pack("a16", User::KEY_SECRET), 0, pack("a16", User::KEY_SECRET_II));



		$sql = new Sql();
		

//sql q faz a validação verificando se existe registro , se nao ja nao foi validado e
//  e se  esta dentro de uma hora do momento q foi cadastro o registro de recuperação de senha	
		$results = $sql->select("
			SELECT *
			FROM tb_userspasswordsrecoveries a
			INNER JOIN tb_users b on a.iduser=b.iduser
			INNER JOIN tb_persons c on c.idperson=b.idperson
			WHERE
				a.idrecovery = :idrecovery
				AND
				a.dtrecovery IS NULL
				AND
				DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW()
		",[":idrecovery"=>$code]);

		

		


		if (count($results[0]) === 0)
		{
			throw new \Exception("Não foi possível recuperar a senha.");
		}
		else
		{

			return $results[0];

		}

	}
	
	
	public static function setFogotUsed($idrecovery)
	{

		$sql = new Sql();
		//setando a data de validação da recuperação de senha

		$sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery", array(
			":idrecovery"=>$idrecovery
		));

	}
	



public  function setPassword($password)
	{

		$sql = new Sql();

		//setando a nova senha no banco de dados 
		$sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", array(
			":password"=>$password,
			":iduser"=>$this->getiduser()
		));

	}

}

 ?>
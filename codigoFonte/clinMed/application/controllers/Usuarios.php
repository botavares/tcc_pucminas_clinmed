<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Usuarios_model', 'Usuarios');
		$this->load->model('Crud_model', 'Crud');
    }
	
	
	public function index(){
		//Verificar se está logado
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		//carregar usuários cadastrados
		$dadosUsuarios = $this->Usuarios->readUsuarios();
		
		 $tituloTabelas = array(
            "Nome do Profissional","Nome do Usuário","Nível","Cargo"
        );
        $arrayView = array(
            "camada1"		=>'telas',
            "camada2"		=>'usuarios',
            "pagina"		=>'usuarios',
            "usuario"		=>$this->session->userdata('ds_nome_profissional'),
            "perfil"		=>$this->session->userdata('ds_nivel'),
			"dadosUsuarios"	=>$dadosUsuarios,
			"titulosTabela"	=>$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	
	public function formUsuarios(){
		
		if($this->uri->segment(3)=="superusuario"){
			$nomesProfissionais = $this->Crud->read("tb_profissionais","ds_nome_profissional");
			$tipoUsuario = "superusuario";
		}else{
			$nomesProfissionais = $this->Usuarios->readProfSemUsuarios();
			$tipoUsuario = "usuario";
			if(!$nomesProfissionais){
				$this->session->set_flashdata( 'mensagemerror', 'Não existe novos profissionais para cadastrar seus usuários!' );
				redirect( 'Usuarios' );
			}
		}
		
			$arrayView = array(
				"camada1"			=> 'telas',
				"camada2"			=> 'usuarios',
				"pagina"			=> 'formUsuarios',
				"nomesProfissionais"=> 	$nomesProfissionais,
				"tipoUsuario"		=>	$tipoUsuario,
				"usuario"			=> 	$this->session->userdata('ds_nome_profissional'),
				"perfil"			=> 	$this->session->userdata('ds_nivel'),
			);
			$this->load->view('layout',$arrayView);
		
	}
	
	
	
	/*=======================================================================
	======================================================================*/
	public function alterarSenha(){
		
		$usuario = $this->input->post("usuario");
		$senhaatual = sha1($this->input->post("senhaatual"));
		$novasenha = sha1($this->input->post("novasenha"));
		$verificacao = $this->Usuarios->getUsuario($usuario,$senhaatual);
		
		if(!$verificacao){
			$arrayView = array(
					"camada1"=>'errors',
					"camada2"=>'html',
					"pagina"=>'error_login',
					"heading"=>"Erro no login",
					"message"=>"Alteração negada. Sua senha atual não confere! Verifique sua digitação."
				);
				$this->load->view('layoutLogin',$arrayView);
		}else{
			if(!$novasenha==NULL){
				$dados = array(
					'ds_senha_usuario'=>$novasenha,
				);
				$this->Crud->update("tb_usuarios",$dados,array("ds_nome_usuario"=>$usuario));
				redirect('Home');
			}else{
				$this->session->set_flashdata('mensagemerror','Nova senha não pode ficar em branco.');
				redirect('Home');
			}
		}
	}
	
	
	public function reiniciarSenha(){
		$idUsuario = $this->input->post("chavePrimaria");
		$senha = sha1("1234567");
		$verificacao = $this->Crud->readBy("tb_usuarios","pk_id_usuario",$idUsuario,"ds_nome_usuario");
		if($verificacao){
			$dados = array(
					'ds_senha_usuario'=>$senha,
			);
			$this->Crud->update("tb_usuarios",$dados,array("pk_id_usuario"=>$idUsuario));
			redirect('Usuarios');
		}else{
			$this->session->set_flashdata('mensagemerror','Não foi possível reiniciar a senha desse usuário.'.$idUsuario);
			redirect('Usuarios');
		}
		
	}
	
	public function registrarDados(){
		
		$nome 			= $this->input->post("nome");
		$idProfissional	= $this->input->post("idProfissional");
		$nivel 			= $this->input->post("nivel");
		$acao 			= $this->input->post("action");
		
		if ($acao == "create"){
			$senha = sha1("1234567");
		}else if($acao == "update"){
			$usuario = $this->Crud->readBy("tb_usuarios","pk_id_usuario",$this->input->post( 'id' ),"ds_nome_usuario");
			$senha = $usuario[0]["ds_senha_usuario"];
		}
		
		$dados = array(
			"ds_nome_usuario"		=> $nome,
			"fk_id_profissional"	=> $idProfissional,
			"ds_nivel"				=> $nivel,
			"ds_senha_usuario"		=> $senha
		);
		
		$this->form_validation->set_rules( 'nome', 'Nome do Usuário', 'required' );
		$this->form_validation->set_rules( 'idProfissional', 'Nome do Profissional', 'required' );
		$this->form_validation->set_rules( 'nivel', 'Nível de usuário', 'required' );
		
		if ( $this->form_validation->run() == true ) {
			$verificarUsuario = $this->Crud->readBy("tb_usuarios","ds_nome_usuario",$nome,"ds_nome_usuario");
			
			if ( $acao == 'create' ) {
				if(!$verificarUsuario){
					$this->Crud->create( "tb_usuarios", $dados );
					redirect( 'Usuarios' );
				}else{
					$this->session->set_flashdata( 'mensagemerror', 'Já existe um usuário com esse nome cadastrado!' );
					redirect( 'Usuarios' );
				}
			}
			
			if ( $acao == 'update' ) {
				$this->Crud->update( "tb_usuarios", $dados, array( "pk_id_usuario" => $this->input->post( 'id' ) ) );
				redirect( 'Usuarios' );
			}
		}else{
			if($this->input->post("action")=='create'){
				$this->formUsuarios();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('Usuarios');
			}
		}
	}
	
	
	
	public function listarJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Usuarios->readUsuarioProfissional($id);
		$jsonData="";
		
		//Resolvi fazer separadamente para usuário para não 'carregar' a senha no json.
		foreach ( $data as $row ) {
			$jsonData[] = array(
				'pk_id_usuario'			=> $row[ 'pk_id_usuario' ],
				'fk_id_profissional' 	=> $row[ 'fk_id_profissional' ],
				'ds_nome_usuario'		=> $row[ 'ds_nome_usuario' ],
				'ds_nivel'				=> $row[ 'ds_nivel' ],
				'ds_nome_profissional'	=> $row[ 'ds_nome_profissional' ],
			);
		}
		if ( $jsonData==[""] ) {
			$jsondt = array( 
				array(
					'retorno' => 'false'
				),
			);
			echo json_encode( $jsondt );
		} else {
			echo json_encode( $jsonData );
		}
	}
	
	
	public function delete() {
		$idUsuario = $this->input->post( "chavePrimaria" );
		$tipoUsuario = $this->Crud->readBy("tb_usuarios","pk_id_usuario",$idUsuario);
		if($tipoUsuario[0]["ds_nivel"]== 1 ){
			$totalSuperUsuarios = $this->Crud->contarRegistros("tb_usuarios","ds_nivel = 1");
			if($totalSuperUsuarios > 1){
				$this->Crud->delete( "tb_usuarios", array( "pk_id_usuario" => $idUsuario ) );
				redirect("Usuarios");
			}else{
				$this->session->set_flashdata( 'mensagemerror', 'Deve existir pelo menos um Superusuário no sistema' );
				redirect( 'Usuarios' );
			}
		}else{
			$this->Crud->delete( "tb_usuarios", array( "pk_id_usuario" => $idUsuario ) );
			redirect("Usuarios");
		}
	}
	
	
	public function logar(){
		$usuario = $this->input->post("usuario");
		$senha = sha1($this->input->post("senha"));
		
		$dados = $this->Usuarios->getUsuario($usuario,$senha);
		
		if($dados){
			
			$this->session->set_userdata(
				array(
						'pk_id_usuario'			=>		$dados[0]["pk_id_usuario"],
						'fk_id_profissional'	=>		$dados[0]["fk_id_profissional"],
						'ds_nome_usuario'		=>		$dados[0]["ds_nome_usuario"],
						'ds_nome_profissional'	=>		$dados[0]["ds_nome_profissional"],
						"ds_sexo"				=>		$dados[0]["ds_sexo"],
						'ds_nivel'				=>		$dados[0]["ds_nivel"],
						'ds_status'				=>		"TRUE"
						
				)
			);
			
			redirect("Home/iniciar");
			
		}else{
			$this->session->sess_destroy();
			$arrayView = array(
				"camada1"=>'errors',
				"camada2"=>'html',
				"pagina"=>'error_login',
				"heading"=>"Usuário ou senha não encontrado",
				"message"=> "Usuário ou senha inválido! Verifique sua digitação."
			);
			$this->load->view('layoutLogin',$arrayView);
		}
	}
	
	public function logOut(){
		$this->session->sess_destroy();
		redirect('Home');
		
	}
	
	
}

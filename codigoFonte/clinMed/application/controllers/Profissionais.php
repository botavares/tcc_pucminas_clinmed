<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profissionais extends CI_Controller {
	public function __construct(){
		
		parent::__construct();
		$this->load->model('Profissionais_model', 'Profissionais');
		$this->load->model('Crud_model', 'Crud');
		$this->load->library( 'form_validation' );
    }
	
	public function index(){
		//Verificar se logado está
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$dadosProfissionais	=	$this->Profissionais->profissionaisCargos();
		$cargos				=	$this->Crud->read("tb_cargos","ds_nome_cargo");
		$especialidades		=	$this->Crud->read("tb_especialidades","ds_nome_especialidade");
		
		$tituloTabelas		=	array(
            "Profissional","cargo","Telefone"
        );
		
        $arrayView = array(
            "camada1"			=>	'telas',
            "camada2"			=>	'profissionais',
            "pagina"			=>	'profissionais',
            "usuario"			=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"			=>	$this->session->userdata('ds_nivel'),
			"dadosProfissionais"=>	$dadosProfissionais,
			"cargos"			=>	$cargos,
			"especialidades"	=>	$especialidades,
			"titulosTabela"		=>	$tituloTabelas,
        );
        $this->load->view('layout',$arrayView);
	}
	
	public function formProfissionais(){
		
		if(!$this->session->userdata('ds_status')){
			redirect('Home');
		}
		
		$cargos = $this->Crud->read("tb_cargos","ds_nome_cargo");
		$especialidades = $this->Crud->read("tb_especialidades","ds_nome_especialidade");
		
		 $arrayView	=	array(
            "camada1"			=>	'telas',
            "camada2"			=>	'profissionais',
            "pagina"			=>	'formProfissionais',
			"cargos"			=>	$cargos,
			"especialidades"	=>	$especialidades,
            "usuario"			=>	$this->session->userdata('ds_nome_profissional'),
            "perfil"			=>	$this->session->userdata('ds_nivel'),
        );
        $this->load->view('layout',$arrayView);
	}
	
	public function registrarDados(){
		$acao	=	$this->input->post("action");
		
		$verificarRegistroCRM = $this->Crud->readBy("tb_cargos","pk_id_cargo",$this->input->post("selectCargo"),"ds_nome_cargo");
		$possuiRegistroCRM = $verificarRegistroCRM[0]["ds_registro_conselho"];
		
		
		$dados	=	array(
			"ds_nome_profissional"	=> 	$this->input->post("nome"),
			"fk_id_cargo"			=> 	$this->input->post("selectCargo"),
			"ds_sexo"				=>	$this->input->post("sexo"),
			"ds_cpf"				=> 	$this->input->post("cpf"),
			"ds_crm"				=> 	$this->input->post("crm"),
			"ds_cep"				=> 	$this->input->post("cep"),
			"ds_logradouro"			=> 	$this->input->post("logradouro"),
			"ds_numresidencia"		=> 	$this->input->post("numero"),
			"ds_complemento"		=> 	$this->input->post("complemento"),
			"ds_bairro"				=> 	$this->input->post("bairro"),
			"ds_telfixo"			=>	$this->input->post("telfixo"),
			"ds_telcel"				=> 	$this->input->post("telcel"),
			"ds_email"				=> 	$this->input->post("email"),
			"fk_id_especialidade"	=>	$this->input->post("especialidade"),
		);
		
		
		
		$this->form_validation->set_rules( 'nome', 'Nome do Profissional', 'required' );
		$this->form_validation->set_rules( 'selectCargo', 'Cargo', 'required' );
		$this->form_validation->set_rules( 'cpf', 'CPF do Profissional', 'required' );
		
		if($possuiRegistroCRM == 1){
			$this->form_validation->set_rules( 'crm', 'Registro no CRM', 'required' );
			$this->form_validation->set_rules( 'especialidade', 'Especialidade Médica', 'required' );
		}
		
		$this->form_validation->set_rules( 'cep', 'Nome do Profissional', 'required' );
		$this->form_validation->set_rules( 'logradouro', 'Rua de residência', 'required' );
		$this->form_validation->set_rules( 'bairro', 'Bairro do Profissional', 'required' );
		$this->form_validation->set_rules( 'telcel', 'Telefone do Profissional', 'required' );
		$this->form_validation->set_rules( 'email', 'Email do Profissional', 'required|valid_email' );

		if ( $this->form_validation->run() == true ) {
			
			if ( $acao == 'create' ) {
				$duplicidade = $this->Crud->readBy( "tb_profissionais", "ds_cpf", $this->input->post("cpf"),"ds_nome_profissional" );
				if ( !$duplicidade ) {
					$this->Crud->create( "tb_profissionais", $dados );
					redirect( 'Profissionais' );
				} else {
					$this->session->set_flashdata( 'mensagemerror', 'Já existe um profissional com esse cpf cadastrado!' );
					redirect( 'Profissionais' );
				}
			}
			
			if ( $acao == 'update' ) {
				$this->Crud->update( "tb_profissionais", $dados, array( "pk_id_profissional" => $this->input->post( 'id' ) ) );
				redirect( 'Profissionais' );
			}
			
		}else{
			if($this->input->post("action")=='create'){
				$this->formProfissionais();
			}else if($this->input->post("action")=='update'){
				$this->session->set_flashdata('mensagemerror', validation_errors());
				redirect('Profissionais');
			}
		}
	}
	/*====================================================
	Função: Deleção de alguma dicretiva
	Nome: delete
	Última Modificação: 10/06/2019
	======================================================*/
	public function delete() {
		$codigo = $this->input->post( "chavePrimaria" );
		$verificarVinculoProfissional = $this->Crud->readBy("tb_agendaconsultas", "fk_id_profissional",$codigo,"fk_id_profissional");
		if(!$verificarVinculoProfissional){
			$verificarVinculoUsuario = $this->Crud->readBy("tb_usuarios", "fk_id_profissional",$codigo,"fk_id_profissional");
			if(!$verificarVinculoUsuario){
				$this->Crud->delete( "tb_profissionais", array( "pk_id_profissional" => $codigo ) );
				redirect("Profissionais");
			}else{
				$this->session->set_flashdata( 'mensagemerror', 'Esse profissional está vinculado a um usuário!' );
				redirect("Profissionais");
			}
		}else{
			$this->session->set_flashdata( 'mensagemerror', 'Esse profissional está vinculado à consultas agendadas!' );
			redirect("Profissionais");
		}
	}
	/*====================================================
	Função: listar informações e retornar em json
	Nome: listarJSON
	Última Modificação: 10/06/2019
	======================================================*/
	public function listarProfissionaisJSON(){
		$id = trim( $_POST[ 'id' ] );
		$data = $this->Crud->readBy( "tb_profissionais", "pk_id_profissional", $id, "ds_nome_profissional" );
		// jsonMe é um 'helper' criado por mim e está localizado no arquivo clinica_helper na pasta application/helpers
		jsonMe($data); 
	}
	
}
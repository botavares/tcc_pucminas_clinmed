<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model{
	
    public function __constuct(){
		parent::__constuct();
		
	}
	/*====================================
	Nome: 	create
	Função:	Persistencia dos dados
	Modificação: 09/08/2019	
	======================================*/
	public function create($tabela=NULL,$dados=NULL){
        $default = $this->load->database('default', TRUE);
		if($dados!=NULL){
			if($default->insert($tabela,$dados)){
				$this->session->set_flashdata('mensagemok','CADASTRO feito com sucesso!');
			}else{
				$this->session->set_flashdata('mensagemError','Não consegui gravar suas informações. Contate o desenvolvedor!');
			}
		}	
	}
	
	
	 /*====================================
	Nome: 	Read
	Função:	Recupera dados de uma tabela
	Modificação: 09/08/2019
	======================================*/   
    public function read($tabela = NULL,$order=NULL){
		if($tabela!=NULL || $order!=NULL){
        	$default = $this->load->database('default', TRUE);
			$query = $default->order_by($order, 'ASC');
			$query = $default->get($tabela);
			return $query->result_array();
		}else{
			$this->session->set_flashdata('mensagemError','Não consegui listar a informação que pediu. Contate o desenvolvedor!');
		}
    }
	
	
	/*====================================
	Nome: 	readBy
	Função:	Consulta uma tabela impondo condições
	Modificação: 19/08/2019	
	======================================*/
	public function readBy($tabela=NULL, $campo=NULL, $dados=NULL,$order=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by($order/*, 'ASC'*/);
		$query 		= $default->where($campo, $dados);
		$query 		= $default->get($tabela);
		return $query->result_array();
	}
	
	
	/*====================================
	Nome: 	readCond
	Função:	Consulta uma tabela impondo mais de uma condição
	Modificação: 19/08/2019	
	======================================*/
	public function readCond($tabela=NULL, $campo1=NULL, $dados1=NULL, $campo2=NULL, $dados2=NULL,$order=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by($order/*, 'ASC'*/);
		$query 		= $default->where($campo1, $dados1);
		$query 		= $default->where($campo2, $dados2);
		$query 		= $default->get($tabela);
		return $query->result_array();
	}
	
	/*====================================
	Nome: 	readCond
	Função:	Consulta uma tabela impondo mais de uma condição
	Modificação: 19/08/2019	
	======================================*/
	public function readORCond($tabela=NULL, $campo1=NULL, $dados1=NULL, $campo2=NULL, $dados2=NULL,$order=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by($order/*, 'ASC'*/);
		$query 		= $default->where($campo1, $dados1);
		$query 		= $default->or_where($campo2, $dados2);
		$query 		= $default->get($tabela);
		return $query->result_array();
	}
	
	
	/*====================================
	Nome: 	update
	Função:	Altera dados de uma tabela
	Modificação: 09/08/2019	
	======================================*/
    public function update($tabela=NULL,$dados=NULL,$id=NULL){
        $default = $this->load->database('default', TRUE);
		if($dados!=NULL && $id!=NULL){
			if($default->update($tabela,$dados,$id)){
				$this->session->set_flashdata('mensagemok','AÇÃO executada com sucesso!');
			}else{
				$this->session->set_flashdata('mensagemError','Não consegui alterar a informação que pediu. Contate o desenvolvedor!');
			}
		}
	}
	
	/*====================================
	Nome: 	delete
	Função:	Exclusão dos dados de uma tabela
	Modificação: 09/08/2019	
	======================================*/
	public function delete($tabela=NULL,$dados=NULL){
		$default = $this->load->database('default', TRUE);
		if($dados!=NULL){
			if($default->delete($tabela,$dados)){
				    $this->session->set_flashdata('mensagemok','EXCLUSÃO feita com sucesso!');
                }else{
                    $this->session->set_flashdata('mensagemerror','Não consegui excluir o registro. Contate o desenvolvedor');
                }
            }
		
	}
	
	
	public function contarRegistros($tabela=NULL,$where=NULL){
		$default = $this->load->database('default', TRUE);
		$default->where($where);
		$default->select('count(*)');
		$default->from($tabela);
		$query = $default->count_all_results();
		return $query;
		
	}
	
	public function maiorNumero($tabela=NULL,$campo=NULL){
		$default = $this->load->database('default', TRUE);
		$default->select_max($campo,'maiorNumero');
		$query = $default->get($tabela);
		return $query;
	}
	
	
	
	
	
	
}
<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model{
	
    public function __constuct(){
		parent::__constuct();
		
	}
	
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
	
	
	
	public function readBy($tabela=NULL, $campo=NULL, $dados=NULL,$order=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by($order/*, 'ASC'*/);
		$query 		= $default->where($campo, $dados);
		$query 		= $default->get($tabela);
		return $query->result_array();
	}
	
	
	
	public function readCond($tabela=NULL, $campo1=NULL, $dados1=NULL, $campo2=NULL, $dados2=NULL,$order=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by($order/*, 'ASC'*/);
		$query 		= $default->where($campo1, $dados1);
		$query 		= $default->where($campo2, $dados2);
		$query 		= $default->get($tabela);
		return $query->result_array();
	}
	
	
	public function readORCond($tabela=NULL, $campo1=NULL, $dados1=NULL, $campo2=NULL, $dados2=NULL,$order=NULL){
		$default 	= $this->load->database('default', TRUE);
		$query 		= $default->order_by($order/*, 'ASC'*/);
		$query 		= $default->where($campo1, $dados1);
		$query 		= $default->or_where($campo2, $dados2);
		$query 		= $default->get($tabela);
		return $query->result_array();
	}
	
	
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
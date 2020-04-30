<?php
$controler = "Consultas";
$anoAtual = date('Y');
$refer =  base_url()."Home/iniciar/";
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Histórico dos pacientes</h2>
				<div class="clearfix"></div>
			</div>
			<?php
				if($this->session->flashdata('mensagemok')):?>
					<div id="porta-mensagem">
						<div class="mensagem alert alert-success alert-block alert-aling" role="alert">
							<?php echo $this->session->flashdata('mensagemok')?>
						</div>
					</div>
			<?php endif;?>
			<?php
				if($this->session->flashdata('mensagemerror')):?>
					<div id="porta-mensagem">
						<div class="mensagem alert alert-danger alert-block alert-aling" role="alert">
							<?php echo $this->session->flashdata('mensagemerror')?>
						</div>
					</div>
			<?php endif;?>
			
			<table id="datatable-fixed-header" class="table table-striped table-bordered">
				<thead>
					<tr>
						<?php
							for($i = 0,$j=count($titulosTabela);$i<$j;$i++){
						?>
						<th ><?php echo $titulosTabela[$i]?></th>
						<?php 
							}
						?>
						<th>Acessar Prontuário</th>
						
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($pacientes as $valuePacientes){?>
					<tr>
						<td align="center"><?php echo $valuePacientes['pk_id_cliente']?></td>
						<td><?php echo $valuePacientes['ds_nome_cliente']?></td>
						<td><?php echo $valuePacientes['ds_cpf_cliente']?></td>
						<td align="center"><a class="btn btn-success" href="<?php echo base_url().'Consultas/historicoPaciente/'.$valuePacientes['pk_id_cliente'].'/'.$medico?>">Acessar Histórico</a>
						</td>
					</tr>
						<?php } ?>
				</tbody>
			</table>
			<a class="btn btn-warning" href="<?php echo $refer?>"> Voltar </a>
		</div>
	</div>
</div>
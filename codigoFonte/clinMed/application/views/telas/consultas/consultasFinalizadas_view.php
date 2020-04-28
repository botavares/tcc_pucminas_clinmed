<?php
$controler = "Consultas";
$anoAtual = date('Y');
?>
<div class="right_col" role="main">
	<div class="x_panel">
		<div class="x_content">
			<div class="x_title">
				<h2>Consultas Finalizadas </h2>
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
						<th>Iniciar Consulta</th>
						
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($relacaoConsultas as $keyConsultas){?>
					<tr>
						<td><?php echo $keyConsultas['ds_nome_cliente']?></td>
						<td align="center"><?php echo date('d/m/Y',strtotime($keyConsultas['ds_data']))?></td>
						<td align="center"><?php echo date('H:i',strtotime($keyConsultas['ds_hora']))?></td>
						<td align="center"><?php echo $keyConsultas['ds_tipo_atendimento'] == 1 ? "CONSULTA" : "RETORNO" ?></td>
						<td><?php echo $keyConsultas['ds_nome_plano'] ?></td>
						
						<?php 
							$numeroConsulta = $keyConsultas['ds_numero_consulta'];

						?>

						<td align="center"><a class="btn btn-success" href="<?php echo base_url().'Medicos/iniciarConsultas/'.$keyConsultas['pk_id_cliente'].'-'.$keyConsultas['ds_tipo_atendimento'].'-'.$numeroConsulta.'-'.$keyConsultas['fk_id_profissional']?>">REVER CONSULTA</a>
						</td>
					</tr>
						<?php } ?>
				</tbody>
			</table>
			<a href="<?php echo base_url()."Medicos/formAtendimentoConsultas/1"?>" class="btn btn-primary">Consultas em aberto</a>
		</div>
	</div>
</div>
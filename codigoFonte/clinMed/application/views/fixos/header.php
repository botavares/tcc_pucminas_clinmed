<?php
//header('Content-Type:text/html; charset=UTF-8');
$previous_encoding = mb_internal_encoding();
$caminho = base_url();
$gentelella = $caminho."external/gentelella/vendors/";


   //Set the encoding to UTF-8, so when reading files it ignores the BOM       
   mb_internal_encoding('UTF-8');
   //Finally, return to the previous encoding
   mb_internal_encoding($previous_encoding);
?>

<!DOCTYPE>
<html lang="pt-br">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="TCC, PUC Minas, Clínica Médica">
		<meta name="author" content="Breno Oliveira Tavares">
		
		<title>Clínica Médica</title>
		<!-- Bootstrap -->
		<link type="text/css" href="<?php echo $gentelella."bootstrap/dist/css/bootstrap.min.css"?>" rel="stylesheet">
		<!-- Font Awesome -->
        <link type="text/css"  rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
       	<!--<link href="<?php echo base_url()."external/font-awesome/css/font-awesome.css"?>" rel="stylesheet">-->
        <link type="text/css"  href="<?php echo $gentelella."font-awesome/css/font-awesome.css"?>" rel="stylesheet">
        <!-- NProgress -->
        <link type="text/css"  href="<?php echo $gentelella."nprogress/nprogress.css"?>" rel="stylesheet">
        <!-- iCheck -->
        <link type="text/css"  href="<?php echo $gentelella."iCheck/skins/flat/green.css"?>" rel="stylesheet">
        <!-- pretify-->
        <link type="text/css"  href="<?php echo $gentelella."google-code-prettify/bin/prettify.min.css"?>" rel="stylesheet">
        <!-- animate -->
        <link type="text/css"  href="<?php echo $gentelella."animate.css/animate.min.css"?>" rel="stylesheet">
		<!-- Select2 -->
        <link type="text/css"  href="<?php echo $gentelella."select2/dist/css/select2.min.css"?>" rel="stylesheet">
		<!-- Switchery -->
		<link type="text/css"  href="<?php echo $gentelella."switchery/dist/switchery.min.css"?>" rel="stylesheet">
		<!-- starrr -->
		<link type="text/css"  href="<?php echo $gentelella."starrr/dist/starrr.css"?>" rel="stylesheet">
        <!-- bootstrap-progressbar -->
        <link type="text/css"  href="<?php echo $gentelella."bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"?>" rel="stylesheet">
        <!-- JQVMap -->
        <link type="text/css"  href="<?php echo $gentelella."jqvmap/dist/jqvmap.min.css"?>" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link type="text/css"  href="<?php echo $gentelella."iconPicker/dist/css/fontawesome-iconpicker.css"?>" rel="stylesheet"/>
        <link type="text/css"  href="<?php echo $gentelella."bootstrap-daterangepicker/daterangepicker.css"?>" rel="stylesheet">
        <!-- datatables -->
        <link type="text/css"  href="<?php echo $gentelella."datatables.net-bs/css/dataTables.bootstrap.min.css"?>" rel="stylesheet">
        <link type="text/css"  href="<?php echo $gentelella."datatables.net-buttons-bs/css/buttons.bootstrap.min.css"?>" rel="stylesheet">
        <link type="text/css"  href="<?php echo $gentelella."datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"?>" rel="stylesheet">
        <link type="text/css"  href="<?php echo $gentelella."datatables.net-responsive-bs/css/responsive.bootstrap.min.css"?>" rel="stylesheet">
        <link type="text/css"  href="<?php echo $gentelella."datatables.net-scroller-bs/css/scroller.bootstrap.min.css"?>" rel="stylesheet">
        <!-- FullCalendar -->
        <link href="<?php echo $gentelella."fullcalendar/dist/fullcalendar.min.css"?>" rel="stylesheet">
        <link href="<?php echo $gentelella."fullcalendar/dist/fullcalendar.print.css"?>" rel="stylesheet" media="print">
        
        <!-- Custom Theme Style -->
		<link type="text/css"  href="<?php echo base_url()."/external/css/calendario.css"?>" rel="stylesheet">        
        <link type="text/css"  href="<?php echo base_url()."external/gentelella/build/css/custom.css"?>" rel="stylesheet">
		<link type="text/css"  href="<?php echo base_url()."/external/css/includes.css"?>" rel="stylesheet">        

		
		<script type="text/javascript">
    		var path = '<?php echo base_url(); ?>'
		</script>
        
	</head>
	
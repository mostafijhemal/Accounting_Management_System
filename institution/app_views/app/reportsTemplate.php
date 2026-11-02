<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="01816293649">

	<title><?php echo $title; ?></title>
	<style>
		@media print {
			.no-print {
				display: none !important;
				height: 30px;
			}
			.tableHeaderFooter th {
				color: #000;
			}
		}
		.fixedElement {
			background-color: #6CB5D7;
			position:fixed;
			top:0;
			height: 30px;
			width:100%;
			z-index:100;
			text-align: center;

		}
		table {
			border-collapse: collapse;
		}
		td, th {
			padding: 3px;
		}
		.pageBody {
			background-color: white;
			margin: 0 auto;
			margin-top: 30px !important;
		}
		.portrait {
			width:740px;
			padding: 0px 15px 20px 40px;
		}
		.landscape {
			padding: 0px 15px 20px 40px;
		}
		.company_name {
			font-family:'Lucida Calligraphy';
			font-size:14px;
			text-align: center;
		}
		.reportName {
			font-family:'Lucida Calligraphy';
			font-size:14px;
			text-align: center;
			padding: 10px;
		}
		.tableDesign {
			font-size:11px;
			font-family:Verdana, Arial, Helvetica, sans-serif, 'Comic Sans MS'; 
			width:100%; 
			padding:2px;
			border: 1px solid #C7E3C7;
		}
		.custom-border {
			border: 1px solid #000 !important;
		}
		.tableDesign .sign_field {
			width:24%;
			float:left;
			text-align:center;
		}
		.tableHeaderFooter {
			background-color:#2B3643 !important; 
			font-size:12px; 
			color: white;
		}
		tr:nth-child(even) {
		    background-color: #EEEEEE;
		}
		.btnStyle {
			margin-top: 4px; 
			margin-right: 5px;
		}
	</style>
</head>
<body style="margin:0px; font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size: 14px;">
	<div class='fixedElement no-print'>
		<button class="btnStyle" onClick='window.print();'>Print</button>
		<!-- <button class="btnStyle">Excel</button>
		<button class="btnStyle">PDF</button> -->
	</div>
	<div class="pageBody" id="pageBody">
		<div class="company_name">
			<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
				<?php $head_data = $this->M_crud->findById('institute_info', array('id' => 1)); ?>
				<span style="font-size:18px; font-weight:bold;"><?php if(!empty($head_data->full_name)) echo $head_data->full_name; ?></span><br />
				<span class="style1" style="font-size:13px; font-weight:bold;"><?php if(!empty($head_data->head_office)) echo $head_data->head_office; ?></span><br />
			</div>
			<div class="reportName">
				<?php echo $title;?>
			</div>
			<!-- REPORT BODY START -->
			<?php if(isset($view)) {$this->load->view($view);} ?>
			<!-- REPORT BODY END -->
		</div>
	</div>
	<script type="text/javascript">
		/*function ChangeUrl(page, url) {
	        if (typeof (history.pushState) != "undefined") {
	            var obj = {Page: page, Url: url};
	            history.pushState(obj, obj.Page, obj.Url);
	        } else {
	            window.close();
	        }
	    }

	  	ChangeUrl('Page1', 'AccountsReport');
		parent.location.hash = 'about:blank';*/
	</script>
</body>
</html>
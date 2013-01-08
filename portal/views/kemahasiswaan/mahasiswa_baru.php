
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-ina.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

<script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "mahasiswa/getlistJQGRID/baru" );
						  ?>',
					datatype: "json",
					colNames:['Kode Registrasi','Nama', 'Email','Waktu Pendaftaran','Status','Form F1'],	
					colModel:[
						{name:'reg_code',index:'reg_code',width:70,align:'center'},
						{name:'name',align:'center',index:'name',formatter:add_view_link},
						{name:'email',align:'center',index:'email'},
						{name:'reg_time',align:'center',index:'reg_time',width:90},						
						{name:'verified',index:'verified',width:100,align:'center',stype:'select',searchoptions:{value:{'0':'Not Verified','1':'Verified'}},formatter:check_verified},
						{name:'none',formatter:attach_link_f1,align:'center'}						
					],
					mtype : "POST",							
					sortname: 'name',
					rownumbers: true,
					pager: "#pager2",
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",					
					jsonReader: { repeatitems : false, id: "0"}
				}).navGrid('#pager2',{edit:false,add:false,del:false, search: true},{},{},{},{					
					sopt:['cn']
		});
		
		function attach_link_f1(cellValue, options, rowObject){
			return '<a target="_blank" href="<?php echo base_url(); ?>pendaftaran/show_pdf/' + rowObject.reg_code + '/true">Download</a>'
		}

		function check_verified(cellValue, options, rowObject){
			if(cellValue==1){
				return '<button class="blue small" style="width:140px">Verified</button>';
			}else{
				return '<button class="unverified" class="red small" style="width:140px">Not Verified<input type="hidden" value="' + rowObject.reg_code  + '" /></button>';
			}
		}	
		
		function add_view_link(cellValue, options, rowObject){
			return '<a href="#" class="viewStudent">' + cellValue + '<input type="hidden" value="' + rowObject.reg_code  + '" /></a>';
		}
		
		$(".viewStudent").live('click',function(){
			$("#dialogcontainer").attr("title","Data Mahasiswa");
			var data = $(this).children("input:hidden").val();
			$.ajax({
					  type: "POST",
					  url: "<?php echo site_url("mahasiswa/get_mahasiswa_baru_by_reg_code"); ?>/" + data + "/html",
					  dataType: "html",					  
					  beforeSend: function(){
						$("#dialogcontainer").html("<div class=\"ajax_loader\"></div>");
						$("#dialogcontainer").dialog({
							modal: true,
							position: {my: "top", at: "top", of: window},
							width: 800,
							height: 500,
							close: function(event,ui){
								$(this).dialog("destroy");
							}
						});
					  },
					  success: function(data){
							$("#dialogcontainer").html(data);
					  }
			});			
		});
		
		$(".unverified").live('click',function(){			
			var data = $(this).children("input:hidden").val();			
			$("#dialogcontainer").html("Konfirmasi pendaftaran mahasiswa ini?<span style='font-size:9px'><br /><i>(status tidak bisa dikembalikan)</i></span>");
			$("#dialogcontainer").attr("title","Konfirmasi Pendaftaran");
			$("#dialogcontainer").dialog({
				modal: true,
				buttons: {
                "Yes": function() {
                    $.ajax({
					  type: "POST",
					  url: "<?php echo site_url("mahasiswa/verify_mahasiswa_baru"); ?>",
					  dataType: "html",
					  data: {reg_code:data},
					  success: function(data){
						if(data!=""){
							alert(data);							
						}
						$("#grid_name").trigger("reloadGrid");							
					  }
					});
					$(this).dialog("close");
                },
                Cancel: function() {
                    $( this ).dialog("close");
                }
				},
				close: function(event,ui){
					$(this).dialog("destroy");
				},
				resizable: false
			});
			
		});			
								
	});
  </script>
 </head>
 <body>			
 <span style="font-size:8pt;"><i>Klik pada Nama untuk melihat data mahasiswa</i></span>
 <table id="grid_name" style="font-size:10pt"></table>
 <div id="pager2" ></div> 
 <div id="dialogcontainer" style="display:none;"></div> 
 

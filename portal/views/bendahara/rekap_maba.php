<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-ina.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

<script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "bendahara/get_rekap_maba" );
						  ?>',
					datatype: "json",
					colNames:['REG CODE','Nama','ver KMHS','ver DU','ver BS','Amount'],	
					colModel:[
						{name:'reg_code',index:'reg_code',align:'center'},						
						{name:'name',index:'name',formatter:add_view_link},
						{name:'verified',index:'verified',formatter:check_verified},
						{name:'duver',index:'duver',formatter:check_verified},
						{name:'bsver',index:'bsver',formatter:check_verified},
						{name:'amount',index:'amount'},										
					],
					mtype : "POST",					
					rownumbers: true,
					pager: "#pager2",
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",					
					jsonReader: { repeatitems : false, id: "0"}
				}).navGrid('#pager2',{edit:false,add:false,del:false, search: true},{},{},{},{					
					sopt:['cn']
		}).navButtonAdd("#pager2",{caption:"Export Current Table",buttonicon:"ui-icon-bookmark",
					onClickButton:function(){
						$("#grid_name").jqGrid('excelExport',{url:"<?php
						  echo site_url( "bendahara/exportCurrentCRUD_rekap_maba" );
						  ?>"});
				}, position: "last", title:"Export Current Table",cursor: "pointer"});

		function check_verified(cellValue, options, rowObject){
			if(cellValue==1){
				return '<button class="blue small" style="width:140px">Done</button>';
			}else{
				return '';
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
		
		
								
	});
  </script>
 </head>
 <body>			 
 
 <span style="font-size:8pt;"><i>Klik nomor NIM untuk melihat data mahasiswa</i></span>
 <table id="grid_name" style="font-size:10pt"></table>
 <div id="pager2" ></div> 
 <div id="dialogcontainer" style="display:none;"></div> 
 <div style="clear:both"></div>
 
 

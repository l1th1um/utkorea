<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-ina.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

<script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "bendahara/getlistJQGRID" );
						  ?>',
					datatype: "json",
					colNames:['Kode Konfirmasi','NIM', 'Semester','Nomer Account','Nama Bank','Tanggal Transfer','Atas Nama','Status'],	
					colModel:[
						{name:'id',index:'id'},
						{name:'nim',width:80,align:'center',index:'nim',formatter:add_view_link},
						{name:'period',width:50,align:'center',index:'period'},
						{name:'account_no',index:'account_no'},
						{name:'bank_name',index:'bank_name'},
						{name:'payment_date',width:90,align:'center',index:'payment_date'},
						{name:'sender_name',index:'sender_name'},
						{name:'is_verified',index:'is_verified',width:150,align:'center',stype:'select',searchoptions:{value:{'0':'Not Verified','1':'Verified'}},formatter:check_verified},						
					],
					mtype : "POST",							
					sortname: 'id',
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

		function check_verified(cellValue, options, rowObject){
			if(cellValue==1){
				return '<button class="blue small" style="width:140px">Verified</button>';
			}else{
				return '<button class="unverified" class="red small" style="width:140px">Not Verified<input type="hidden" value="' + rowObject.id  + '" /></button>';
			}
		}	
		
		function add_view_link(cellValue, options, rowObject){
			return '<a href="#" class="viewStudent">' + cellValue + '</a>';
		}
		
		$(".viewStudent").live('click',function(){
			$("#dialogcontainer").attr("title","Data Mahasiswa");
			var data = $(this).html();
			$.ajax({
					  type: "POST",
					  url: "<?php echo site_url("mahasiswa/get_mahasiswa_by_nim"); ?>/" + data,
					  dataType: "json",					  
					  beforeSend: function(){
						$("#dialogcontainer").html("<div class=\"ajax_loader\"></div>");
						$("#dialogcontainer").dialog({
							modal: true,
							close: function(event,ui){
								$(this).dialog("destroy");
							}
						});
					  },
					  success: function(data){
							
					  }
			});			
		});
		
		$(".unverified").live('click',function(){			
			var data = $(this).children("input:hidden").val();			
			$("#dialogcontainer").html("Anda yakin dengan konfirmasi pembayaran ini?<span style='font-size:9px'><br /><i>(status tidak bisa dikembalikan)</i></span>");
			$("#dialogcontainer").attr("title","Konfirmasi Pembayaran");
			$("#dialogcontainer").dialog({
				modal: true,
				buttons: {
                "Yes": function() {
                    $.ajax({
					  type: "POST",
					  url: "<?php echo site_url("bendahara/verify_daftar_ulang"); ?>",
					  dataType: "html",
					  data: {id:data},
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
 <span style="font-size:8pt;"><i>Klik nomor NIM untuk melihat data mahasiswa</i></span>
 <table id="grid_name" style="font-size:10pt"></table>
 <div id="pager2" ></div> 
 <div id="dialogcontainer" style="display:none;"></div> 
 
 
 

<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-ina.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

<script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "bendahara/get_transport_list" );
						  ?>',
					datatype: "json",
					colNames:['ID','Staff ID','Nama','Tanggal TTM','Total (Rp)','Deskripsi','Pilihan Pembayaran','Status'],	
					colModel:[
						{name:'id',index:'id',hidden:true},
						{name:'staff_id',index:'staff_id',hidden:true},
						{name:'name',index:'name',formatter:add_view_link},
						{name:'tanggalttm',index:'tanggalttm',align:'center',width:90},						
						{name:'total',index:'total',width:35,align:'center'},						
						{name:'deskripsi',width:90,align:'center',index:'deskripsi'},
						{name:'waktudibayar',index:'waktudibayar',align:'center',stype:'select',searchoptions:{value:{"m":'per Minggu',"s":'Akhir Semester'}},edittype:'select',editoptions:{value:{"m":'per Minggu',"s":'Akhir Semester'}},formatter:'select'},						
						{name:'is_verified',index:'is_verified',width:150,align:'center',stype:'select',searchoptions:{value:{'0':'Belum dibayar','1':'Sudah dibayar'}},formatter:check_verified},                        						
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
				return '<button class="blue small" style="width:140px">Sudah dibayar</button>';
			}else{
				return '<button class="unverified" class="red small" style="width:140px">Belum dibayar<input type="hidden" value="' + rowObject.id  + '" /></button>';
			}
		}
        
                
        	
		
		function add_view_link(cellValue, options, rowObject){
			return '<a href="#" class="viewStaff" id="' + rowObject.staff_id + '">' + cellValue + '</a>';
		}
		
		$(".viewStaff").live('click',function(){
			$("#dialogcontainer").attr("title","Data Tutor");
			var data = $(this).attr("id");			
			$.ajax({
					  type: "POST",
					  url: "<?php echo site_url("tutor/get_tutor"); ?>/" + data + "/html",
					  dataType: "html",					  
					  beforeSend: function(){
						$("#dialogcontainer").html("<div class=\"ajax_loader\"></div>");
						$("#dialogcontainer").dialog({
							modal: true,
							position: {my: "top", at: "top", of: window},
							width: 700,
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
			$("#dialogcontainer").html("Anda yakin dengan konfirmasi pembayaran ini?<span style='font-size:9px'><br /><i>(status tidak bisa dikembalikan)</i></span>");
			$("#dialogcontainer").attr("title","Konfirmasi Pembayaran");
			$("#dialogcontainer").dialog({
				modal: true,
				buttons: {
                "Yes": function() {
                    $.ajax({
					  type: "POST",
					  url: "<?php echo site_url("bendahara/verify_transport"); ?>",
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
 
 

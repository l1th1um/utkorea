
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
					colNames:['Period','NIM','Semester','Nama Bank','Tanggal Transfer','Atas Nama','Status','Receipt','Download','Ket'],	
					colModel:[						
						{name:'period',width:80,align:'center',index:'period'},
						{name:'nim',width:80,align:'left',index:'nim',formatter:add_view_link},						
						{name:'entry_period',index:'entry_period',width:60,align:'center'},
						{name:'bank_name',index:'bank_name'},
						{name:'payment_date',width:140,align:'center',index:'payment_date'},
						{name:'sender_name',index:'sender_name'},
						{name:'is_verified',index:'is_verified',width:140,align:'center',stype:'select',searchoptions:{value:{'0':'Not Verified','1':'Verified'}},formatter:check_verified},
						{name:'receipt_sent',index:'receipt_sent',width:100,align:'center',stype:'select',searchoptions:{value:{'0':'Not Send','1':'Sent','2':'Not Verified'}},formatter:check_sent},
						{name:'nim',index:'nim',width:100,align:'center',formatter:add_download},
						{name:'id',index:'id',width:40,align:'center'}
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
				return '<button class="blue small" style="width:120px">Verified</button>';
			}else{
				return '<button class="unverified" class="red small" style="width:120px">Not Verified<input type="hidden" value="' + rowObject.id  + '" /></button>';
			}
		}	
		
		function add_download(cellValue, options, rowObject){
			if(rowObject.receipt_sent==1){
				return '<button class="green small download" style="width:80px;"><input type="hidden" value="' + rowObject.period + 'n' + cellValue + '" />Download</button>';
			}else{
				return '';
			}
		}
		
		function check_sent(cellValue, options, rowObject){
			if(cellValue == 2) {
				return '';
			} else if(cellValue == 1){
				return '<button class="blue small" style="width:80px">Sent</button>';
			} else {	
				return '<button class="sent_receipt" class="red small" style="width:80px">Not Send<input type="hidden" value="' + rowObject.id  + '" /></button>';
			}
		}
		
		function add_view_link(cellValue, options, rowObject){
			nim = cellValue;
			
			if (isNaN(cellValue)) {
				nim = cellValue.substr(5,4); 
			}
			
			return '<a href="#" class="viewStudent" id="'+nim+'">' + cellValue + '</a>';
		}
		
		$(".download").live('click',function(){
			val = $(this).children("input:hidden").val();
			$.post("<?php echo base_url('bendahara/download_receipt/du'); ?>/" + val, function(data){
				if(data!=0){
					window.open("<?php echo base_url("assets/core/pdf/receipt/kuitansi_"); ?>" + data + ".pdf",'_blank');
				}
			});
		});
		
		$(".viewStudent").live('click',function(){
			$("#dialogcontainer").attr("title","Data Mahasiswa");
			var data = $(this).attr("id");
			var urlloc;
			if(data.length<5){
				urlloc = "<?php echo site_url("mahasiswa/get_mahasiswa_baru_by_reg_code"); ?>/" + data + "/html";
			}else{
				urlloc = "<?php echo site_url("mahasiswa/get_mahasiswa_by_nim"); ?>/" + data + "/html";
			}
			$.ajax({
					  type: "POST",
					  url: urlloc,
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
		
		$(".sent_receipt").live('click',function(){			
			var data = $(this).children("input:hidden").val();			
			$("#dialogcontainer").html("Kirim Kuitansi?");
			$("#dialogcontainer").attr("title","Konfirmasi Kuitansi");
			$("#dialogcontainer").dialog({
				modal: true,
				buttons: {
                "Yes": function() {
                    $.ajax({
					  type: "POST",
					  url: "<?php echo site_url("bendahara/sent_receipt_reregistration"); ?>",
					  dataType: "html",
					  data: {id:data},
					  success: function(data){
						if(data!="1"){
							alert("Kuitansi Telah Dikirim");							
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
  <style>
 	.viewStudent {text-decoration : none;font-weight:bold} 
 </style>
 <div style="padding-bottom:50px">
	 <span style="font-size:8pt;"><i>Klik nomor NIM untuk melihat data mahasiswa</i></span>
	 <table id="grid_name" style="font-size:10pt"></table>
	 <div id="pager2" ></div> 
	 <div id="dialogcontainer" style="display:none;"></div>   
 </div>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-ina.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

<script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "bendahara/get_rekap_mahasiswa_lama" );
						  ?>',
					datatype: "json",
					colNames:['NIM','Status','registrationpayment','semesterpayment'],	
					colModel:[
						{name:'nim',index:'nim',align:'center',formatter:add_view_link},						
						{name:'status',index:'status',width:150,stype:'select',formatter:check_verified,search:false,},	
						{name:'registrationpayment',hidden:true,search:false,index:'registrationpayment',width:150,align:'center'},
						{name:'semesterpayment',index:'semesterpayment',width:150,align:'center',hidden:true,search:false,}				
					],
					mtype : "POST",							
					sortname: 'nim',
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
			if(rowObject['registrationpayment']==1&&rowObject['semesterpayment']==1){
				return 'Pembayaran Lengkap';	
			}else if(rowObject['registrationpayment']==1&&(rowObject['semesterpayment']==0||rowObject['semesterpayment']==null)){
				return 'Sudah bayar pendaftaran namun belum bayar/konfirmasi uang semester';
			}else{
				return 'Belum melakukan pembayaran';
			}
		}	
		
		function add_view_link(cellValue, options, rowObject){
			return '<a href="#" class="viewStudent">' + cellValue + '</a>';
		}
		
		$(".viewStudent").live('click',function(){
			$("#dialogcontainer").attr("title","Data Mahasiswa");
			var data = $(this).html();
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
					  url: "<?php echo site_url("bendahara/verify_payment"); ?>",
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
		
		$("input:radio").click(function(){
			var value = $(this).val();
			var purl = "<?php
						  echo site_url( "bendahara/get_rekap_mahasiswa_lama" );
					?>/" + value;
			var mygrid = $("#grid_name");
			mygrid.clearGridData(true);
			$.ajax({
			  type: "POST",
			  url: purl,
			  dataType: 'json',
			  complete: function(data){			  	
				mygrid.jqGrid('setGridParam',{url:purl});
			  	mygrid[0].addJSONData(eval("(" + data.responseText + ")"));
			  }			  
			});
		});
		
		$( "#tabs" ).tabs({
            collapsible: true,
            active: false
        });
								
	});
  </script>
 </head>
 <body>			
 <h3>Filter Data</h3>
 <input name="filter" type="radio" checked="checked" value="all" />&nbsp;All&nbsp;<br />
 <input name="filter" type="radio" value="1" />&nbsp;Pembayaran Lengkap&nbsp;<br />
 <input name="filter" type="radio" value="3" />&nbsp;Belum Melakukan Pembayaran&nbsp;<br />
 <input name="filter" type="radio" value="2" />&nbsp;Sudah bayar pendaftaran namun belum bayar/konfirmasi uang semester &nbsp;<br />
 <br />
 <div id="tabs" style="display:none;">
    <ul>
        <li><a href="#tabs-1">Forward List</a></li>        
    </ul>
    <div id="tabs-1">
    	<form method="POST">
    	<h2>Kirim Pesan beserta dengan Daftar Mahasiswa dibawah</h2><hr />
        <label>Pesan</label><br />
        <textarea name="pesan" rows="10" cols="75"></textarea><br />
       <input type="submit" value="Kirim" />
       </form>
    </div>    
 </div>
 
 
 
 <br />
 <span style="font-size:8pt;"><i>Klik nomor NIM untuk melihat data mahasiswa</i></span>
 <table id="grid_name" style="font-size:10pt"></table>
 <div id="pager2" ></div> 
 <div id="dialogcontainer" style="display:none;"></div> 
 <div style="clear:both"></div>
 
 

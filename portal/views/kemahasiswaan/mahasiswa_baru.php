
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-ina.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

<style>
	.CaptionTD{
		font-size:9pt;
	}
  </style>


<script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "mahasiswa/getlistJQGRID/baru_default" );
						  ?>',
					datatype: "json",
					colNames:['Kode Registrasi','Nama', 'Email','Major','Region','Phone','Birth Date','Religion','Gender','Status','Nama Ibu','Tahun Lulus','Address ID','Address KR','Waktu Pendaftaran','Status','Form F1'],	
					colModel:[
						{name:'nim',index:'nim',width:70,align:'center'},
						{name:'name',align:'left',index:'name',editable:true,formatter:add_view_link,unformat:unformat_add_view_link},
						{name:'email',align:'left',index:'email',editable:true},
						{name:'major',index:'major', stype:'select',searchoptions:{value:{<?php $first=true;foreach($major_arr as $row){if(!$first){echo ',';}echo $row['major_id'].':"'.$row['major'].'"';$first=false;} ?>}},editable:true, edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true;foreach($major_arr as $row){if(!$first){echo ',';}echo $row['major_id'].':"'.$row['major'].'"';$first=false;} ?>}}},	
						{name:'region',index:'region',hidden:true,editable:true,editrules:{edithidden:true}, edittype:'select',formatter:'select',editoptions:{value:{'1':'Utara','2':'Selatan'}}},
						{name:'phone',index:'phone',hidden:true,editable:true,editrules:{edithidden:true,required:true,number:true}},
						{name:'birth_date',index:'birth_date',hidden:true,editable:true,editrules:{edithidden:true}},
						{name:'religion',index:'religion',hidden:true,editrules:{edithidden:true},editable:true,edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true; foreach(lang_list('religion_list') as $key=>$row){if(!$first){echo ',';} echo "'".$key."':'".$row."'";$first=false; } ?>}}},
						{name:'gender',index:'gender',hidden:true,editrules:{edithidden:true},editable:true,edittype:'select',editoptions:{value:{'P':'Pria','L':'Wanita'}}},
						{name:'marital_status',index:'marital_status',hidden:true,editrules:{edithidden:true},editable:true,edittype:'select',formatter:'select',editoptions:{value:{'1':'Menikah','0':'Belum Menikah'}}},
						{name:'mother_name',index:'mother_name',editable:true,hidden:true,editrules:{edithidden:true,required:true}},
						{name:'year_graduate',index:'year_graduate',editable:true,hidden:true,editrules:{edithidden:true,required:true}},
						{name:'address_id',index:'address_id',editable:true,edittype:'textarea',hidden:true,editrules:{edithidden:true,required:true}},
						{name:'address_kr',index:'address_kr',editable:true,edittype:'textarea',hidden:true,editrules:{edithidden:true,required:true}},
						{name:'reg_time',align:'center',index:'reg_time',width:90},						
						{name:'verified',index:'verified',width:100,align:'center',stype:'select',searchoptions:{value:{'0':'Not Verified','1':'Verified'}},formatter:check_verified},
						{name:'none',formatter:attach_link_f1,align:'center'}						
					],
					mtype : "POST",	
					editurl: "<?php echo site_url( "kemahasiswaan/CRUD_baru" ); ?>",				
					rownumbers: true,
					pager: "#pager2",
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",					
					jsonReader: { repeatitems : false, id: "0"}
				}).navGrid('#pager2',{edit:true,add:false,del:false, search: true},{
					resize:false,
					width:600,
					
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},{},{},{					
					sopt:['cn']
		});
		
		
		
		function attach_link_f1(cellValue, options, rowObject){
			return '<a target="_blank" href="<?php echo base_url(); ?>pendaftaran/show_and_replace_pdf/' + rowObject.nim + '">Download</a>'
		}

		function check_verified(cellValue, options, rowObject){
			if(cellValue==1){
				return '<button class="blue small" style="width:140px">Verified</button>';
			}else{
				return '<button class="unverified" class="red small" style="width:140px">Not Verified<input type="hidden" value="' + rowObject.nim  + '" /></button>';
			}
		}	
		
		function add_view_link(cellValue, options, rowObject){
			return '<a href="#" class="viewStudent">' + cellValue + '<input type="hidden" value="' + rowObject.nim  + '" /><input type="hidden" class="hdnname" value="' + cellValue  + '" /></a>';
		}
		
		function unformat_add_view_link( cellvalue, options, cell){
			return $("a",cell).children("input:hidden.hdnname").val();
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
  <style>
	.ui-widget{
		font-size:11pt;
	}
</style>
 </head>
 <body>
 	
 <header>
	<div style="float:left;padding:8px;border-right:1px solid #666666;"><a href="<?php echo base_url('kemahasiswaan/mahasiswa_baru'); ?>">Tabel Mahasiswa Baru</a></div>
	<div style="float:left;padding:8px;"><a href="<?php echo base_url('kemahasiswaan/reupload/maba'); ?>">Re-upload Ijasah/Foto</a></div>
 </header>			
 	
 <span style="font-size:8pt;"><i>Klik pada Nama untuk melihat data mahasiswa</i></span>
 <table id="grid_name" style="font-size:10pt"></table>
 <div id="pager2" ></div> 
 <div id="dialogcontainer" style="display:none;"></div> 
 

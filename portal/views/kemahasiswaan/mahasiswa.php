<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />	
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>css/add.css" />	
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
						  echo site_url( "humas/getlistJQGRID/student" );
						  ?>',
					datatype: "json",
					colNames:['NIM','Nama', 'Major','Region','Phone','Status','Entry Period','Email','Tangal Lahir','Agama','Gender','Marital Status','Address Indonesia','Address Korea','Remarks'],	
					colModel:[
						{name:'nim',width:250,index:'nim',editable:true,editrules:{required:true,number:true}},
						{name:'name',width:600,index:'name',editable:true,editrules:{required:true},formatter:add_view_link,unformat:unformat_add_view_link},
						{name:'major',width:600,index:'major', stype:'select',searchoptions:{value:{<?php $first=true;foreach($major_arr as $row){if(!$first){echo ',';}echo $row['major_id'].':"'.$row['major'].'"';$first=false;} ?>}},editable:true, edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true;foreach($major_arr as $row){if(!$first){echo ',';}echo $row['major_id'].':"'.$row['major'].'"';$first=false;} ?>}}},	
						{name:'region',index:'region',hidden:true,editable:true,editrules:{edithidden:true}, edittype:'select',formatter:'select',editoptions:{value:{'1':'Utara','2':'Selatan'}}},
						{name:'phone',index:'phone',hidden:true,editable:true,editrules:{edithidden:true,required:true,number:true}},
						{name:'status',index:'status',align:'center',editable:true,formatter:'select',stype:'select',searchoptions:{value:{'1':'Aktif','0':'Tidak Aktif','2':'Cuti','3':'Alumni'}},edittype:'select',editoptions:{value:{'1':'Aktif','0':'Tidak Aktif','2':'Cuti','3':'Alumni'}}},
						{name:'entry_period',index:'entry_period',align:'center',editable:true},
						{name:'email',width:700,index:'email',hidden:true,editable:true,editrules:{edithidden:true,requried:true,email:true}},
						{name:'birth_date',index:'birth_date',hidden:true,editable:true,editrules:{edithidden:true}},
						{name:'religion',index:'religion',hidden:true,editrules:{edithidden:true},editable:true,edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true; foreach(lang_list('religion_list') as $key=>$row){if(!$first){echo ',';} echo "'".$key."':'".$row."'";$first=false; } ?>}}},
						{name:'gender',index:'gender',hidden:true,editrules:{edithidden:true},editable:true,edittype:'select',editoptions:{value:{'P':'Pria','L':'Wanita'}}},
						{name:'marital_status',index:'marital_status',hidden:true,editrules:{edithidden:true},editable:true,edittype:'select',formatter:'select',editoptions:{value:{'1':'Menikah','0':'Belum Menikah'}}},
						{name:'address_id',index:'address_id',editable:true,edittype:'textarea',hidden:true,editrules:{edithidden:true,required:true}},
						{name:'address_kr',index:'address_kr',editable:true,edittype:'textarea',hidden:true,editrules:{edithidden:true,required:true}},
						{name:'remarks',index:'remarks',editable:true,edittype:'textarea',hidden:true,editrules:{edithidden:true}}
						
					],
					mtype : "POST",		
					editurl: "<?php echo site_url( "kemahasiswaan/CRUD" ); ?>",
					sortname: 'name',
					rownumbers: true,
					pager: "#pager2",
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",					
					jsonReader: { repeatitems : false, id: "0"}
				}).navGrid('#pager2',{edit:true,add:true,del:true, search: true},{
					resize:false,
					width:600,
					
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},
					{resize:false,	
						width:600,
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},
					{resize:false,	
						width:600,
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},{					
					sopt:['cn']
				}).navButtonAdd("#pager2",{caption:"Export Current Table",buttonicon:"ui-icon-bookmark",
					onClickButton:function(){
						$("#grid_name").jqGrid('excelExport',{url:"<?php
						  echo site_url( "kemahasiswaan/exportCurrentCRUD" );
						  ?>"});
				}, position: "last", title:"Export Current Table",cursor: "pointer"});	

		function add_view_link(cellValue, options, rowObject){
			return '<a href="#" class="viewStudent">' + cellValue + '<input type="hidden" class="hdnnim" value="' + rowObject.nim  + '" /><input type="hidden" class="hdnname" value="' + cellValue  + '" /></a>';
		}
		
		function unformat_add_view_link( cellvalue, options, cell){
			return $("a",cell).children("input:hidden.hdnname").val();
		}
		
		$(".viewStudent").live('click',function(){
			$("#dialogcontainer").attr("title","Data Mahasiswa");
			var data = $(this).children("input:hidden.hdnnim").val();
			$.ajax({
					  type: "POST",
					  url: "<?php echo site_url("mahasiswa/get_mahasiswa_by_nim"); ?>/" + data + "/html",
					  dataType: "html",					  
					  beforeSend: function(){
						$("#dialogcontainer").html("<div class=\"ajax_loader\"></div>");
						$("#dialogcontainer").dialog({
							modal: true,
							position: {my: "top", at: "top", of: window},
							width: 900,
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
<style>
	.ui-widget{
		font-size:11pt;
	}
</style>
<body>		
	<?php if (isset($content)) echo "<h3>".$content."</h3>";  else $content= '';?>			
    <table id="grid_name"></table>
    <div id="pager2" ></div>         
	<div id="dialogcontainer" style="display:none;"></div>
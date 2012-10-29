<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>
  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />	
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>css/add.css" />	
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

  
  <script type="text/javascript">
	$(document).ready(function(){	
		
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "sms/getlistJQGRID/student" );
						  ?>',
					datatype: "json",
					colNames:['NIM','Nama', 'Major','Region','Phone','Status','Period','Email','Birth','Religion','Sex','Marital Status','Address','Key'],	
					colModel:[
						{name:'nim',width:250,index:'nim',editable:true,editrules:{required:true,number:true}},
						{name:'name',width:600,index:'name',editable:true,editrules:{required:true}},
						{name:'major',width:600,index:'major', editable:true, edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true;foreach($major_arr as $row){if(!$first){echo ',';}echo $row['major_id'].':"'.$row['major'].'"';$first=false;} ?>}}},	
						{name:'region',index:'region',editable:true, edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true;foreach($region_arr as $key=>$row){if(!$first){echo ',';}echo '"'.$key.'":"'.$row.'"';$first=false;} ?>}}},
						{name:'phone',index:'phone',editable:true,editrules:{required:true,number:true}},
						{name:'status',index:'status',editable:true,edittype:'select',editoptions:{value:{'Aktif':'Aktif','Tidak Aktif':'Tidak Aktif'}}},
						{name:'period',index:'period',editable:true,editrules:{required:true,number:true}},
						{name:'email',width:700,index:'email',editable:true,editrules:{requried:true,email:true}},
						{name:'birth',index:'birth',editable:true},
						{name:'religion',index:'religion',editable:true},
						{name:'sex',index:'sex',editable:true,edittype:'select',editoptions:{value:{'Pria':'Pria','Wanita':'Wanita'}}},
						{name:'marital_status',index:'marital_status',editable:true,edittype:'select',formatter:'select',editoptions:{value:{'Menikah':'Menikah','Belum Menikah':'Belum Menikah'}}},
						{name:'address',index:'address',editable:true,edittype:'textarea',editrules:{required:true}},
						{name:'nim',index:'nim_key',hidden:true}
					],
					mtype : "POST",		
					editurl: "<?php echo site_url( "mahasiswa/CRUD" ); ?>",
					sortname: 'name',
					rownumbers: true,
					pager: $('#pager2'),
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",					
					jsonReader: { repeatitems : false, id: "0"}
				}).navGrid('#pager2',{edit:true,add:true,del:true, search: true},{
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},
					{afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},
					{afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				});
	});
  </script>
</head>
<body>		
	<?php if (isset($content)) echo "<h3>".$content."</h3>";  else $content= '';?>		
	
    <table id="grid_name"></table>
    <div id="pager2" ></div>         
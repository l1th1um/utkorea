<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />	
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>css/add.css" />	
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

  
  <script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "sms/getlistJQGRID/tutor" );
						  ?>',
					datatype: "json",
					colNames:['Nama', 'Major','Region','Phone','Email','Affiliation','Birth','Key'],	
					colModel:[						
						{name:'name',width:600,index:'name',editable:true,editrules:{required:true}},
						{name:'major_id',width:600,index:'major_id', stype:'select',searchoptions:{value:{<?php $first=true;foreach($major_arr as $row){if(!$first){echo ',';}echo $row['major_id'].':"'.$row['major'].'"';$first=false;} ?>}},editable:true, edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true;foreach($major_arr as $row){if(!$first){echo ',';}echo $row['major_id'].':"'.$row['major'].'"';$first=false;} ?>}}},	
						{name:'region',index:'region',editable:true,stype:'select',searchoptions:{value:{<?php $first=true;foreach($region_arr as $key=>$row){if(!$first){echo ',';}echo '"'.$key.'":"'.$row.'"';$first=false;} ?>}}, edittype:'select',formatter:'select',editoptions:{value:{<?php $first=true;foreach($region_arr as $key=>$row){if(!$first){echo ',';}echo '"'.$key.'":"'.$row.'"';$first=false;} ?>}}},
						{name:'phone',index:'phone',hidden:true,editable:true,editrules:{edithidden:true,required:true,number:true}},									
						{name:'email',width:700,index:'email',hidden:true,editable:true,editrules:{edithidden:true,requried:true,email:true}},
						{name:'affiliation',index:'period',align:'center',editable:true,hidden:true,editrules:{edithidden:true,required:true}},
						{name:'birth',index:'birth',hidden:true,editable:true,editrules:{edithidden:true}},												
						{name:'staff_id',index:'staff_id',hidden:true,editable:true}
					],
					mtype : "POST",		
					editurl: "<?php echo site_url( "tutor/CRUD" ); ?>",
					sortname: 'name',
					rownumbers: true,
					pager: "#pager2",
					autowidth: true,
					height: "100%",					
					viewrecords: true,					
					sortorder: "ASC",					
					jsonReader: { repeatitems : false, id: "7"}
				}).navGrid('#pager2',{edit:true,add:true,del:true, search: true},{
					resize:false,					
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},
					{resize:false,					
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},
					{resize:false,					
					afterComplete: function(data){						
						if(data.responseText!=''){alert(data.responseText)};
					}
				},{					
					sopt:['cn']
				}).navButtonAdd("#pager2",{caption:"Export Current Table",buttonicon:"ui-icon-bookmark",
					onClickButton:function(){
						$("#grid_name").jqGrid('excelExport',{url:"<?php
						  echo site_url( "tutor/exportCurrentCRUD" );
						  ?>"});
				}, position: "last", title:"Export Current Table",cursor: "pointer"});				
								
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
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
		
		$(".trglist").click(function(){
			
			var id = $(this).attr("alt");
			curid = id;
			$('#grid_name').jqGrid('GridUnload');
			$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "kelas/data_pengumuman/");
						  ?>/' + curid,
					datatype: "json",
					colNames:[' ','Content','Until'],	
					colModel:[
						{name:'id',index:'nim',editable:false},
						{name:'content',width:500,index:'content',editable:true,edittype:'textarea',editoptions:{rows:"6",cols:"50"},editrules:{required:true}},
							
						{name:'until',index:'until',editable:true,editrules:{required:true},editoptions:{size:20, 
	                  dataInit:function(el){ 
	                        $(el).datepicker({dateFormat:'yy-mm-dd'}); 
	                  }, 
	                  defaultValue: function(){ 
	                    var currentTime = new Date(); 
	                    var month = parseInt(currentTime.getMonth() + 1); 
	                    month = month <= 9 ? "0"+month : month; 
	                    var day = currentTime.getDate(); 
	                    day = day <= 9 ? "0"+day : day; 
	                    var year = currentTime.getFullYear(); 
	                    return year+"-"+month + "-"+day; 
	                  } 
	                }}						
						
					],
					mtype : "POST",		
					editurl: "<?php echo site_url( "kelas/data_pengumuman_CRUD" ); ?>",				
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
						editData: {assignment_id : function(){ return curid; }},
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
	<h1>Pengumuman Kelas</h1>
	<div class="sidetabs">
		<nav class="sidetab-switch">
			<ul>
				<?php foreach($list->result() as $row){
					echo '<li><a class="trglist" href="#" alt="'.$row->id.'">('.$row->code.')<br />'.$row->title.'</a></li>';
				}?>
			</ul>
		</nav>
		<div class="sidetab default-sidetab">
			<?php if (isset($content)) echo "<h3>".$content."</h3>";  else $content= '';?>			
		    <table id="grid_name"></table>
		    <div id="pager2" ></div>         
			<div id="dialogcontainer" style="display:none;"></div>
		</div>
	</div>
	
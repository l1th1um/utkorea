<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-ina.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.src.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

<script type="text/javascript">
	$(document).ready(function(){			
		$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "profiles/getinboxJQGRID/".$this->session->userdata('username') );
						  ?>',
					datatype: "json",
					colNames:['Dari','Tanggal',' ',' ',' ',' ',' '],	
					colModel:[						
						{name:'mname',width:80,align:'center',index:'mname',formatter:name_format},						
						{name:'timestamp',index:'timestamp',align:'right',width:45},
						{name:'id',index:'id',formatter:add_baca,align:'center',sortable:false,search:false},
						{name:'action',align:'center',index:'Action',width:15,formatter:add_checkbox,sortable:false,search:false},
						{name:'sname',width:80,align:'center',index:'sname',hidden:true},
						{name:'from',width:80,align:'center',index:'from',hidden:true},
						{name:'is_read',width:80,align:'center',index:'is_read',hidden:true}												
					],
					mtype : "POST",							
					sortname: 'id',
					rownumbers: true,
					pager: "#pager2",
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",					
					jsonReader: { repeatitems : false, id: "3"}
				}).navGrid('#pager2',{edit:false,add:false,del:false, search: true},{},{},{},{					
					sopt:['cn']
		});

		function name_format(cellValue, options, rowObject){
			if(cellValue==null&&rowObject['sname']!=null){
				return rowObject['sname'];
			}else if(cellValue==null&&rowObject['sname']==null){
				return rowObject['from'];
			}else{
				return cellValue;
			}
		}
		
		function add_checkbox(cellValue, options, rowObject){
			return '<input type="checkbox" name="msgid[]" value="' + rowObject['id'] + '" />'	
		}
		
		function add_baca(cellValue, options, rowObject){
			return '<a href="<?php
						  echo site_url( "message/read/" );
						  ?>/' + cellValue + '">Baca</a>';	
		}		
			
		$("#hapus").click(function(){			
			$.ajax({
					  type: "POST",
					  url: "<?php
						  echo site_url( "profiles/delete_msg/" );
						  ?>",
					  data : $("#grid_form").serialize(),
					  dataType: "html",					  
					  success: function(data){
							$("#grid_name").trigger("reloadGrid");
					  }
			});
		});		
								
	});
  </script>
 </head>
 <body>			
 <form id="grid_form">
 <table id="grid_name" style="font-size:10pt"></table>
 <div id="pager2" ></div>
 </form> 
 <div id="dialogcontainer" style="display:none;"></div> <br />
 <div style="float:right">
 	<button id="hapus">Hapus Pesan Terpilih</button>
 </div>
 

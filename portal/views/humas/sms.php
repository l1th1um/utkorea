
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo admin_tpl_path()?>js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<script src="<?php echo admin_tpl_path()?>js/jquery.blockUI.js" type="text/javascript"></script>
  
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqueryui/css/blitzer/jquery-ui-1.8.23.custom.css" />	
<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>css/add.css" />	

<link rel="stylesheet" type="text/css" href="<?php echo admin_tpl_path()?>js/jqgrid/css/ui.jqgrid.css" />	

  
  <script type="text/javascript">
	$(document).ready(function(){	
		$("input[name='radio']").click(function(){
			$("#selectable").html('');
			$('#grid_name').jqGrid('GridUnload');
			switch(this.value){
			case 'tutor':
                $("#listcontainer").show();				
				$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "sms/getlistJQGRID/tutor" );
						  ?>',
					datatype: "json",
					colNames:['Nama','Telepon', 'NIP'],
					ondblClickRow: function(rowid, iRow, iCol, e){
						$("#selectable").append("<li><label>" + $(this).getCell(rowid,1) + " (" + $(this).getCell(rowid,2) + ") " + "</label><input type=\"hidden\" name=\"who[]\" value=\"" + $(this).getCell(rowid, 3) + "\" /><div class=\"list-close\" >&nbsp;</a></li>");						

					},												
					colModel:[
						{name:'name',index:'name',width:100},
						{name:'phone',index:'phone',width:50,  align:"center", sortable: false},
						{name:'staff_id',index:'staff_id', width:20, align:"center"},					

					],
					mtype : "POST",				
					sortname: 'name',
					rownumbers: true,
					pager: $('#pager2'),
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",	
					jsonReader: { repeatitems : false, id: "0"}
					
				}).navGrid('#pager2',{edit:false,add:false,del:false, search: true});
				break;
            case 'staff':
                $("#listcontainer").show();				
				$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "sms/getlistJQGRID/staff" );
						  ?>',
					datatype: "json",
					colNames:['Nama','Telepon', 'NIP'],
					ondblClickRow: function(rowid, iRow, iCol, e){
						$("#selectable").append("<li><label>" + $(this).getCell(rowid,1) + " (" + $(this).getCell(rowid,2) + ") " + "</label><input type=\"hidden\" name=\"who[]\" value=\"" + $(this).getCell(rowid, 3) + "\" /><div class=\"list-close\" >&nbsp;</a></li>");						

					},												
					colModel:[
						{name:'name',index:'name',width:100},
						{name:'phone',index:'phone',width:50,  align:"center", sortable: false},
						{name:'staff_id',index:'staff_id', width:20, align:"center"},					

					],
					mtype : "POST",				
					sortname: 'name',
					rownumbers: true,
					pager: $('#pager2'),					
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",	
					jsonReader: { repeatitems : false, id: "0"}					

					
				}).navGrid('#pager2',{edit:false,add:false,del:false, search: true});
				break;
			case 'student':
                $("#listcontainer").show();				
				$("#grid_name").jqGrid({
					url:'<?php
						  echo site_url( "sms/getlistJQGRID" );
						  ?>',
					datatype: "json",
					colNames:['Nama','Telepon', 'NIM'],
					ondblClickRow: function(rowid, iRow, iCol, e){
						$("#selectable").append("<li><label>" + $(this).getCell(rowid,1) + " (" + $(this).getCell(rowid,2) + ") " + "</label><input type=\"hidden\" name=\"who[]\" value=\"" + $(this).getCell(rowid, 3) + "\" /><div class=\"list-close\" >&nbsp;</a></li>");						
					},												
					colModel:[
						{name:'name',index:'name',width:100},
						{name:'phone',index:'phone',width:50,  align:"center", sortable: false},
						{name:'nim',index:'nim', width:20, align:"center"},						
					],
					mtype : "POST",				
					sortname: 'name',
					rownumbers: true,
					pager: $('#pager2'),					
					autowidth: true,
					height: "100%",
					viewrecords: true,					
					sortorder: "ASC",	
					jsonReader: { repeatitems : false, id: "0"}
					
				}).navGrid('#pager2',{edit:false,add:false,del:false, search: true});
				break;
			default:				
				$("#listcontainer").hide();
			}
		});		
		$(".list-close").live('click',function(){
			$(this).parent("li").remove();
		});
        
        $("#message").keypress(function(){
            var len = $(this).val().length;
            var char_left = 90-len;
            
            $(".counter").html(char_left);
        });
        
        $('#frmSms').submit(function(event){
           event.preventDefault()

           if ($('#message').val() === '') {
                alert('Mohon Isi Pesan Terlebih Dahulu');                
           } else {
                if (confirm("Anda Yakin Untuk Mengirim SMS?")) {
                    $.blockUI({ message: '<h1><img src="<?php echo admin_tpl_path()?>img/ajax-loader.gif" />   Mohon Tunggu Sebentar...</h1>' });
                    $.post("<?php echo base_url() ?>humas/send_sms", $(this).serialize(),function(data){
						alert(data);
						window.location = '<?php echo current_url()?>'; //redirects to homepage						
                    });           
               } 
           } 
           
        });
	});
  </script>
</head>
<body>		
	<?php if (isset($content)) echo "<h3>".$content."</h3>";  else $content= '';?>
	<strong><?php echo get_balance()?></strong>
	<form method="post" action="<?php echo current_url();?>" id="frmSms">
    <fieldset>
        <table>
            <tr>
                <td width="120px"><label><?php echo $this->lang->line('send');?></label></td>
                <td colspan="2"><input type="radio" name="radio" value="all" checked="checked" /> Semua</td>                
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="150px"><input type="radio" name="radio" value="all_student" /> Semua Mahasiswa</td>
                <td><input type="radio" name="radio" value="student" /> Mahasiswa</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="radio" name="radio" value="all_tutor" /> Semua Tutor</td>
                <td><input type="radio" name="radio" value="tutor" /> Tutor</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="radio" name="radio" value="all_staff" /> Semua Pengurus</td>
                <td><input type="radio" name="radio" value="staff" /> Pengurus</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2">
                    <br />
                    <div id="listcontainer" style="display:none">
                		<b style="font-weight:900">Double Click to Add</b> <hr />
                		<table id="grid_name"></table>
                		<div id="pager2" ></div>                        

                	</div>
                    <br />	                	
                	<ol id="selectable">
                	</ol>
                </td>
            </tr>
            <tr>
                <td><label><?php echo $this->lang->line('message');?></label></td>
                <td><textarea rows="4" cols="100" name="message" id="message"></textarea></td>
                <td><span class="counter">90</span></td>
            </tr>
            <tr>
                <td colspan="3"><button type="submit"><?php echo $this->lang->line('send_to');?></button></td>
            </tr>
        </table>	
	</fieldset>	
	
	</form>
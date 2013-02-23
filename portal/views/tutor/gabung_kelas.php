<style>
  .ui-combobox {
    position: relative;
    display: inline-block;
  }
  .ui-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .ui-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
</style>


<h1>Tahun Ajaran <?php echo setting_val('time_period')?></h1>
<div id='container'>
	
	<table>
		<thead>
			<tr>
				<td>Kelas</td><td>Digabung dengan</td><td>Status</td>
			</tr>
		</thead>
		
		<?php if($list){
			foreach($list->result() as $row){
				echo '<tr>';
					echo '<td><b>'.$row->from_title.' ( '.(($row->from_region)?'Utara':'Selatan').' )</b></td>';
					echo '<td><b>'.$row->to_title.' ( '.(($row->to_region)?'Utara':'Selatan').' )</b></td>';
					echo '<td>';
					if($row->is_active){
						echo '<img title="Click to unlink" src="'.template_path('core').'/images/link.png" />';
					}else{
						echo '<img title="Click to link" src="'.template_path('core').'/images/unlink.png" />';
					}
					echo '</td>';					
				echo '</tr>';
			}
		}else{
			echo '<tr><td colspan="4">Tidak ada daftar penggabungan kelas</td></tr>';
		}?>
	</table><br />
	

	<div id="accordion">
  		<h3 style="padding:6px;font-size:12pt;padding-left:26px;">Tambah</h3>
		<div>	
			<form id="frmTambah" method="post">		
				<label>Kelas</label>
				<select class="combobox" name="from_assignment">
					    <option value="">Select one...</option>
					    <?php if($asgnmt_list){
					    	foreach($asgnmt_list->result() as $row){
					    		echo '<option value="'.$row->id.'">'.(($row->region==1)?'(Utara)':'(Selatan)').' '.$row->title.'</option>';
					    	}
						}
						?>		   
				</select>
				&nbsp;
				<label style="margin-left:28px;">Digabung dengan</label>
				<select class="combobox" name="to_assignment">
						<option value="">Select one...</option>
					    <?php if($asgnmt_list){
					    	foreach($asgnmt_list->result() as $row){
					    		echo '<option value="'.$row->id.'">'.(($row->region==1)?'(Utara)':'(Selatan)').' '.$row->title.'</option>';
					    	}
						}
						?>
				</select>
				<br /><br />	
				<button>Submit</button>
			</form>
		</div>
	</div>
</div>


 <script>
    $(function() {    	
    	
    	$.widget( "ui.combobox", {
	      _create: function() {
	        var input,
	          that = this,
	          wasOpen = false,
	          select = this.element.hide(),
	          selected = select.children( ":selected" ),
	          value = selected.val() ? selected.text() : "",
	          wrapper = this.wrapper = $( "<span>" )
	            .addClass( "ui-combobox" )
	            .insertAfter( select );
	 
	        function removeIfInvalid( element ) {
	          var value = $( element ).val(),
	            matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
	            valid = false;
	          select.children( "option" ).each(function() {
	            if ( $( this ).text().match( matcher ) ) {
	              this.selected = valid = true;
	              return false;
	            }
	          });
	 
	          if ( !valid ) {
	            // remove invalid value, as it didn't match anything
	            $( element )
	              .val( "" )
	              .attr( "title", value + " didn't match any item" )
	              .tooltip( "open" );
	            select.val( "" );
	            setTimeout(function() {
	              input.tooltip( "close" ).attr( "title", "" );
	            }, 2500 );
	            input.data( "ui-autocomplete" ).term = "";
	          }
	        }
	 
	        input = $( "<input>" )
	          .appendTo( wrapper )
	          .val( value )
	          .attr( "title", "" )
	          .addClass( "ui-state-default ui-combobox-input" )
	          .autocomplete({
	            delay: 0,
	            minLength: 0,
	            source: function( request, response ) {
	              var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
	              response( select.children( "option" ).map(function() {
	                var text = $( this ).text();
	                if ( this.value && ( !request.term || matcher.test(text) ) )
	                  return {
	                    label: text.replace(
	                      new RegExp(
	                        "(?![^&;]+;)(?!<[^<>]*)(" +
	                        $.ui.autocomplete.escapeRegex(request.term) +
	                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
	                      ), "<strong>$1</strong>" ),
	                    value: text,
	                    option: this
	                  };
	              }) );
	            },
	            select: function( event, ui ) {
	              ui.item.option.selected = true;
	              that._trigger( "selected", event, {
	                item: ui.item.option
	              });
	            },
	            change: function( event, ui ) {
	              if ( !ui.item ) {
	                removeIfInvalid( this );
	              }
	            }
	          })
	          .addClass( "ui-widget ui-widget-content ui-corner-left" );
	 
	        input.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
	          return $( "<li>" )
	            .append( "<a>" + item.label + "</a>" )
	            .appendTo( ul );
	           
	        };
	 
	        $( "<a>" )
	          .attr( "tabIndex", -1 )	         
	          .appendTo( wrapper )
	          .button({
	            icons: {
	              primary: "ui-icon-triangle-1-s"
	            },
	            text: false
	          })
	          .removeClass( "ui-corner-all" )
	          .addClass( "ui-corner-right ui-combobox-toggle" )
	          .mousedown(function() {
	            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
	          })
	          .click(function() {
	            input.focus();
	 
	            // close if already visible
	            if ( wasOpen ) {
	              return;
	            }
	 
	            // pass empty string as value to search for, displaying all results
	            input.autocomplete( "search", "" );
	          });
	 
	        input.tooltip({
	          tooltipClass: "ui-state-highlight"
	        });
	      },
	 
	      _destroy: function() {
	        this.wrapper.remove();
	        this.element.show();
	      }
	    });	 
    	
      $( ".combobox" ).combobox();
      $( "#accordion" ).accordion({
      	 collapsible: true,
      	 active:false
      });
      	
    });
</script>
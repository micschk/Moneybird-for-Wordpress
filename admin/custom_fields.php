<?php
	$custom_fields = mb_custom_fields($post->post_type);
	
			$query_string = array(
						  'post_type'=>'mb_companies',
						  'post_status'=> 'publish'
						);
		add_filter( 'post_limits', 'mb_no_limit' );
		$query = new WP_Query( $query_string );
		remove_filter( 'post_limits', 'mb_no_limit' );
?>
<div class="custom_made_fields">
	<?php foreach($custom_fields as $key => $details) { ?>
		<?php
			switch($details['type']) :
				case 'hidden':
					break;
				default :
					echo '<label>'.$details['name'].'</label>';
					break;
			endswitch;	
		?>
		<?php
			switch($details['type']) {
				case 'string':
					echo '<input type="text" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="'.$details['name'].'" />';
					break;
				case 'disabled':
					echo '<input type="text" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="'.$details['name'].'" disabled="disabled" />';
					break;
				case 'boolean':
					echo '<label><input type="radio" name="'.$key.'" value="true" '.($$key=='true'?'checked="checked"':'').' /> Ja</label>';
					echo '<label><input type="radio" name="'.$key.'" value="false" '.(!isset($$key)||empty($$key)||$$key=='false'?'checked="checked"':'').' /> Nee</label>';
					break;
				case 'date':
					echo '<input type="text" class="datepicker" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="'.$details['name'].'" />';
					break;
				case 'datetime':
					echo '<input type="text" class="datetimepicker" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="'.$details['name'].'" />';
					break;
				case 'time':
					echo '<input type="text" class="timepicker" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="'.$details['name'].'" />';
					break;
				case 'hidden':
					echo '<input type="hidden" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'"/>';
					break;
				case 'email':
					echo '<input type="email" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="abc@example.com" />';
					break;
				case 'int':
					echo '<input type="number" min="0" step="1" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'"/>';
					break;
				case 'float':
					echo '<input type="text" maxlength="20" size="20" style="width:100px;" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="'.$details['name'].'" />';
					break;
				case 'text':
					echo '<textarea name="'.$key.'" placeholder="'.$details['name'].'">'.(!empty($$key)?$$key:'').'</textarea>';
					break;
				case 'image':
					echo '<input type="file" name="'.$key.'"/>';
					break;
				case 'file':
					echo '<input type="file" name="'.$key.'"/>';
					break;
				case 'company_relations':
					echo '<input type="number" min="0" step="1" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="0" />';
					break;
				default :
					echo '<input type="text" name="'.$key.'" value="'.(!empty($$key)?$$key:'').'" placeholder="'.$details['name'].'" />';
					break;
			}
		?>
	<?php } ?>	
</div>
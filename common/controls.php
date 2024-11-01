<?php 
function wp_spatialtree_get_control($type, $label, $id, $name, $value = '',  $data = null, $info = '', $style = 'input widefat') {
	switch($type) {
		case 'text':
			$output = '<p>';
				$output .= '<label for="'.$name.'">'.$label.'</label>:';
				$output .= '<input type="text" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="'.$style.'">';
			if($info != '') {
				$output .= '<small>'.$info.'</small>';
			}
			$output .= '</p>';
			break;
		case 'password':
			$output = '<p>';
				$output .= '<label for="'.$name.'">'.$label.'</label>:';
				$output .= '<input type="password" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="'.$style.'">';
			if($info != '') {
				$output .= '<small>'.$info.'</small>';
			}
			$output .= '</p>';
			break;
		case 'checkbox':
			$output = '<p>';
				$output .= '<input type="checkbox" id="'.$id.'" name="'.$name.'" value="1" class="input" '.checked($value, 1, false).' />';
				$output .= '<label for="'.$name.'">'.$label.'</label>';		
			if($info != '') {
				$output .= '<small>'.$info.'</small>';
			}
			$output .= '</p>';
			break;	
		case 'textarea':
			$output = '<p>';
				$output .= '<label for="'.$name.'">'.$label.'</label>:<br />';
				$output .= '<textarea id="'.$id.'" name="'.$name.'" class="'.$style.'" style="height: 100px;">'.$value.'</textarea>';	
			if($info != '') {
				$output .= '<small>'.$info.'</small>';
			}
			$output .= '</p>';
			break;
		case 'select':
			if($label != '') {
				$output .= '<label for="'.$name.'">'.$label.'</label>:';
			}
			$output .= '<select id="'.$id.'" name="'.$name.'" class="'.$style.'">';
			if($data) {
				foreach($data as $option) {
					$output .= '<option value="'.$option['value'].'" '.selected($value, $option['value'], false).'>'.$option['text'].'</option>';
				}
			}
			$output .= '</select>';
			if($info != '') {
				$output .= '<small>'.$info.'</small>';
			}
			break;
		case 'upload':
			$output = '<p>';
				$output .= '<label for="'.$name.'">'.$label.'</label>:<br />';
				$output .= '<input type="text" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="'.$style.'" style="width: 74%;" />';
				$output .= '<input type="button" value="Upload Image" class="wp_prayer_scheduler_uploader_button" id="upload_image_button" style="width: 25%;" />';
			if($info != '') {
				$output .= '<small>'.$info.'</small>';
			}
			$output .= '</p>';
			break;
		case 'multiselect':
			$output = '<p>';
				$output .= '<label for="'.$name.'">'.$label.'</label>:<br />';
				$output .= '<select id="'.$id.'" name="'.$name.'" class="'.$style.'" multiple="multiple" style="height: 220px">';
				if($data) {
					foreach($data as $option) {
						if(is_array($value) && in_array($option['value'], $value)) {
							$output .= '<option value="'.$option['value'].'" selected="selected">'.$option['text'].'</option>';
						} else {
							$output .= '<option value="'.$option['value'].'">'.$option['text'].'</option>';
						}
					}
				}
				$output .= '</select>';
			if($info != '') {
				$output .= '<small>'.$info.'</small>';
			}
			$output .= '</p>';
			break;
	}
	return $output;
}
?>
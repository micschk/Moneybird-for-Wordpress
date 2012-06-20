<?php

// general functions error, success, ifo and warnings notices
function error_notice($msg){
	echo '<div class="global-error">'.$msg.'</div>';
}
function success_notice($msg){
	echo '<div class="global-success">'.$msg.'</div>';
}
function info_notice($msg){
	echo '<div class="global-info">'.$msg.'</div>';
}
function warning_notice($msg){
	echo '<div class="global-warning">'.$msg.'</div>';
}

?>
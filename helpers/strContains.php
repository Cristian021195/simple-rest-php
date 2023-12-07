<?php 
function strContains($haystack, $needle) {
	if ( is_string($haystack) && is_string($needle) ) {
		return '' === $needle || false !== strpos($haystack, $needle);
	} else {
		return false;
	}
}
?>
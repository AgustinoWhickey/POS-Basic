<?php 

 function is_logged_in()
 {
 	$ci = get_instance();
 	if(!$ci->session->userdata('email')){
		redirect('auth');
	} 
 }

 function check_access()
 {
 	$ci = get_instance();

 	$roleid = $ci->session->userdata('role_id');

	if($roleid == 3){
		redirect('auth/blocked');
	}

 }

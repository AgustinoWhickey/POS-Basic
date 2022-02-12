<?php 

 function is_logged_in()
 {
 	$ci = get_instance();
 	if(!$ci->session->userdata('email')){
		redirect('auth');
	} else {
		$roleid = $ci->session->userdata('role_id');
		$menu 	= $ci->uri->segment(1);

		$query = $ci->db->get_where('user_menu',['name' => $menu])->row_array();
		$menuid = $query['id'];

		// $userAccsess = $ci->db->get_where('user_access_menu',[
		// 	'role_id' => $roleid,
		// 	'menu_id' => $menuid
		// ]);
		// if($userAccsess->num_rows() < 1){
		// 	redirect('auth/blocked');
		// }
	}
 }

 function check_access($roleid,$menuid)
 {
 	$ci = get_instance();

 	$result = $ci->db->get_where('user_access_menu',['role_id' => $roleid, 'menu_id' => $menuid]);

 	if($result->num_rows()>0){
 		return "checked='checked'";
 	}

 }

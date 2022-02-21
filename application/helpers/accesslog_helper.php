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

 function pdf_generator($html, $filename)
 {
	$ci = get_instance();

	$dompdf = new Dompdf\Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->setPaper('A4', 'landscape');
	$dompdf->render();

	$dompdf->stream($filename, array('Attachment' => 0));
 }

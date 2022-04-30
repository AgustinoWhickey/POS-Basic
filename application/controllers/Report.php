<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_item_model','item_m');
		$this->load->model('Login_model','login_m');
        $this->load->model('Sale_model','sale_m');
        $this->load->model('Stock_model','stock_m');
		is_logged_in();
	}

    public function sales()
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['sales'] 		= $this->sale_m->getSale()->result();
		$data['title'] 		= 'Laporan Data Penjualan';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("reports/sale_report",$data);
		$this->load->view("templates/footer");
	
	}

    function test(){
        $list = $this->sale_m->get_datatables_range_date('1647685510', '1647685510');
        // $countAll = $this->sale_m->count_all_range_date();
        // $countFiltered = $this->sale_m->count_filtered_range_date('1647685510', '1647685510');

        $list2 = $this->sale_m->get_datatables();
        $countAll2 = $this->sale_m->count_all();
        $countFiltered2 = $this->sale_m->count_filtered();

        print_r($countFiltered2);
    }

    function get_ajax_sale() {
        $list = $this->sale_m->get_datatables();
        $countAll = $this->sale_m->count_all();
        $countFiltered = $this->sale_m->count_filtered();
        $data = array();
        $no = @$_POST['start'];
        
        if($_POST['searchByFromdate'] != '' && $_POST['searchByTodate'] != ''){
            $fromDate = strtotime($_POST['searchByFromdate']);
            $toDate = strtotime($_POST['searchByTodate']);

            if($fromDate != '' && $toDate != ''){
                $list = $this->sale_m->get_datatables_range_date($fromDate, $toDate);
                $countAll = $this->sale_m->count_all_range_date();
                $countFiltered = $this->sale_m->count_filtered_range_date($fromDate, $toDate);
            }
        }

        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no.".";
            $row[] = $item->invoice;
            $row[] = Date("d-m-Y", $item->created);
            $row[] = $item->total_price;
            $row[] = $item->discount;
            $row[] = $item->cash;
			$row[] = '<a href="'.site_url('sale/cetak/'.$item->id).'" target="_blank" class="btn btn-xs btn-info" id="printreport">
                        <i class="fa fa-print"></i> Print
                    </a>
                    <button data-invoice="'.$item->invoice.'" data-date="'.$item->date.'" data-time="'.Date("d-m-Y", $item->created).'" data-total="'.indo_currency($item->total_price).'" data-diskon="'.indo_currency($item->discount).'" data-grandtotal="'.indo_currency($item->final_price).'" data-cash="'.indo_currency($item->cash).'" data-remaining="'.indo_currency($item->remaining).'" data-note="'.$item->note.'" data-kasir="'.$item->user_name.'" data-saleid="'.$item->id.'" id="detail" data-target="#modal-detail" data-toggle="modal" class="btn btn-xs btn-success" id="detailreport">
                        Detail
                    </button>';
           $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $countAll,
                    "recordsFiltered" => $countFiltered,
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }

	public function sale_product($saleid)
    {
		$result = $this->sale_m->get_sale_detail($saleid)->result();

		echo json_encode($result); 
	}

}
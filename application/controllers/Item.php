<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_Item_model','item_m');
		$this->load->model('Item_model','unit_item_m');
		$this->load->model('Item_menu_model','item_menu_m');
		$this->load->model('Login_model','login_m');
		$this->load->model('Category_model','category_m');
		is_logged_in();
	}

	function get_ajax() {
        $list = $this->item_m->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no.".";
			$row[] = $item->name.' <a href="'.site_url('item/print_barcode/'.$item->id).'" class="btn btn-default btn-xs">
									<i class="fa fa-barcode"></i>
								</a>';
            $row[] = $item->barcode;
            $row[] = $item->category_name;
            $row[] = $item->price;
            $row[] = $item->stock;
            $row[] = $item->image != null ? '<img src="'.base_url('assets/img/upload/products/'.$item->image).'" class="img" style="width:100px">' : null;
			$row[] = '<a href="'.base_url('item/edit/'.$item->id).'" class="btn btn-xs btn-info">Edit</a>
						<form action="'.site_url('item/delete').'" method="post">
							<input type="hidden" name="item_id" value="'.$item->id.'">
							<input type="hidden" name="gambar" value="'.$item->image.'">
							<button type="submit" onclick="return confirm(\'Apakah Anda yakin?\')" class="btn btn-xs btn-danger">Delete</button>
						</form>';
           $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->item_m->count_all(),
                    "recordsFiltered" => $this->item_m->count_filtered(),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }
	
	public function index()
	{
		$data['title'] 		= 'Product Item Management';
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['items'] 		= $this->item_m->getItems();
		$data['unititems'] 	= $this->unit_item_m->getItems();
		$data['category'] 	= $this->category_m->getCategories();

		$this->form_validation->set_rules('name','Nama','required');
		$this->form_validation->set_rules('barcode','Kode','required|trim|is_unique[product_item.barcode]');

		if($this->form_validation->run() == false){

			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("product/item/index",$data);
			$this->load->view("templates/footer");
		} else {
			$image = '';
			$upload_image = $_FILES['image']['name'];

			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/img/upload/products';
				$config['file_name'] = 'img-'.$this->input->post('barcode');

				$this->load->library('upload',$config);
				if($this->upload->do_upload('image')){
					// unlink(FCPATH.'assets/img/upload/products/'.$this->upload->data('file_name'));
					$image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">'.$this->upload->display_errors().'</div>');
					redirect('item');
				}
			}

			$data = [
				'barcode' => htmlspecialchars($this->input->post('barcode',true)),
				'name' => htmlspecialchars($this->input->post('name',true)),
				'category_id' => htmlspecialchars($this->input->post('kategori',true)),
				'price' => htmlspecialchars($this->input->post('harga',true)),
				'stock' => htmlspecialchars($this->input->post('stock',true)),
				'image' => $image,
				'created' => time()
			];

			$this->db->insert('product_item', $data); 
			$insert_id = $this->db->insert_id();

			for($i=1;$i<=8;$i++){
				$bahan = 'bahan'.$i;
				$quantity = 'qty'.$i;
				if($this->input->post($bahan) != ''){
					$databahan = [
						'product_id' => (int)$insert_id,
						'item_id' => (int)$this->input->post($bahan),
						'qty' => (int)$this->input->post($quantity),
						'created' => time()
					];
					$this->db->insert('menu_item', $databahan);
				}
			}

			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Item Baru Berhasil Ditambahkan!</div>');
			redirect('item');
		}
	
	}

	public function edit($id_item)
	{
		$data['user'] 			= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['oneitem'] 		= $this->item_m->getItem($id_item);
		$data['onemenuitem'] 	= $this->item_menu_m->getMenuItem($id_item);
		$data['category'] 		= $this->category_m->getCategories();
		$data['unititems'] 		= $this->unit_item_m->getItems();
		$data['title'] 			= 'Edit Item';

		$this->form_validation->set_rules('nama','Nama','required|trim');
		if($this->form_validation->run() == false)
		{
			if(!$data['oneitem']){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data Item Tidak Ditemukan!</div>');
				redirect('item');
			} else {
				$this->load->view("templates/header",$data);
				$this->load->view("templates/sidebar",$data);
				$this->load->view("templates/topbar",$data);
				$this->load->view("product/item/edit",$data);
				$this->load->view("templates/footer");
			}
		} else {

			$image = $data['oneitem']->image;
			$upload_image = $_FILES['image']['name'];

			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/img/upload/products';
				$config['file_name'] = 'img-'.$this->input->post('barcode');

				$this->load->library('upload',$config);
				$fileExt = pathinfo($upload_image, PATHINFO_EXTENSION);
				if($image != ''){
					unlink('./assets/img/upload/products/img-'.$this->input->post('barcode').'.'.$fileExt);
				}
				if($this->upload->do_upload('image')){
					$image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">'.$this->upload->display_errors().'</div>');
					redirect('item');
				}
			}

			$data = [
				'id' => $this->input->post('item_id'),
				'barcode' => htmlspecialchars($this->input->post('barcode',true)),
				'name' => htmlspecialchars($this->input->post('nama',true)),
				'category_id' => htmlspecialchars($this->input->post('kategori',true)),
				'price' => htmlspecialchars($this->input->post('price',true)),
				'stock' => htmlspecialchars($this->input->post('stock',true)),
				'image' => $image,
				'updated' => time()
			];

			$this->item_m->updateitem($data);

			for($i=1;$i<=8;$i++){
				$id = 'menuitem'.$i;
				$bahan = 'bahan'.$i;
				$quantity = 'qty'.$i;

				if($this->input->post($bahan) != ''){
					$databahan = [
						'id' => (int)$this->input->post($id),
						'product_id' => (int)$this->input->post('item_id'),
						'item_id' => (int)$this->input->post($bahan),
						'qty' => (int)$this->input->post($quantity),
						'updated' => time()
					];
				}

				$cek = $this->item_menu_m->getMenuItem((int)$this->input->post('item_id'));

				if(count($cek) > 0 ){
					$this->item_menu_m->updatemenuitem($databahan);
				} else {
					$this->db->insert('menu_item', $databahan);
				}
					
			}

			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Item Sukses!</div>');
			redirect('item/edit/'.$this->input->post('item_id'));
			// if($this->db->affected_rows() > 0){
			// 	$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Item Sukses!</div>');
			// 	redirect('item/edit/'.$this->input->post('item_id'));
			// } else {
			// 	$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Update Item Gagal! Silahkan Coba Lagi!</div>');
			// 	redirect('item/edit/'.$this->input->post('item_id'));
			// }
		}
	}

	public function delete()
	{
		$id = $this->input->post('item_id');
		
		$this->item_m->deleteItem($id);
		$this->item_menu_m->deleteMenuItem($id);

		if($this->db->affected_rows() > 0){
			unlink('./assets/img/upload/products/'.$this->input->post('gambar'));
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Item Berhasil Dihapus!</div>');
			redirect('item');
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus Item Baru Gagal! Silahkan Coba Lagi!</div>');
			redirect('item');
		}
	}

	public function print_barcode($id_item)
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$data['category'] 	= $this->category_m->getCategories();
		$data['title'] 		= 'Barcode Item';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("product/item/barcode",$data);
		$this->load->view("templates/footer");
	} 

	public function printpdf_barcode($id_item)
	{
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    
		pdf_generator('<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data['oneitem']->barcode, $generator::TYPE_CODE_128)) . '"><br>'.$data['oneitem']->barcode,'coba');
	}

}

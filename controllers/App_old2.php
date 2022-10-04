<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	
	public function __construct()
  {
    parent::__construct();
    
    //$this->load->model('m_login');
	$this->load->model('m_app');
    $this->load->library(array('form_validation','session', 'user_agent'));
	$this->load->library('pagination');
    $this->load->database();
    $this->load->helper('url','form','download');
  } 
  
public function dummy_over()
{
	$a = $this->session->userdata('level');
	if (strpos($a, '999')!== false) {
		// function generateRandomString($length = 10) {
   			// $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   			// $charactersLength = strlen($characters);
   			// $randomString = '';
   			// for ($i = 0; $i < $length; $i++) {
   				// $randomString .= $characters[rand(0, $charactersLength - 1)];
   			// }
   			// return $randomString;
   		// }
		
		$this->db->select('*');
		$query = $this->db->get('users_dummy');
		if ($query->num_rows() > 0 ){
		foreach ($query->result() as $data){
			$users = $data->username;
			$sql1 = "select username FROM users WHERE username = '$users'";
			$query1 = $this->db->query($sql1);
			$r1 = $query1->result_array();
			//$r2 = $r1[0]['username'];
			if (empty($r1)) {
				$pass_hash = password_hash($data->nip, PASSWORD_DEFAULT);
				$data_insert = array (
					'nama' 				=> $data->nama,
					'username'			=> $data->username,
					'password'			=> $pass_hash,
					'level'				=> $data->level,
					'status'			=> $data->status,
					'email'				=> $data->email,
					'phone'				=> $data->phone,
					'kd_agent'			=> $data->kd_agent,
					'nip'				=> $data->nip
				);
				$this->db->insert('users',$data_insert);
			}
		}
		}
		echo "<script>alert('Coba cek deh!');window.history.back();</script>";
	}
	echo "<script>alert('Not Allowed!');window.history.back();</script>";
}  

public function create_memo()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '402')!== false) {
		$data['sendto'] = $this->m_app->sendto($this->session->userdata('level_jabatan'),$this->session->userdata('bagian'));
		$this->load->view('create_memo', $data);
	}
	}
}
public function simpan_memo()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '402')!== false) {
		$this->form_validation->set_rules('tujuan_memo[]', 'tujuan_memo', 'required');
		$this->form_validation->set_rules('subject_memo', 'subject_memo', 'required|trim');
		$this->form_validation->set_rules('ckeditor', 'ckeditor', 'required');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			echo "<script>alert('error input!');window.location.href = '" . base_url() . "app/create_memo';</script>";
		} else {
			date_default_timezone_set('Asia/Jakarta');
			//simpan memo
			$nip_kpd='';
			foreach ($this->input->post('tujuan_memo[]') as $value) 
			{
				$nip_kpd .= $value.';';
			}
			if ($this->session->userdata('level_jabatan')==3){
				$this->db->select_max('nomor_memo');
				$this->db->where('nip_dari', $this->session->userdata('nip'));
				$res1 = $this->db->get('memo');
				if ($res1->num_rows() > 0)
				{
					$res2 = $res1->result_array();
					$no_memo = $res2[0]['nomor_memo']+1;
				}else{$no_memo = 1;}
			}
			else{
				$no_memo='';}
		
			$judul		= $this->input->post('subject_memo');
			$isi_memo		= $this->input->post('ckeditor');
			$data_update1 	= array (
				'nomor_memo'	=> $no_memo,
				'nip_kpd'		=> $nip_kpd,
				'judul'			=> $judul,
				'isi_memo'		=> $isi_memo,
				'nip_dari'		=> $this->session->userdata('nip'),
				'tanggal'		=> date('Y-m-d H:i:s'),
				'read'			=> 0
			);
			$this->db->insert('memo', $data_update1);
			echo "<script>alert('Create & Send Success to ID $nip_kpd');window.location.href = '" . base_url() . "app/create_memo';</script>";
		}
		
		//reload Send Memo
		$data['sendto'] = $this->m_app->sendto($this->session->userdata('level_jabatan'),$this->session->userdata('bagian'));
		$this->load->view('create_memo', $data);
	}
	}
}

public function inbox_cari()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '401')!== false) {
		// get search string
		$search = ($this->input->post("search"))? $this->input->post("search") : "NIL";
		if ($search<>'NIL'){
			$this->session->set_userdata('keyword',$search);
		}
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		$stringLink = str_replace(' ', '_', $search);
		// pagination settings
		$config = array();
		$config['base_url'] = site_url("app/inbox_cari/$stringLink");
		$config['total_rows'] = $this->m_app->inbox_cari_count($search,$this->session->userdata('nip'));
		$config['per_page'] = "10";
		$config["uri_segment"] = 4;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;

		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		// get books list
		$data['users_data'] = $this->m_app->inbox_cari_pagination($config["per_page"], $data['page'], $search,$this->session->userdata('nip'));
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('inbox_view', $data);
	}
	}
}


public function send_memo()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '401')!== false) {
		//pagination settings
		$config['base_url'] = site_url('app/inbox');
		$config['total_rows'] = $this->m_app->memo_count_send($this->session->userdata('nip'));
		$config['per_page'] = "10";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['users_data'] = $this->m_app->memo_get_send($config["per_page"], $data['page'], $this->session->userdata('nip'));
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('inbox_view', $data);
	}
	}
}

public function inbox()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '401')!== false) {
		//pagination settings
		$config['base_url'] = site_url('app/inbox');
		$config['total_rows'] = $this->m_app->memo_count($this->session->userdata('nip'));
		$config['per_page'] = "10";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['users_data'] = $this->m_app->memo_get($config["per_page"], $data['page'], $this->session->userdata('nip'));
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('inbox_view', $data);
	}
	}
}
public function memo_view()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
	$a = $this->session->userdata('level');
	if (strpos($a, '401')!== false) {
		$data['memo'] = $this->m_app->memo_get_detail($this->uri->segment(3));
		$this->load->view('memo_view',$data);
	}
	}
}

public function cari_gaji()
{
	$a = $this->session->userdata('level');
	if (strpos($a, '302')!== false) {
		$data['slip'] = $this->m_app->cari_gaji($this->session->userdata('nip'));
		$this->load->view('cetak_gaji',$data);
		// if (count($data)==1){
			// $this->slip_gaji_pdf();
			// }else{
			// $this->load->view('cetak_gaji',$data);
		// }
	}
}
public function cetak_gaji()
{
	$a = $this->session->userdata('level');
	if (strpos($a, '302')!== false) {
		$this->load->view('cetak_gaji');
	}
}
public function slip_gaji_pdf()
{
	$id=$this->uri->segment(3);	
	//$data['slip'] = $this->m_app->slip_gaji($this->session->userdata('nip'));
	$data['slip'] = $this->m_app->slip_gaji($id);
	
    $this->load->library('pdf');
	$options = $this->pdf->getOptions(); 
    $options->set(array('isRemoteEnabled' => true));
    $this->pdf->setOptions($options);
	
	if (empty($data['slip'])){
		echo "<script>alert('Data tidak ditemukan!');window.location.href = '" . base_url() . "app/cetak_gaji';</script>";
	}else{
		if ($data['slip']->pembayaran == 1) {
			$this->pdf->setPaper('A4', 'potrait');
			$this->pdf->filename = "slip_gaji.pdf"; 
			$this->pdf->load_view('slip_gaji_pdf', $data);
		}elseif($data['slip']->pembayaran == 2){
			$this->pdf->setPaper('A4', 'potrait');
			$this->pdf->filename = "slip_gaji.pdf"; 
			$this->pdf->load_view('slip_gaji_pdf2', $data);
		}
	}
}
public function import()
{
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('home');}
	else{
		$a = $this->session->userdata('level');
		if (strpos($a, '301')!== false) {
			$this->load->view('upload_gaji');
		}
	}
}
public function upload_gaji()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '301')!== false) {
		// Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('excel');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect('app/import');
        } else {
			$data_upload 	= $this->upload->data();

            $excelreader	= new PHPExcel_Reader_Excel2007();
            $loadexcel		= $excelreader->load('excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet          = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $numrow = 2;
            foreach($sheet as $row){
				if($numrow > 2){
					array_push($data, array(
						'nama' 			=> $row['B'],
						'jabatan'      	=> $row['C'],
						'gapok'     	=> $row['E'],
						'tu_jabatan'    => $row['F'],
						'tu_transport'  => $row['G'],
						'tu_makan'     	=> $row['H'],
						'tu_insentif'   => $row['I'],
						'tu_lembur'     => $row['J'],
						'tu_bpjs_tk'    => $row['K'],
						'tu_bpjs_kes'   => $row['L'],
						'gross_gaji'	=> $row['M'],
						'pot_kasbon'	=> $row['N'],
						'pot_wfh'		=> $row['O'],
						'pot_absen'		=> $row['P'],
						'pot_terlambat'	=> $row['Q'],
						'pot_pulang'	=> $row['R'],
						'pot_bpjs_tk'	=> $row['S'],
						'simp_koperasi'	=> $row['T'],
						'pot_koperasi'	=> $row['U'],
						'pot_bpjs_kes'	=> $row['V'],
						'pot_total'		=> $row['W'],
						'net_gaji'		=> $row['X'],
						'hari_kerja'	=> $row['Y'],
						'tidak_hadir'	=> $row['Z'],
						'surat_dokter'	=> $row['AA'],
						'potong_cuti'	=> $row['AB'],
						'nip'			=> $row['AC'],
						'bulan_gaji'	=> $row['AD'],
						'pembayaran'	=> 1,
						'user_upload'	=> $this->session->userdata('username')
					));
				}
                $numrow++;
            }
            $this->db->insert_batch('gaji', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));
            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('app/import');
        }
	}else{
		//echo "<script>alert('Not Allowed!');window.history.back();</script>";
		echo "<script>alert('Not Allowed!');</script>";
		redirect('home');
	}
  }
  
public function upload_gaji2()
{
	$a = $this->session->userdata('level');
	if (strpos($a, '301')!== false) {
		// Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('excel');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            //upload gagal
            $this->session->set_flashdata('notif2', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect('app/import');
        } else {
			$data_upload 	= $this->upload->data();

            $excelreader	= new PHPExcel_Reader_Excel2007();
            $loadexcel		= $excelreader->load('excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet          = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $numrow = 2;
            foreach($sheet as $row){
				if($numrow > 2){
					array_push($data, array(
						'nama' 					=> $row['B'],
						'jabatan'      			=> $row['C'],
						'gapok'     			=> $row['D'],
						'tu_transport'  		=> $row['E'],
						'tu_makan'     			=> $row['F'],
						'gross_gaji'			=> $row['G'],
						'hari_kerja'			=> $row['H'],
						'upah_perhari'			=> $row['I'],
						'hari_kerja_berjalan'	=> $row['J'],
						'pot_absen'				=> $row['K'],
						'kebijakan_prsh'		=> $row['L'],
						'hok_dibayar'			=> $row['M'],
						'insentif_backup'		=> $row['N'],
						'tu_bpjs_kes'			=> $row['O'],
						'tu_lembur'				=> $row['P'],
						'tu_insentif'			=> $row['Q'],
						'simp_koperasi'			=> $row['R'],
						'pot_kasbon'			=> $row['S'],
						'pot_bpjs_tk'			=> $row['T'],
						'pot_total'				=> $row['U'],
						'net_gaji'				=> $row['V'],
						'nip'					=> $row['W'],
						'bulan_gaji'			=> $row['X'],
						'periode_gaji'			=> $row['Y'],
						'pembayaran'			=> 2,
						'user_upload'			=> $this->session->userdata('username')
					));
				}
                $numrow++;
            }
            $this->db->insert_batch('gaji', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));
            //upload success
            $this->session->set_flashdata('notif2', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('app/import');
        }
	}else{
		//echo "<script>alert('Not Allowed!');window.history.back();</script>";
		echo "<script>alert('Not Allowed!');</script>";
		redirect('home');
	}
}
  public function review_antrian()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '102')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('home');}
		else{
			$id_antrian = $this->uri->segment(3);
			$antrian = $this->m_app->get_antrian($id_antrian);
			$users = $this->m_app->get_user_username($antrian->username);
			$agent = $this->m_app->get_agent_id($users->kd_agent);
			$data['antrian_smu']=$this->m_app->get_antrian_smu_nomor_antrian($id_antrian);
			$data['id_antrian']=$id_antrian;
			$data['nama_agent']=$agent->nama;
			$data['antrian']   = $antrian;
			$this->load->view('review_antrian', $data);
		}
	}else{
		//echo "<script>alert('Not Allowed!');window.history.back();</script>";
		echo "<script>alert('Not Allowed!');</script>";
		redirect('home');
	}
  }
  public function list_antrian()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '102')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('home');}
		else{
		$utility = $this->m_app->get_utility();	
		
			//pagination settings
        $config['base_url'] = site_url('app/list_antrian');
        $config['total_rows'] = $this->m_app->list_antrian_count($utility->tgl_antrian);
        $config['per_page'] = "8";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        //$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // get books list
        $data['antrian'] = $this->m_app->list_antrian_pagination($config["per_page"], $data['page'], NULL);
        $data['pagination'] = $this->pagination->create_links();
		
		$this->session->unset_userdata('keyword');
		$this->load->view('list_current_antrian', $data);
		}
	}else{
		//echo "<script>alert('Not Allowed!');window.history.back();</script>";
		echo "<script>alert('Not Allowed!');</script>";
		redirect('home');
	}
  }
  
  public function quotation()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '201')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('home');}
		else{
			// get search string
			$search = ($this->input->post("search"))? $this->input->post("search") : "NIL";
			if ($search<>'NIL'){
				$this->session->set_userdata('keyword',$search);
			}
			$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
			$stringLink = str_replace(' ', '_', $search);
			// pagination settings
			$config = array();
			$config['base_url'] = site_url("app/quotation/$stringLink");
			$config['total_rows'] = $this->m_app->quotation_count($search);
			$config['per_page'] = "10";
			$config["uri_segment"] = 4;
			$choice = $config["total_rows"]/$config["per_page"];
			//$config["num_links"] = floor($choice);
			$config["num_links"] = 10;

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = 'Prev';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			// get books list
			$data['users_data'] = $this->m_app->list_quotation($config["per_page"], $data['page'], $search);
			$data['pagination'] = $this->pagination->create_links();
			$data['tujuan'] = $this->m_app->ambil_tujuan();
			$this->load->view('quotation', $data);
		}
	}else{
		//echo "<script>alert('Not Allowed!');window.history.back();</script>";
		echo "<script>alert('Not Allowed!');</script>";
		redirect('home');
	}
  }
  
  public function antrian_monitor()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '103') !== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('login');}else{
			$utility = $this->m_app->get_utility();
			$data['utility'] = $this->m_app->get_utility();
			$data['antrian']  = $this->m_app->get_antrian_user($this->session->userdata('username'));
			$data['sisa_antrian'] = $this->m_app->sisa_antrian($utility->tgl_antrian);
			$data['antrian_besok'] = $this->m_app->antrian_besok($utility->tgl_antrian);
			$data['antrian1'] = $this->m_app->get_antrian($utility->slot1_id);
			$data['antrian2'] = $this->m_app->get_antrian($utility->slot2_id);
			$data['antrian3'] = $this->m_app->get_antrian($utility->slot3_id);
			$data['antrian4'] = $this->m_app->get_antrian($utility->slot4_id);
			$data['antrian5'] = $this->m_app->get_antrian($utility->slot5_id);
			$data['antrian6'] = $this->m_app->get_antrian($utility->slot6_id);
			$data['antrian7'] = $this->m_app->get_antrian($utility->slot7_id);
			$data['antrian8'] = $this->m_app->get_antrian($utility->slot8_id);
			$this->load->view('antrian_monitor', $data);
		}
	}else{
		//echo "<script>alert('Not Allowed!');window.history.back();</script>";
		echo "<script>alert('Not Allowed!');</script>";
		redirect('home');
	}
  }
  public function antrian_panggil()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '102') !== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('login');}else{
			$utility = $this->m_app->get_utility();
			$data['utility']  = $this->m_app->get_utility();
			$data['sisa_antrian'] = $this->m_app->sisa_antrian($utility->tgl_antrian);
			$data['need_approve'] = $this->m_app->get_antrian_status(1, date("Y-m-d"));
			$data['antrian_besok'] = $this->m_app->antrian_besok($utility->tgl_antrian);
			$data['antrian1'] = $this->m_app->get_antrian($utility->slot1_id);
			$data['antrian2'] = $this->m_app->get_antrian($utility->slot2_id);
			$data['antrian3'] = $this->m_app->get_antrian($utility->slot3_id);
			$data['antrian4'] = $this->m_app->get_antrian($utility->slot4_id);
			$data['antrian5'] = $this->m_app->get_antrian($utility->slot5_id);
			$data['antrian6'] = $this->m_app->get_antrian($utility->slot6_id);
			$data['antrian7'] = $this->m_app->get_antrian($utility->slot7_id);
			$data['antrian8'] = $this->m_app->get_antrian($utility->slot8_id);
			$this->load->view('antrian_panggil', $data);
		}
	}else{
		//echo "<script>alert('Not Allowed!');window.history.back();</script>";
		echo "<script>alert('Not Allowed!');</script>";
		redirect('home');
	}
  }
  public function set_date()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{
		$this->form_validation->set_rules('date_pic', 'date_pic', 'required|trim');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			echo "<script>alert('Tanggal belum diseting!');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
		} else {
			$this->m_app->set_date($this->input->post('date_pic'));
			echo "<script>alert('Tanggal berhasil diubah!');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
		}
	}
  }
  public function jadwal_ngantri()
  {
	$tanggal 	 = $this->input->post('tanggal');
	$time_flight = $this->input->post('time_flight');
	$tgl_flight  = $this->input->post('tgl_flight');
	$now 		= date('Y-m-d');
	$yesterday 	= date('Y-m-d',strtotime($now . "-1 days"));
	$tomorrow 	= date('Y-m-d',strtotime($now . "+1 days"));
	if (($tanggal==$now) OR ($tanggal==$tomorrow)){
		$data 		= $this->m_app->ambil_jadwal($tanggal, $time_flight, $tgl_flight);
		echo json_encode($data);
	}else{
		$data = [
			'0'=>['Id'=>1,'name'=>'Void Time'],
		];
		echo json_encode($data);
	}
  }
  public function delete_smu()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '101')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('login');}else{
			$this->m_app->delete_smu_id($this->uri->segment(3));
			echo "<script>alert('AWB Deleted!');window.location.href = '" . base_url() . "app/antrian_input';</script>";
		}
	}else{
		echo "<script>alert('Not Allowed!');window.history.back();</script>";
	}
  }
  public function reject_antrian()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '102')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('login');}else{
			$remark = $this->input->post('remark');
			$this->m_app->update_antrian_id(9,$this->uri->segment(3),$remark,'',);
			
			$id = $this->uri->segment(3);
			$sql = "select username FROM antrian WHERE Id = $id";
			$query = $this->db->query($sql);
			$res2 = $query->result_array();
			//$users = $this->m_app->get_user_username($res2[0]['username']);
			$users = $res2[0]['username'];
			$sql = "select phone FROM users WHERE username = '$users'";
			$query = $this->db->query($sql);
			$res3 = $query->result_array();
			$no_wa = $res3[0]['phone'];
			//echo "<script>alert('Antrian ditolak!');window.location.href = '" . base_url() . "app/list_antrian';</script>";
			echo "<script>alert('Antrian ditolak!');window.location.href = 'https://api.whatsapp.com/send?phone=$no_wa&text=Antrian Rejected, check BDL Apps';</script>";
		}
	}else{
		echo "<script>alert('Not Allowed!');window.history.back();</script>";
	}
  }
  public function approve_antrian()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '102')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('login');}else{
			$id = $this->uri->segment(3);
			$sql = "select username,jam_terpilih FROM antrian WHERE Id = $id";
			$query = $this->db->query($sql);
			$res2 = $query->result_array();
			$result = $res2[0]['jam_terpilih'];
			
			$this->m_app->update_antrian_id(2,$this->uri->segment(3),'', $this->input->post('jam_terpilih'), $result);
			
			$users = $res2[0]['username'];
			$sql = "select phone FROM users WHERE username = '$users'";
			$query = $this->db->query($sql);
			$res3 = $query->result_array();
			$no_wa = $res3[0]['phone'];
			//echo "<script>alert('Antrian telah disetujui!');window.location.href = '" . base_url() . "app/list_antrian';</script>";
			echo "<script>alert('Antrian telah disetujui!');window.location.href = 'https://api.whatsapp.com/send?phone=$no_wa&text=Antrian Approved, check BDL Apps';</script>";
		}
	}else{
		echo "<script>alert('Not Allowed!');window.history.back();</script>";
	}
  }
  public function submit_antrian()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '101')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('login');}else{
			$id = $this->uri->segment(3);
			if (empty($id)){
				echo "<script>alert('Data tidak ditemukan!');window.location.href = '" . base_url() . "app/antrian_input';</script>";
			}else{
				$this->m_app->update_antrian_id(1,$this->uri->segment(3),'');
				$sql = "select * FROM utility";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['avsec_cgk_no'];
				$no_wa = $result;
				//echo "<script>alert('Antrian telah disubmit untuk meminta Approval!');window.location.href = '" . base_url() . "app/antrian_input';</script>";
				
				echo "<script>alert('Antrian telah disubmit untuk meminta Approval!');window.location.href = 'https://api.whatsapp.com/send?phone=$no_wa&text=Antrian Submite, check BDL Apps';</script>";
			}
		}
	}else{
		echo "<script>alert('Not Allowed!');window.history.back();</script>";
	}
  }
  public function antrian_input()
  {
	$a = $this->session->userdata('level');
	if (strpos($a, '101')!== false) {
		if($this->session->userdata('isLogin') == FALSE)
		{redirect('login');}else{
			if (empty($this->uri->segment(3))){
				$last_id = '';
				$id_antrian = '';
			}else{
				$id = $this->uri->segment(3);
				$this->db->select('nomor_antrian');
				$this->db->where('Id', $this->uri->segment(3));
				$this->db->where('status', 0);
				$res1 = $this->db->get('antrian');
				if ($res1->num_rows() > 0)
				{
					$res2 = $res1->result_array();
					$result = $res2[0]['nomor_antrian'];
					$last_id = $result;
					$data['antrian_smu']=$this->m_app->get_antrian_smu_nomor_antrian($id);
				}else{
					$last_id = '';
				}
				
			}
			$data['utility'] = $this->m_app->get_utility();
			$data['agent'] = $this->m_app->ambil_data_agent($this->session->userdata('kd_agent'));
			//$data['tujuan'] = $this->m_app->ambil_tujuan();
			$data['last_id'] = $last_id;
			if (!empty($id)){
				$data['id_antrian'] = $id;
			}else{$data['id_antrian'] = '';}
			//$data['jadwal_antrian'] = $this->m_app->ambil_jadwal();
			$this->load->view('antrian_truck_input', $data);
		}
	}else{
		echo "<script>alert('Not Allowed!');window.history.back();</script>";
	}
  }
  function simpan_antrian(){
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		$this->form_validation->set_rules('nomor_mobil', 'nomor_mobil', 'required|trim');
		$this->form_validation->set_rules('nomor_segel', 'nomor_segel', 'required|trim');
		//$this->form_validation->set_rules('nomor_csd', 'nomor_csd', 'required|trim');
		$this->form_validation->set_rules('nama_driver', 'nama_driver', 'required|trim');
		$this->form_validation->set_rules('phone', 'phone', 'required|trim');
		//$this->form_validation->set_rules('tujuan', 'tujuan', 'required|trim');
		$this->form_validation->set_rules('date_flight', 'date_flight', 'required|trim');
		$this->form_validation->set_rules('date_pic', 'date_pic', 'required|trim');
		$this->form_validation->set_rules('jam_terpilih', 'jam_terpilih', 'required|trim');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			echo "<script>alert('error input!');window.location.href = '" . base_url() . "app/antrian_input';</script>";
		} else {
			date_default_timezone_set('Asia/Jakarta');
			$date_pic 	= date('Y-m-d',strtotime($this->input->post('date_pic')));
			$dnow 		= date('Y-m-d');
			$now 		= date('Y-m-d',strtotime($dnow));
			$tomorrow 	= date('Y-m-d',strtotime($dnow . "+1 days"));
			$yesterday 	= date('Y-m-d',strtotime($dnow . "-1 days"));
			if (($date_pic > $tomorrow) OR ($date_pic < $now)){
				echo "<script>alert('tanggal antrian tidak diijinkan!');window.history.back();</script>";
			}else{
				$this->db->select('*');
				$this->db->where('name', $this->input->post('jam_terpilih'));
				$this->db->where('tanggal', $this->input->post('date_pic'));
				$res2 = $this->db->get('antrian_book');
				if ($res2->num_rows() > 7){
					echo "<script>alert('Full Book!');window.location.href = '" . base_url() . "app/antrian_input';</script>";
				}else{
					$this->m_app->simpan_antrian();
					
					$this->db->select_max('Id');
					$res1 = $this->db->get('antrian');
					if ($res1->num_rows() > 0)
					{
						$res2 = $res1->result_array();
						$result = $res2[0]['Id'];
					}
					$this->session->set_userdata('last_id',$result);
					echo "<script>alert('Antrian sukses di buat!');window.location.href = '" . base_url() . "app/antrian_input/".$result."';</script>";
					//echo "<script>alert('Antrian sukses di buat!');window.location.href = '" . base_url() . "app/antrian_input/".$result ."';</script>";
				}
			}
		}
	}
  }
  function upload_smu()
	{
		if($this->session->userdata('isLogin') == FALSE)
		{ 
			redirect('login'); 
		}else{
			
			$this->form_validation->set_rules('nomor_smu', 'nomor_smu', 'required|trim');
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run()==FALSE)
			{
				echo '<script>alert("Have an error Input!");window.history.back();</script>';
				
			}else {
				
				$config['upload_path'] = './upload/smu/';
				$config['allowed_types'] = 'jpg|jpeg';
				$config['file_name'] = $this->input->post('nomor_smu');
				$config['overwrite']= TRUE;
				$config['max_size']	= '4096';
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
					//$this->load->view('input_customer_view', $error);
					echo '<script>alert("Upload Error!");window.history.back();</script>';
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					//start save customer
					$smu_nomor	= $this->input->post('nomor_smu');
					$query 		= $this->m_app->get_antrian_smu_id($smu_nomor);
					if(!empty($query)){
						echo '<script>alert("Error! AWB number existing");window.history.back();</script>';
						//$this->load->view('input_customer_view');
					}else{
						if (!empty($this->uri->segment(3))){
							$this->db->select('nomor_antrian');
							$this->db->where('Id', $this->uri->segment(3));
							$res1 = $this->db->get('antrian');
							if ($res1->num_rows() > 0)
							{
								$res2 = $res1->result_array();
								$result = $res2[0]['nomor_antrian'];
							}
							$this->m_app->insert_smu($result);
							echo "<script>alert('AWB successfully saved!');window.location.href = '" . base_url() . "app/antrian_input/".$this->uri->segment(3)."';</script>";
							//$this->load->view('input_customer_view');
						}else{
							echo "<script>alert('Nomor Antrian tidak ditemukan!');window.location.href = '" . base_url() . "app/antrian_input/';</script>";
						}
						
					}
					//finish save customer	
					
					//$this->load->view('input_customer_view');
					//echo '<script>alert("Upload Laporan Keuangan sukses!");</script>';
				}
			}
		}
		
	}
  public function slot()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{
		//eksekusi antrian slot1
		$slot = $this->uri->segment(3);
		if ($slot==""){
			$utility = $this->m_app->get_utility();
			$this->form_validation->set_rules('nom_antrian', 'nom_antrian', 'required|trim');
			$this->form_validation->set_rules('pilih_slot', 'pilih_slot', 'required|trim');
			$this->form_validation->set_rules('date_pic1', 'date_pic1', 'required|trim');
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run()==FALSE)
			{
				echo "<script>alert('Terdapat kesalah input!');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
			}else{
				$this->db->select('Id,status');
				$this->db->where('date_pic', $this->input->post('date_pic1'));
				$this->db->where('nomor_antrian', $this->input->post('nom_antrian'));
				$res = $this->db->get('antrian');
				$res3 = $res->result_array();
				if (empty($res3)){
					echo "<script>alert('Tidak ditemukan nomor antrian');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
				}else{
					$id_status = $res3[0]['status'];
					if($id_status==3){
						echo "<script>alert('Nomor antrian sedang loading');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";	
					}else{
						$slot = 'slot'.$this->input->post('pilih_slot');
						if ($utility->$slot<>0){
							echo "<script>alert('Slot On Loading');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
						}else{	
							$this->m_app->slot($utility->tgl_antrian, $this->input->post('pilih_slot'), $this->input->post('nom_antrian'));
							
							//$res2 = $query->result_array();
							//$users = $this->m_app->get_user_username($res2[0]['username']);
							//echo "<script>alert('Antrian ditolak!');window.location.href = '" . base_url() . "app/list_antrian';</script>";
							
							echo "<script>alert('Antrin berhasil loading');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
						}
					}
				}
			}
		}else{
			$slot = $this->uri->segment(3);
			$utility = $this->m_app->get_utility();
			$s1 = $this->m_app->sisa_antrian($utility->tgl_antrian);
			if ($s1 == 0){
				echo "<script>alert('Tidak ada antrian!');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
			}else{
				$this->db->select('current_antrian');
				$current_antrian = $this->db->get('utility');
				$res2 = $current_antrian->result_array();
				$result = $res2[0]['current_antrian']+1;
				$tgl_antrian = $utility->tgl_antrian;
				$sql1 = "SELECT * FROM antrian WHERE ((DATE_ADD(NOW(), INTERVAL 8 HOUR) < date_flight) AND (date_pic = '$tgl_antrian') AND (nomor_antrian = $result))";
				$query = $this->db->query($sql1);
				$res3 = $query->result_array();
				//eksekusi antrian
				
				$sql="SELECT phone FROM antrian WHERE (date_pic = '$tgl_antrian' AND status = 2) ORDER BY jam_terpilih ASC, nomor_antrian ASC LIMIT 1";
				$r0 = $this->db->query($sql);
				$r1 = $r0->result_array();
				$r2 = $r1[0]['phone'];
				$no_wa = $r2;
				
				$this->m_app->slot($utility->tgl_antrian, $slot);
				if (empty($res3)){
					echo "<script>alert('Antrin berhasil loading');window.location.href = 'https://api.whatsapp.com/send?phone=$no_wa&text=Antrian Anda dimulai, check BDL Apps';</script>";
					//echo "<script>window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
				}else{
					echo "<script>alert('Warning!!! Date Flight Over 8 Hour!');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
				}
			}
		}
	}
  }
  public function slot_e()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{
		//eksekusi antrian finish
		$slot = $this->input->post('id_slot');
		//$slot = $this->uri->segment(3);
		$utility = $this->m_app->get_utility();
		if ($slot==1){$this->m_app->slot_e($utility->slot1_id, $slot);
		}elseif($slot==2){$this->m_app->slot_e($utility->slot2_id, $slot);
		}elseif($slot==3){$this->m_app->slot_e($utility->slot3_id, $slot);
		}elseif($slot==4){$this->m_app->slot_e($utility->slot4_id, $slot);
		}elseif($slot==5){$this->m_app->slot_e($utility->slot5_id, $slot);
		}elseif($slot==6){$this->m_app->slot_e($utility->slot6_id, $slot);
		}elseif($slot==7){$this->m_app->slot_e($utility->slot7_id, $slot);
		}elseif($slot==8){$this->m_app->slot_e($utility->slot8_id, $slot);
		}
		echo "<script>alert('Antrian Finish!');window.location.href = '" . base_url() . "app/antrian_panggil';</script>";
	}
  }
  
  
  
  
  
  
  
  //reference script
  
  public function finance_report()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{ 
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		$this->load->view('finance_report_view', $data);}
  }
  
  public function input_finance()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{ 
		$data['transaksi'] 	= $this->m_app->get_transaksi2();
		$data['users']		= $this->m_app->get_user_username($this->session->userdata('username'));
		$this->load->view('input_finance_view', $data);}
  }
  
  public function eom_proccess()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{ 
		if ($this->session->userdata('level')==1){
			//if admin
			$this->m_app->eom_proccess();
			echo '<script>alert("Success!");</script>';
			$this->load->view('admin_eom');
		}else{
			//if not admin
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}}
  }
  
  public function eom()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{ 
		if ($this->session->userdata('level')==1){
			//if admin
			$this->load->view('admin_eom');
		}else{
			//if not admin
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}}
  }
  
  public function admin_dashboard()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{ 
		if ($this->session->userdata('level')==1){
			//if admin
			$data['bank_cash'] 		= $this->m_app->bank_cash();
			$this->load->view('admin_dashboard', $data);
		}else{
			//if not admin
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}}
  }
  
  public function pending_transaction()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}else{ 
		if ($this->session->userdata('level')==1){
			$data['transaksi'] = $this->m_app->get_transaksi_admin(1);
			//$data['transaksi'] = $this->m_app->get_transaksi_admin(0);
			$this->load->view('pending_view', $data); 
		}else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}}
  }
  
  public function list_open()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		//pagination settings
        $config['base_url'] = site_url('app/list_open');
        $config['total_rows'] = $this->m_app->list_open_pagination_count();
        $config['per_page'] = "8";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        //$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // get books list
        $data['project'] = $this->m_app->list_open_pagination($config["per_page"], $data['page'], NULL);
        $data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
        //$this->load->view('pencarian',$data);
		
		$this->session->unset_userdata('keyword');
		$this->load->view('list_open_view', $data);
    }
  }
  
  public function list_open_search()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		// get search string
		$search = ($this->input->post("search"))? $this->input->post("search") : "NIL";
		if ($search<>'NIL'){
		$this->session->set_userdata('keyword',$search);}
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		$stringLink = str_replace(' ', '_', $search);
		// pagination settings
		$config = array();
		$config['base_url'] = site_url("app/list_open_search/$stringLink");
		$config['total_rows'] = $this->m_app->list_open_pagination_count($search);
		$config['per_page'] = "8";
		$config["uri_segment"] = 4;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;

		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		// get books list
		$data['project'] = $this->m_app->list_open_pagination($config["per_page"], $data['page'], $search);
		$data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		
		$this->load->view('list_open_view', $data);
    }
  }
  
  public function list_open_search_all()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		if ($this->session->userdata('level')==1){
		
		// get search string
		$search = ($this->input->post("search"))? $this->input->post("search") : "NIL";
		if ($search<>'NIL'){
		$this->session->set_userdata('keyword',$search);}
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		$stringLink = str_replace(' ', '_', $search);
		// pagination settings
		$config = array();
		$config['base_url'] = site_url("app/list_open_search/$stringLink");
		$config['total_rows'] = $this->m_app->list_open_pagination_count($search);
		$config['per_page'] = "8";
		$config["uri_segment"] = 4;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;

		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		// get books list
		$data['project'] = $this->m_app->list_open_all_pagination($config["per_page"], $data['page'], $search);
		$data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		
		$this->load->view('list_open_view_all', $data);
		} else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}
    }
  }
  
  public function waktunya_bayar_investor()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		//pagination settings
		$config['base_url'] = site_url('app/waktunya_bayar_investor');
		$config['total_rows'] = $this->m_app->list_open_pagination_pay_count(NULL, 'p.project_investor_username');
		$config['per_page'] = "8";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['project'] = $this->m_app->list_open_pagination_pay($config["per_page"], $data['page'], NULL, 'p.project_investor_username');
		$data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_project_view_pay', $data);
	}
  }
  
  public function cari_customer_overmonth()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		if ($this->session->userdata('level')==1){
		//pagination settings
		$config['base_url'] = site_url('app/cari_customer_overmonth');
		$config['total_rows'] = $this->m_app->list_open_pagination_over_count(NULL, 'p.project_username');
		$config['per_page'] = "8";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['project'] = $this->m_app->list_open_pagination_over($config["per_page"], $data['page'], NULL, 'p.project_username');
		$data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_open_view', $data);
		} else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}
	}
  }
  
  public function cari_customer_bayar()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		//if ($this->session->userdata('level')==1){
		
		//pagination settings
		$config['base_url'] = site_url('app/cari_customer_bayar');
		$config['total_rows'] = $this->m_app->list_open_pagination_pay_count(NULL, 'p.project_username');
		$config['per_page'] = "8";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['project'] = $this->m_app->list_open_pagination_pay($config["per_page"], $data['page'], NULL, 'p.project_username');
		$data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_open_view', $data);
		/*} else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}*/
	}
  }
  
  public function detail_transaction()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		
		//pagination settings
		$config['base_url'] = site_url('app/detail_transaction');
		$config['total_rows'] = $this->m_app->detrans_count_all($this->session->userdata('username'));
		$config['per_page'] = "20";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['users_data'] = $this->m_app->detrans_user($config["per_page"], $data['page'], NULL, $this->session->userdata('username'));
		$data['pagination'] = $this->pagination->create_links();
		//$data['total_kas'] = $this->m_app->list_ttl_kas();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_detail_transaction', $data);
	}
  }
  
  public function agent_list()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		if ($this->session->userdata('level')==1){
		
		//pagination settings
		$config['base_url'] = site_url('app/agent_list');
		$config['total_rows'] = $this->m_app->agent_list_count_all(NULL, 'u.users');
		$config['per_page'] = "20";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['users_data'] = $this->m_app->agent_list_all($config["per_page"], $data['page'], NULL, 'p.users');
		$data['pagination'] = $this->pagination->create_links();
		//$data['total_kas'] = $this->m_app->list_ttl_kas();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_agent_view_all', $data);
		} else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}
	}
  }
  
  public function cash_list()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		if ($this->session->userdata('level')==1){
		
		//pagination settings
		$config['base_url'] = site_url('app/cash_list');
		$config['total_rows'] = $this->m_app->cash_list_count_all('users');
		$config['per_page'] = "20";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['users_data'] = $this->m_app->cash_list_all($config["per_page"], $data['page'], NULL, 'users');
		$data['pagination'] = $this->pagination->create_links();
		$data['total_kas'] = $this->m_app->list_ttl_kas();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_cash_view_all', $data);
		} else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}
	}
  }
  
  public function payable_list()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		if ($this->session->userdata('level')==1){
		
		//pagination settings
		$config['base_url'] = site_url('app/payable_list');
		$config['total_rows'] = $this->m_app->payable_list_count_all(NULL, 'u.users');
		$config['per_page'] = "20";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['users_data'] = $this->m_app->payable_list_all($config["per_page"], $data['page'], NULL, 'p.users');
		$data['pagination'] = $this->pagination->create_links();
		$data['total_hutang'] = $this->m_app->list_ttl_hutang();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_payable_view_all', $data);
		} else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}
	}
  }
  
  public function cari_customer_bayar_all()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		if ($this->session->userdata('level')==1){
		
		//pagination settings
		$config['base_url'] = site_url('app/cari_customer_bayar_all');
		$config['total_rows'] = $this->m_app->list_open_pagination_pay_count_all(NULL, 'p.project_username');
		$config['per_page'] = "8";
		$config["uri_segment"] = 3;
		$choice = $config["total_rows"]/$config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '«';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '»';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		// get books list
		$data['project'] = $this->m_app->list_open_pagination_pay_all($config["per_page"], $data['page'], NULL, 'p.project_username');
		$data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
		//$this->load->view('pencarian',$data);
		$this->load->view('list_open_view_all', $data);
		} else{
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}
	}
  }
  
  public function list_project()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		//pagination settings
        $config['base_url'] = site_url('app/list_project');
        $config['total_rows'] = $this->m_app->list_project_pagination_count();
        $config['per_page'] = "8";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        //$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // get books list
        $data['project'] = $this->m_app->list_project_pagination($config["per_page"], $data['page'], NULL);
        $data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->list_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
        //$this->load->view('pencarian',$data);

		//$data['project'] = $this->m_app->get_new_project();
		$this->load->view('list_project_view', $data);
    }
  } 
  
  public function list_offers()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		//pagination settings
        $config['base_url'] = site_url('app/list_offers');
        $config['total_rows'] = $this->m_app->get_listoffers_count();
        $config['per_page'] = "8";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        //$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // get books list
        $data['offers'] = $this->m_app->get_listoffers($config["per_page"], $data['page'], NULL);
        $data['pagination'] = $this->pagination->create_links();
		//$data['total_invest'] = $this->m_app->get_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
        //$this->load->view('pencarian',$data);

		//$data['project'] = $this->m_app->get_new_project();
		$this->load->view('list_offers', $data);
    }
  } 
  
  public function grab_project()
  {
    if($this->session->userdata('isLogin') == FALSE)
    {redirect('home');}
	else{
		//pagination settings
        $config['base_url'] = site_url('app/grab_project');
        $config['total_rows'] = $this->m_app->get_project_pagination_count();
        $config['per_page'] = "8";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        //$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // get books list
        $data['project'] = $this->m_app->get_project_pagination($config["per_page"], $data['page'], NULL);
        $data['pagination'] = $this->pagination->create_links();
		$data['total_invest'] = $this->m_app->get_ttl_invest();
		$data['users'] = $this->m_app->get_user_username($this->session->userdata('username'));
		// load view
		//$this->session->unset_userdata('keyword');
        //$this->load->view('pencarian',$data);

		//$data['project'] = $this->m_app->get_new_project();
		$this->load->view('grab_project_view', $data);
    }
  } 
  
  public function umrah()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else { 
		if($this->input->post('save_umrah')){
		$this->form_validation->set_rules('package_name', 'package_name', 'required');
		$this->form_validation->set_rules('userfile', 'userfile', 'required');
		$this->form_validation->set_rules('date_depart', 'date_depart', 'required');
		$this->form_validation->set_rules('duration', 'duration', 'required');
		$this->form_validation->set_rules('price4', 'price4', 'required|trim');
		$this->form_validation->set_rules('price3', 'price3', 'required|trim');
		$this->form_validation->set_rules('price2', 'price2', 'required|trim');
		$this->form_validation->set_rules('discount', 'discount', 'required|trim');
		$this->form_validation->set_rules('quota_awal', 'quota_awal', 'required|trim');
		$this->form_validation->set_rules('quota_sisa', 'quota_sisa', 'required|trim');
		$this->form_validation->set_rules('voucher', 'voucher', 'required|trim');
		$this->form_validation->set_rules('airline', 'airline', 'required');
		$this->form_validation->set_rules('hotel_mekah', 'hotel_mekah', 'required|trim');
		$this->form_validation->set_rules('hotel_madinah', 'hotel_madinah', 'required|trim');
		$this->form_validation->set_rules('special_guest', 'special_guest');
		$this->form_validation->set_rules('halal_tourism', 'halal_tourism');
		$this->form_validation->set_rules('dateline_payment', 'dateline_payment', 'required');
		$this->form_validation->set_rules('dateline_document', 'dateline_document', 'required');
		$this->form_validation->set_rules('dateline_visa', 'dateline_visa', 'required');
		$this->form_validation->set_rules('manasik_date', 'manasik_date', 'required');
		$this->form_validation->set_rules('manasik_info', 'manasik_info');
		$this->form_validation->set_rules('itinerary', 'itinerary');
		$this->form_validation->set_rules('include', 'include');
		$this->form_validation->set_rules('other_info', 'other_info');

		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE){
			echo '<script>alert("Save ERROR! Check your input");</script>';
			$this->input_umrah();
		}else {
			
			echo '<script>alert("New umrah successfully saved!");</script>';
			$this->input_umrah();
		}
		}
	}
  }
  
  public function simpan_resale()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		$this->form_validation->set_rules('id_post1', 'id_post1', 'required');
		if($this->form_validation->run()==FALSE)
		{
			echo '<script>alert("Have an error Input!");</script>';
			$this->list_project();
		} else {
			//verifikasi user investor
			$id = $this->input->post('id_post1');
			$project = $this->m_app->get_project_id($id);
			$user = $this->m_app->get_user_username($this->session->userdata('username'));
			if (($this->session->userdata('username')==$project->project_investor_username) AND ($user->hutang < 1)){
				//valid project to sale, 
				$this->m_app->resale($id);
				echo '<script>alert("Resale project success!");</script>';
				$this->list_project();
			}else {
				//invalid project to sale
				echo '<script>alert("Invalid Project to Resale you have a payable less than 0");</script>';
				$this->list_project();
			}
		}
	}
  }
  
  function save_project()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		//check otorisation
		if ($this->session->userdata('level')==3){
			echo '<script>alert("ERROR!!! Sorry, your user is not allowed to create a project!");</script>';
			$this->input_form(); 
		} else {
		//check limit
		$query = $this->m_app->list_ttl_username();
		if (($this->session->userdata('limit')<=$query->project_modal)){
			echo '<script>alert("ERROR!!! your project limit is over!");</script>';
			$this->input_form();
		}else{
			//check NIK
			$nik = $this->m_app->get_identity($this->input->post('identity_number'));
			if (empty($nik)){
				echo '<script>alert("ERROR!!! Customer Identity Not found!");</script>';
				$this->input_form();
			}elseif ($nik->customer_status==9){
				echo '<script>alert("ERROR!!! Customer Identity is Banned!");</script>';
				$this->input_form();
			}else
			{
				$this->form_validation->set_rules('project_name', 'project_name', 'required');
				$this->form_validation->set_rules('identity_number', 'identity_number', 'required|trim');
				//$this->form_validation->set_rules('gender', 'gender', 'required');
				$this->form_validation->set_rules('product', 'product', 'required');
				$this->form_validation->set_rules('product_series', 'product_series', 'required');
				$this->form_validation->set_rules('quantity', 'quantity', 'required|trim');
				$this->form_validation->set_rules('price', 'price', 'required|trim');
				$this->form_validation->set_rules('down_payment', 'down_payment', 'required|trim');
				//$this->form_validation->set_rules('invesment', 'invesment', 'required|trim');
				$this->form_validation->set_rules('monthly', 'monthly', 'required|trim');
				$this->form_validation->set_rules('tenor', 'tenor', 'required|trim');
				$this->form_validation->set_rules('project_detail', 'project_detail');
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
				if($this->form_validation->run()==FALSE)
				{
					echo '<script>alert("Have an error Input!");</script>';
					$this->input_form();
				} else {
					$this->m_app->insert_project();
					echo '<script>alert("New projects successfully saved!");</script>';
					$this->input_form();
				}
			}
		}
		}
	}
  }
  
  function simpan_transaksi(){
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		$this->form_validation->set_rules('modal_nominal', 'modal_nominal', 'required|trim');
		$this->form_validation->set_rules('modal_info_detail', 'modal_info_detail');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			echo '<script>alert("Have an error Input!");</script>';
			$this->input_finance();
		} else {
			$this->m_app->insert_transaksi("modal",1);
			//echo '<script>alert("New transactions successfully saved for moderation!");</script>';
			echo "<script>alert('New transactions successfully saved for moderation!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			//$this->input_finance();
		}
	}
  }
  
  function transfer_user(){
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		$this->form_validation->set_rules('user_destination', 'user_destination', 'required|trim');
		$this->form_validation->set_rules('modal_nominal', 'modal_nominal', 'required|trim');
		$this->form_validation->set_rules('modal_info_detail', 'modal_info_detail');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			//echo '<script>alert("Have an error Input!");</script>';
			echo "<script>alert('Have an error Input!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			//$this->input_finance();
		} else {
			$userCheck = $this->m_app->get_user_username($this->input->post('user_destination'));
			if (empty($userCheck)){
				//echo '<script>alert("User Destination not found!");</script>';
				//$this->input_finance();
				echo "<script>alert('User Destination not found!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			}else{
				//cek main cash > transfer
				$users 	= $this->m_app->get_user_username($this->session->userdata('username'));
				if ($users->kas >= $this->input->post('modal_nominal')){
					$this->m_app->insert_transaksi("transfer -> ".$this->input->post('user_destination'),1);
					$this->m_app->insert_transaksi("transfer -> ".$this->input->post('user_destination'),2);
					$detail_transaksi = $this->m_app->get_transaksi_username($this->session->userdata('username'), 1);
					$this->m_app->post_transaksi_transfer($detail_transaksi->Id, $this->input->post('user_destination'));
					//echo '<script>alert("New transactions saved successfully!");</script>';
					echo "<script>alert('New transactions successfully saved for moderation!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
					//$this->input_finance();
				}else{
					//echo '<script>alert("insufficient main cash!");</script>';
					//$this->input_finance();
					echo "<script>alert('insufficient main cash!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
				}
			}
		}
	}
  }
  
  function simpan_tarik(){
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		$this->form_validation->set_rules('modal_nominal', 'modal_nominal', 'required|trim');
		$this->form_validation->set_rules('penarikan_info_detail', 'penarikan_info_detail');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			//echo '<script>alert("Have an error Input!");</script>';
			//$this->input_finance();
			echo "<script>alert('Have an error Input!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
		} else {
			$users		= $this->m_app->get_user_username($this->session->userdata('username'));
			$tarik 		= $this->input->post('modal_nominal');
			$f_tarik	= preg_replace('/\./', '', $tarik);
			if ($users->kas >= $f_tarik){
				$this->m_app->insert_transaksi("kas",1);
				//echo '<script>alert("New transactions successfully saved for moderation!");</script>';
				//$this->input_finance();
				echo "<script>alert('New transactions successfully saved for moderation!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			}else{
			//echo '<script>alert("Your Main Cash is insufficient!");</script>';
			//$this->input_finance();}
			echo "<script>alert('Your Main Cash is insufficient!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			}
		}
	}
  }
  
  function simpan_hutang(){
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		$this->form_validation->set_rules('modal_nominal', 'modal_nominal', 'required|trim');
		$this->form_validation->set_rules('modal_info_detail', 'modal_info_detail');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			//echo '<script>alert("Have an error Input!");</script>';
			//$this->input_finance();
			echo "<script>alert('Have an error Input!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
		} elseif ($this->input->post('modal_nominal')<>0) {
			//cek pending transaksi
			$cek	= $this->m_app->get_transaksi_username2($this->session->userdata('username'));
			//cek main cash > hutang
			$users 	= $this->m_app->get_user_username($this->session->userdata('username'));
			if (!empty($cek)){
				//echo '<script>alert("Please wait, you have a pending transactions");</script>';
				//$this->input_finance();
				echo "<script>alert('Please wait, you have a pending transactions!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			}else {
				if ($users->kas >= $users->hutang){
					$this->m_app->insert_transaksi("hutang",1);
					$detail_transaksi = $this->m_app->get_transaksi_username($this->session->userdata('username'), 1);
					$this->m_app->post_transaksi($detail_transaksi->Id);
					//echo '<script>alert("New transactions saved successfully!");</script>';
					//$this->input_finance();
					echo "<script>alert('New transactions saved successfully!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
				}else{
					//echo '<script>alert("insufficient main cash!");</script>';
					//$this->input_finance();
					echo "<script>alert('insufficient main cash!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
				}
			}
		}else{
			//echo '<script>alert("You dont have payable!");</script>';
			//$this->input_finance();
			echo "<script>alert('You dont have payable!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
		}
	}
  }
  
  function simpan_spending(){
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		$this->form_validation->set_rules('modal_nominal', 'modal_nominal', 'required|trim');
		$this->form_validation->set_rules('modal_info_detail', 'modal_info_detail');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		if($this->form_validation->run()==FALSE)
		{
			//echo '<script>alert("Have an error Input!");</script>';
			//$this->input_finance();
			echo "<script>alert('Have an error Input!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
		} else {
			$users	= $this->m_app->get_user_username($this->session->userdata('username'));
			$tarik 		= $this->input->post('modal_nominal');
			$f_tarik	= preg_replace('/\./', '', $tarik);
			if (($users->kas >= $f_tarik)AND($users->laba_bersih >= $f_tarik)){
				$this->m_app->insert_transaksi("kas",0);
				//echo '<script>alert("New transactions successfully saved for moderation!");</script>';
				//$this->input_finance();
				echo "<script>alert('New transactions successfully saved for moderation!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			}else{
			//echo '<script>alert("Your Main Cash is insufficient!");</script>';
			//$this->input_finance();
			echo "<script>alert('Your Main Cash is insufficient!');window.location.href = '" . base_url() . "app/input_finance/';</script>";
			}
		}
	}
  }
  
  public function simpan()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{ 
		//menyimpan data customer
		if($this->input->post('save_customer')){
			$this->form_validation->set_rules('customer_name', 'customer_name', 'required');
			$this->form_validation->set_rules('identity_number', 'identity_number', 'required|trim');
			$this->form_validation->set_rules('Address', 'Address', 'required');
			$this->form_validation->set_rules('gender', 'gender', 'required');
			$this->form_validation->set_rules('marital', 'marital', 'required');
			$this->form_validation->set_rules('date_pic', 'date_pic', 'required');
			$this->form_validation->set_rules('salary', 'salary', 'required|trim');
			$this->form_validation->set_rules('Dependents', 'Dependents', 'required|trim');
			$this->form_validation->set_rules('customer_info', 'customer_info');
			$this->form_validation->set_rules('pekerjaan', 'pekerjaan');
			
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			if($this->form_validation->run()==FALSE)
			{
				echo '<script>alert("Have an error Input!");</script>';
				$this->load->view('input_customer_view');
			} else {
				$customer_identity	= $this->input->post('identity_number');
				$query 				= $this->m_app->get_cust_id($customer_identity);
				if(!empty($query)){
					echo '<script>alert("Error! Customer Identity number existing");</script>';
					$this->load->view('input_customer_view');
				}else{
					$this->m_app->insert_customer();
					echo '<script>alert("new customers successfully saved!");</script>';
					$this->load->view('input_customer_view');
				}
			}
		}
		/**
		//menyimpan setoran modal/top up
		if($this->input->post('simpan_transaksi')){
			
		}
		//menyimpan penarikan tunai
		if($this->input->post('simpan_tarik')){
			
		}
		//menyimpan spending
		if($this->input->post('simpan_spending')){
			
		}
		//menyimpan transfer antar user
		if($this->input->post('transfer_user')){
			
		}
		//menyimpan pembayaran hutang
		if($this->input->post('simpan_hutang')){
			
		} **/
		//eksekusi transaksi oleh admin
		if($this->input->post('post_transaksi')){
			$this->form_validation->set_rules('id_post', 'id_post', 'required|trim');
			if($this->form_validation->run()==FALSE){
				echo '<script>alert("Have an error Post!");</script>';
				$this->pending_transaction();
			}else {
				//cek kecukupan kas
				$query = $this->m_app->get_transaksi_id($this->input->post('id_post'));
				if ($query->post=='kas'){
					$users = $this->m_app->get_user_username($query->username);
					if ($users->kas < $query->nominal){
						echo '<script>alert("insufficient main cash!");</script>';
						$this->pending_transaction();
					}else {
						$this->m_app->post_transaksi();
						echo '<script>alert("Successfully transacted!");</script>';
						$this->pending_transaction();
					}
				}else {
					$this->m_app->post_transaksi();
					echo '<script>alert("Successfully transacted!");</script>';
					$this->pending_transaction();
				}
			}
		}
		//menyimpan pembayaran angsuran
		if($this->input->post('bayar_angsuran')){
			//$this->form_validation->set_rules('payment', 'payment', 'required|trim');
			//if($this->form_validation->run()==FALSE){
				//echo '<script>alert("Have an error Post!");</script>';
				//$this->list_open();
			//}else {
				$project 	= $this->m_app->get_project_id($this->input->post('id_post'));
				$users_2	= $project->project_username;
				$username	= $this->session->userdata('username');
				
				$this->db->where('id_project', $this->input->post('id_post'));
				$this->db->from('angsuran_current');
				$cnt = $this->db->count_all_results();
				if ($users_2==$username){
					if ($cnt==0) {
						$this->m_app->post_angsuran();
						echo '<script>alert("Project Payment saved successfully!");</script>';
						$this->list_open();
					}else{
						echo '<script>alert("The project has been paid!");</script>';
						$this->list_open();
					}
				}else{
					echo '<script>alert("You are not authorize this project!");</script>';
					$this->list_open();
				}
		
			//}
		}
		//menyimpan pembayaran full payment
		if($this->input->post('bayar_angsuran_full')){
			$project 	= $this->m_app->get_project_id($this->input->post('id_postf'));
			$users_2	= $project->project_username;
			$username	= $this->session->userdata('username');
			
			$this->form_validation->set_rules('full_payment', 'full_payment', 'required|trim');
			if($this->form_validation->run()==FALSE){
				echo '<script>alert("Have an error Post!");</script>';
				$this->list_open();
			}else{
				if ($users_2==$username){
					$full_pay	= preg_replace('/\./', '', $this->input->post('full_payment'));
					//$project 	= $this->m_app->get_project_id($this->input->post('id_postf'));
					$sisa_hpp   = $project->project_modal - $project->project_hpp;
					if ($full_pay > $sisa_hpp){
						$this->m_app->post_angsuran_full();
						echo '<script>alert("Project Full Payment saved successfully!");</script>';
						$this->list_open();
					}else{
						echo '<script>alert("Amount of payment is not enough!");</script>';
						$this->list_open();
					}
				}else{
					echo '<script>alert("You are not authorize this project!");</script>';
					$this->list_open();
				}
				
			}
		}
		
		//mengambil proyek oleh investor
		if($this->input->post('get_project')){
			$this->form_validation->set_rules('id_post', 'id_post', 'required|trim');
			if($this->form_validation->run()==FALSE){
				echo '<script>alert("Have an error Grab!");</script>';
				$this->grab_project();
			}else {
				
				$id 	= $this->input->post('id_post');
				$query 	= $this->m_app->get_project_id($id);
				$users 	= $this->m_app->get_user_username($this->session->userdata('username'));
				$kas	= $users->kas;
				
				//cek status proyek
				if(($query->project_status==1) OR ($query->project_status==3)){
					//cek username 
					if($query->project_username==$this->session->userdata('username')){
						echo '<script>alert("Not allowed to take the same user project.!");</script>';
						$this->grab_project();
					}else{
						//cek kas
						if ($kas < ($query->project_modal-$query->project_hpp)){
							echo '<script>alert("Your cash is insufficient.!");</script>';
							$this->grab_project();
						}else {
							//memenuhi kriteria pengambilan project
							$this->m_app->grab_project($query->project_status);
							echo '<script>alert("Grab the project successfully!");</script>';
							$this->grab_project();
						}
					}
				}else{
					echo '<script>alert("The project cannot be processed.!");</script>';
					$this->grab_project();
				}	
			}
		}
	}
  }
  
  public function write_off()
  {
	if($this->session->userdata('isLogin') == FALSE)
	{redirect('login');}
	else{
		if ($this->session->userdata('level')==1){
			//if admin
			$id			= $this->input->post('id_post');
			$this->m_app->write_off($id);
		}else{
			//if not admin
			echo '<script>alert("user is not permitted to use this fitur!");</script>';
			$this->load->view('home_view');
		}
	}
  }

  
}
?>
<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_app extends CI_Model
{

	public function __construct()
  {
    parent::__construct();
  }
  
  public function __destruct()
	{
		$this->db->close();
	}

function memo_count_send($nip)
{
	$sql = "select Id FROM memo WHERE nip_dari LIKE '%$nip%'";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function memo_get_send($limit, $start, $nip)
{
	$sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,b.nama FROM memo a 
	LEFT JOIN users b ON a.nip_dari = b.nip
	WHERE nip_dari LIKE '%$nip%' ORDER BY tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}
	
function memo_count($nip)
{
	$sql = "select Id FROM memo WHERE nip_kpd LIKE '%$nip%'";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function memo_get_detail($id)
{
	$sql="SELECT * FROM memo WHERE (id = '$id')";
	$query = $this->db->query($sql);
	return $query->result();
}
function memo_get($limit, $start, $nip)
{
	$sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,b.nama FROM memo a 
	LEFT JOIN users b ON a.nip_dari = b.nip
	WHERE nip_kpd LIKE '%$nip%' ORDER BY tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}
function inbox_cari_count($st = NULL,$nip)
{
	if ($st == "NIL") $st = "";
	$sql = "select id FROM memo WHERE (judul LIKE '%$st%' AND nip_kpd LIKE '%$nip%')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function inbox_cari_pagination($limit, $start, $st = NULL,$nip)
{
	if ($st == "NIL") $st = "";
	$sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,b.nama
	FROM memo a LEFT JOIN users b ON a.nip_dari = b.nip
	WHERE (a.judul LIKE '%$st%' AND a.nip_kpd LIKE '%$nip%') ORDER BY a.tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function sendto($level_jabatan,$bagian)
{
	$sql="SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan') OR (level_jabatan = '$level_jabatan'+1)) AND (bagian = '$bagian') ORDER BY level_jabatan DESC";
	$query = $this->db->query($sql);
	return $query->result();
}
	
function cari_gaji($nip)
{
	$bulan = $this->input->post('date_pic');
	$sql="SELECT * FROM gaji WHERE (nip = '$nip') AND (DATE_FORMAT(bulan_gaji, '%Y-%m') = '$bulan')";
	$query = $this->db->query($sql);
	return $query->result();
	
	/* $this->db->select('*');
	$this->db->from('gaji');
	$this->db->where('nip', $nip);
	$query = $this->db->get();
	return $query->row(); */
}	
function slip_gaji($id)
{
	$bulan	= $this->input->post('date_pic');
	$nip 	= $this->session->userdata('nip');
	//$sql="SELECT * FROM gaji WHERE (nip = '$nip') AND (DATE_FORMAT(bulan_gaji, '%Y-%m') = '$bulan')";
	$sql="SELECT * FROM gaji WHERE Id=$id AND nip='$nip';";
	$query = $this->db->query($sql);
	return $query->row();
	
	/* $this->db->select('*');
	$this->db->from('gaji');
	$this->db->where('nip', $nip);
	$query = $this->db->get();
	return $query->row(); */
}
function get_agent_id($id){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('agent');
    $this->db->where('Id', $id);
    $query = $this->db->get();
    return $query->row();
}
function get_user_username($username){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('users');
    $this->db->where('username', $username);
    $query = $this->db->get();
    return $query->row();
}
function list_antrian_count($tgl_antrian,$st = NULL)
{
	if ($st == "NIL") $st = "";
	//$sql="SELECT * FROM antrian WHERE (date_pic = '$tgl_antrian' AND status = 1)";
	$sql="SELECT * FROM antrian WHERE (date_pic >= '$tgl_antrian')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function list_antrian_pagination($limit, $start, $st = NULL)
{
	$utility = $this->m_app->get_utility();	
	$tgl_antrian = $utility->tgl_antrian; 
	if ($st == "NIL") $st = "";
	//$sql="SELECT * FROM antrian WHERE (date_pic = '$tgl_antrian' AND status = 1) ORDER BY jam_terpilih ASC, nomor_antrian ASC limit " . $start . ", " . $limit;
	$sql="SELECT * FROM antrian WHERE (date_pic >= '$tgl_antrian') ORDER BY status ASC, jam_terpilih ASC  limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}	
function get_antrian_smu_id($id){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('antrian_smu');
    $this->db->where('nomor_smu', $id);
    $query = $this->db->get();
    return $query->row();
}
function update_antrian_id($status,$id,$remark,$jam = NULL, $jam_old = NULL){
	if (empty($jam)){
		$sql = "UPDATE antrian SET status = $status, remark = '$remark' WHERE Id=$id";
		$query = $this->db->query($sql);
		//update 0 jadwal_slot20
		$sql = "SELECT jam_terpilih FROM antrian WHERE Id=$id";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['jam_terpilih'];
		
		$data_update1	= array(
			'status'	=> 0
		);
		$this->db->where('status', 1);
		$this->db->where('name', $result);
		$this->db->limit(1, 1);
		$this->db->update('jadwal_slot20', $data_update1);
	}else{
		$sql = "UPDATE antrian SET status = $status, remark = '$remark', jam_terpilih = '$jam' WHERE Id=$id";
		$query = $this->db->query($sql);
		
		//update 1 jadwal_slot20
		$data_update2	= array(
			'status'	=> 1
		);
		$this->db->where('status', 0);
		$this->db->where('name', $jam);
		$this->db->limit(1, 1);
		$this->db->update('jadwal_slot20', $data_update2);
		
		//update 0 jadwal_slot20
		$data_update1	= array(
			'status'	=> 0
		);
		$this->db->where('status', 1);
		$this->db->where('name', $jam_old);
		$this->db->limit(1, 1);
		$this->db->update('jadwal_slot20', $data_update1);
	}
}
function delete_smu_id($id){
	$sql = "delete FROM antrian_smu WHERE Id = $id";
	$query = $this->db->query($sql);
}
function get_antrian_smu_nomor_antrian($id){
	$sql = "select * FROM antrian_smu WHERE id_antrian = $id";
	$query = $this->db->query($sql);
	return $query->result();
}
function insert_smu($no_antrian){
		$nomor_smu	= $this->input->post('nomor_smu');
		$info		= $this->input->post('info');
		$data_insert = array (
			'nomor_antrian' 	=> $no_antrian,
			'id_antrian'		=> $this->uri->segment(3),
			'nomor_smu'			=> $nomor_smu,
			'status'			=> 0,
			'info'				=> $info
			);
		$this->db->insert('antrian_smu',$data_insert);
}
function quotation_count($st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM quotation p
	WHERE (p.Id LIKE '%$st%')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}
function list_quotation($limit, $start, $st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM quotation p
	WHERE (p.Id LIKE '%$st%') ORDER BY p.Id DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function ambil_tujuan()
{
	$sql = "select * FROM rate";
	$query = $this->db->query($sql);
	return $query->result();
}
	
function ambil_jadwal($tanggal,$time_flight,$tgl_flight){
	date_default_timezone_set('Asia/Jakarta');
	$now 		= date('Y-m-d');
	$time		= date('H:i');
	$time1		= date('H:i',strtotime($time_flight . "-8 hours"));
	$time2		= date('H:i',strtotime($time_flight));
	$date_flight = date('Y-m-d',strtotime($tgl_flight));
	//if ($time1<$time){$time2=$time;}
	//else{$time2=$time1;}
	//if ($tanggal==$now){	
		if (($date_flight <> $tanggal) AND ($time2 >= '08:00')){
			$data = [
				'0'=>['Id'=>1,'name'=>'Void Time'],
			];
			$hasil_query[] = $data;
			return $hasil_query;
		}else{
		
			$this->db->select('*');
			$this->db->where('status',0);
			//$this->db->where('name > ', $time2);
			if ($tanggal==$now){
				$this->db->where('name > ', $time1);
			}else{
				if(($time2 >= '08:00')){
					$this->db->where('name > ', $time1);
					$this->db->where('name < ', $time2);
				}else{
					$this->db->where('name < ', $time2);
				}
			}
			$this->db->group_by('name'); 
			$this->db->order_by('name', 'asc'); 
			$query = $this->db->get('jadwal_slot20');
			if ($query->num_rows() > 0 ){
			foreach ($query->result() as $data){
			$hasil_query[] = $data;
			}
			return $hasil_query;
			}   
		}
	/**}else{
		$sql1 = "select a.Id,a.slot,a.name from jadwal_slot20 a LEFT JOIN antrian_book b ON a.name = b.name AND a.slot = b.slot WHERE ((b.name IS NULL) AND (b.tanggal = $tanggal OR b.tanggal IS NULL)) GROUP BY a.name";
		$sql2 = "select a.Id,a.slot,a.name from jadwal_slot20 a LEFT JOIN antrian_book b ON a.name = b.name AND a.slot = b.slot WHERE b.name IS NULL AND a.name > '$time1' GROUP BY a.name";
		$query = $this->db->query($sql2);
		return $query->result();
	}**/
}
  
function simpan_antrian(){
	date_default_timezone_set('Asia/Jakarta');
	$now 		= date('Y-m-d H:i:s');
	$tgl_antrian	= $this->input->post('date_pic');
	$this->db->select_max('nomor_antrian');
    $this->db->where('date_pic', $tgl_antrian);
    $res1 = $this->db->get('antrian');
	if ($res1->num_rows() > 0)
    {
        $res2 = $res1->result_array();
        $result = $res2[0]['nomor_antrian']+1;
	}else{$result = 1;}
	
	$data_insert 	= array (
		'username'		=> $this->session->userdata('username'),
		'nomor_mobil'	=> $this->input->post('nomor_mobil'),
		'nomor_segel'	=> $this->input->post('nomor_segel'),
		'csd'			=> $this->input->post('nomor_csd'),
		'nama_driver'	=> $this->input->post('nama_driver'),
		'phone'			=> $this->input->post('phone'),
		'date_flight'	=> $this->input->post('date_flight'),
		//'tujuan'		=> $this->input->post('tujuan'),
		'date_pic'		=> $this->input->post('date_pic'),
		'informasi'		=> $this->input->post('informasi'),
		'jam_terpilih'	=> $this->input->post('jam_terpilih'),
		'date_input'	=> date('Y-m-d H:i:s'),
		'status'		=> 0,
		'nomor_antrian'	=> $result
		);
	$this->db->insert('antrian',$data_insert);
	
	//update tabel jadwal_slot20
	$dnow 		= date('Y-m-d');
	//if ($this->input->post('date_pic')==$dnow){   //aktifkan ini jika kembali model lama
		$this->db->select('*');
		$this->db->where('name', $this->input->post('jam_terpilih'));
		$this->db->where('status', 0);
		$res2 = $this->db->get('jadwal_slot20');
		if ($res2->num_rows() <= 8){
			$this->db->select_min('slot');
			$this->db->where('name', $this->input->post('jam_terpilih'));
			$this->db->where('status', 0);
			$res1 	= $this->db->get('jadwal_slot20');
			$res2 	= $res1->result_array();
			$result = $res2[0]['slot'];
			$stat 	= $result; 
		}
			
		$data_update 	= array (
			'status' 	=> 1
			);
		$this->db->where('name',$this->input->post('jam_terpilih'));
		$this->db->where('slot',$stat);
		$this->db->update('jadwal_slot20',$data_update);
	/**}else{
		$this->db->select('*');
		$this->db->where('name', $this->input->post('jam_terpilih'));
		$this->db->where('tanggal', $this->input->post('date_pic'));
		$res2 = $this->db->get('antrian_book');
		if ($res2->num_rows() == 0){$stat = 1;}
		elseif($res2->num_rows() == 1){$stat = 2;}
		elseif($res2->num_rows() == 2){$stat = 3;}
		elseif($res2->num_rows() == 3){$stat = 4;}
		elseif($res2->num_rows() == 4){$stat = 5;}
		elseif($res2->num_rows() == 5){$stat = 6;}
		elseif($res2->num_rows() == 6){$stat = 7;}
		elseif($res2->num_rows() == 7){$stat = 8;}
		
		$data_ins 	= array (
			'slot' 		 => $stat,
			'name' 		 => $this->input->post('jam_terpilih'),
			'tanggal'	 => $this->input->post('date_pic'),
			'input_date' => date('Y-m-d H:i:s'),
			'input_user' => $this->session->userdata('username')
			);
		$this->db->insert('antrian_book',$data_ins);
	}**/ //aktifkan ini jika kembali model lama
}
function get_utility(){
	$this->db->select('*');
	$this->db->from('utility');
	$query = $this->db->get();
	return $query->row();
}
function get_antrian($id){
	$this->db->select('*');
	$this->db->from('antrian');
	$this->db->where('Id', $id);
	$query = $this->db->get();
	return $query->row();
}
function get_antrian_user($username){
	date_default_timezone_set('Asia/Jakarta');
	$now 		= date('Y-m-d');
	$first_date = date('Y-m-d', strtotime($now. ' - 1 days'));
	$this->db->select('*');
	$this->db->from('antrian');
	$this->db->where('username', $username);
	$this->db->where('date_pic >=',$first_date); 
	//$this->db->where('date_pic', $now);
	$query = $this->db->get();
	if ($query->num_rows() > 0 ){
	foreach ($query->result() as $data){
	$hasil_query[] = $data;
	}
	return $hasil_query;
	}

}
function get_antrian_status($status, $tgl = NULL){
	//$tgl_antrian	= date("Y/m/d");
	if (empty($tgl)){
		$this->db->select('Id');
		$this->db->where('status', $status);
		$query = $this->db->get('antrian');
		return $query->num_rows();
	}else{
		$this->db->select('Id');
		$this->db->where('status', $status);
		$this->db->where('date_pic', $tgl);
		$query = $this->db->get('antrian');
		return $query->num_rows();
	}
}
function sisa_antrian($tgl_antrian){
	//$tgl_antrian	= date("Y/m/d");
	$this->db->select('Id');
	$this->db->where('date_pic', $tgl_antrian);
	$this->db->where('status', 2);
	$query = $this->db->get('antrian');
	return $query->num_rows();
}
function antrian_besok($tgl_besok){
	//$tgl_besok 		= date("Y-m-d"); //date H+1
	$this->db->select('Id');
	$this->db->where('date_pic', date('Y-m-d', strtotime($tgl_besok. ' + 1 days')));
	$query = $this->db->get('antrian');
	return $query->num_rows();
}
function slot($tgl_antrian, $slot, $nom_antrian=NULL){
	date_default_timezone_set('Asia/Jakarta');
	$this->db->select('current_antrian');
    $current_antrian = $this->db->get('utility');
	$res2 = $current_antrian->result_array();
    $result = $res2[0]['current_antrian']+1;
	
	if ($nom_antrian==""){
		//$this->db->select('Id');
		//$this->db->where('date_pic', $tgl_antrian);
		//$this->db->where('nomor_antrian', $result);
		//$res = $this->db->get('antrian');
		
		$sql="SELECT Id,nomor_antrian,nomor_mobil FROM antrian WHERE (date_pic = '$tgl_antrian' AND status = 2) ORDER BY jam_terpilih ASC, nomor_antrian ASC LIMIT 1";
		$query = $this->db->query($sql);
		
		$res3 = $query->result_array();
		$id_antrian = $res3[0]['Id'];
		$nomor_antrian = $res3[0]['nomor_antrian'];
		$nopol = $res3[0]['nomor_mobil'];
		//update utility
		$data_update 	= array (
			'slot'.$slot		=> $nomor_antrian,
			'slot'.$slot.'_id'	=> $id_antrian,
			'nopol'.$slot		=> $nopol,
			'current_antrian' 	=> $nomor_antrian
			);
		$this->db->update('utility',$data_update);
		
		//update antrian
		$data_update1	= array(
			'status'	=> 3,
			'slot'		=> $slot,
			'start_time'=> date("H:i:s") 
		);
		$this->db->where('date_pic', $tgl_antrian);
		$this->db->where('Id', $id_antrian);
		$this->db->where('status', 2);
		$this->db->update('antrian', $data_update1);
	}else{
		$this->db->select('Id,nomor_mobil');
		$this->db->where('date_pic', $tgl_antrian);
		$this->db->where('nomor_antrian', $nom_antrian);
		$res = $this->db->get('antrian');
		$res3 = $res->result_array();
		$id_antrian = $res3[0]['Id'];
		$nopol = $res3[0]['nomor_mobil'];
		//update utility
		$data_update 	= array (
			'slot'.$slot		=> $nom_antrian,
			'slot'.$slot.'_id'	=> $id_antrian,
			'nopol'.$slot		=> $nopol
			);
		$this->db->update('utility',$data_update);
		
		//update antrian
		$data_update1	= array(
			'status'	=> 3,
			'slot'		=> $slot,
			'start_time'=> date("H:i:s") 
		);
		$this->db->where('date_pic', $tgl_antrian);
		$this->db->where('nomor_antrian', $nom_antrian);
		$this->db->update('antrian', $data_update1);
	}
	
}
function slot_e($id, $slot){
	//update tabel antrian
	date_default_timezone_set('Asia/Jakarta');
	$data_update1	= array(
		'status'		=> 4,
		'remark'		=> $this->input->post('remark'),
		'finish_time'	=> date("H:i:s") 
	);
	$this->db->where('Id', $id);
	$this->db->update('antrian', $data_update1);
	$antrian = $this->get_antrian($id);
	//update utility
	$data_update 	= array (
		'slot'.$slot		=> 0,
		'slot'.$slot.'_id'	=> 0,
		'nopol'.$slot		=> 0
		);
	$this->db->update('utility',$data_update);
	//update jadwal slot
	$data_update2	= array(
		'status'	=> 0
	);
	$this->db->where('status', 1);
	$this->db->where('name', $antrian->jam_terpilih);
	$this->db->limit(1, 1);
	$this->db->update('jadwal_slot20', $data_update2);
}
function set_date($tanggal){
	//update utility
	$data_update 	= array (
		'tgl_antrian'		=> $tanggal,
		'current_antrian'	=> 0
		);
	$this->db->update('utility',$data_update);
	
	//update tabel antrian
	$sql1 = "UPDATE jadwal_slot20 SET status = 0;";
	$sql2 = "UPDATE jadwal_slot20 LEFT JOIN antrian_book ON (jadwal_slot20.slot = antrian_book.slot AND jadwal_slot20.name = antrian_book.name) SET jadwal_slot20.status = 1 WHERE antrian_book.name IS NOT NULL;;";
	$this->db->query($sql1);
	$this->db->query($sql2);
	
	//update delete antrian_book
	$this->db->empty_table('antrian_book'); 
}






//reference script

function insert_transaksi($post,$status){
	date_default_timezone_set('Asia/Jakarta');
	$nominal = $this->input->post('modal_nominal');

	$now 			= date('Y-m-d H:i:s');
	$nominal		= preg_replace('/\./', '', $nominal);
	$keterangan		= $this->input->post('modal_info_detail');
	if ($status==2){
		$username = $this->input->post('user_destination');
		$post = 'transfer <- '.$this->session->userdata('username');
	}else{$username = $this->session->userdata('username');}
	$dc				= '(+)';
	if ($post == 'kas'){$dc = '(-)';}
	if ($post == 'hutang'){$dc = '(-)';}
	$data_insert 	= array (
			'tanggal'		=> $now,
			'keterangan' 	=> $keterangan,
			'nominal' 		=> $nominal,
			'status' 		=> $status,
			'username' 		=> $username,
			'dc'			=> $dc,
			'post' 			=> $post
			);
		$this->db->insert('detail_transaksi',$data_insert);
}

function get_hutang_username($username, $status){
	$this->db->select('*');
	$this->db->where('user_jual',$username);
	$this->db->where('status',$status);
	$query = $this->db->get('detail_hutang');
	if ($query->num_rows() > 0 ){
	foreach ($query->result() as $data){
    $hasil_query[] = $data;
	}
	return $hasil_query;
	}
}

function ambil_data_agent($kd_agent){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('agent');
    $this->db->where('Id', $kd_agent);
    $query = $this->db->get();
    return $query->row();
}

function get_transaksi_username($username, $status){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('detail_transaksi');
    $this->db->where('username', $username);
	$this->db->where('status', $status);
    $query = $this->db->get();
    return $query->row();
}

function get_transaksi_username2($username){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('detail_transaksi');
    $this->db->where('username', $username);
	$this->db->where('status', 1);
	$this->db->or_where('status', 0);
    $query = $this->db->get();
    return $query->row();
}

function get_transaksi_id($id){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('detail_transaksi');
    $this->db->where('Id', $id);
    $query = $this->db->get();
    return $query->row();
}

function get_project_id($id){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('project');
    $this->db->where('Id', $id);
    $query = $this->db->get();
    return $query->row();
}

function get_cust_id($id){
	//get transaksi to post
	$this->db->select('*');
    $this->db->from('customer');
    $this->db->where('customer_identity', $id);
    $query = $this->db->get();
    return $query->row();
}

function post_angsuran_full(){
	date_default_timezone_set('Asia/Jakarta');
	$id 		= $this->input->post('id_postf');
	$payment 	= $this->input->post('full_payment');
	$pay		= preg_replace('/\./', '', $payment);

	$project 	= $this->get_project_id($id);
	$users 		= $this->get_user_username($project->project_investor_username);
	$users_2	= $this->get_user_username($project->project_username);
	$users_pm	= $this->get_user_username('pm');

	//$pay		= $project->project_angsuran;
	$now 		= date('Y-m-d');
	$kas		= $users->kas+$pay;
	$username	= $users->username;
	$username_2	= $users_2->username;
	$sisahpp	= $project->project_modal - $project->project_hpp;
	$laba		= $pay - ($sisahpp);
	$fee		= 0;

	//insert table angsuran
	$data_update1 	= array (
		'id_project'	=> $id,
		'angs_ke'		=> $project->project_angs_ke+1,
		'nominal'		=> round($pay),
		'tgl_angs'		=> $now
	);
	$this->db->insert('angsuran', $data_update1);

	//update Users jual
	$data_update5 	= array (
		'hutang'	=> round($users_2->hutang + ($pay - ($laba*$users_2->with_fee))),
		//'kas'		=> round($users_2->kas + ($laba*$users_2->with_fee)),
		//'piutang_pihak_lain' => $users_2->piutang_pihak_lain + $pay
		'modal' 	=> round($users_2->modal - $pay + ($laba*$users_2->with_fee))
		);
	$this->db->where('username', $username_2);
	$this->db->update('users', $data_update5);

	//update Users investor
	/*$data_update2 	= array (
			'hutang' 			=> $users->hutang - $pay,
			'piutang_penjualan'	=> $users->piutang_penjualan - $sisahpp,
			'pendapatan'		=> $users->pendapatan + ($laba*(1-$users_2->with_fee)),
			'laba_bersih'		=> $users->laba_bersih + ($laba*(1-$users_2->with_fee))
			);
	$this->db->where('username', $username);
	$this->db->update('users', $data_update2);*/
	
	if ($users_2->with_fee==0){
		$fee = 0.10;
	}else{
		$fee = 0.05;
	}
	
	//update fee Users investor
	$data_update2 	= array (
	'hutang' => round($users->hutang - (($pay - ($laba*$users_2->with_fee))-(($laba*(1-$users_2->with_fee))*$fee))),
	'piutang_penjualan'	=> round($users->piutang_penjualan - $sisahpp),
	'pendapatan' => round($users->pendapatan + ($laba*(1-($users_2->with_fee)))-(($laba*(1-$users_2->with_fee))*$fee)),
	'laba_bersih'=> round($users->laba_bersih + ($laba*(1-($users_2->with_fee)))-(($laba*(1-$users_2->with_fee))*$fee))
			);
	$this->db->where('username', $username);
	$this->db->update('users', $data_update2);

	//update users invenstor
	/**$data_update2 	= array (
	'hutang' => round($users->hutang - ($pay - ($laba*$users_2->with_fee))),
	'piutang_penjualan'	=> round($users->piutang_penjualan - $sisahpp),
	'pendapatan' => round($users->pendapatan + ($laba*(1-$users_2->with_fee))),
	'laba_bersih'=> round($users->laba_bersih + ($laba*(1-$users_2->with_fee)))
			);
	$this->db->where('username', $username);
	$this->db->update('users', $data_update2);**/
	
	//update fee management
	$data_fee = array(
		'hutang' 		=> round($users_pm->hutang - (($laba*(1-$users_2->with_fee))*$fee)),
		'pendapatan'	=> round($users_pm->pendapatan + (($laba*(1-$users_2->with_fee))*$fee)),
		'laba_bersih'	=> round($users_pm->laba_bersih + (($laba*(1-$users_2->with_fee))*$fee))
	);
	$this->db->where('username', 'pm');
	$this->db->update('users', $data_fee);

	//update project
	//cek kualitas kredit
	if ($project->coll >=2){
		$coll = $project->coll - 1;
	}else {
		$coll = $project->coll;
	}
	$data_update3 	= array (
			'project_angs_ke' 		=> $project->project_angs_ke+1,
			'project_ttl_agsuran'	=> round($project->project_ttl_agsuran + $pay),
			'project_laba_cur'		=> round($project->project_laba_cur + $laba),
			'project_hpp'			=> round($project->project_modal),
			'project_tgl_akhir'		=> $now,
			'coll'					=> 1,
			'project_status'		=> 9
			);
	$this->db->where('Id', $id);
	$this->db->update('project', $data_update3);

	//insert angsuran current
	if ($project->coll == 1) {
		$data_update4 	= array (
			'id_project'	=> $id,
			'tanggal'		=> $now
			);
		$this->db->insert('angsuran_current', $data_update4);
	}

	//insert hutang penjual ke investor
	$data_update4 	= array (
			'id_project'	=> $id,
			'tanggal'		=> $now,
			//'nominal'		=> round(($pay - ($laba*$users_2->with_fee))),
			'nominal'		=> round(($pay - ($laba*$users_2->with_fee))-(($laba*(1-$users_2->with_fee))*$fee)),
			'user_investor'	=> $username,
			'user_jual'		=> $username_2,
			'keterangan'	=> 'pelunasan angsuran',
			'status'		=> 0
			);
	$this->db->insert('detail_hutang', $data_update4);
	//insert hutang ke PM
	$data_update4 	= array (
			'id_project'	=> $id,
			'tanggal'		=> $now,
			'nominal'		=> round(($laba*(1-$users_2->with_fee))*$fee),
			'user_investor'	=> 'pm',
			'user_jual'		=> $username_2,
			'keterangan'	=> 'Fee Management',
			'status'		=> 0
			);
	$this->db->insert('detail_hutang', $data_update4);
}

function post_angsuran(){
	date_default_timezone_set('Asia/Jakarta');
	$id 		= $this->input->post('id_post');
	//$payment 	= $this->input->post('payment');
	//$pay		= preg_replace('/\./', '', $payment);

	$project 	= $this->get_project_id($id);
	$users 		= $this->get_user_username($project->project_investor_username);
	$users_2	= $this->get_user_username($project->project_username);
	$users_pm	= $this->get_user_username('pm');

	$pay		= $project->project_angsuran;
	$now 		= date('Y-m-d');
	$kas		= $users->kas+$pay;
	$username	= $users->username;
	$username_2	= $users_2->username;
	$hpp		= $project->project_modal/$project->project_jmlangsuran;
	$laba		= $pay - ($project->project_modal/$project->project_jmlangsuran);
	$fee		=0;

	//insert table angsuran
	$data_update1 	= array (
		'id_project'	=> $id,
		'angs_ke'		=> $project->project_angs_ke+1,
		'nominal'		=> round($pay),
		'tgl_angs'		=> $now
	);
	$this->db->insert('angsuran', $data_update1);

	//update Users jual
	$data_update5 	= array (
		'hutang'	=> round($users_2->hutang + ($pay - ($laba*$users_2->with_fee))),
		//'kas'		=> $users_2->kas + ($laba*$users_2->with_fee),
		//'piutang_pihak_lain' => $users_2->piutang_pihak_lain + $pay
		'modal'	 	=> round($users_2->modal - $pay + ($laba*$users_2->with_fee))
		);
	$this->db->where('username', $username_2);
	$this->db->update('users', $data_update5);

	if ($users_2->with_fee==0){
		$fee = 0.10;
	}else{
		$fee = 0.05;
	}
	
	//update fee Users investor         
	$data_update2 	= array (              
	//'hutang' => round($users->hutang - (($pay - ($laba*$users_2->with_fee))+(($laba*(1-$users_2->with_fee))*$fee))),
	'hutang' 		=> round($users->hutang - ($pay-(($laba*($users_2->with_fee))+(($laba*(1-$users_2->with_fee))*$fee)))),
	'piutang_penjualan'	=> round($users->piutang_penjualan - $hpp),
	'pendapatan' 	=> round($users->pendapatan + ($laba*(1-($users_2->with_fee)))-(($laba*(1-$users_2->with_fee))*$fee)),
	'laba_bersih'	=> round($users->laba_bersih + ($laba*(1-($users_2->with_fee)))-(($laba*(1-$users_2->with_fee))*$fee))
			);
	$this->db->where('username', $username);
	$this->db->update('users', $data_update2);
	
	//update fee management
	$data_fee = array(
		'hutang' 		=> round($users_pm->hutang - (($laba*(1-$users_2->with_fee))*$fee)),
		'pendapatan'	=> round($users_pm->pendapatan + (($laba*(1-$users_2->with_fee))*$fee)),
		'laba_bersih'	=> round($users_pm->laba_bersih + (($laba*(1-$users_2->with_fee))*$fee))
	);
	$this->db->where('username', 'pm');
	$this->db->update('users', $data_fee);

	//update project
	//cek kualitas kredit
	if ($project->coll >=2){
		$coll = $project->coll - 1;
	}else {
		$coll = $project->coll;
	}
	$data_update3 	= array (
			'project_angs_ke' 		=> $project->project_angs_ke+1,
			'project_ttl_agsuran'	=> round($project->project_ttl_agsuran + $pay),
			'project_laba_cur'		=> round($project->project_laba_cur + $laba),
			'project_hpp'			=> round($project->project_hpp + $hpp),
			'coll'					=> $coll,
			'project_tgl_akhir'		=> $now
			);
	$this->db->where('Id', $id);
	$this->db->update('project', $data_update3);

	//insert angsuran current
	if ($project->coll == 1) {
		$data_update4 	= array (
			'id_project'	=> $id,
			'tanggal'		=> $now
			);
		$this->db->insert('angsuran_current', $data_update4);
	}

	//insert detail_hutang penjual ke investor
	$data_update4 	= array (
			'id_project'	=> $id,
			'tanggal'		=> $now,
			//'nominal'		=> round($pay - ($laba*$users_2->with_fee)),
			'nominal'		=> round($pay-(($laba*($users_2->with_fee))+(($laba*(1-$users_2->with_fee))*$fee))),
			//'nominal'		=> round(($pay - ($laba*$users_2->with_fee))-(($laba*(1-$users_2->with_fee))*0.05)),
			'user_investor'	=> $username,
			'user_jual'		=> $username_2,
			'keterangan'	=> 'pembayaran angsuran',
			'status'		=> 0
			);
	$this->db->insert('detail_hutang', $data_update4);
	//insert detail_hutang ke PM
	$data_update4 	= array (
			'id_project'	=> $id,
			'tanggal'		=> $now,
			'nominal'		=> round(($laba*(1-$users_2->with_fee))*$fee),
			//'nominal'		=> round(($laba*(1-$users_2->with_fee))*0.05),
			'user_investor'	=> 'pm',
			'user_jual'		=> $username_2,
			'keterangan'	=> 'Fee Management',
			'status'		=> 0
			);
	$this->db->insert('detail_hutang', $data_update4);
	
}

function post_transaksi_transfer($id, $user_dest){
	date_default_timezone_set('Asia/Jakarta');
	$now 		= date('Y-m-d H:i:s');
	$query  = $this->get_transaksi_id($id);
	$user1 = $this->get_user_username($query->username);
	$user2 = $this->get_user_username($this->input->post('user_destination'));
	//update user1
	if ($user1->laba_bersih < $query->nominal){
		$data_update1 	= array (
			//'pengeluaran' => $users->pengeluaran + $nominal,
			'laba_bersih' 	=> 0,
			'kas' 			=> $user1->kas - $query->nominal,
			'modal'		  	=> $user1->modal - ($query->nominal - $user1->laba_bersih)
		);
	}else {
		$data_update1 	= array (
			//'pengeluaran' => $users->pengeluaran + $nominal,
			'kas' 			=> $user1->kas - $query->nominal,
			'laba_bersih' 	=> $user1->laba_bersih - $query->nominal
		);
	}
	$this->db->where('username', $query->username);
	$this->db->update('users', $data_update1);

	//update user2
	$data_update2 	= array (
		'kas' 	=> $user2->kas + $query->nominal,
		'modal' => $user2->modal + $query->nominal
	);
	$this->db->where('username', $this->input->post('user_destination'));
	$this->db->update('users', $data_update2);
	
	//update detail transaksi
	$data_update3 	= array (
		'status' 	=> 2,
		'dc'		=> '(-)'
	);
	$this->db->where('Id', $id);
	$this->db->update('detail_transaksi', $data_update3);
	
	//detail traksaksi
	/*$data_insert 	= array (
		'tanggal'		=> $now,
		'keterangan' 	=> 'Transfer ke '+$user_dest,
		'nominal' 		=> $query->nominal,
		'status' 		=> 2,
		'username' 		=> $query->username,
		'dc'			=> '(-)',
		'post' 			=> 'Pindah Buku'
		);*/
	//$this->db->insert('detail_transaksi',$data_insert);
}

function post_transaksi($id=NULL){
	date_default_timezone_set('Asia/Jakarta');
	if ($id == "") {$id = $this->input->post('id_post');}

	$query = $this->get_transaksi_id($id);
	$users = $this->get_user_username($query->username);

	$now 		= date('Y-m-d H:i:s');
	$post		= $query->post;
	$modal		= $query->nominal + $users->$post;
	$kas		= $users->kas+$query->nominal;
	$username	= $query->username;

	//transaksi modal
	if ($post=='modal'){
		$data_update1 	= array (
			'kas' => $kas,
			$post => $modal
		);
		$this->db->where('username', $username);
		$this->db->update('users', $data_update1);
	}

	//transaksi kas
	if ($post=='kas'){
		if ($users->laba_bersih < $query->nominal){
			$data_update1 	= array (
				//'pengeluaran' => $users->pengeluaran + $nominal,
				'laba_bersih' 	=> 0,
				'kas' 			=> $users->kas - $query->nominal,
				'modal'		  	=> $users->modal - ($query->nominal - $users->laba_bersih)
			);
		}else {
			if ($query->status == 0){
				$data_update1 	= array (
					//'pengeluaran' => $users->pengeluaran + $nominal,
					'pengeluaran' 	=> $users->pengeluaran + $query->nominal,
					'kas' 			=> $users->kas - $query->nominal,
					'laba_bersih' 	=> $users->laba_bersih - $query->nominal
				);
			}else{
				$data_update1 	= array (
					//'pengeluaran' => $users->pengeluaran + $nominal,
					'kas' 			=> $users->kas - $query->nominal,
					'laba_bersih' 	=> $users->laba_bersih - $query->nominal
				);
			}
		}
		$this->db->where('username', $username);
		$this->db->update('users', $data_update1);
	}

	//transaksi hutang
	if ($post=='hutang'){
		$detail_hutang = $this->get_hutang_username($query->username, 0);
		//pembukuan hutang pada user investor (multipost)
		foreach( $detail_hutang as $value ) {
			$users_inv = $this->get_user_username($value->user_investor);
			$users_j = $this->get_user_username($value->user_jual);
			$data_update_v 	= array (
				'kas' 		=> $users_inv->kas + $value->nominal,
				'hutang'	=> $users_inv->hutang + $value->nominal
			);
			$this->db->where('username', $value->user_investor);
			$this->db->update('users', $data_update_v);
			//update detail hutang status
			$data_update_v1 	= array (
				'status' 	=> 1,
			);
			$this->db->where('Id', $value->Id);
			$this->db->update('detail_hutang', $data_update_v1);

			//pembukuan hutang pada user penjual
			$data_update1 	= array (
				//'kas' 		=> $users->kas - $query->nominal,
				'kas' 		=> $users_j->kas - $value->nominal,
				//'hutang'	=> $users->hutang - $query->nominal
				'hutang'	=> $users_j->hutang - $value->nominal
			);
			$this->db->where('username', $value->user_jual);
			$this->db->update('users', $data_update1);
         }
	}

	//update detail transaksi
	$data_update2 	= array (
			'status' 	=> 2
			);
	$this->db->where('Id', $id);
	$this->db->update('detail_transaksi', $data_update2);

}

function grab_project($project_status){
	date_default_timezone_set('Asia/Jakarta');
	$id 		= $this->input->post('id_post');
	$username	= $this->session->userdata('username');
	$query 		= $this->get_project_id($id);
	$users 		= $this->get_user_username($username);
	$users_jual = $this->get_user_username($query->project_username);
	$users_resale = $this->get_user_username($query->project_investor_username);

	$kas				= $users->kas-$query->project_modal;
	//$kas_jual			= $users_jual->kas+$query->project_modal;
	//$modal_jual		= $users_jual->modal+$query->project_modal;
	$piutang_penjualan	= $users->piutang_penjualan+($query->project_modal-$query->project_hpp);

	$now 		= date('Y-m-d H:i:s');

	//update project
	if ($project_status==1){
		//update project status 1
		$data_update1 	= array (
			'project_status' 			=> 2,
			'project_investor_username'	=> $username
		);
		$this->db->where('Id', $id);
		$this->db->update('project', $data_update1);
		//update financials user invest
		$data_update2 	= array (
			'kas'					=> $kas,
			'piutang_penjualan'		=> $piutang_penjualan
		);
		$this->db->where('username', $username);
		$this->db->update('users', $data_update2);
		//update financials user jual
		$data_update4 	= array (
			'modal' 	=> $users_jual->modal + $query->project_modal,
			'kas'		=> $users_jual->kas + $query->project_modal
		);
		$this->db->where('username', $query->project_username);
		$this->db->update('users', $data_update4);
		//update detail transaksi
		$data_update3 	= array (
				'tanggal' 		=> $now,
				'keterangan'	=> 'Grab Project',
				'nominal'		=> $query->project_modal,
				'status'		=> 2,
				'username'		=> $username,
				'dc'			=> '(-)',
				'post'			=> 'Kas -> Piutang Penjualan'
				);
		$this->db->insert('detail_transaksi', $data_update3);
		//add angsuran current
		$data_update 	= array (
				'id_project' 	=> $id
				);
		$this->db->insert('angsuran_current', $data_update);
	}

	if ($project_status==3){
		//update financials user invest by session
		$data_update2 	= array (
			'kas'					=> $users->kas-($query->project_modal-$query->project_hpp),
			'piutang_penjualan'		=> $piutang_penjualan
		);
		$this->db->where('username', $username);
		$this->db->update('users', $data_update2);
		//update financials user resale
		$data_update4 	= array (
			'piutang_penjualan' => $users_resale->piutang_penjualan - ($query->project_modal-$query->project_hpp),
			'kas'				=> $users_resale->kas + ($query->project_modal-$query->project_hpp)
		);
		$this->db->where('username', $query->project_investor_username);
		$this->db->update('users', $data_update4);
		//update detail transaksi
		$data_update3 	= array (
				'tanggal' 		=> $now,
				'keterangan'	=> 'Grab Resale Project',
				'nominal'		=> ($query->project_modal-$query->project_hpp),
				'status'		=> 2,
				'username'		=> $username,
				'dc'			=> '(-)',
				'post'			=> 'Kas -> Piutang Penjualan'
				);
		$this->db->insert('detail_transaksi', $data_update3);
		//update project status 3
		$data_update1 	= array (
			'project_status' 			=> 2,
			'project_investor_username'	=> $username
		);
		$this->db->where('Id', $id);
		$this->db->update('project', $data_update1);
	}

	/**if (($users->hutang * -1) > $query->project_modal){
		$data_update2 	= array (
			'hutang' 				=> $users->hutang + $query->project_modal,
			'piutang_penjualan'		=> $piutang_penjualan
		);
		$this->db->where('username', $username);
		$this->db->update('users', $data_update2);
		//kondisi hutang minus dan hutang dibawah nilai proyek
	}elseif (($users->hutang < 0) and (($users->hutang * -1) < $query->project_modal)){
		$data_update2 	= array (
			'hutang' 				=> 0,
			'kas'					=> ($users->kas + ($users->hutang * -1)) - $query->project_modal,
			'piutang_penjualan'		=> $piutang_penjualan
		);
		$this->db->where('username', $username);
		$this->db->update('users', $data_update2);
	}else{
		$data_update2 	= array (
			'kas'					=> $kas,
			'piutang_penjualan'		=> $piutang_penjualan
		);
		$this->db->where('username', $username);
		$this->db->update('users', $data_update2);
	}**/

	/**if (($users_jual->hutang > 0) and ($users_jual->hutang > $query->project_modal)){
		$data_update4 	= array (
			'hutang' 	=> $users_jual->hutang - $query->project_modal,
			'kas'		=> $users_jual->kas + $query->project_modal
		);
		$this->db->where('username', $query->project_username);
		$this->db->update('users', $data_update4);
		//kondisi hutang plus dan lebih kecil dari nilai proyek
	}elseif (($users_jual->hutang > 0) and ($users_jual->hutang < $query->project_modal)){
		$data_update4 	= array (
			'hutang' 	=> 0,
			'kas'		=> $users_jual->kas + ($query->project_modal - $users_jual->hutang),
			'modal'		=> $users_jual->modal + ($query->project_modal - $users_jual->hutang)
		);
		$this->db->where('username', $query->project_username);
		$this->db->update('users', $data_update4);
		//kondisi hutang minus
	}else {
		$data_update4 	= array (
			'hutang' 	=> $users_jual->hutang + ($query->project_modal * -1),
			'kas'		=> $users_jual->kas + $query->project_modal
		);
		$this->db->where('username', $query->project_username);
		$this->db->update('users', $data_update4);
	}**/

}

function insert_project(){
		date_default_timezone_set('Asia/Jakarta');
		$newPrice = $this->input->post('price');
		$newDown_payment = $this->input->post('down_payment');
		//$newInvesment = $this->input->post('invesment');
		$newMonthly = $this->input->post('monthly');

		$project_name		= $this->input->post('project_name');
		$project_id_number	= $this->input->post('identity_number');
		//$project_fullname	= $this->input->post('full_name');
		//$project_gender		= $this->input->post('gender');
		$project_produk		= $this->input->post('product');
		$project_series		= $this->input->post('product_series');
		$project_jml		= $this->input->post('quantity');
		$project_budget		= preg_replace('/\./', '', $newPrice);
		$project_dp			= preg_replace('/\./', '', $newDown_payment);
		//$project_modal		= preg_replace('/\./', '', $newInvesment);
		$project_modal		= $project_budget - $project_dp;
		$project_angsuran	= preg_replace('/\./', '', $newMonthly);
		$project_jmlangsuran= $this->input->post('tenor');
		$project_detail		= $this->input->post('project_detail');
		$project_username	= $this->session->userdata('username');
		$data_insert = array (
			'project_name' 		=> $project_name,
			'project_id_number'	=> $project_id_number,
			//'project_fullname' 	=> $project_fullname,
			//'project_gender' 	=> $project_gender,
			'project_produk' 	=> $project_produk,
			'project_series' 	=> $project_series,
			'project_jml' 		=> $project_jml,
			'project_budget' 	=> round($project_budget),
			'project_dp' 		=> round($project_dp),
			'project_modal'		=> round($project_modal),
			'project_angsuran'	=> round($project_angsuran),
			'project_jmlangsuran' => $project_jmlangsuran,
			'project_date'		=> date("Y-m-d H:i:s"),
			'project_detail' 	=> $project_detail,
			'project_status' 	=> 1,
			'project_potensi_jual' => round($project_jmlangsuran * $project_angsuran),
			'project_potensi_laba' => round(($project_jmlangsuran * $project_angsuran)-$project_modal),
			'project_angs_ke' 	=> 0,
			'project_ttl_agsuran' 	=> 0,
			'project_laba_cur' 	=> 0,
			'project_hpp' 		=> 0,
			'project_tgl_akhir' => date('Y-m-d H:i:s'),
			'coll' 				=> 1,
			'project_username' 	=> $project_username
			);
		$this->db->insert('project',$data_insert);
}

function insert_customer(){
		date_default_timezone_set('Asia/Jakarta');
		$salary = $this->input->post('salary');

		$customer_name		= $this->input->post('customer_name');
		$customer_identity	= $this->input->post('identity_number');
		$customer_address	= $this->input->post('Address');
		$customer_hp		= $this->input->post('Phone');
		$customer_gender	= $this->input->post('gender');
		$customer_marital	= $this->input->post('marital');
		$customer_dob		= $this->input->post('date_pic');
		$customer_salary	= preg_replace('/\./', '', $salary);
		$customer_dependents= $this->input->post('Dependents');
		$customer_info		= $this->input->post('customer_info');
		$pekerjaan			= $this->input->post('pekerjaan');
		$data_insert = array (
			'customer_name' 		=> $customer_name,
			'customer_identity'		=> $customer_identity,
			'customer_address' 		=> $customer_address,
			'customer_hp' 			=> $customer_hp,
			'customer_gender' 		=> $customer_gender,
			'customer_marital' 		=> $customer_marital,
			'customer_dob' 			=> $customer_dob,
			'customer_salary' 		=> $customer_salary,
			'customer_dependents' 	=> $customer_dependents,
			'customer_info' 		=> $customer_info,
			'customer_status'		=> 1,
			'customer_input'		=> $this->session->userdata('username'),
			'customer_pekerjaan'	=> $pekerjaan
			);
		$this->db->insert('customer',$data_insert);
}

function save_offers($image){
		date_default_timezone_set('Asia/Jakarta');
		
		$harga 				= $this->input->post('harga');
		$harga_num			= preg_replace('/\./', '', $harga);
		$name				= $this->input->post('name');
		$exp_date			= $this->input->post('exp_date');
		$info				= $this->input->post('info');
		$data_insert = array (
			'nama' 				=> $name,
			'harga_cash'		=> $harga_num,
			'keterangan' 		=> $info,
			'exp_date' 			=> $exp_date,
			'insert_date' 		=> date("Y-m-d H:i:s"),
			'image' 			=> $image,
			'status'			=> 1,
			'user_input'		=> $this->session->userdata('username')
			);
		$this->db->insert('offers',$data_insert);
}

function get_new_project(){
	$this->db->select('*');
	$query = $this->db->get('project');
	if ($query->num_rows() > 0 ){
	foreach ($query->result() as $data){
    $hasil_query[] = $data;
	}
	return $hasil_query;
	}
}

function get_transaksi_admin($status)
{
	if ($this->session->userdata('level')==1){
		$this->db->select('*');
		$this->db->from('detail_transaksi');
		$this->db->where('status', $status);
		$this->db->or_where('status', 0);
		$query = $this->db->get();
		if ($query->num_rows() > 0 ){
		foreach ($query->result() as $data){
		$hasil_query[] = $data;
		}
		return $hasil_query;
		}
	}
}

function get_transaksi($status)
{
	$this->db->select('*');
    $this->db->from('detail_transaksi');
    $this->db->where('status', $status);
	$this->db->where('username', $this->session->userdata('username'));
	$query = $this->db->get();
	if ($query->num_rows() > 0 ){
	foreach ($query->result() as $data){
	$hasil_query[] = $data;
	}
	return $hasil_query;
	}

}

function get_transaksi2()
{
	$this->db->select('*');
    $this->db->from('detail_transaksi');
    $this->db->where('status', 1);
	$this->db->or_where('status', 0);
	$this->db->where('username', $this->session->userdata('username'));
	$query = $this->db->get();
	if ($query->num_rows() > 0 ){
	foreach ($query->result() as $data){
	$hasil_query[] = $data;
	}
	return $hasil_query;
	}

}

function bank_cash()
{
	$this->db->select_sum('kas');
	$this->db->select_sum('piutang_penjualan');
	$this->db->select_sum('pendapatan');
	$this->db->select_sum('write_off');
    $this->db->from('users');
    //$this->db->where('(project_status = 2)');
	//$this->db->where('project_username', $this->session->userdata('username'));
    $query = $this->db->get();
    return $query->row();
}

function list_ttl_username()
{
	$this->db->select_sum('project_modal');
    $this->db->from('project');
    $this->db->where('(project_status = 2)');
	$this->db->where('project_username', $this->session->userdata('username'));
    $query = $this->db->get();
    return $query->row();
}

function list_ttl_hutang()
{
	$this->db->select_sum('hutang');
	$this->db->from('users');
	$this->db->where('hutang > 0');
    $query = $this->db->get();
    return $query->row();
}

function list_ttl_kas()
{
	$this->db->select_sum('kas');
	$this->db->from('users');
    $query = $this->db->get();
    return $query->row();
}

function list_ttl_invest()
{
	$this->db->select_sum('project_modal');
	$this->db->select_sum('project_hpp');
	$this->db->select_sum('project_potensi_laba');
    $this->db->from('project');
    $this->db->where('(project_status = 2) ');
	$this->db->where('project_investor_username', $this->session->userdata('username'));
    $query = $this->db->get();
    return $query->row();
}

function get_ttl_invest()
{
	$this->db->select_sum('project_modal');
    $this->db->from('project');
    $this->db->where('(project_status = 1) ');
	$this->db->where("project_date > (DATE_SUB(NOW(), INTERVAL 24 HOUR))");
    $query = $this->db->get();
    return $query->row();
}

function get_project_pagination($limit, $start, $st = NULL)
{
	date_default_timezone_set('Asia/Jakarta');
	if ($st == "NIL") $st = "";
	$sql = "select * from project LEFT JOIN users ON project.project_username = users.username WHERE (((project_date > DATE_SUB(NOW(), INTERVAL 24 HOUR)) AND (project.project_status = 1)) OR (project.project_status = 3)) ORDER BY project_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function get_listoffers($limit, $start, $st = NULL)
{
	date_default_timezone_set('Asia/Jakarta');
	if ($st == "NIL") $st = "";
	$sql = "SELECT * FROM offers WHERE exp_date > CURDATE() ORDER BY insert_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function get_project_pagination_count($st = NULL)
{
	date_default_timezone_set('Asia/Jakarta');
	if ($st == "NIL") $st = "";
	$sql = "select * from project LEFT JOIN users ON project.project_username = users.username WHERE (((project_date > DATE_SUB(NOW(), INTERVAL 24 HOUR)) AND (project.project_status = 1)) OR (project.project_status = 3))";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function get_listoffers_count($st = NULL)
{
	date_default_timezone_set('Asia/Jakarta');
	if ($st == "NIL") $st = "";
	$sql = "SELECT * FROM offers WHERE exp_date > CURDATE()";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function list_project_pagination($limit, $start, $st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select * from project
	LEFT JOIN users ON project.project_username = users.username
	WHERE (project.project_status=2) AND (project.project_investor_username='".$this->session->userdata('username')."') ORDER BY project_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function list_project_pagination_count($st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select * from project LEFT JOIN users ON project.project_username = users.username WHERE (project.project_status=2) AND (project.project_investor_username='".$this->session->userdata('username')."')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function list_open_pagination($limit, $start, $st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select p.Id, p.project_name, p.project_angsuran, p.project_username,p.project_detail, p.project_id_number, p.project_status, p.project_produk, p.project_series, p.project_date, p.project_jmlangsuran, p.project_modal, p.project_hpp, p.project_angs_ke, p.coll, p.project_tgl_akhir
	FROM project p
	LEFT JOIN users u ON p.project_username = u.username
	LEFT JOIN angsuran_current a ON p.Id = a.id_project
	WHERE (p.project_name LIKE '%$st%' OR p.project_id_number LIKE '%$st%') AND (p.project_status=2) AND (p.project_username='".$this->session->userdata('username')."') ORDER BY p.project_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function list_open_all_pagination($limit, $start, $st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select p.Id, p.project_name, p.project_angsuran, p.project_username,p.project_detail, p.project_id_number, p.project_status, p.project_produk, p.project_series, p.project_date, p.project_jmlangsuran, p.project_modal, p.project_hpp, p.project_angs_ke, p.coll, p.project_tgl_akhir, p.project_username, p.project_investor_username
	FROM project p
	LEFT JOIN angsuran_current a ON p.Id = a.id_project
	WHERE (p.project_name LIKE '%$st%' OR p.project_id_number LIKE '%$st%') AND (p.project_status=2) ORDER BY p.project_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function list_open_pagination_count($st = NULL)
{
	if ($st == "NIL") $st = "";
	$sql = "select p.project_name, p.project_username, p.project_id_number, p.project_status
	FROM project p
	WHERE (p.project_name LIKE '%$st%' OR p.project_id_number LIKE '%$st%') AND (p.project_status=2) AND (p.project_username='".$this->session->userdata('username')."')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function list_open_pagination_pay($limit, $start, $st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$date 	= date('Y-m-d');
	$day 	= date('d', strtotime($date));
	$sql = "select DAY(p.project_date), p.Id, p.project_name, p.project_angsuran, p.project_username,p.project_detail, p.project_id_number, p.project_status, p.project_produk, p.project_series, p.project_date, p.project_jmlangsuran, p.project_modal, p.project_hpp, p.project_angs_ke, p.coll, p.project_tgl_akhir, u.rating,a.id_project
	FROM project p
	LEFT JOIN users u ON p.project_username = u.username
	LEFT JOIN angsuran_current a ON p.Id = a.id_project
	WHERE ((p.project_status=2) AND (".$user."='".$this->session->userdata('username')."') AND  (DAY(p.project_date) <= ".$day.") AND (a.id_project IS NULL)) OR ((p.coll>=2) AND (p.project_status=2) AND (".$user."='".$this->session->userdata('username')."'))
	ORDER BY p.project_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function list_open_pagination_pay_count($st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$date 	= date('Y-m-d');
	$day 	= date('d', strtotime($date));
	$sql = "select DAY(p.project_date), p.project_status, p.project_username, p.coll
	FROM project p
	LEFT JOIN angsuran_current a ON p.Id = a.id_project
	WHERE ((p.project_status=2) AND (".$user."='".$this->session->userdata('username')."') AND  (DAY(p.project_date) <= ".$day.") AND (a.id_project IS NULL)) OR ((p.coll>=2) AND (p.project_status=2) AND (".$user."='".$this->session->userdata('username')."'))";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function list_open_pagination_pay_all($limit, $start, $st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$date 	= date('Y-m-d');
	$day 	= date('d', strtotime($date));
	$sql = "select DAY(p.project_date), p.Id, p.project_name, p.project_angsuran, p.project_username,p.project_detail, p.project_id_number, p.project_status, p.project_produk, p.project_series, p.project_date, p.project_jmlangsuran, p.project_modal, p.project_hpp, p.project_angs_ke, p.coll, p.project_tgl_akhir, p.project_investor_username, u.rating,a.id_project
	FROM project p
	LEFT JOIN users u ON p.project_username = u.username
	LEFT JOIN angsuran_current a ON p.Id = a.id_project
	WHERE ((p.project_status=2) AND (DAY(p.project_date) <= ".$day.") AND (a.id_project IS NULL)) OR ((p.project_status=2) AND (p.coll>=2))
	ORDER BY p.project_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function payable_list_all($limit, $start, $st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM users u
	WHERE u.hutang > 0
	ORDER BY u.hutang DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function payable_list_count_all($user)
{
	$sql = "select username
	FROM users
	WHERE hutang > 0";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function agent_list_all($limit, $start, $st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$sql = "SELECT p.project_username, sum(p.project_modal) AS omset, sum(p.project_modal-project_hpp) AS outs, u.nama
	FROM project p
	LEFT JOIN users u ON p.project_username = u.username
	GROUP by project_username
	ORDER BY outs DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function cash_list_all($limit, $start, $st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM users
	ORDER BY kas DESC, piutang_penjualan DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function agent_list_count_all($user)
{
	$sql = "select username
	FROM users WHERE level = 2";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function cash_list_count_all($user)
{
	$sql = "select username
	FROM users";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function detrans_count_all($user)
{
	$sql = "select *
	FROM detail_transaksi
	WHERE username = '$user'";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function detrans_user($limit, $start, $st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$sql = "select *
	FROM detail_transaksi d
	WHERE d.username = '$user'
	ORDER BY d.tanggal DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function list_open_pagination_pay_count_all($st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$date 	= date('Y-m-d');
	$day 	= date('d', strtotime($date));
	$sql = "select DAY(p.project_date), p.project_status, p.project_username, p.coll
	FROM project p
	LEFT JOIN angsuran_current a ON p.Id = a.id_project
	WHERE ((p.project_status=2) AND  (DAY(p.project_date) <= ".$day.") AND (a.id_project IS NULL)) OR ((p.project_status=2) AND (p.coll>=2))";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function list_open_pagination_over($limit, $start, $st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$date 	= date('Y-m-d');
	$day 	= date('d', strtotime($date));
	$sql = "select *
	FROM project p
	WHERE (coll>=2) AND (".$user."='".$this->session->userdata('username')."')
	ORDER BY project_date DESC limit " . $start . ", " . $limit;
	$query = $this->db->query($sql);
	return $query->result();
}

function list_open_pagination_over_count($st = NULL, $user)
{
	if ($st == "NIL") $st = "";
	$date 	= date('Y-m-d');
	$day 	= date('d', strtotime($date));
	$sql = "select Id
	FROM project p
	WHERE (coll>=2) AND (".$user."='".$this->session->userdata('username')."')";
	$query = $this->db->query($sql);
	return $query->num_rows();
}

function get_project_outer(){
	//get transaksi to post
	$sql = "select p.coll, p.Id, p.project_status
	FROM project p
	LEFT JOIN angsuran_current a ON p.Id = a.id_project
	WHERE (a.id_project is NULL) AND (p.project_status<>9)";
	$query = $this->db->query($sql);
	return $query->result();

}

function eom_proccess()
{
	$project = $this->get_project_outer();
	foreach($project as $data) {
		$data_update 	= array (
			'coll' 		=> $data->coll + 1
		);
		$this->db->where('Id', $data->Id);
		$this->db->update('project', $data_update);
	}
	//empty angsuran_current
	$this->db->empty_table('angsuran_current');
}

function resale($id)
{
	$data_update5 	= array (
		'project_status'	=> 3
	);
	$this->db->where('Id', $id);
	$this->db->update('project', $data_update5);
}

function write_off($id)
{
	$dw_os 		= $this->input->post('down_os');
	$down_os	= preg_replace('/\./', '', $dw_os);
	$project 		= $this->get_project_id($id);
	$outstanding 	= $project->project_modal-$project->project_hpp;

	//cek equity
	$users = $this->get_user_username($project->project_investor_username);
	if ($users->laba_bersih < $outstanding) {
		//equity dibawah oustanding ditolak
		echo '<script>alert("Insufficient equity.!");</script>';
		redirect('app/cari_customer_bayar_all');
	}else {
		//update sales volume, equity dan write_off
		$data_update 	= array (
			'piutang_penjualan'	=> $users->piutang_penjualan-$outstanding,
			'laba_bersih'		=> ($users->laba_bersih+$down_os)-$outstanding,
			'kas'				=> $users->kas+$down_os,
			'pendapatan'		=> $users->pendapatan+$down_os,
			'write_off'			=> $users->write_off+$outstanding
		);
		$this->db->where('username', $project->project_investor_username);
		$this->db->update('users', $data_update);
		//ubah status project
		$data_update1 	= array (
			'project_status'	=> 0
		);
		$this->db->where('Id', $id);
		$this->db->update('project', $data_update1);
		//sukses
		echo '<script>alert("Write Off Success.!");</script>';
		redirect('app/cari_customer_bayar_all');
	}

}

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />
    <title>BDL CORE | Business Development</title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>src/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url();?>src/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url();?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url();?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>src/build/css/custom.min.css" rel="stylesheet">
	<!-- footer menu -->
	<link rel="stylesheet" href="<?php echo base_url();?>src/css/mobile_menu/header.css">
	<link rel="stylesheet" href="<?php echo base_url();?>src/css/mobile_menu/icons.css">
	
	<style>
		.col-xs-3 {
			width: 25%;
			background-color: #008080;
		}
		.row {
			margin-left: 0px;
		}
		.container-fluid {
			padding-right: 0px;
			padding-left: 0px
		}
		.btn_footer_panel .tag_ {
			padding-top: 37px;
		}
		body {
			
		}
	</style>
  </head>
  
  <header class="header_area sticky-header">
   <!-- footer menu -->
	<div class="footer_panel">
		<div class="container-fluid text-center">
			<div class="row">

				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>app/create_memo">
					<i class="la-i la-i-m la-i-home"></i>
					<div class="tag_"><font color="white">Create</font></div></a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>app/inbox">
					<i class="la-i la-i-m la-i-order"></i>
					<div class="tag_"><font color="white">Inbox</font></div></a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>app/send_memo">
					<i class="la-i la-i-m la-i-notif"></i>
					<div class="tag_">
						<font color="white">Outbox</font>
					</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>login/logout">
					<i class="la-i la-i-m la-i-akun"></i>
					<div class="tag_"><font color="white">Logout</font></div></a>
				</div>
				
			</div>
		</div>
	</div>
	<!-- footer menu -->
	</header>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url();?>" class="site_title"><img
								src="<?php echo base_url();?>img/logo-harnoko3_logo.png" alt="..." height="42"
								width="50"><span> Harnoko Group</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo base_url();?>src/images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->userdata('nama');?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
				<?php $this->load->view('side_menu.php'); ?>
				</div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url();?>src/images/img.jpg" alt=""><?php echo $this->session->userdata('nama');?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="<?php echo base_url();?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="<?php echo base_url()."app/inbox"; ?>" class="dropdown-toggle info-number">
                    <i class="fa fa-envelope-o"></i>
					<?php if ($count_inbox==0) {?>
						<span class="badge bg-green"><?php echo $count_inbox;?></span>
					<?php }else{?>
						<span class="badge bg-red"><?php echo $count_inbox;?></span>
					<?php }?>
                  </a>
                  <!--ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul-->
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
			
			<!-- Start content-->
		<div class="right_col" role="main">	
		
			<div class="x_panel card">
				<!--div class="alert alert-info">Daftar Surat Kuasa </div-->
				<div align="center">
				  <?php 
					if (($this->uri->segment(2)=='send_memo') OR ($this->uri->segment(2)=='send_cari')) {
						?><font color="brown">Send Memo</font><br><br>
				</div>
				<!-- search -->
				<form data-parsley-validate action="<?php echo base_url();?>app/send_cari" method="post" name="form_input" id="form_input">
					<label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
						<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-8">
						<input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dengan judul yang akan dicari">
					</div>
					<?php echo form_submit('cari_memo', 'Cari', 'class="btn btn-primary"'); ?>
					<input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/inbox'" />
				</form>
				<?php }else{?>
				<font color="brown">Inbox Memo</font><br><br>
			</div>
			<!-- search -->
			<form data-parsley-validate action="<?php echo base_url();?>app/inbox_cari" method="post" name="form_input" id="form_input">
				<label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
					<span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-8">
					<input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dengan judul yang akan dicari">
				</div>
				<?php echo form_submit('cari_memo', 'Cari', 'class="btn btn-primary"'); ?>
				<input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/inbox'" />
			</form>
					
				<?php } ?>
			
		   
			<div class="table-responsive">
			<table class="table table-striped">
			<thead>
			  <tr>
				<th bgcolor="#008080"><font color="white">No.</font></th>
				<th bgcolor="#008080"><font color="white">No.Memo</font></th>
				<th bgcolor="#008080"><font color="white">Judul</font></th>
				<th bgcolor="#008080"><font color="white">Tanggal</font></th>
				<?php if ($this->uri->segment(2)=='send_memo' OR $this->uri->segment(2)=='send_cari') {?>
					<th bgcolor="#008080"><font color="white">Kepada</font></th>
				<?php }else{ ?>
				<th bgcolor="#008080"><font color="white">Dari</font></th>
				<?php } ?>
				<!--th bgcolor="#008080"><font color="white">Status</font></th-->
				<th bgcolor="#008080"><font color="white">Detail</font></th>
			  </tr>
			</thead>
			<?php
			if ($this->uri->segment(3)=='') {
				$no=1;
			}else{
				$no=$this->uri->segment(3)+1;
			}
			if (empty($users_data)) {
			?>
			
			<?php
			} else 
			{
			foreach ($users_data as $data):
			?>
				<!--content here-->
				<tbody>
				<tr>
					<?php 
					$nip = $this->session->userdata('nip');
					$kalimat = $data->read;
					if (preg_match("/$nip/i", $kalimat)) {?>
						<p style="font-weight: normal;">
						<td><?php echo $no; ?></td>
						<td><?php echo $data->nomor_memo; ?></td>
						<td><?php echo $data->judul; ?></td>
						<td><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></td>
						<td><?php 
						if ($this->uri->segment(2)=='send_memo' OR $this->uri->segment(2)=='send_cari') {
						$string = substr($data->nip_kpd, 0, -1);
						$arr_kpd = explode(";",$string);
						$last = $arr_kpd[0];
						$sql="SELECT nama FROM users WHERE nip='$last';";
						$query = $this->db->query($sql);
						$result = $query->row();
						echo $result->nama;
						}else{
							echo $data->nama;
						}?></td>
						<!--td><?php 
							if ($data->persetujuan==0){
								echo 'Pending';
							}else{
								echo 'Approved';
							}?>
						</td-->
						<td>
							<form action="<?php echo base_url()."app/memo_view/".$data->id; ?>" target="">
								<button type="submit" class="btn btn-dark btn-xs">Open</button>
							</form>
						</td>
					<?php }else{?>
						<td><p style="font-weight: bold;"><?php echo $no; ?></p></td>
						<td><p style="font-weight: bold;"><?php echo $data->nomor_memo; ?></p></td>
						<td><p style="font-weight: bold;"><?php echo $data->judul; ?></p></td>
						<td><p style="font-weight: bold;"><?php echo date('d-m-Y', strtotime($data->tanggal)); ?></p></td>
						<td><p style="font-weight: bold;"><?php 
						if ($this->uri->segment(2)=='send_memo' OR $this->uri->segment(2)=='send_cari') {
						$string = substr($data->nip_kpd, 0, -1);
						$arr_kpd = explode(";",$string);
						$last = $arr_kpd[0];
						$sql="SELECT nama FROM users WHERE nip='$last';";
						$query = $this->db->query($sql);
						$result = $query->row();
						echo $result->nama;
						}else{
							echo $data->nama;
						}?></p></td>
						<!--td><p style="font-weight: bold;"><?php 
							if ($data->persetujuan==0){
								echo 'Pending';
							}else{
								echo 'Approved';
							}?></p>
						</td-->	
						<td>
							<form action="<?php echo base_url()."app/memo_view/".$data->id; ?>" target="">
								<button type="submit" class="btn btn-dark btn-xs">Open</button>
							</form>
						</td>
						
					<?php } ?>
					
					<!--td>
						<form action="<?php echo base_url()."app/surat_keluar_edit/".$data->id; ?>">
							<button type="submit" class="btn btn-warning btn-xs">Edit</button>
						</form>
					</td-->
				</tr>
				</tbody>
				
			<?php
			$no++;
			endforeach;} 
			?>
			</table>
			</div>

			<!--pagination-->
			<div class="row col-12 text-center">
				<?php echo $pagination; ?>
			</div>
			
		</div> 

			<!-- Finish content-->
			

        <!-- /page content -->

        <!-- footer content -->

        <!-- /footer content --></br></br>



    <!-- jQuery -->
    <script src="<?php echo base_url();?>src/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>src/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>src/vendors/nprogress/nprogress.js"></script>
    
    <!-- gauge.js -->
    <script src="<?php echo base_url();?>src/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url();?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>src/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url();?>src/vendors/skycons/skycons.js"></script>
    
    <!-- DateJS -->
    <script src="<?php echo base_url();?>src/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url();?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo base_url();?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url();?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url();?>src/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>src/build/js/custom.min.js"></script>
	
  </body>
</html>

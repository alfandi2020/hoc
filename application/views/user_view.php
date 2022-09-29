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
	<link href="<?php echo base_url();?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"
		rel="stylesheet">
	<!-- JQVMap -->
	<link href="<?php echo base_url();?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
	<!-- bootstrap-daterangepicker -->
	<link href="<?= base_url() ?>src/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
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

		body {}

		table,
		th,
		td {
			border: 0px solid black;
		}

		table.center {
			margin-left: auto;
			margin-right: auto;
		}

		.button1 {
			background-color: #4CAF50;
		}

		table,
		table {
			border-collapse: separate;
			border-spacing: 0 1em;
		}

		/* Green */

	</style>
</head>

<header class="header_area sticky-header">
	<!-- footer menu -->
	<!--div class="footer_panel">
		<div class="container-fluid text-center">
			<div class="row">

				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>app/antrian_input">
					<i class="la-i la-i-m la-i-home"></i>
					<div class="tag_"><font color="white">Create</font></div></a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>app/antrian_panggil">
					<i class="la-i la-i-m la-i-order"></i>
					<div class="tag_"><font color="white">Manage</font></div></a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>app/antrian_monitor">
					<i class="la-i la-i-m la-i-notif">
					</i>
					<div class="tag_">
						<font color="white">Monitor</font>
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
								width="50"><span> Harnoko</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="<?php echo base_url();?>src/images/img.jpg" alt="..."
								class="img-circle profile_img">
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
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
									aria-expanded="false">
									<img src="<?php echo base_url();?>src/images/img.jpg"
										alt=""><?php echo $this->session->userdata('nama');?>
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
									<li><a href="<?php echo base_url();?>login/logout"><i
												class="fa fa-sign-out pull-right"></i> Log Out</a></li>
								</ul>
							</li>

							<li role="presentation" class="dropdown">
								<a href="<?php echo base_url()."app/user"; ?>" class="dropdown-toggle info-number">
									<i class="fa fa-envelope-o"></i>
									<?php if ($count_inbox==0) {?>
									<span class="badge bg-green"><?php echo $count_inbox;?></span>
									<?php }else{?>
									<span class="badge bg-red"><?php echo $count_inbox;?></span>
									<?php }?>
								</a>
								<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
									<li>
										<a>
											<span class="image"><img src="<?php echo base_url();?>src/images/img.jpg"
													alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
											</span>
										</a>
									</li>
									<li>
										<a>
											<span class="image"><img src="<?php echo base_url();?>src/images/img.jpg"
													alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
											</span>
										</a>
									</li>
									<li>
										<a>
											<span class="image"><img src="<?php echo base_url();?>src/images/img.jpg"
													alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
											</span>
										</a>
									</li>
									<li>
										<a>
											<span class="image"><img src="<?php echo base_url();?>src/images/img.jpg"
													alt="Profile Image" /></span>
											<span>
												<span>John Smith</span>
												<span class="time">3 mins ago</span>
											</span>
											<span class="message">
												Film festivals used to be do-or-die moments for movie makers. They were
												where...
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
								</ul>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->

			<!-- Start content-->
			<div class="right_col" role="main">
				<div class="clearfix"></div>

				<div class="x_panel card">
					<strong>
						<font style="color:blue;font-size:24px;">BANDES</font>
						<font style="color:green;font-size:24px;">LOGISTIK</font>
					</strong></br>
					<font style="font-size:17px;">PT. Harnoko Logistindo</font></br></br>

					<div align="center">
						<font style="font-size:17px;">
							<?php if ($this->uri->segment(4) == 'e') {
                                echo 'User Edit';
                            }else{
                                echo 'User View';
                            } ?>
							<hr />
						</font>
					</div>
					<font style="font-size:14px;">
						<?php if($this->uri->segment(4) != 'e' && $this->uri->segment(3) == true){ ?>
						</br>
						<table>
							<tr>
								<th width="200">Usernamee</th>
								<td>: <?= $user->username ?></td>
							</tr>
							<tr>
								<th>Nama</th>
								<td>: <?= $user->nama ?></td>

							</tr>
							<tr>
								<th>Level</th>
								<td>: <?= $user->level ?></td>
							</tr>
							<tr>
								<th>Status</th>
								<td>:<?php if($user->status == 1){ ?>
									<span style="cursor: default;" class="btn btn-primary">Active</span>
									<?php }else{ ?>
									<span style="cursor: default;" class="btn btn-danger">Not Active</span>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<th>Email</th>
								<td>: <?= $user->email ?></td>
							</tr>
							<tr>
								<th>Phone</th>
								<td>: <?= $user->phone ?></td>
							</tr>
							<tr>
								<th>Code Agent</th>
								<td>: <?= $user->kd_agent ?></td>
							</tr>
							<tr>
								<th>Nip</th>
								<td>: <?= $user->nip ?></td>
							</tr>
							<tr>
								<th>Level</th>
								<td>: <?= $user->level_jabatan ?></td>
							</tr>
							<tr>
								<th>Bagian</th>
								<td>: <?= $user->bagian ?></td>
							</tr>
							<tr>
								<th>Nama Jabatan</th>
								<td>: <?= $user->nama_jabatan ?></td>
							</tr>
							<tr>
								<th>Supervisi</th>
								<td>: <?= $user->supervisi ?></td>
							</tr>
							<tr>
								<th><a href="<?= base_url('app/user') ?>" class="btn btn-warning"><i
											class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></th>
							</tr>
						</table>
						<br>
						<?php }elseif ($this->uri->segment(3) == false) { ?> <!-- add user -->
						<?= $this->session->flashdata('msg') ?>
                        	<form action="<?= base_url('app/add_user/'.$this->uri->segment('3')) ?>" method="POST">
							<input type="hidden" value="add" name="add">
							<input type="hidden" value="<?= $this->uri->segment('3') ?>" name="id">
							<table>
								<tr>
									<th width="300">Username</th>
									<td width="300"> <input type="text" value="<?php echo set_value('username'); ?>" name="username" class="form-control"></td>
								</tr>
								<tr>
									<th width="300">Password</th>
									<td width="300"> <input type="text" name="password" class="form-control"></td>
								</tr>
								<tr>
									<th width="300">Password Confirmation</th>
									<td width="300"> <input type="text" name="password_confirmation" class="form-control"></td>
								</tr>
								<tr>
									<th width="200">Name</th>
									<td> <input type="text" name="nama" class="form-control">
									</td>
								</tr>
								<tr>
									<th width="200">Date of birth</th>
									<td> <div class='input-group date' id='myDatepicker2'>
                                 <input type='text' id='date_pic' name='date_pic' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required"/>
                                 <span class="input-group-addon">
                                 <span class="glyphicon glyphicon-calendar"></span>
                                 </span>
                                 </div>
									</td>
								</tr>
								<tr>
									<th width="200">Level</th>
									<td>
										<select class="form-control js-example-basic-multiple" name="level[]"
											multiple="multiple">
											<?php 
                                     $level_x = explode(',',$user->level);
                                    $x = $this->db->get('menu')->result();
                                    foreach ($x as $k) { 
                                        // foreach($level_x as $o) {
                                            if (strpos($user->level, $k->level) !== false) {
                                        ?>
											<option selected="selected" value="<?= $k->level ?>"><?= $k->nama ?>
											</option>
											<?php } else{?>
											<option value="<?= $k->level ?>"><?= $k->nama ?></option>

											<?php }
                                      //}
                                    }?>
										</select>
									</td>
								</tr>

								<tr>
									<th>Status</th>
									<td>
										<input name="status" type="radio"
											id="active">
										<label for="active">Active</label>
										<input name="status" type="radio"
											 id="noactive">
										<label for="noactive">Not Active</label>
									</td>
								</tr>
								<tr>
									<th width="200">Email</th>
									<td> <input type="text" name="email" class="form-control"
											></td>
								</tr>
								<tr>
									<th>Phone</th>
									<td><input type="text" name="phone" class="form-control"
											></td>
								</tr>
								<tr>
									<th>Code Agent</th>
									<td><input type="text" name="kd_agent" class="form-control"
										></td>
								</tr>
								<tr>
									<th>Nip</th>
									<td><input type="text" name="nip" class="form-control"
											></td>
								</tr>
								<tr>
									<th>Level Jabatan</th>
									<td>
										<select name="level" id="" class="form-control">
											<option disabled selected>Pilih Jabatan</option>
											<option value="1">Staff</option>
											<option value="2">Supervisor</option>
											<option value="3">Manajer</option>
											<option value="4">General Manajer</option>
											<option value="5">Direktur</option>
											<option value="6">Direktur Utama</option>

										</select>
									</td>
								</tr>
								<tr>
									<th>Bagian</th>
									<td>
										<select name="bagian" class="form-control" id="">
											<?php $xx = $this->db->get('bagian')->result();
                                            foreach ($xx as $k) {
                                                if (!empty($user)) {
                                                ?>
											<option <?= $k->Id == $user->bagian ? 'selected' : '' ?>
												value="<?= $k->Id ?>"><?= $k->nama ?></option>
											<?php }else{?>
                                                <option 
												value="<?= $k->Id ?>"><?= $k->nama ?></option>
                                            <?php } 
                                            }?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Nama Jabatan</th>
									<td><input type="text" name="nama_jabatan" class="form-control"
											></td>
								</tr>
								<tr>
									<th>Supervisi</th>
									<td><input type="text" name="supervisi" class="form-control"
											></td>
								</tr>
								<tr>
									<th>
										<a class="btn btn-warning" href="<?= base_url('app/user') ?>"><i
												class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
									</th>
									<td><button type="submit" class="btn btn-primary">Submit</button></td>

								</tr>
							</table>
						</form>
                        <?php  }else if($this->uri->segment(4) == 'e'){?>
						</br>
						<?= $this->session->flashdata('msg') ?>
						<form action="<?= base_url('app/user_edit/'.$this->uri->segment('3')) ?>" method="POST">
							<input type="hidden" value="edit" name="edit">
							<input type="hidden" value="<?= $this->uri->segment('3') ?>" name="id">
							<table>
								<tr>
									<th width="300">Username</th>
									<td width="300"> <input readonly type="text" name="username" class="form-control"
											value="<?= $user->username ?>"></td>
								</tr>
								<tr>
									<th width="200">Name</th>
									<td> <input type="text" name="nama" class="form-control" value="<?= $user->nama ?>">
									</td>
								</tr>
								<tr>
									<th width="200">Level</th>
									<td width="100%">
										<select class="form-control js-example-basic-multiple" name="level[]"
											multiple="multiple">
											<?php 
                                     $level_x = explode(',',$user->level);
                                    $x = $this->db->get('menu')->result();
                                    foreach ($x as $k) { 
                                        // foreach($level_x as $o) {
                                            if (strpos($user->level, $k->level) !== false) {
                                        ?>
											<option selected="selected" value="<?= $k->level ?>"><?= $k->nama ?>
											</option>
											<?php } else{?>
											<option value="<?= $k->level ?>"><?= $k->nama ?></option>

											<?php }
                                      //}
                                    }?>
										</select>
									</td>
								</tr>

								<tr>
									<th>Status</th>
									<td>
										<input <?= $user->status ? 'checked' : '' ?> name="status" type="radio"
											value="<?= $user->status ?>" id="active">
										<label for="active">Active</label>
										<input <?= $user->status ? '' : 'checked' ?> name="status" type="radio"
											value="<?= $user->status ?>" id="noactive">
										<label for="noactive">Not Active</label>
									</td>
								</tr>
								<tr>
									<th width="200">Email</th>
									<td> <input type="text" name="email" class="form-control"
											value="<?= $user->email ?>"></td>
								</tr>
								<tr>
									<th>Phone</th>
									<td><input type="text" name="phone" class="form-control"
											value="<?= $user->phone ?>"></td>
								</tr>
								<tr>
									<th>Code Agent</th>
									<td><input type="text" name="kd_agent" class="form-control"
											value="<?= $user->kd_agent ?>"></td>
								</tr>
								<tr>
									<th>Nip</th>
									<td><input readonly type="text" name="nip" class="form-control"
											value="<?= $user->nip ?>"></td>
								</tr>
								<tr>
									<th>Level Jabatan</th>
									<td><input type="text" name="phone" class="form-control"
											value="<?= $user->level_jabatan ?>"></td>
								</tr>
								<tr>
									<th>Bagian</th>
									<td>
										<select name="bagian" class="form-control" id="">
											<?php $xx = $this->db->get('bagian')->result();
                                            foreach ($xx as $k) {?>
											<option <?= $k->Id == $user->bagian ? 'selected' : '' ?>
												value="<?= $k->Id ?>"><?= $k->nama ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Nama Jabatan</th>
									<td><input type="text" name="nama_jabatan" class="form-control"
											value="<?= $user->nama_jabatan ?>"></td>
								</tr>
								<tr>
									<th>Supervisi</th>
									<td><input type="text" name="supervisi" class="form-control"
											value="<?= $user->supervisi ?>"></td>
								</tr>
								<tr>
									<th>
										<a class="btn btn-warning" href="<?= base_url('app/user') ?>"><i
												class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
										<button type="submit" class="btn btn-primary">Update</button>
									</th>
								</tr>
							</table>
						</form>
						<br>
						<?php } ?>
					</font>


				</div>

				<!-- Finish content-->


				<!-- /page content -->

				<!-- footer content -->

				<!-- /footer content --></br>


				<!-- jQuery -->
				<script src="<?php echo base_url();?>src/vendors/jquery/dist/jquery.min.js"></script>
				<!-- Bootstrap -->
				<script src="<?php echo base_url();?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
				<!-- FastClick -->
				<script src="<?php echo base_url();?>src/vendors/fastclick/lib/fastclick.js"></script>
				<!-- NProgress -->
				<script src="<?php echo base_url();?>src/vendors/nprogress/nprogress.js"></script>
				<!-- Chart.js -->
				<script src="<?php echo base_url();?>src/vendors/Chart.js/dist/Chart.min.js"></script>
				<!-- gauge.js -->
				<script src="<?php echo base_url();?>src/vendors/gauge.js/dist/gauge.min.js"></script>
				<!-- bootstrap-progressbar -->
				<script src="<?php echo base_url();?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js">
				</script>
				<!-- iCheck -->
				<script src="<?php echo base_url();?>src/vendors/iCheck/icheck.min.js"></script>
				<!-- Skycons -->
				<script src="<?php echo base_url();?>src/vendors/skycons/skycons.js"></script>
				<!-- Flot -->
				<script src="<?php echo base_url();?>src/vendors/Flot/jquery.flot.js"></script>
				<script src="<?php echo base_url();?>src/vendors/Flot/jquery.flot.pie.js"></script>
				<script src="<?php echo base_url();?>src/vendors/Flot/jquery.flot.time.js"></script>
				<script src="<?php echo base_url();?>src/vendors/Flot/jquery.flot.stack.js"></script>
				<script src="<?php echo base_url();?>src/vendors/Flot/jquery.flot.resize.js"></script>
				<!-- Flot plugins -->
				<script src="<?php echo base_url();?>src/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
				<script src="<?php echo base_url();?>src/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
				<script src="<?php echo base_url();?>src/vendors/flot.curvedlines/curvedLines.js"></script>
				<!-- DateJS -->
				<script src="<?php echo base_url();?>src/vendors/DateJS/build/date.js"></script>
				<!-- JQVMap -->
				<script src="<?php echo base_url();?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
				<script src="<?php echo base_url();?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
				<script src="<?php echo base_url();?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
				<!-- bootstrap-daterangepicker -->
				<script src="<?php echo base_url();?>src/vendors/moment/min/moment.min.js"></script>
				<script src="<?php echo base_url();?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
				<script src="<?= base_url() ?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
				<!-- Custom Theme Scripts -->
				<script src="<?php echo base_url();?>src/build/js/custom.min.js"></script>
				<!-- Select2 -->
				<link rel="stylesheet" href="http://localhost/bdl_core/src/select2/css/select2.min.css">
				<script type="text/javascript" src="http://localhost/bdl_core/src/select2/js/select2.min.js"></script>
				<script>
					$(document).ready(function () {
						$('.js-example-basic-multiple').select2();
					});
					window.setTimeout(function () {
						$(".alert-success").fadeTo(500, 0).slideUp(500, function () {
							$(this).remove();
						});
					}, 3000);
					$('#myDatepicker2').datetimepicker({
						format: 'YYYY-MM-DD',
						maxDate : Date.now()+90000000
					});
					window.setTimeout(function () {
						$(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
							$(this).remove();
						});
					}, 3000);

				</script>
</body>

</html>

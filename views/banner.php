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
	<!-- <link href="<?php echo base_url();?>login_lib/vendor/bootstrap/css/bootstrap-grid.css" rel="stylesheet"> -->
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
		.justify-content-center {
			display: flex;
  			justify-content: center;
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
						<div class="tag_">
							<font color="white">Create</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url();?>app/inbox">
						<i class="la-i la-i-m la-i-order"></i>
						<div class="tag_">
							<font color="white">Inbox</font>
						</div>
					</a>
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
						<div class="tag_">
							<font color="white">Logout</font>
						</div>
					</a>
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
								width="50"><span> Bangun
								Desa</span></a>
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
												class="fa fa-sign-out pull-right"></i> Log
											Out</a></li>
								</ul>
							</li>

							<li role="presentation" class="dropdown">
								<!--a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"-->
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
			<div class="right_col" role="main">
				<div class="container">
					<div class="page-title">
						<div class="title_left">
							<h3>Dashboard 2022</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-8 col-xs-12">
						
							<div class="row">
								<!-- <div class="col-md-6 col-sm-6 col-xs-12">
									<div class="x_panel tile fixed_height_300">
										<div class="x_title">
											<h2><i class="fa fa-envelope-o"></i> Inbox</h2>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">
											<h4>Total Inbox</h4><br>
										
											<div class="widget_summary">
												<div class="w_left w_25">
													<span>In</span>
												</div>
												<div class="w_center w_55">
													<div class="progress">
														<div class="progress-bar bg-green" role="progressbar" aria-valuenow="46.288209606987"
															aria-valuemin="0" aria-valuemax="100" style="width: 46.288209606987%;">
															<span class="sr-only">46.288209606987%</span>
														</div>
													</div>
												</div>
												<div class="w_right w_20">
													<span>106</span>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="widget_summary">
												<div class="w_left w_25">
													<span>Out</span>
												</div>
												<div class="w_center w_55">
													<div class="progress">
														<div class="progress-bar bg-green" role="progressbar" aria-valuenow="20.960698689956"
															aria-valuemin="0" aria-valuemax="100" style="width: 20.960698689956%;">
															<span class="sr-only">20.960698689956%</span>
														</div>
													</div>
												</div>
												<div class="w_right w_20">
													<span>48</span>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								</div> -->
								<div class="col-md-12 col-sm-6 col-xs-12">
									<div class="x_panel tile fixed_height_300">
										<div class="x_title">
											<h2><i class="fa fa-envelope-o"></i> Banner</h2>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">
                                            <div class="row">
                                                    <div class="col-4">
                                                        <span>Banner</span>
                                                        <input type="file" class="form-control">
                                                    </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                    <div class="col-xl-4">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>



							</div>
						</div>

					</div>
					<!-- Start content-->

					<!-- Finish content-->
				</div>
			</div>

			<!-- /page content -->

			<!-- footer content -->

			<!-- /footer content -->
		</div>
	</div>

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
	<script src="<?php echo base_url();?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
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



</body>

</html>

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
	<!-- bootstrap-datetimepicker -->
    <link href="<?php echo base_url();?>src/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
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
              <a href="<?php echo base_url();?>" class="site_title"><img src="<?php echo base_url();?>img/logo-harnoko3_logo.png" alt="..." height="42" width="60"><span> Harnoko</span></a>
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
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">0</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
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
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
			<div class="clearfix"></div>
			
			<!-- Start content-->
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
				   <div class="x_title">
					  <p><font size="4"><strong>Review Antrian </font></strong></p> 
				   </div>
				   
					<div class="x_content">
						<br>
						<div class="table-responsive">
						 <table class="table table-striped jambo_table bulk_action">
							<thead>
							   <tr class="headings">
								  <th class="column-title">No.</th>
								  <th class="column-title">No. SMU</th>
								  <th class="column-title">View</th>
							   </tr>
							</thead>
							<tbody>
							   <?php
								  $no=1;
								  if (empty($antrian_smu)) { ?>
								  <div class="alert alert-info">Tidak ditemukan data SMU/AWB</div>
								  <?php } else 
								  {
								  foreach ($antrian_smu as $data):
								   ?>
							   <tr class="even pointer">
								  <td class=" "><?php echo $no; ?></td>
								  <td class=" "><?php echo $data->nomor_smu; ?></td>
								  <td class=" "><a href="<?php echo base_url().'/upload/smu/'.$data->nomor_smu .'.jpg';?>" target="_blank" class="alert-success tile-stats" style="text-align: center;">review</a></td>
							   </tr>
							   <?php
								  $no++;
								  endforeach;} 
							   ?>
							</tbody>
						 </table>
					    </div>
						
						  <div class="item form-group">
							<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nomor Antrian</label>
							<div class="col-md-6 col-sm-6 col-xs-12 text-left">
							  <label style="text-align: left;" class="control-label col-md-12 col-sm-12 col-xs-12" for="name"><?php echo $antrian->nomor_antrian; ?></label>
							</div>
						  </div><br>
						  <div class="item form-group">
							<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama RA</label>
							<div class="col-md-6 col-sm-6 col-xs-12 text-left">
							  <label style="text-align: left;" class="control-label col-md-12 col-sm-12 col-xs-12" for="name"><?php echo $nama_agent; ?></label>
							</div>
						  </div><br>
						  <div class="item form-group">
							<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jam Booking</label>
							<div class="col-md-6 col-sm-6 col-xs-12 text-left">
							  <label style="text-align: left;" class="control-label col-md-12 col-sm-12 col-xs-12" for="name"><?php echo $antrian->jam_terpilih; ?></label>
							</div>
						  </div><br>
						  <div class="item form-group">
								<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Ubah Jam Antrian<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
                                 <div class='input-group date' id='myDatepicker2'>
                                 <input type='text' id='date_pic' name='date_pic' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required"/>
                                 <span class="input-group-addon">
                                 <span class="glyphicon glyphicon-calendar"></span>
                                 </span>
                                 </div>
                                </div>
								<div >
								  <button type="button" class="btn btn-primary" onclick="tampil_data_barang()" data-toggle="modal" data-target="#myModal1">Pilih Jam Antrian &raquo;</button>
								  <label id="label_jam_terpilih" style="font-weight: bold; font-size: 16px; text-align: center; color: white;" class="badge badge-light">--:--</label>
								  <!--button name="button" class="btn btn-primary" onclick="tampil_data_barang()">Load &raquo;</button-->
								  <!--select name="show_data1" id="show_data1" class="form-control" style="width: 100px;">
									
								  </select-->
								</div>
						  </div><br>
						  <div class="item form-group">
							<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Time Flight</label>
							<div class="col-md-6 col-sm-6 col-xs-12 text-left">
							  <label style="text-align: left;" id="date_flight" class="control-label col-md-12 col-sm-12 col-xs-12" for="name"><?php echo $antrian->date_flight; ?></label>
							</div>
						  </div><br>
						  <div class="item form-group">
							<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Info</label>
							<div class="col-md-6 col-sm-6 col-xs-12 text-left">
							  <label style="text-align: left;" class="control-label col-md-12 col-sm-12 col-xs-12" for="name"><?php echo $antrian->informasi; ?></label>
							</div>
						  </div><br>
						  <?php echo form_open_multipart('app/approve_antrian/'.$id_antrian, 'class="form-horizontal form-label-left" name="form_input" id="form_input"');?>
						  <input id="jam_terpilih" name="jam_terpilih" type="hidden" required="required" value="">
						  <!--a href="<?php echo base_url().'app/approve_antrian/'.$id_antrian;?>" class="btn btn-primary" style="text-align: center;">Approve</a-->
						  <button type="submit" class="btn btn-primary" onclick="" data-toggle="modal">Approve</button>
						  <!--a href="<?php echo base_url().'app/reject_antrian/'.$id_antrian;?>" class="btn btn-danger" style="text-align: center;">--</a-->
						  
						  <button type="button" class="btn btn-danger" onclick="" data-toggle="modal" data-target="#myModal2">Reject</button>
						  </form>
					</div>
				   
				</div>
				<br><br><br><br><br>
			</div>
			<!-- Finish content-->
			
		</div>
		
		<!--Modal Content-->
		<form data-parsley-validate action="<?php echo base_url().'app/reject_antrian/'.$id_antrian;?>" method="post" name="modal_slot" id="modal_slot" class="form-horizontal form-label-left">
		  <div class="modal fade" id="myModal2" role="dialog">
			 <div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
				   <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h2 class="modal-title">Attention </h2>
				   </div>
				   <div class="modal-body text-center">
					  <h4><font color="Green"><Strong>Note to Regulated Agent </h4><br>
					  <div class="form-group">
						 <label style="text-align: left;" for="informasi" class="control-label col-md-3 col-sm-3 col-xs-12">Note Content</label>
						 <div class="col-md-6 col-sm-6 col-xs-12">
							<textarea name="remark" class="form-control" rows="3" placeholder="Write your information"></textarea>
						 </div>
					  </div>
				   </div>
				   <div class="modal-footer">
					  <button name="btn-submit" id="btn-submit" type="submit" class="btn btn-success">Reject</button>
					  <?php //echo form_submit('submit', 'Finish', 'class="btn btn-primary"'); ?>
					  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				   </div>
				</div>
			 </div>
		  </div>
	    </form>
		
		<div class="modal fade" id="myModal1" role="dialog">
		 <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			   <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h2 class="modal-title">Tentukan jam antrian</h2>
			   </div>
			   <div class="modal-body text-center">
				  <h4><font color="Green"><Strong></h4><br>
				  <div class="form-group">
					<?php
						$no=1;
					?>
						<!-- ajax test -->
						<div class="container">
						<!-- Page Heading -->
								<div class="row" id="ajax_message"></div>
								<div class="row" id="show_data"></div>
						</div>
						<!--button id="button" name="button" class="btn btn-success" onclick="tampil_data_barang()">Load</button--><br>
						<script>
							//fungsi tampil barang
							function tampil_data_barang(){
								var tanggal=$("#date_pic").val();
								var tgl = $("#date_flight").val();
								var ts = new Date($("#date_flight").val());
								var time_flight=ts.getHours()+":"+ts.getMinutes();
								$.ajax({
									type  : 'post',
									url   : '<?php echo base_url()?>/app/jadwal_ngantri',
									async : false,
									dataType : 'json',
									data : {tanggal: tanggal,time_flight: time_flight, tgl_flight: tgl},
									success : function(data){
										//var json = $.parseJSON(data);
										var html = '';
										var i;
										for(i=0; i<data.length; i++){
											html += "<button style='width:20%' data-dismiss='modal' onClick='jam_selected(`"+data[i].name+"`)' class='button"+data[i].Id+"'>"+data[i].name+"</button>";
											//html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
										}
										$('#show_data').html(html);
									}
								});
							}
						</script>

				  </div>
			   </div>
			   <div class="modal-footer">
					<div style="text-align: center;">Diharuskan mengambil antrian kembali jika terlambat lebih dari 5 menit<br>
				  <input id="id_slot" name="id_slot" type="hidden" required="required" value="">
				  <!--button name="btn-submit" id="btn-submit" type="submit" class="btn btn-success">Finish</button-->
				  <?php //echo form_submit('submit', 'Finish', 'class="btn btn-primary"'); ?>
				  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
			   </div>
			</div>
		 </div>
		 <br><br><br>
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
	<!-- bootstrap-datetimepicker -->    
    <script src="<?php echo base_url();?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>src/build/js/custom.min.js"></script>
	
	<script>
		$('#myDatepicker2').datetimepicker({
		    format: 'YYYY-MM-DD',
			maxDate : Date.now()+90000000
        });
		function jam_selected(val) {
			//alert(val+' Selected');
			$('#label_jam_terpilih').text(val);
			document.getElementById('jam_terpilih').value = val;
		}
	</script>
	
  </body>
</html>

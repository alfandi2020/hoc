<!DOCTYPE html>
<html>
<style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
<body>
<div class="x_panel card">
			<div style="direction: row;margin-top:15px;">
			<img src="<?= base_url() ?>img/logo_h.png" width="40" alt="">
			<span style="font-size: 24px;font-weight:bold;"> Harnoko Investama </span>
			</div>
			<!-- <strong><font style="color:blue;font-size:24px;">BANDES</font> <font style="color:green;font-size:24px;">LOGISTIK</font></strong></br> -->
			<!-- <font style="font-size:17px;">PT. Harnoko Logistindo</font></br></br> -->
			
			<div align="center">
				<font style="font-size:17px;">
				E-MEMO INTERN</br>
				No. <?php 
					$array_bln = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
					$bln = $array_bln[date('n',strtotime($memo->tanggal))];
					
					echo sprintf("%03d",$memo->nomor_memo) . '/E-MEMO/' . $memo->kode_nama . '/'.$bln.'/'. date('Y',strtotime($memo->tanggal));
				?>
				<hr/>
				</font>
			</div>
			<font style="font-size:14px;">
			<table class="center">
			<tr>
				<td style="width:30%"><strong>Dari</td>
				<td> : &nbsp;</td>
				<td><?php echo $memo->nama ." (". $memo->nama_jabatan .")"; ?></td>
			</tr>
			<tr>
				<td valign="top"><strong>Kepada&nbsp;&nbsp;&nbsp;</td>
				<td valign="top"> : &nbsp;</td>
				<td>
				<?php 
				$no=0;
				$string = substr($memo->nip_kpd, 0, -1);
				$arr_kpd = explode(";",$string);
				foreach ($arr_kpd as $data):
					$sql="SELECT nama,nama_jabatan FROM users WHERE nip='$data';";
					$query = $this->db->query($sql);
					$result = $query->row();
					echo $result->nama ." (". $result->nama_jabatan .")";
					echo "</br>";
					$no++;
				endforeach;
				?></td>
			</tr>
			<tr>
				<td valign="top"><strong>Tembusan&nbsp;&nbsp;&nbsp;</td>
				<td valign="top"> : &nbsp;</td>
				<td>
				<?php 
				$no=0;
				if (!empty($memo->nip_cc)){
					$string = substr($memo->nip_cc, 0, -1);
					$arr_kpd = explode(";",$string);
					foreach ($arr_kpd as $data):
						$sql="SELECT nama,nama_jabatan FROM users WHERE nip='$data';";
						$query = $this->db->query($sql);
						$result = $query->row();
						echo $result->nama ." (". $result->nama_jabatan .")";
						echo "</br>";
						$no++;
					endforeach;
				}else{echo "--";};
				?></td>
			</tr>
			<tr>
				<td style="width:30%"><strong>Perihal</td>
				<td> : </td>
				<td><?php echo $memo->judul; ?></td>
			</tr>
			</table>
			<hr/>
			</br>
			
			<table>
			<tr>
				<td style="word-wrap: break-word; text-align:justify;" width="100%"><?php echo $memo->isi_memo; ?></td>
			</tr>
			</table></br></br>
			
			<table>
			<tr>
				<td width="80%">Jakarta, <?php $date = $memo->tanggal; echo $newDate = date("d F Y", strtotime($date));?></td><td></td>
			</tr>
			<tr>
				<td>Dibuat oleh,</td>
				<?php if (($this->session->userdata('level_jabatan') >= 2) AND ($memo->nip_dari <> $this->session->userdata('nip'))){?>
					<td></td>
				<?php } ?>
			</tr>
			
			<!-- <?php if (($this->session->userdata('level_jabatan') >= 1) AND ($memo->nip_dari <> $this->session->userdata('nip'))){?>
				<tr style="height:100px;">
					<td style="vertical-align:bottom"><?php echo $memo->nama;?></td>
					<td style="vertical-align:bottom">
					<form action="<?php echo base_url()."app/create_memo_approve/".$memo->Id ."/x"; ?>" target="">
						<button type="submit" class="btn btn-primary">Replay</button>
					</form>
					</td>
					<td style="vertical-align:bottom">
					<form action="<?php echo base_url()."app/create_memo_approve/".$memo->Id; ?>" target="">
						<button type="submit" class="btn btn-primary">Replay All</button>
					</form>
					</td>
					<td style="vertical-align:bottom"><a href="<?= base_url('app/memo_pdf/'.$memo->Id) ?>" class="btn btn-warning">Cetak PDF</a></td>
				</tr>
			<?php } else {?>
				<tr style="height:100px;">
					<td style="vertical-align:bottom"><?php echo $memo->nama;?></td>
				</tr>
			<?php }?> -->
			</table>
			<br>
			<table>
			<tr>
				<td>Attachment : </td>
			</tr>
			<?php if (!empty($memo->attach)){?>
			<tr>
				<td>
					<?php 
					$attach_ = ''; $no='1';
					$attch1 = explode(";",$memo->attach);
					$attch2 = explode(";",$memo->attach_name);

					foreach (array_combine($attch1, $attch2) as $attch1 => $attch2) {
						if (!empty($attch1)){
							$attach_ .= "<a href='"."/upload/att_memo/".$attch1."' target='_blank'>".$no.'. '.$attch2."</a></br>\n";
							$no++;
						}
					}
					echo $attach_;
					// foreach($attch2 as $data) {
						// $data = trim($data);
						// $attach_ .= "<a href='"."/upload/att_memo/".$data."'>".$no.'. '.$data."</a></br>\n";
						// $no++;
					// }
					?>
				</td>
			</tr>
			<?php } ?>
			</table>
			</font>
			
			
		</div> 
</body>

</html>

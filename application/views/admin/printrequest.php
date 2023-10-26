    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
        <div class="col-sm-4 ">
<?php
// Previous button 
$sql ="SELECT * FROM quotations WHERE status = 'Lead' AND id<$data->id ORDER BY id DESC";
$query = $this->db->query($sql);
$row1= $query->result();
if($row1 != false)
{
    $row1 = $query->result()[0];
  echo '<a href="'.base_url("admin/printrequest/".$row1->id."").'" class="btn btn-outline-primary take-btn"><i class="fa fa-arrow-left"></i> Previous</a>';  
} 

// Next button 
$sql ="SELECT * FROM quotations WHERE status = 'Lead' AND id>$data->id ORDER BY id ASC";
$query = $this->db->query($sql);
$row1= $query->result();
if($row1 != false)
{
    $row1 = $query->result()[0];
    echo '<a href="'.base_url("admin/printrequest/".$row1->id."").'" class="btn btn-outline-primary take-btn">Next <i class="fa fa-arrow-right"></i> </a>';  
} 

?>

            </div>
            <div class="col-sm-4 text-right">
            
                <a href="<?= base_url('admin/printsquotation/'.$id ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;<?= ($data->sbqstatus == "yes"  ? "" : "display:none;") ?>"><b>Print Quotation [Single Brand]</b></span>
                </a>
                <a href="<?= base_url('admin/printquotation/'.$id ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;<?= ($data->mbqstatus == "yes"  ? "" : "display:none;") ?>"><b>Print Quotation [Multiple Brand]</b></span>
                </a>                
			</div>
            <div class="col-sm-4 text-right">
            <a href="<?= base_url('admin/user/'.$data->userid ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;"><b>Edit User</b></span>
                </a>&nbsp;
                <button class="btn btn-success" onclick="printDiv('printDiv_Invoice')" style=""> <i class="fa fa-print fa-lg"></i> Print</button>
                <!-- <button class="btn btn-success" onclick="saveAsPDF('printDiv_Invoice')" style="margin-left:20px"> <i class="fa fa-file-pdf-o fa-lg"></i> PDF</button>             -->
                <button class="btn btn-success" onclick="saveAsImage('printDiv_Invoice')" style="margin-left:20px"> <i class="fa fa-file-image-o fa-lg"></i> Image</button>            
			</div>
            <div class="col-sm-12"><br /></div>
        </div>
        <div class="card-box">            
            <div id="printDiv_Invoice" style="width:1000px; background-color:white; color:black;">
                <style>
                    tr.border_bottom td {
                    border-bottom:groove;
                    color:black;
                    }
                    
                </style>
                <div style="border-style:groove;padding:10px;">
                    <table style="width:100%;color:black">
                    
                        <tr>
                            <td style="width:20%">
                                <img src="<?= base_url($firm->firmicon == "" ? "assets/PIPL":'assets/'.$firm->firmicon.'.png');?>" alt="<?= $firm->firm;?>"
                                    height="120"  style="margin:auto;display:block">
                            </td>
                            <td style="width:60%">
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:1-0%;text-align:center;">
                                            <h1 style="color:<?= $firm->firmcolor == '' ? '#F89504' : $firm->firmcolor; ?>;" ><?= $firm->firm;?></h1>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            <?= $firm->address;?><br />
                                            Email - <?= $firm->email;?><br />
                                            Tel - <?= $firm->telephone;?> Mob - <?= $firm->mobileno;?><br />
                                            <b>GSTIN - <?= $firm->gst;?></b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:20%">
                            <!-- <img src="<?= base_url('assets/icon/psc.png');?>"
                                    height="120" alt="" style="margin:auto;display:block"> -->
                            </td>
                        </tr>
                    </table>
                    <hr style="background-color:gray">
                    <table style="width:100%">
                        <tr>
                            <td style="width:10%;text-align:center;">
                                <h3><u> LEAD </u></h3>
                            </td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr class="border_bottom" style="width:100%;">
                            <td style="width:50%;text-align:left; vertical-align:top;">
                            <h4>Firm : <b><?= $data->firmname; ?></b> </h4>
                                <?php 
                                if($data->username !=""){
                                    echo "<h5>Name : ". $data->username."</h5>";
                                }
                                ?>
                                <?php 
                                if($data->mobileno !=""){
                                    echo "<h5>Mob No. : <a href='https://wa.me/91".str_replace(' ', '', $data->mobileno)."' target='_blank' title='Click to chat'> ". $data->mobileno."</a></h5>";
                                }
                                ?>
                                <?php 
                                if($data->address !="" || $data->city !=""){
                                    echo "<h5>Address. : ". $data->address." - ".$data->city." - ".$data->state."</h5>";
                                }
                        
                                ?>
                                
                            </td>
                            <td style="width:50%;text-align:right;margin-right:100px;vertical-align:top;">
                                <!-- <b> Lead No : <?= $data->id; ?> </b><br /> -->
                                <?php $leadno = substr("00000{$data->leadno}", -6); ?>
                                <h5>Lead No : PIPL/LEAD/<?= $leadno; ?>/<?= date("d-m-y", strtotime($data->requestdate)); ?></h5>
                                <b> Date : <?= date_format(date_create($data->requestdate), 'd/m/Y') ?> </b>
                            </td>
                        </tr>
                    </table>   
                    <br>  
                       
                    <table style="width:100%;border: 2px solid gray;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="color:black;border: 2px solid gray;border-collapse: collapse;text-align: center">No</th>
                                <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px">Category</th>
                                <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px">Product</th>
                                <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">Req</th>
                                <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px">Unit</th>
                                <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">
                                <!-- Weight (Kg) -->
                                Quantity
                            </th>
                            <!-- <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:5px; text-align:left;">
                                Billing in
                            </th> -->
                                <!-- <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;"></th> -->
                                <th style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px">Narration</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 1;
                                $qbpcount = 1;
                                $totalWeight = 0;
                                foreach ($result as $row) {
                                    $totalWeight += $row->weight;
                                    ?>
                                <tr>
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;text-align: center"><?php echo $count; ?></td>
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px"><?= $row->productname; ?></td>
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px"><?= $row->sizeinmm; ?></td>
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->estimationin == "Kgs" ? "" : $row->quantities; ?></td> 
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px"><?= $row->estimationin; ?></td>
                                    <!-- <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;"><?= number_format($row->weight, 1)."/".$row->billingin; ?></td> -->
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->billingin == "Kgs" ? number_format($row->weight, 1)."  ".$row->billingin : $row->quantities."  ".$row->billingin; ?></td>
                                    <!-- <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px"><?= $row->billingin; ?></td> -->
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-left:10px"><?= $row->narration; ?></td>
                                </tr>
                                <?php ++$count;
                                }?>
                                <tr>
                                    <td colspan="5" style="text-align:right">
                                    <b>Total Weight : </b>
                                </td>
                                    <td style="color:black;border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">
                                    <b><?= number_format($totalWeight, 1)." Kg"; ?></b>
                                </td>
                                    <td></td>
                                </tr>
                        </tbody>
                    </table>
                    <hr>
                    
                    <table style="width:100%; color:black;border: 2px solid gray;border-collapse: collapse;">
                        <tr>
                            <td style="width:100%">
                                <?= $data->enquirydetails;?>
                                
                                </td>  
                        </tr>
                        <tr>
                            <td style="100%">
                                <?php if($data->enquirypic !=''){?>
                                <a href="<?= base_url('enquirypics/'.$data->enquirypic.'.png');?>" target="_blank"><img src="<?= base_url('enquirypics/'.$data->enquirypic.'.png');?>" alt="" style="height:200px"></a>
                                
                                <?php } if($data->enquirypic1 !=null){?>
                                <a href="<?= base_url('enquirypics/'.$data->enquirypic1.'.png');?>" target="_blank"><img src="<?= base_url('enquirypics/'.$data->enquirypic1.'.png');?>" alt="" style="height:200px"></a>
                                
                                <?php }?>
                            </td>
                        </tr>
                    </table>  
                   
                    <!-- <table style="width:100%"> 
                        <tr style="width:100%">
                            <td style="width:100%;text-align:center">
                                    <hr>
                                    <img src="<?= base_url('assets/icon/tata.png'); ?>" alt="" height="35" style="margin-right:45px;margin-left:10px   "> 
                                    <img src="<?= base_url('assets/icon/tata-pipes.png'); ?>" alt="" height="35" style="margin-right:45px"> 
                                    <img src="<?= base_url('assets/icon/Steel_Authority_of_India.png'); ?>" alt="" height="35" style="margin-right:45px"> 
                                    <img src="<?= base_url('assets/icon/am.png'); ?>" alt="" height="35" style="margin-right:45px"> 
                                    <img src="<?= base_url('assets/icon/Jindal_Steel_and_Power.png'); ?>" alt="" height="35" style="margin-right:45px"> 
                                    <img src="<?= base_url('assets/icon/vizag-steel.png'); ?>" alt="" height="35" style="margin-right:45px"> 
                                    <img src="<?= base_url('assets/icon/JSW.png'); ?>" alt="" height="35" style="margin-right:45px"> 
                                    <img src="<?= base_url('assets/icon/rajuri.png'); ?>" alt="" height="35" style="margin-right:45px"> 
                                    <br><br>
                                    <h4 style="color:#f37800;">One Stop Solution for Variety of Branded Steel</h4>
                            </td>
                        </tr>
                    </table> -->
            </div>
        </div>
    </div>    
	<a class="btn btn-danger pull-left" href="<?= base_url('admin/editrequest/'.$id); ?>" style="color:white;" ><i class="fa fa-arrow-left fa-lg"></i> Edit Lead</a>
    <a class="btn btn-danger pull-right" href="<?= base_url('admin/squotation/'.$id); ?>" style="color:white;margin-left:10px;" ><i class="fa fa-arrow-right fa-lg"></i> Single Brand Quotation</a>
	<a class="btn btn-danger pull-right" href="<?= base_url('admin/quotation/'.$id); ?>" style="color:white;" ><i class="fa fa-arrow-right fa-lg"></i> Multiple Brand Quotation</a>
    <br/>
    <br/><br/>
    <?php 
    date_default_timezone_set('Asia/Kolkata');
    $now = date('Y-m-d H:i:s'); 
    ?>
</div>
<script> 
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function saveAsImage(divName)
    {
        html2canvas([document.getElementById(divName)], {
            onrendered: function (canvas) {
        var a = document.createElement('a');
        // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
        a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
        a.download = '<?= "LD_".substr($data->firmname,0,11)."".date_format(date_create($data->requestdate), 'ymd') ?>.jpg';
        a.click();
      }
});
    }
    function saveAsPDF(divName)
    {
        html2canvas([document.getElementById(divName)], {
            onrendered: function (canvas) {
        
        var imgData = canvas.toDataURL('image/png');
                var doc = new jsPDF("l", "mm", "a4");
                doc.addImage(imgData, 'PNG', 10, 10);
                var name = '<?= "LD_".substr($data->firmname,0,11)."".date_format(date_create($data->requestdate), 'ymd') ?>.pdf';
                doc.save(name);

        
      }
});
    }
</script>

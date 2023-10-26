<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
<?php
// Previous button 
$sql ="SELECT * FROM quotations WHERE sbqstatus = 'yes' AND id<$data->id ORDER BY id DESC";
$query = $this->db->query($sql);
$row1= $query->result();
if($row1 != false)
{
    $row1 = $query->result()[0];
//   echo '<a href="'.base_url("admin/printsquotation/".$row1->id."").'" class="btn btn-outline-primary take-btn"><i class="fa fa-arrow-left"></i> Previous</a>';  
} 

// Next button 
$sql ="SELECT * FROM quotations WHERE sbqstatus = 'yes' AND id>$data->id ORDER BY id ASC";
$query = $this->db->query($sql);
$row1= $query->result();
if($row1 != false)
{
    $row1 = $query->result()[0];
    // echo '<a href="'.base_url("admin/printsquotation/".$row1->id."").'" class="btn btn-outline-primary take-btn">Next <i class="fa fa-arrow-right"></i> </a>';  
} 

?>

            </div>
            <div class="col-sm-8 text-right">
            <!-- <a href="<?= base_url('admin/user/'.$data->userid ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;"><b>Edit User</b></span>
                </a>&nbsp; -->
                <?php
					if(!isset($_GET["printamount"]))
					{
						
                        echo '<a href="'.base_url("admin/printproforma/$id").'?printamount=no">
						<span class="custom-badge status-green" style="padding:10px;"><b>Print Without Amount</b></span>
					</a>';
					}
					else{
						echo '<a href="'.base_url("admin/printproforma/$id").'">
						<span class="custom-badge status-green" style="padding:10px;"><b>Print With Amount</b></span>
					</a>';
					}
				?>&nbsp;&nbsp;
                <button class="btn btn-success pull-right" onclick="sendonwhatsapp('printDiv_Invoice')" style="margin-left:20px"> <i class="fa fa-whatsapp fa-lg"></i> Send</button>
            <button class="btn btn-success pull-right" onclick="saveAsImage('printDiv_Invoice')" style="margin-left:20px"> <i class="fa fa-file-image-o fa-lg"></i> Image</button>
            <button class="btn btn-success pull-right" onclick="printDiv('printDiv_Invoice')" style=""> <i class="fa fa-print fa-lg"></i> Print</button>
            <!-- <a class="btn btn-success pull-right" href="<?= base_url("admin/printproforma/".$id); ?>" style="color:white;margin-right:10px">Profarma</a> -->

            
            </div>
        </div>
        <div class="card-box">            
            <div id="printDiv_Invoice" style="width:1000px; background-color:white; color:black;">
                <style>
                    tr.border_bottom td {
                    border-bottom:groove;
                    }
                </style>
                <div style="border-style:groove;padding:10px;">
                    <!-- Print Header  -->
                    <table style="width:100%">
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
                                <!-- <img src="<?= base_url('assets/icon/psc.png');?>" height="120" alt=""
                                    style="margin:auto;display:block"> -->
                            </td>
                        </tr>
                    </table>
                    <hr >
                    <table style="width:100%">
                        <tr>
                            <td style="width:1-0%;text-align:center;">
                                <h3><u> PROFORMA &nbsp;&nbsp;INVOICE </u></h3>
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
                                    echo "<h5>Mob No. : ". $data->mobileno."</h5>";
                                }
                                ?>
                                <?php 
                                if($data->address !="" || $data->city !=""){
                                    echo "<h5>Address. : ". $data->address."  ".$data->city."</h5>";
                                }
                        
                                ?>
                            </td>
                            <td style="width:50%;text-align:right;margin-right:100px;vertical-align:top;"><br/>
                                <b>Proforma Date : <?= date("d-m-Y", strtotime($data->createdon)); ?> <br/>
                                <?php $qno = substr("000{$data->sbqno}", -4); ?>
                                <h5>Proforma No : PIPL/SBQ/<?= $qno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?></h5></b>
                                <?php if($data->vehicleno !==""){
                                                ?><br/>
                                                <b>Vehicle Number : <?= $data->vehicleno;?></b>
                                            <?php } ?>
                            <?php if($data->narration !==""){
                                ?>
                                <b>Enquiry Ref. - </b> <?= $data->narration;?>
                            <?php } ?>
                                
                            </td>
                        </tr>
                    </table>   
                    <br>       
                    <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black;border-collapse: collapse;text-align: center">No</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Prooduct</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Size</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">Narration</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Req</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Unit</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">Producer</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Quantity</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Rate</th>
                                <!-- <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Amount</th> -->
                                <?php
                                    if(!isset($_GET["printamount"]))
                                    {
                                        echo '<th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Amount</th>';
                                    }
                                ?>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 1;
                                $qbpcount = 1;
                                foreach ($result as $row) {
                                    ?>
                                <tr>
                                    <td style="border: 1px solid black;border-collapse: collapse;text-align: center"><?php echo $count; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->productname; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->sizeinmm; ?></td>
                                    
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px;"><?= $row->narration; ?>
                                    
                                   </td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->estimationin == "Kgs" ? "" : $row->quantities; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->estimationin; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">
                                    <?php
                                        
                                        

                                        $rate = $row->rate;
                                        $query = "SELECT name AS svalue FROM brands WHERE id = " . $row->brandid;
                                        $name = $this->dbmodel->getsinglevalue($query);
                                        //echo $name." - ". number_format($rate, 2) ."  &#8377;";                                        
                                        echo $name;                                        
                                    ?>
                                   </td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->billingin == "Kgs" ? number_format($row->weight, 1)."  ".$row->billingin : $row->quantities."  ".$row->billingin; ?></td>
                                    
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= " &#8377 ". number_format($rate, 2)."/". $row->billingin; ?></td>
                                    <?php
                                    if(!isset($_GET["printamount"]))
                                    {
                                        echo '<td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">' . number_format($row->amount, 2) . '  &#8377;</td>';
                                    } ?>
                                    
                                </tr>
                                <?php ++$count;
                                }?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="pull-right"><b>Total Weight :  </b></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><b><?= number_format($data->totalweight, 1)." Kg"; ?></b></td>
                                
                                    <td></td>
                                    <?php
                                        if(!isset($_GET["printamount"]))
                                        {
                                            echo '<td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">' . number_format($data->subtotal, 2) . '  &#8377</td>';
                                        }
                                    ?>
                                    
                                </tr>
                        </tbody>
                    </table>
                   
                    

                    <?php
                        if(!isset($_GET["printamount"]))
                            echo '<table style="width:100%;">';
                        else
                            echo '<table style="width:100%; display:none;">';
                    ?>
                        <tr style="width:100%;">
                            <td style="width:55%;vertical-align:top;">
								<p><br />
							   Account : <b><?= $firm->firm;?></b><br>
                               Acc No  : <b><?= $firm->accno;?></b><br>
                               IFSC    : <b><?= $firm->ifsc;?></b><br>
                               Bank    : <b><?= $firm->bank;?></b><br>
                               Branch  : <b><?= $firm->branch;?></b></p>
							   
							   <b>Term and Conditions:</b><br />
							   <ol>
								<li>GST @ 18% applicable extra on all above rates.</li>
								<li>All Above Rates Are Ex Our Shiroli Godown Delivery/ For Full Load Quantity Site Delivery Negotiable.</li>
								<li>Rates Are Valid For SAME Day Only subject to Market Fluctuation.</li>
								</ol>
                            </td>
                            <td style="width:45%;">                            
                                <table class="table custom-table" style="width:100%;border: 1px solid black;font-size: 16px">
                                    <tbody>
                                        <tr style="width:100%;">                                        
                                            <td style="text-align:left; width:70%;">
                                                Loading Charges (<?= $data->loading; ?>):<br />
                                                Cutting Charges :<br />
                                                Freight Charges (<?= $data->paidby ?>):<br />
                                                Other Charges : <br />
                                                GST(18%) : <br />
                                                Round Off : <br /><hr/>
                                                <b>Total :</b> <br />
                                            </td>
                                            <td style="text-align:right; width:30%;">
                                                <?= number_format($data->lcharges, 2) ."  &#8377;"; ?><br />
                                                <?= number_format($data->ccharges, 2) ."  &#8377;"; ?><br />
                                                <?= number_format($data->fcharges, 2) ."  &#8377;"; ?><br />
                                                <?= number_format($data->ocharges, 2) ."  &#8377;"; ?><br />
                                                <!-- <?= number_format($data->ocharges, 2) ."  &#8377;"; ?><br /> -->
                                                <?= number_format($data->gst, 2) ."  &#8377;"; ?><br />
                                                <?= number_format($data->roundoff, 2) ."  &#8377;"; ?><br /><hr/>
                                                <b><?= "<b>". number_format($data->total, 2) ."  &#8377;</b>"; ?></b><br />
                                            </td>
                                            <!--<td style="width:120px;"></td>-->
                                        </tr>                                        
                                    </tbody>
                                </table>
                                <br><br>
                                <h5 style="text-align:right;"><b>For <?= $firm->firm;?></b></h5>
                            </td>
                        </tr>
                        <tr style="width:100%">
                        <td style="width:100%;text-align:center" colspan=2>
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
                        
                    </table>
                    <?php
                        if(!isset($_GET["printamount"]))
                            echo '<table class="table custom-table" style="width:100%; display:none;">';
                        else
                            echo '<table class="table custom-table" style="width:100%;">';
                    ?>                    
                        <tbody>
                            <tr style="width:100%;">
                                <td style="text-align:center; width:100%;">
                                   <b style="font-size:18px"> Loading Charges : ( <?= $data->loading; ?> )</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                   <b style="font-size:18px"> Freight Charges : ( <?= $data->paidby ?> )</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                   <b style="font-size:18px">  Vehicle No : ( <?= $data->vehicleno; ?> )</b> 
                                </td>
                            </tr>
                            <tr>                                
                                <td style="text-align:right;">
                                    <br /><br />
                                    <h5><b>For <?= $firm->firm;?></b></h5>
                                </td>              
                            </tr>
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
                        </tbody>
                    </table>
                    
                    <hr>
                    <!-- <?php $this->load->view('admin/printfooter');?> -->
            </div>
        </div>
    </div>
    
    <!-- <a class="btn btn-danger pull-left" href="<?= base_url('admin/editsquotation/'.$id); ?>" style="color:white;" ><i class="fa fa-arrow-left fa-lg"></i> Edit Single Brand Quotation</a> -->
    <?php
        if($data->dostatus != "yes")
        {
            // echo '<a class="btn btn-danger pull-right" href="' .  base_url('admin/preparedo/'.$id) . '" style="color:white;" onclick="return confirm(\'Are you sure you want prepare DO ?\');" >Prepare D.O. <i class="fa fa-arrow-right fa-lg"></i> </a>';
        }
    ?>
    
<br/><br/><br/>
</div>
<?php 
    date_default_timezone_set('Asia/Kolkata');
    $now = date('Y-m-d H:i:s'); 
    ?>
    <script>
        function sendonwhatsapp(divName) {
            var confirmation = confirm("are you sure you want to send on whatsapp ?");
            if (confirmation) {
            html2canvas([document.getElementById(divName)], {
            onrendered: function(canvas) {
            document.body.appendChild(canvas);
            var data = canvas.toDataURL('image/png');       
            $.ajax({
                    type:'POST',
                    url:'<?= base_url('admin/sendQuotation');?>',
                    data: {'img': data, 'id': <?= $id ?>,'mobileno':<?= $data->mobileno ?>},
                    success:function(html){
                        const context = canvas.getContext('2d');
                        context.clearRect(0, 0, canvas.width, canvas.height);
                    }
                });
            }
        });
        }
    }
</script>
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
        a.download = '<?= "QT_".substr($data->firmname,0,16)."".date_format(date_create($data->createdon), 'ymd') ?>.jpg';
        a.click();
      }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
        <div class="col-sm-6 ">
<?php
// Previous button 
// $sql ="SELECT * FROM orders WHERE  id<$data->id ORDER BY id DESC";
// $query = $this->db->query($sql);
// $row1= $query->result();
// if($row1 != false)
// {
//     $row1 = $query->result()[0];
//   echo '<a href="'.base_url("admin/printorder/".$row1->id."").'" class="btn btn-outline-primary take-btn"><i class="fa fa-arrow-left"></i> Previous</a>';  
// } 

// Next button 
// $sql ="SELECT * FROM orders WHERE id>$data->id ORDER BY id ASC";
// $query = $this->db->query($sql);
// $row1= $query->result();
// if($row1 != false)
// {
//     $row1 = $query->result()[0];
//     echo '<a href="'.base_url("admin/printorder/".$row1->id."").'" class="btn btn-outline-primary take-btn">Next <i class="fa fa-arrow-right"></i> </a>';  
// } 

?>

            </div>
            <div class="col-sm-6 text-right">
                <!-- <a href="<?= base_url('admin/editorder/'.$id ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;"><b>Edit Order</b></span>
				</a>

				<?php
					// if(isset($_GET["printamount"]))
					// {
					// 	echo '<a href="'.base_url("admin/printorder/$id ").'">
					// 	<span class="custom-badge status-green" style="padding:10px;"><b>Print Without Amount</b></span>
					// </a>';
					// }
					// else{
					// 	echo '<a href="'.base_url("admin/printorder/$id").'?printamount=yes">
					// 	<span class="custom-badge status-green" style="padding:10px;"><b>Print With Amount</b></span>
					// </a>';
					// }
				?> -->

<button class="btn btn-success pull-right" onclick="sendonwhatsapp('printDiv_Invoice')" style="margin-left:10px"> <i class="fa fa-whatsapp fa-lg"></i> Send</button>
                <button class="btn btn-success pull-right" onclick="saveAsImage('printDiv_Invoice')" style="margin-left:10px"> <i class="fa fa-file-image-o fa-lg"></i> Image</button>
                <button class="btn btn-success" onclick="printDiv('printDiv_Invoice')" style=""> <i class="fa fa-print fa-lg"></i> Print</button>
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
                            <td style="width:1-0%;text-align:center;">
                                <h1 style="color:brown;"><?= $firm->firm;?></h1>         
                            </td>
                        </tr>
                        <tr class="border_bottom">
                            <td style="text-align:center;" >
                            <?= $firm->address;?><br />
                                Email - <?= $firm->email;?><br/>
                                Tel - <?= $firm->telephone;?> Mob - <?= $firm->mobileno;?><br/>
                                <b>GSTIN - <?= $firm->gst;?></b>
                            </td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr>
                            <td style="width:1-0%;text-align:center;">
                                <h3 style="color:red;"><u> DELIVERY ORDER </u></h3>
                                <!-- <?php $orderno = substr("000{$data->orderno}", -4); ?>
                                <h5><u>PIPL/<?= $orderno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?></u></h5> -->
                            </td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr style="width:100%;">
                            <td style="width:40%;text-align:left; vertical-align:top;">
                                
                                <h4>Firm : <b><?= $data->firmname; ?></b> </h4>
                                <?php 
                                if($data->name !=""){
                                    echo "<h5>Name : ". $data->name."</h5>";
                                }
                                ?>
                                <?php 
                                if($data->mobileno !=""){
                                    echo "<h5>Mob No. : <a href='https://wa.me/91".str_replace(' ', '', $data->mobileno)."' target='_blank' title='Click to chat'>". $data->mobileno."</a></h5>";
                                }
                                ?>
                                <?php 
                                if($data->address !="" || $data->city !=""){
                                    echo "<h5>Address. : ". $data->address."  ".$data->city."</h5>";
                                }
                        
                                ?>
                                <?php 
                                if($data->gstno !=""){
                                    echo "<h5>GST No. : ". $data->gstno."</h5>";
                                }
                                ?>
                                
                                 

                            </td>
                            <td class="pull-right" style="width:60%;text-align:right;border:none">
                                 

                            <table>
                             
                                    <!--<tr style="border:none">-->
                                    <!--    <td style="border:none">Date : </td>-->
                                    <!--    <td style="border:none"><b><?= date('d-m-Y');?> </b></td>-->
                                    <!--</tr>-->
                                    <tr>
                                    <?php $orderno = substr("000{$data->orderno}", -4); ?>
                                        <td style="border:none">Order No : </td>
                                        <td style="border:none;text-align:left"><b>PIPL/<?= $orderno; ?> - <?= $dispatch->srno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?> </b></td>
                                    </tr>
                                    <tr style="border:none">
                                        <td style="border:none">D. O. Date : </td>
                                        <td style="border:none;text-align:left"><b><?= date("d-m-Y", strtotime($data->createdon)); ?> </b></td>
                                    </tr>

                                    <?php
                                            if($data->ponumber !="")
                                             {
                                    ?>
                                                <tr>
                                                    <td style="border:none">PO Number : </td>
                                                    <td style="border:none;text-align:left"><b><?= $data->ponumber;?></b></td>
                                                </tr>
                                            

                                    <?php 
                                             }
                                    if($data->paymentmode !="")
                                            {
                                        ?>
                                    <tr>
                                        <td style="border:none">Payment Mode : </td>
                                        <td style="border:none;text-align:left"><b><?= $data->paymentmode;?></b></td>
                                    </tr>
                                  
                                    
                                    <?php 
                                            }
                                    if($data->paymentdetails !=""){
                                        ?>
                                    <tr style="text-align:left">
                                        <td style="border:none">Payment Details : </td>
                                        <td style="border:none;text-align:left"><b><?= $data->paymentdetails;?></b></td>
                                    </tr>
                                   
                                    <?php }
                                    
                                            if($data->vehicleno !=""){
                                                ?>
                                            <tr style="text-align:left">
                                                <td style="border:none">Vehicle Number : </td>
                                                <td  style="border:none;text-align:left"><b><?= $data->vehicleno;?></b></td>
                                            </tr>
                                            <?php } 
                                    
                                    if($data->narration !==""){ ?>
                                    

                                    <tr style="text-align:left">
                                                <td style="border:none">Enquiry Ref. : </td>
                                                <td  style="border:none;text-align:left"><b><?= $data->narration;?></b></td>
                                            </tr>

                            <?php } ?>
                                    
                                </table>


                            </td>
                        </tr>
                        
                    </table>   
                    <br>       
                    <table style="width:100%; border: 1px solid black;border-collapse: collapse; font-size:medium;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black;border-collapse: collapse;text-align: center">No</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Category</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Product</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px; min-width:120px;">Narration</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Req</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Unit</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">Producer</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Quantity</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count = 1;
                                $qbpcount = 1;
                                foreach ($result as $row) {
                                    ?>
                                <tr>
                                    <td style="border: 1px solid black;border-collapse: collapse;text-align: center; padding:5px;"><?php echo $count; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->product; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->sizeinmm; ?></td><td style="border: 1px solid black;border-collapse: collapse;padding-right:10px;"><?= $row->narration; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->estimationin == "Kgs" ? "" : $row->quantities; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->estimationin; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->brandname; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->billingin == "Kgs" ? number_format($row->weight, 1)."  ".$row->billingin : $row->weight."  ".$row->billingin; ?></td>
                                    
                                    
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
                                    <td style="text-align:center"><b>Total wt. </b></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><b><?= number_format($data->totalweight, 1); ?></b></td>
                                    <td></td>
                                    
                                    
                                </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <tr style="width:100%;">
                            <td style="width:55%;">
                            <br><br>
                           <span style="font-size:10px"> Dispatch <?= $dispatch->srno; ?>   </span>                         </td>
                            <td style="width:45%;">                            
                                
                                <br><br>
                                <h5 style="text-align:right;"><b>For <?= $firm->firm;?></b></h5>
                            </td>
                        </tr>
                        
                    </table>
                    
            </div>
        </div>
    </div>
    
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
                    url:'<?= base_url('admin/sendOrder');?>',
                    data: {'img': data, 'id': <?= $id ?>,'mobileno':<?= $data->mobileno ?>},
                    success:function(html){
                        const context = canvas.getContext('2d');
                        context.clearRect(0, 0, canvas.width, canvas.height);
                        $('#snackbar').html("Sent successfully").fadeIn('slow') //also show a success message 
                        $('#snackbar').delay(5000).fadeOut('slow');
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
        a.download = '<?= "DO_". substr($data->firmname,0,16)."".date_format(date_create($data->createdon), 'ymd') ?>.jpg';
        a.click();
      }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 ">
                <?php
// Previous button 
$sql ="SELECT * FROM orders WHERE  id<$data->id ORDER BY id DESC";
$query = $this->db->query($sql);
$row1= $query->result();
if($row1 != false)
{
    $row1 = $query->result()[0];
  echo '<a href="'.base_url("admin/printorder/".$row1->id."").'" class="btn btn-outline-primary take-btn"><i class="fa fa-arrow-left"></i> Previous</a>';  
} 

// Next button 
$sql ="SELECT * FROM orders WHERE id>$data->id ORDER BY id ASC";
$query = $this->db->query($sql);
$row1= $query->result();
if($row1 != false)
{
    $row1 = $query->result()[0];
    echo '<a href="'.base_url("admin/printorder/".$row1->id."").'" class="btn btn-outline-primary take-btn">Next <i class="fa fa-arrow-right"></i> </a>';  
} 

?>

            </div>
            <div class="col-sm-6 text-right">
                <a href="<?= base_url('admin/editorder/'.$id ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;"><b>Edit Order</b></span>
                </a>

                <?php
					if(isset($_GET["printamount"]))
					{
						echo '<a href="'.base_url("admin/printorder/$id ").'">
						<span class="custom-badge status-green" style="padding:10px;"><b>Print Without Amount</b></span>
					</a>';
					}
					else{
						echo '<a href="'.base_url("admin/printorder/$id").'?printamount=yes">
						<span class="custom-badge status-green" style="padding:10px;"><b>Print With Amount</b></span>
					</a>';
					}
				?>

                <button class="btn btn-success pull-right" onclick="sendonwhatsapp('printDiv_Invoice')"
                    style="margin-left:10px"> <i class="fa fa-whatsapp fa-lg"></i> Send</button>
                <!-- <button class="btn btn-success" onclick="saveAsPDF('printDiv_Invoice')" style="margin-left:20px"> <i class="fa fa-file-pdf-o fa-lg"></i> PDF</button>             -->
                <button class="btn btn-success pull-right" onclick="saveAsImage('printDiv_Invoice')"
                    style="margin-left:10px"> <i class="fa fa-file-image-o fa-lg"></i> Image</button>
                <button class="btn btn-success" onclick="printDiv('printDiv_Invoice')" style=""> <i
                        class="fa fa-print fa-lg"></i> Print</button>
            </div>
        </div>
        <div class="card-box">
            <div id="printDiv_Invoice" style="width:1000px; background-color:white; color:black;">
                <style>
                tr.border_bottom td {
                    border-bottom: groove;
                }
                </style>
                <div style="border: 2px groove gray;padding:10px;">
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
                    <hr style="background-color:gray">
                    <table style="width:100%">
                        <tr>
                            <td style="width:1-0%;text-align:center;">
                                <h3><u> DELIVERY ORDER </u></h3>
                               
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
                                    echo "<h5>Address. : ". $data->address." - ".$data->city." - ".$data->state."</h5>";
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
                                        <td style="border:none;text-align:left">
                                            <b>PIPL/<?= $orderno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?>
                                            </b></td>
                                    </tr>
                                    <tr style="border:none">
                                        <td style="border:none">D. O. Date : </td>
                                        <td style="border:none;text-align:left">
                                            <b><?= date("d-m-Y", strtotime($data->createdon)); ?> </b></td>
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
                                        <td style="border:none;font-size:17px"> Vehicle Number : </td>
                                        <td style="border:none;text-align:left;font-size:17px"><b><?= $data->vehicleno;?></b></td>
                                    </tr>
                                    <?php } 
                                    
                                    if($data->narration !==""){ ?>


                                    <tr style="text-align:left">
                                        <td style="border:none">Enquiry Ref. : </td>
                                        <td style="border:none;text-align:left"><b><?= $data->narration;?></b></td>
                                    </tr>

                                    <?php } ?>

                                </table>


                            </td>
                        </tr>

                    </table>
                    <br>
                    <table style="width:100%; border: 2px solid gray;border-collapse: collapse; font-size:medium;">
                        <thead>
                            <tr>
                                <th style="border: 2px solid gray;border-collapse: collapse;text-align: center">No</th>
                                <th style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">Category
                                </th>
                                <th style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">Product
                                </th>
                                <th
                                    style="border: 2px solid gray;border-collapse: collapse;padding-left:10px; min-width:120px;">
                                    Narration</th>
                                <th
                                    style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">
                                    Req</th>
                                <th style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">Unit
                                </th>
                                <th style="border: 2px solid gray;border-collapse: collapse;padding-left:10px;">
                                    Producer</th>
                                <th
                                    style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">
                                    Quantity</th>
                                <th style="border: 2px solid gray;border-collapse: collapse;padding-left:10px;">Rate
                                </th>
                                <?php
                                    if(isset($_GET["printamount"]))
                                    {
                                        echo '<th style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">Amount</th>';
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
                                <td
                                    style="border: 2px solid gray;border-collapse: collapse;text-align: center; padding:5px;">
                                    <?php echo $count; ?></td>
                                <td style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">
                                    <?= $row->product; ?></td>
                                <td style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">
                                    <?= $row->sizeinmm; ?></td>
                                <td style="border: 2px solid gray;border-collapse: collapse;padding-right:10px;">
                                    <?= $row->narration; ?></td>
                                <td
                                    style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">
                                    <?= $row->estimationin == "Kgs" ? "" : $row->quantities; ?></td>
                                <td style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">
                                    <?= $row->estimationin; ?></td>
                                <td style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">
                                    <?= $row->brandname; ?></td>
                                <td
                                    style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">
                                    <?= $row->billingin == "Kgs" ? number_format($row->weight, 1)."  ".$row->billingin : $row->quantities."  ".$row->billingin; ?>
                                </td>
                                <td style="border: 2px solid gray;border-collapse: collapse;padding-left:10px">
                                    <?= number_format($row->rate, 2)."/". $row->billingin; ?></td>
                                <?php
                                        if(isset($_GET["printamount"]))
                                        {
                                            echo '<td style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">' . number_format($row->amount, 2) . '  &#8377;</td>';
                                        }
                                    ?>

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
                                <td
                                    style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">
                                    <b><?= number_format($data->totalweight, 1); ?></b></td>
                                <td></td>
                                <?php
                                        if(isset($_GET["printamount"]))
                                        {
                                            echo '<td style="border: 2px solid gray;border-collapse: collapse;padding-right:10px; text-align:right;">' . number_format($data->subtotal, 2) . '  &#8377</td>';
                                        }
                                    ?>

                            </tr>
                        </tbody>
                    </table>
                    <?php
                        if(isset($_GET["printamount"]))
                            echo '<table style="width:100%;">';
                        else
                            echo '<table style="width:100%; display:none;">';
                    ?>
                    <tr style="width:100%;">
                        <td style="width:55%;vertical-align:top;">
                            <p><br />
                                Account : <b><?= $firm->firm;?></b><br>
                                Acc No : <b><?= $firm->accno;?></b><br>
                                IFSC : <b><?= $firm->ifsc;?></b><br>
                                Bank : <b><?= $firm->bank;?></b><br>
                                Branch : <b><?= $firm->branch;?></b></p>

                            <b>Term and Conditions:</b><br />
                            <ol>
                                <li>GST @ 18% applicable extra on all above rates.</li>
                                <li>All Above Rates Are Ex Our Shiroli Godown Delivery/ For Full Load Quantity Site
                                    Delivery Negotiable.</li>
                                <li>Rates Are Valid For SAME Day Only subject to Market Fluctuation.</li>
                            </ol>
                        </td>
                        <td style="width:45%;">
                            <table class="table custom-table"
                                style="width:100%;border: 2px solid gray;font-size: 16px">
                                <tbody>
                                    <tr style="width:100%;">
                                        <td style="text-align:left; width:70%;">
                                            Loading Charges (<?= $data->loading; ?>):<br />
                                            Cutting Charges :<br />
                                            Freight Charges (<?= $data->paidby ?>):<br />
                                            <span style="color:<?= $data->cd !=0?'red':'black';?>"> Cash Discount : </span><br />
                                            GST(18%) : <br />
                                            Round Off : <br />
                                            <hr style="background-color:gray" />
                                            <b>Total :</b> <br />
                                        </td>
                                        <td style="text-align:right; width:30%;">
                                            <?= number_format($data->lcharges, 2) ."  &#8377;"; ?><br />
                                            <?= number_format($data->ccharges, 2) ."  &#8377;"; ?><br />
                                            <?= number_format($data->fcharges, 2) ."  &#8377;"; ?><br />
                                            <?= "<span style='color:".($data->cd !=0?'red':'black')."'> - ". number_format($data->ocharges, 2) ."  &#8377; </span>"; ?><br />
                                            <!-- <?= number_format($data->ocharges, 2) ."  &#8377;"; ?><br /> -->
                                            <?= number_format($data->gst, 2) ."  &#8377;"; ?><br />
                                            <?= number_format($data->roundoff, 2) ."  &#8377;"; ?><br />
                                            <hr />
                                            <b><?= "<b>". number_format($data->total, 2) ."  &#8377;</b>"; ?></b><br />
                                        </td>
                                        <!--<td style="width:120px;"></td>-->
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                            <h5 style="text-align:right;"><b>For <?= $firm->firm;?></b></h5>
                            <hr style="background-color:gray">
                        </td>
                    </tr>
                    <tr style="width:100%" >
                        <td style="width:100%;text-align:center" colspan=2>
                        <img src="<?= base_url('assets/icon/tata.png'); ?>" alt="" height="35" style="margin-right:50px;margin-left:20px   "> 
                                    <img src="<?= base_url('assets/icon/tata-pipes.png'); ?>" alt="" height="35" style="margin-right:50px"> 
                                    <img src="<?= base_url('assets/icon/Steel_Authority_of_India.png'); ?>" alt="" height="35" style="margin-right:50px"> 
                                    <!-- <img src="<?= base_url('assets/icon/og-logo.png'); ?>" alt="" height="40" style="margin-right:50px">  -->
                                    <img src="<?= base_url('assets/icon/Jindal_Steel_and_Power.png'); ?>" alt="" height="35" style="margin-right:50px"> 
                                    <img src="<?= base_url('assets/icon/vizag-steel.png'); ?>" alt="" height="35" style="margin-right:50px"> 
                                    <img src="<?= base_url('assets/icon/JSW.png'); ?>" alt="" height="35" style="margin-right:50px"> 
                                    <img src="<?= base_url('assets/icon/rajuri.png'); ?>" alt="" height="35" style="margin-right:50px"> 
                                    <br><br>
                            <h4 style="color:#f37800;">One Stop Solution for Variety of Branded Steel</h4>
                        </td>
                    </tr>

                    </table>
                    <?php
                        if(isset($_GET["printamount"]))
                            echo '<table class="table custom-table" style="width:100%; display:none;">';
                        else
                            echo '<table class="table custom-table" style="width:100%;">';
                    ?>
                    <tbody>
                        
                    <tr style="width:100%">
                        
                        <td style="width:60%;">
                        <b>Term and Conditions:</b><br />
                        <ol>
                            <li>Loading Charges : ( <?= $data->loading; ?> )</li>
                            <li>Freight Charges : ( <?= $data->paidby; ?> )</li>
                            <li>Cutting Charges : ( <?= $data->ccharges. " &#8377 "; ?> )</li>
                            <?php if($data->cd==0)
                            {?>
                            <li>C.D. : Not Applicable</li>
                           <?php }
                           else { ?>
                           <li>C.D. : <?= $data->cd; ?>% - Applicable for advance payment.</li>
                           <?php } ?>
                            
                        </ol>
                        </td>
                        <td style="width:40%;text-align:right">
                            <br /><br />
                            <h5><b>For <?= $firm->firm;?></b></h5>
                        </td>
                    </tr>
                        <tr style="width:100%">
                            <td colspan="2" style="width:100%;text-align:center">
                            <hr style="background-color:gray">
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
                </div>
            </div>
        </div>

        <br /><br /><br />
    </div>
    <?php 
    date_default_timezone_set('Asia/Kolkata');
    $now = date('Y-m-d H:i:s'); 
    ?>

    <script>
    // function sendonwhatsapp(divName, ask = 'Yes') {
    //     var confirmation = true;
    //     if (ask == 'Yes')
    //         confirmation = confirm("are you sure you want to send on whatsapp ?");
    //     if (confirmation) {
    //         html2canvas([document.getElementById(divName)], {
    //             onrendered: function(canvas) {
    //                 document.body.appendChild(canvas);
    //                 var data = canvas.toDataURL('image/png');
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: '<?= base_url('admin/sendOrder');?>',
    //                     data: {
    //                         'img': data,
    //                         'id': <?= $id ?>,
    //                         'mobileno': <?= $data->mobileno ?>
    //                     },
    //                     success: function(html) {
    //                         const context = canvas.getContext('2d', { willReadFrequently: true });
    //                         context.clearRect(0, 0, canvas.width, canvas.height);
                           
    //                     }
    //                 });
    //             }
    //         });
    //     }
    // }

    function sendonwhatsapp(divName, ask = 'Yes') {
        var confirmation = true;
        if (ask == 'Yes')
            confirmation = confirm("are you sure you want to send on whatsapp ?");
        if (confirmation) {
            html2canvas([document.getElementById(divName)], {
                onrendered: function(canvas) {
                    document.body.appendChild(canvas);
                    var data = canvas.toDataURL('image/png');
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('admin/sendOrder');?>',
                        data: {
                            'img': data,
                            'id': <?= $id ?>,
                            'mobileno': <?= $data->mobileno ?>
                        },
                        success: function(html) {
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

    function saveAsImage(divName) {
        html2canvas([document.getElementById(divName)], {
            onrendered: function(canvas) {
                var a = document.createElement('a');
                // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
                a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
                a.download =
                    '<?= "DO_". substr($data->firmname,0,16)."".date_format(date_create($data->createdon), 'ymd') ?>.jpg';
                a.click();
            }
        });
    }

    function saveAsPDF(divName) {
        //         html2canvas([document.getElementById(divName)], {
        //             onrendered: function (canvas) {

        //         var imgData = canvas.toDataURL('image/png');
        //                 var doc = new jsPDF("l", "mm", "a4");
        //                 doc.addImage(imgData, 'PNG', 10, 10);
        //                 var name = '<?= "DO_". substr($data->firmname,0,16)."".date_format(date_create($data->createdon), 'ymd') ?>.pdf';
        //                 doc.save(name);


        //       }
        // });

        var divHeight = $('#printDiv_Invoice').height();
        var divWidth = $('#printDiv_Invoice').width();
        var ratio = divHeight / divWidth;
        html2canvas(document.getElementById(divName), {
            height: divHeight,
            width: divWidth,
            onrendered: function(canvas) {
                var image = canvas.toDataURL("image/jpeg");
                var doc = new jsPDF(); // using defaults: orientation=portrait, unit=mm, size=A4
                var width = doc.internal.pageSize.getWidth();
                var height = doc.internal.pageSize.getHeight();
                height = ratio * width;
                doc.addImage(image, 'JPEG', 10, 10, width, height);
                doc.save('myPage.pdf'); //Download the rendered PDF.
            }
        });

    }
    </script>
    <?php

if(isset($_GET["send"]))
{

    $send = $_GET['send']; 
    if($_GET['send']=='Yes')
    {
        echo "<script>sendonwhatsapp('printDiv_Invoice', 'no');</script>";
    }
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12 text-right">
                <a href="<?= base_url('admin/editdquotation/'.$id ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;"><b>Edit Quotation</b></span>
				</a>

				<?php
					if(isset($_GET["printamount"]))
					{
						echo '<a href="'.base_url("admin/printdquotation/$id ").'">
						<span class="custom-badge status-green" style="padding:10px;"><b>Print Without Amount</b></span>
					</a>';
					}
					else{
						echo '<a href="'.base_url("admin/printdquotation/$id").'?printamount=yes">
						<span class="custom-badge status-green" style="padding:10px;"><b>Print With Amount</b></span>
					</a>';
					}
				?>

				
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
                    <table style="width:100%">
                        <tr>
                            <td style="width:1-0%;text-align:center;">
                                <h1 style="color:brown;"><?= $firm->firm;?></h1>         
                            </td>
                        </tr>
                        <tr class="border_bottom">
                            <td style="text-align:center;" >
                            <?= $firm->address;?><br />
                                Email - purchase@parshwanathsteel.com<br/>
                                Tel - (0230) 2461285, 2460009 Mob - 9607815933, 9607095933<br/>
                                <b>GSTIN - <?= $firm->gst;?></b>
                            </td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr>
                            <td style="width:1-0%;text-align:center;">
                                <h3 style="color:red;"><u> QUOTATION </u></h3>
                                <!-- <?php $orderno = substr("000{$data->orderno}", -4); ?>
                                <h5><u>PIPL/<?= $orderno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?></u></h5> -->
                            </td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr class="border_bottom" style="width:100%;">
                            <td style="width:50%;text-align:left; vertical-align:top;">
                                <?php $orderno = substr("000{$data->orderno}", -4); ?>
                                <h5>Quotation No : PIPL/<?= $orderno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?></h5>
                                <h4>Name :  <b><?= $data->name; ?></b></h4>
                                <?php 
                                if($data->mobileno !==""){
                                    echo "<h4>Mobile :  <b> ". $data->mobileno."</b></h4>";
                                }
                                ?>

                            </td>
                            <td class="pull-right" style="width:50%;text-align:right;border:none">
                                
                                 
                                
                                <table>
                             
                                    <!--<tr >-->
                                    <!--    <td style="border:none">Date : </td>-->
                                    <!--    <td style="border:none;text-align:left"><b><?= date('d-m-Y');?> </b></td>-->
                                    <!--</tr style="border:none">-->
                                    <tr style="border:none">
                                        <td style="border:none">Quotation Date : </td>
                                        <td style="border:none"><b><?= date("d-m-Y", strtotime($data->createdon)); ?> </b></td>
                                    </tr>

                                    <?php
                                            if($data->ponumber !=="")
                                             {
                                    ?>
                                                <tr>
                                                    <td style="border:none">PO Number : </td>
                                                    <td style="border:none;text-align:left"><b><?= $data->ponumber;?></b></td>
                                                </tr>
                                            

                                    <?php 
                                             }
                                    if($data->paymentmode !=="")
                                            {
                                        ?>
                                    <tr>
                                        <td style="border:none">Payment Mode : </td>
                                        <td style="border:none;text-align:left"><b><?= $data->paymentmode;?></b></td>
                                    </tr>
                                  
                                    
                                    <?php 
                                            }
                                    if($data->paymentdetails !==""){
                                        ?>
                                    <tr style="text-align:left">
                                        <td style="border:none">Payment Details : </td>
                                        <td style="border:none;text-align:left"><b><?= $data->paymentdetails;?></b></td>
                                    </tr>
                                   
                                    <?php }
                                    
                                            if($data->vehicleno !==""){
                                                ?>
                                            <tr style="text-align:left">
                                                <td style="border:none">Vehicle Number : </td>
                                                <td  style="border:none;text-align:left"><b><?= $data->vehicleno;?></b></td>
                                            </tr>
                                            <?php } 
                                    
                                    ?>
                                </table>
                            </td>
                        </tr>
                        
                    </table>   
                    <br>       
                    <table style="width:100%; border: 1px solid black;border-collapse: collapse; font-size:medium;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black;border-collapse: collapse;text-align: center">No</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Product</th>
                               
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Size</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">Producer</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px; min-width:120px;">Narration</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Qty</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Unit</th>
       
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Weight (Kg)</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">Rate</th>
                                <?php
                                    if(isset($_GET["printamount"]))
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
                                    <td style="border: 1px solid black;border-collapse: collapse;text-align: center; padding:5px;"><?php echo $count; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->product; ?></td>
                                     <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->sizeinmm; ?></td>
                                     <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->brandname; ?></td>
                                     <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px;"><?= $row->narration; ?></td>
       
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->estimationin == "Kgs" ? "" : $row->quantities; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->estimationin; ?></td>
                    
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= number_format($row->weight, 1); ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= number_format($row->rate, 2); ?></td>
                                    <?php
                                        if(isset($_GET["printamount"]))
                                        {
                                            echo '<td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">' . number_format($row->amount, 2) . '  &#8377;</td>';
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
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><b><?= number_format($data->totalweight, 1); ?></b></td>
                                    <td></td>
                                    <?php
                                        if(isset($_GET["printamount"]))
                                        {
                                            echo '<td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">' . number_format($data->subtotal, 2) . '  &#8377</td>';
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
                            <td style="width:55%;">
                                <p>Account : <b><?= $firm->firm;?></b><br>
                               Acc No  : <b><?= $firm->accno;?></b><br>
                               IFSC    : <b><?= $firm->ifsc;?></b><br>
                               Bank    : <b><?= $firm->bank;?></b><br>
                               Branch  : <b><?= $firm->branch;?></b></p>
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
                        
                    </table>
                    <?php
                        if(isset($_GET["printamount"]))
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
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
<br/><br/><br/>
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
        a.download = '<?= $data->name ?>.jpg';
        a.click();
      }
        });
    }
</script>

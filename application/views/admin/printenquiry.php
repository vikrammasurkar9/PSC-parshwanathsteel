<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12 pull-right">
            <button class="btn btn-success pull-right" onclick="printDiv('printDiv_Invoice')" style=""> <i class="fa fa-print fa-lg"></i> Print</button>
            <button class="btn btn-success pull-right" onclick="saveAsImage('printDiv_Invoice')" style="margin-right:20px"> <i class="fa fa-file-image-o fa-lg"></i> Image</button>            
            <!-- <button class="btn btn-success pull-right" onclick="sendonwhatsapp('printDiv_Invoice')" style="margin-right:20px"> <i class="fa fa-whatsapp fa-lg"></i> Send</button>             -->
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
                                <img src="<?= base_url('assets/icon/psc.png');?>"
                                    height="120" alt="" style="margin:auto;display:block">
                            </td>
                            <td style="width:60%">
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:1-0%;text-align:center;">
                                            <h1 style="color:#f37800;"><?= $firm->firm;?></h1>
                                            <!-- <b>Authorised Business Development Partner for TATA STRUCTURA</b> -->
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
                    <hr style="background-color:#f37800;height:2px">
                    <table style="width:100%">
                        <tr>
                            <td style="width:1-0%;text-align:center;">
                                <h3 style="color:f37800;"><u> ENQUIRY </u></h3>
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
                                <b> Date : <?= date_format(date_create($data->createdon), 'd/m/Y') ?> </b>
                                <!-- <?php $quotationno = substr("000{$data->mbqno}", -4); ?>
                                <h5>Quotation No : PIPL/MBQ/<?= $quotationno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?></h5>
                                <?php if($data->narration !==""){
                                ?>
                                <b>Lead Narration : <?= $data->narration;?></b>
                            <?php } ?> -->
                            </td>
                        </tr>
                    </table>   
                    <br>    
                    <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
                    <tr>
                    <td style="border-collapse: collapse;text-align: center">
                        <?= $data->description;?>
                                </td>
                    </tr>
                    <tr>
                    <td style="border-collapse: collapse;text-align: center">
                        <?php 
                    if($data->filename !='')
                    echo '<img src="'.base_url("enquirypics/".$data->filename.".png").'">'
                    ?>
                    </td>
                    </tr>
                    </table>             
                    <!-- <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black;border-collapse: collapse;text-align: center">No</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:2px">Category</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:2px">Product</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:2px; text-align:right;">Qty</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:2px">Unit</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:2px; text-align:right;">Weight (Kg)</th>
                              
                                <?php
                                    foreach ($producers as $producer) { 
                                        echo "<th style='border: 1px solid black;border-collapse: collapse;padding-left:2px'>" . $producer->name . "</th>";
                                } ?>
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
                                    <td style="border: 1px solid black;border-collapse: collapse;text-align: center"><?php echo $count; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:2px"><?= $row->productname; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:2px"><?= $row->sizeinmm; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:5px; text-align:right;"><?= $row->estimationin == "Kgs" ? "" : $row->quantities; ?></td>                                   
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:2px"><?= $row->estimationin; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:2px; text-align:right;"><?= number_format($row->weight, 1)." kg"; ?></td>
                                    
                                    <?php
                                                foreach ($producers as $producer) {
                                                    echo "<td style='border: 1px solid black;border-collapse: collapse;padding-right:2px; text-align:right;'>";
                                                    echo "<table style='width:100%;'>";
                                                    foreach ($brands as $brand) {
                                                        if($brand->producerid == $producer->id)
                                                        {
                                                            foreach ($brandproducts as $brandproduct) {
                                                                if($brandproduct->bid == $brand->id){
                                                                    if($brandproduct->pwid == $row->pwid && $brandproduct->pwid == $row->pwid){
                                                                        foreach ($quotationbrandprices as $qbp) {
                                                                            if($qbp->bid == $brand->id && $qbp->pwid == $row->pwid && $qbp->rate > 0)
                                                                            {
                                                                                echo "<tr>";
                                                                                echo "<td style='width:40%; text-align:left;'>" . $brand->name . "</td>";
                                                                                echo "<td style='width:30%; text-align:right;'>" . number_format($qbp->rate, 2) . " &#8377;</td>";
                                                                                echo "</tr>";
                                                                                $qbpcount++;
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    echo "</table>";
                                                    echo "</td>";
                                                } ?>
                                </tr>
                                <?php ++$count;
                                }?>
                                <tr>
                                    <td style='border: 1px solid black;border-collapse: collapse;padding-right:2px; text-align:right;' colspan="5" style="text-align:right"><b>Total Weight:</b></td>
                                    <td style='border: 1px solid black;border-collapse: collapse;padding-right:2px; text-align:right;'><?= number_format($totalWeight, 1); ?> Kg</td>
                                    <td style='border: 1px solid black;border-collapse: collapse;padding-right:2px; text-align:right;' colspan="4"></td>
                                </tr>
                        </tbody>
                    </table> -->
                    <hr>
                    <!-- <?php $this->load->view('admin/printfooter');?> -->
            </div>
        </div>
    </div>		
    <!-- <a class="btn btn-danger pull-left" href="<?= base_url('admin/printrequest/'.$id); ?>" style="color:white;" ><i class="fa fa-arrow-left fa-lg"></i> Lead</a>
	<a class="btn btn-danger pull-left" href="<?= base_url('admin/quotation/'.$id); ?>" style="color:white;margin-left:10px;" ><i class="fa fa-arrow-left fa-lg"></i> Edit Multiple Brand Quotation</a>
	<a class="btn btn-danger pull-right" href="<?= base_url('admin/squotation/'.$id); ?>" style="color:white;" ><i class="fa fa-arrow-right fa-lg"></i> Single Brand Quotation</a> -->
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
        a.download = '<?= "QT_".substr($data->firmname,0,11)."".date_format(date_create($data->createdon), 'ymd') ?>.jpg';
        a.click();
      }
});
    }
</script>

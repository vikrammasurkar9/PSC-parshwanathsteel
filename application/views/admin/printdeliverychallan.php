<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12 text-center">
            <button class="btn btn-success pull-right" onclick="printDiv('printDiv_Invoice')" style=""> <i class="fa fa-print fa-lg"></i> Print</button>
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
                    <?php $this->load->view('admin/printheader');?>
                    <table style="width:100%">
                        <tr>
                            <td style="width:1-0%;text-align:center;">
                                <h3 style="color:red;"><u> DELIVERY CHALLAN </u></h3>
                            </td>
                        </tr>
                    </table>
                    <table style="width:100%">
                        <tr class="border_bottom" style="width:100%;">
                            <td style="width:50%;text-align:left; vertical-align:top;">
                                <b>To, </b><br />
                                <?= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data->username; ?> <br />
                                <?= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data->mobileno; ?>  <?= $data->email;?>
                            </td>
                            <td style="width:50%;text-align:right;margin-right:100px;vertical-align:top;">
                                <b> Date : <?= date('d-m-Y');?> </b>
                            </td>
                        </tr>
                    </table>   
                    <br>       
                    <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black;border-collapse: collapse;text-align: center">No</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Category</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Product</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Qty</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px">Unit</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;">Weight (Kg)</th>
                                <th style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">Producer</th>
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
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->productname; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->sizeinmm; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= $row->quantities; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px"><?= $row->estimationin; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><?= number_format($row->weight, 1)." Kg"; ?></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px;">
                                    <?php
                                        foreach ($brands as $brand) {
                                            if($row->brandid == $brand->id)
                                                echo $brand->name;
                                        } 
                                    ?>
                                    </td>
                                </tr>
                                <?php ++$count;
                                }?>
                                <tr>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left:10px;text-align:right;" colspan="5"><b>Total Weight:</b></td>
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-right:10px; text-align:right;"><b><?= number_format($totalWeight, 1); ?> Kg</b></td>
                                    <td></td>
                                </tr>
                        </tbody>
                    </table>
                    <hr>
                    <!-- <?php $this->load->view('admin/printfooter');?> -->
            </div>
        </div>
    </div>
    
    <a class="btn btn-danger pull-left" href="<?= base_url('admin/proforma/'.$id); ?>" style="color:white;" ><i class="fa fa-arrow-left fa-lg"></i> Edit Proforma</a>
	<a class="btn btn-danger pull-right" href="<?= base_url('admin/requests/'); ?>" style="color:white;" ><i class="fa fa-arrow-right fa-lg"></i>All Requests</a>
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
</script>

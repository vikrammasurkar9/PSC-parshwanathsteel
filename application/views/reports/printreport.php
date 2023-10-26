<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-9">
                <h4 class="page-title">Report - <?=$name?></h4>
            </div>             
            <div class="col-sm-3 text-right">
                <button class="btn btn-success" onclick="printDiv('printDiv_Invoice')" style=""> <i class="fa fa-print fa-lg"></i> Print</button>
                <button class="btn btn-success pull-right" onclick="saveAsImage('printDiv_Invoice')" style="margin-left:20px"> <i class="fa fa-file-image-o fa-lg"></i> Image</button>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-12">
            <div id="printDiv_Invoice" style="width:1000px; background-color:white; color:black;">
                <style>
                    tr.border_bottom td {
                    border-bottom:groove;
                    }
                </style>
                <div style="border-style:groove;padding:10px;">
                    <!-- Print Header  -->
                    <?php 
                    // $this->load->view('admin/printheader');
                    ?>
                    <table style="width:100%">
                        <tr>
                            <td style="width:100%;text-align:center;">
                                <h1 style="color:brown;">PARSHWANATH ISPAT PVT LTD</h1>         
                            </td>
                        </tr>
                        <tr class="border_bottom">
                            <td style="text-align:center;" >
                            SHIROLI KOLHAPUR <br />
                                Email - purchase@parshwanathsteel.com<br/>
                                Tel - (0230) 2461285, 2460009 Mob - 9607815933, 9607095933<br/>
                                <b>GSTIN - 27AAFCP4825L1Z2</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;"><b class="page-title" style="color:brown;"><?=$name?></b></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b class="" style="color:black;">Date : <?= date("d-m-Y", strtotime($date)); ?></b></td>
                        </tr>
                    </table>
                    <br>       
                    <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th  style="border: 1px solid black;border-collapse: collapse;text-align: center" rowspan=2>Sr.No</th>
                                <th  style="border: 1px solid black;border-collapse: collapse;text-align: center" rowspan=2>Product</th>
                                <th  style="border: 1px solid black;border-collapse: collapse;text-align: center" rowspan=2>Size</th>
                                <?php
                                    foreach ($brandsTable as $row) {
                                        echo "<th  style='border: 1px solid black;border-collapse: collapse;text-align: center' colspan=2 style='text-align:center;'>" . $row->name . "</th>";
                                    }    
                                ?>
                            </tr>
                            <tr>
                                    <?php
                                    foreach ($brandsTable as $row) {
                                        echo "<th  style='border: 1px solid black;border-collapse: collapse;text-align: center'>Rate + GST</th>";
                                        echo "<th style='border: 1px solid black;border-collapse: collapse;text-align: center'>Rate including GST</th>";
                                    }    
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($result as $row) {
                                ?>
                            <tr>
                                <td style="border: 1px solid black;border-collapse: collapse;text-align: center"><?php echo $count; ?></td>                                
                                <td style="border: 1px solid black;border-collapse: collapse;text-align: left;width:100px"><?php echo $row->product; ?></td>
                                <td style="border: 1px solid black;border-collapse: collapse;text-align: left;width:100px"><?php echo $row->sizeinmm; ?></td>
                                <?php                                    
                                    foreach ($brandsTable as $brand) {
                                        $found = false;
                                        foreach ($brandproducts as $brandproduct) {
                                            if($brand->id == $brandproduct->bid && $row->id == $brandproduct->pwid){
                                                $billingrate = $brandproduct->billingrate;
                                                $billingrateplusgst = $brandproduct->billingrate + ($brandproduct->billingrate * 18/100);
                                                if($billingrate > 0)
                                                {
                                                    echo "<td style='border: 1px solid black;border-collapse: collapse;text-align: right;'>" . number_format($billingrate, 1) . "&nbsp;&nbsp;</td>";
                                                    echo "<td style='border: 1px solid black;border-collapse: collapse;text-align: right'>" . number_format($billingrateplusgst, 1) . "&nbsp;&nbsp;</td>";
                                                }
                                                else{
                                                    echo "<td style='border: 1px solid black;border-collapse: collapse;text-align: right'></td>";
                                                    echo "<td style='border: 1px solid black;border-collapse: collapse;text-align: right'></td>";
                                                }
                                                $found = true;
                                                break;
                                            }
                                        }
                                        if($found == false)
                                        {
                                        }
                                    }    
                                ?>
                            </tr>
                            <?php ++$count;
                                }?>
                        </tbody>
                    </table>
                    <hr>
            </div>
            </div>
        </div>
    </div>
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
        a.download = '<?= $name ?>.jpg';
        a.click();
      }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                    <h4 class="page-title"><img src="<?= base_url('brandpics/' . $brand->id . '.png'); ?>" 
                    style="height:40px; width:40px;" class="img-thumbnail" /> 
                    <?php echo $brand->name;?> [<?= sizeof($result); ?>] Base Rate : <?= number_format(floatval($brand->baserate), 2);?> Report</h4>
                    <input type="hidden" id="baserate" value="<?= $brand->baserate;?>"/>
                    <input type="hidden" id="brandid" value="<?= $brandid;?>"/>

                    <button class="btn btn-success pull-right" onclick="saveAsImage('printDiv_Invoice')" style="margin-left:20px"> <i class="fa fa-file-image-o fa-lg"></i> Image</button>
                    <button class="btn btn-success pull-right" onclick="printDiv('printDiv_Invoice')" style=""> <i class="fa fa-print fa-lg"></i> Print</button>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12">
                <div id="printDiv_Invoice" style="width:1000px; background-color:white; color:black;">
                <style>
                    tr.border_bottom td {
                    border-bottom:groove;
                    }
                    th, tr, td{
                        border: 1px solid black;
                        border-collapse: collapse;
                    }
                    td{
                        padding:5px;
                    }
                </style>
                <div style="border-style:groove;padding:10px;">
                    <center><h4><?php echo $brand->name;?> - Base Rate : <?= number_format(floatval($brand->baserate), 2);?></h4></center>
                        <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Parity</th>
                                    <th>Item</th>
                                    <th>Rate + GST</th>
                                    <th>Rate Inclusive GST</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $pgcount = 1;
                                    foreach ($paritygroups as $paritygroup) {
                                ?>
                                <tr>
                                <td style="vertical-align:top; text-align:center;"><?php echo $pgcount; ?></td>
                                    <td style="vertical-align:top;"><?php echo $paritygroup->name;?></td>
                                    <td style="padding:10px;width:600px;">
                                        <table style="border:solid 1px white;width:100%;">
                                        <?php
                                            $count = 0;
                                            foreach ($result as $row) {
                                                foreach($paritygroupproducts as $pgp)
                                                {
                                                    if($pgp->bpid == $row->bpid && $pgp->pgroupid == $paritygroup->id)
                                                    {
                                                        if($count % 4 == 0)
                                                        {
                                                            if($count != 0)
                                                                echo "</tr>";
                                                            echo "<tr>";
                                                        }
                                                        $bpgid = $pgp->pgroupid;
                                                        echo "<td style='border-top:solid 1px black;width:25%;'>" . $row->sizeinmm . "</td>";
                                                        $count++;
                                                        break;
                                                    }
                                                }
                                            }
                                        ?>
                                        </table>
                                    </td>
                                    <td style="vertical-align:top; text-align:center;">
                                        <?php
                                         $withoutgstrate = $brand->baserate + $paritygroup->parity;
                                         $withgstrate = $withoutgstrate + ($withoutgstrate * (18 / 100));
                                        ?>
                                        <?= number_format($withoutgstrate, 2); ?>
                                    </td>
                                    <td style="vertical-align:top; text-align:center;">
                                        <?= number_format($withgstrate, 2); ?>
                                    </td>
                                </tr>
                                <?php ++$pgcount; }  ?>
                                                
                            </tbody>
                        </table>
                    </div>
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
        a.download = '<?= $brand->name; ?>.jpg';
        a.click();
      }
        });
    }

</script>
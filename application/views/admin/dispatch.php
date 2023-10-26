<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-3">
                <h4 class="page-title">Dispatch</h4>
            </div>
            <div class="col-9">
            </div>

        </div>
        <div class="card-box" style="border-style:ridge">
            <div class="row">
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
                                    echo "<h5>Mob No. : ". $data->mobileno."</h5>";
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
                                <tr>
                                    <?php $orderno = substr("000{$data->orderno}", -4); ?>
                                    <td style="border:none">Order No : </td>
                                    <td style="border:none;text-align:left">
                                        <b>PIPL/<?= $orderno; ?>/<?= date("d-m-y", strtotime($data->createdon)); ?> </b>
                                    </td>
                                </tr>
                                <tr style="border:none">
                                    <td style="border:none">D. O. Date : </td>
                                    <td style="border:none;text-align:left">
                                        <b><?= date("d-m-Y", strtotime($data->createdon)); ?> </b>
                                    </td>
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
                                    <td style="border:none;text-align:left"><b><?= $data->vehicleno;?></b></td>
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
            </div>
        </div>

        <form action="<?php echo base_url('admin/savedispatch'); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
        <div class="col-lg-9">
         </div>
                 <div class="col-lg-3">
                     <div Style="text-algin:right;">
                             <label>Dispatch Date </label>  <input type="date" class="form-control" id="ddate" value="<?php echo date('Y-m-d'); ?>" name="ddate" style="background-color:white">
                             <br>
                          </div>
                  </div>
                <br><br>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th>Product</th>
                                <th>Variety</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Narration</th>
                                <th>Brand</th>
                                <th>Billing In</th>
                                <th>Total Quantity</th>
                                <th>Quantity /   Pending Quantity </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                            $i=1;
                                            for($i=1;$i<=count($result);$i++){
                                                $pid = "";
                                                $pwid = "";
                                                $brandid = "";
                                                $estimationin = "";
                                                $quantities = "";
                                                $weight = "";
                                                $quantity = "";
                                                $singleweight = "";
                                                $rate = "";
                                                $amount = "";
                                                $type = "";
                                                $billingin = "";
                                                $narration = "";
                                                $dispachedtotal = "";
                                                if(count($result) >= $i)
                                                {
                                                    $row = $result[$i - 1];

                                                    // print_r($result);
                                                    // exit;


                                                    $pid = $row->pid;
                                                    $pwid = $row->pwid;
                                                    $brandid = $row->brandid;
                                                    $estimationin = $row->estimationin;
                                                    $quantities = $row->quantities;
                                                    $singleweight = $row->singleweight;
                                                    //$weight = $row->weight;
                                                    if($row->billingin == "Kgs")
                                                    {
                                                        $quantity = $row->weight;
                                                        $total = $row->weight - $row->dispachedtotal;
                                                        $dispachedtotal  = $total ." ".$row->billingin;
                                                    }
                                                    else if($row->billingin == "Feet" || $row->billingin == "Meter" )
                                                    {
                                                        $quantity = $row->quantities;
                                                        $total = $row->quantities - $row->dispachedtotal;
                                                        $dispachedtotal  = $total ." ".$row->billingin;
                                                    }
                                                    
                                                    $rate = $row->rate;
                                                    $amount = $row->amount;
                                                    $narration = $row->narration;
                                                }
                                            ?>

                            <tr>

                                <td style="width:50px; text-align:center;"><?= $i;?></td>
                                <td style="width:180px;">
                                    <?= $row->product; ?>
                                </td>
                                <td style="width:180px;">
                                    <?= $row->sizeinmm; ?>
                                </td>
                                <td style="width:100px;">
                                    <?= $row->estimationin; ?>
                                    <input type="hidden" name="unit<?= $i; ?>" value="<?= $row->estimationin;?>" />
                                </td>
                                <td style="width:50px;">
                                    <?= $row->estimationin == "Kgs" ? "" : $row->quantities; ?>
                                </td>
                                <td style="width:100px">
                                    <?= $row->narration; ?>
                                </td>
                                <td style="width:180px;">
                                    <?= $row->brandname; ?>
                                </td>
                                <td><?= $row->billingin;?></td>
                                <td style="width:100px">
                                    <input type="number" class="form-control" id="totalweight<?= $i; ?>"
                                        name="weight<?= $i; ?>" style="width:100px; text-align:center;"
                                        value="<?= $quantity; ?>" onchange="copyWeightToSingle(<?= $i; ?>)"
                                        <?= ($estimationin == "Kgs" ? "" : "readonly") ?> step="any" />
                                    
                                <td style="width:150px;">
                                    <input type="number" class="form-control" name="dispatchedweight<?= $i; ?>" value=""
                                        style="width:150px; text-align:center; " step="any" />/ <?= $dispachedtotal; ?>
                                </td>

                            </tr>
                            <input type="hidden" name="odid<?= $i; ?>" value="<?= $row->id;?>" />
                            <input type="hidden" name="pwid<?= $i; ?>" value="<?= $pwid;?>" />
                            <input type="hidden" name="pid<?= $i; ?>" value="<?= $pid;?>" />
                            <input type="hidden" name="brandid<?= $i; ?>" value="<?= $brandid;?>" />
                            <?php 
                                        }
                                        ?>

                        </tbody>
                    </table>
                    <input type="hidden" id="count" name="count" value="<?= $i ?>" />
                    <input type="hidden" id="count" name="oid" value="<?= $orderid ?>" />

                    <input type="submit" class="btn btn-lg btn-primary pull-right" style="width:200px" value="Submit" />
                </div>
            </div>
        </div>
                                    </form>
    </div>
</div>
</div>
<script>
function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        var show = false;
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                show = true;
                break;
            }
        }
        if (show)
            tr[i].style.display = "";
        else
            tr[i].style.display = "none";
    }
}
</script>

<?php
function does_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

?>
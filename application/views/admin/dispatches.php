<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-3">
                <h4 class="page-title">Dispatches [123]</h4>
            </div>
            <div class="col-9">


                <a href="<?php echo base_url('admin/dispatch/'.$id);?>" class="btn  btn-primary pull-right"> + New</a>

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

                                <tr>
                                        <td></td>
                                        <td><a href="<?= base_url('admin/printpendingdispatch/'.$id);?>" class="btn  btn-primary pull-right" style="color:white"> Pending Dispatch</a></td>
                                </tr>

                            </table>


                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <br />
                <div class="table-responsive">

                    <table class="table table-striped custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th style="text-align:left;">Dispatch Name </th>
                                <th style="text-align:left;">Created By</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $count = 1;
                                    
                                    foreach ($result as $row) {
                                        
                                ?>
                                
                                <tr>
                                    <td style="text-align:left;"><?php echo $count; ?></td>
                                    <td style="color:green"><?= date("d-m-Y", strtotime($row->ddate)); ?></td> 
                                     
                                    
                                    <td><a href="<?= base_url('admin/printdispatch/'.$row->id);?>" class="btn btn-outline-info" title="View Details"> <?= $row->srno .' - '.$row->ordername?></a></td>
                                    
                                    <td style="text-align:left;">
                                        <?php echo $row->createdby; ?>
                                    </td>                          
                                </tr>
                                <?php ++$count; } ?>                                                
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
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
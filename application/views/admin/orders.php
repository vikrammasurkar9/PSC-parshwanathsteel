<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-4">
                <h4 class="page-title">Delivery Orders [<?= sizeof($result) ?>]</h4>
            </div>
            <div class="col-6">
                <a href="<?= base_url('admin/allorders?status=All'); ?>"
                    class="btn btn<?= $status == "All" ? "-" : "-outline-" ?>primary take-btn">All
                    Orders</a>&nbsp;&nbsp;
                <a href="<?= base_url('admin/orders?status=Open'); ?>"
                    class="btn btn<?= $status == "Open" ? "-" : "-outline-" ?>primary take-btn">Open
                    Orders</a>&nbsp;&nbsp;
                <a href="<?= base_url('admin/orders?status=Close'); ?>"
                    class="btn btn<?= $status == "Close" ? "-" : "-outline-" ?>primary take-btn">Closed
                    Orders</a>&nbsp;&nbsp;

            </div>
            <div class="col-2">
                <a href="<?php echo base_url('admin/order');?>" class="btn  btn-primary pull-right"> + New</a>
            </div>
            <!-- <div class="col-12">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Search..."
                    autocomplete="off">
            </div> -->
        </div>
        <br>
        <form action="<?= base_url('admin/orders');?>" method="GET" >
        <div class="row filter-row">
            
            <div class="col-sm-6 col-md-5">
                <div class="form-group form-focus">
                    <label class="focus-label">Order No.</label>
                    <input type="number" name="orderno"  class="form-control floating">
                </div>
            </div>
            <div class="col-sm-6 col-md-5">
                <div class="form-group form-focus">
                    <label class="focus-label">Search by Name</label>
                    <input type="text" name="qname" class="form-control floating">
                </div>
            </div>

            <div class="col-sm-6 col-md-2">
                <button type="submit" class="btn btn-success btn-block " style="color:white"> Search </button>
            </div>
            
        </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <br />
                <div class="table-responsive">
                    
                    <table class="table table-striped custom-table" id="myTable">
                        <thead>
                            <tr>
                            <th>Order No.</th>
                                <th style="text-align:left;">Date</th>
                                
                                <th style="text-align:left;">User Details</th>
                                <th width="150">Enq. Source</th>
                                <th style="text-align:left;">Narration</th>
                                <th>Dispatches</th>
                                <th>Order Status</th>
                                <!-- <th></th> -->
                                <th>CreatedBy</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $count = 1;
                                    if(isset($result)){
                                        $date = "";
                                    foreach ($result as $row) {
                                        
                                       

                                        // if($row->status=="Close")
                                        // {
                                        //     continue;
                                        // }

                                        // if($status == "All" || $row->status == $status)
                                        // {
                                        $rdate = date("d/m/Y", strtotime($row->createdon));
                                        // if($date != $rdate){
                                        //     $date = $rdate;
                                        // }
                                        // else{
                                        //     $rdate = "";
                                        // }
                                ?>
                            <?php $orderno = substr("000{$row->orderno}", -4); ?>
                            <tr>
                                <!-- <td><?php echo $count; ?></td> -->
                               
                                <td><a href="<?= base_url('admin/printorder/' . $row->id); ?>" style="color:green">
                                        <span class="custom-badge status-green"><?= $orderno; ?></span></a></td>
                                <td style="color:green"><?php echo $rdate; ?></td>
                                <td style="text-align:left;">
                                <a href="<?= base_url('admin/printorder/' . $row->id); ?>" style="color:green"> <?php echo $row->firmname; ?></a> <br>
                                    <?php echo $row->mobileno; ?>&nbsp;&nbsp;
                                    <?php echo $row->city; ?>
                                </td>
                                <td><?= $row->enquirysource; ?></td>
                                <td style="text-align:left;">                                    
                                    
                                    <?= $row->narration;?>
                                </td>
                                <td>
                                    <?php
                                        if($row->dispatchcount != 0){
                                        ?>     
                                        <a href="<?= base_url('admin/dispatches/'.$row->id); ?>" title="Dispatches" style="color:green; border:1px solid green;padding:3px;border-radius:4px">
                                        <!-- <span class="custom-badge status-green" style="width:20px"> -->
                                        &nbsp;
                                        <i class="fa fa-bars"></i>&nbsp;
                                        <!-- </span> -->
                                    </a> 
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="<?= base_url('admin/printpendingdispatch/' . $row->id); ?>" title="Pending Dispatch" style="color:blue">
                                        <span class="custom-badge status-red">
                                            Pending
                                        </span></a>
                                    <?php
                                        }
                                        else{
                                            ?>
                                            <a href="<?= base_url('admin/dispatch/'.$row->id); ?>" title="New Dispatches" style="color:blue; border:1px solid blue;padding:4px;border-radius:3px">
                                        <!-- <span class="custom-badge status-green" style="width:20px"> -->
                                        &nbsp;
                                        <i class="fa fa-plus"></i>&nbsp;
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td style="width:200px">
                                    <?php 
                                        if($row->status=="Open"){?>
                                    <a href="<?= base_url('admin/orderstatus/'.$row->id.'?status=Close'); ?>"
                                        onclick="return confirm('Are you sure you want to close order ?');" title="Click to close order"
                                        class="btn btn-outline-danger take-btn">Close Order</a>
                                    <?php } else if($row->status == 'Close') {?>
                                    <a href="<?= base_url('admin/orderstatus/'.$row->id.'?status=Open'); ?>"
                                        onclick="return confirm('Are you sure you want to open order ?');" title="Click to open order"
                                        class="btn btn-success take-btn">Open Order</a>
                                    <?php } ?>
                                </td>
                                <!-- <td>
                                <a href="<?= base_url('admin/orderstatus/'.$row->id.'?status=Remove'); ?>"
                                        onclick="return confirm('Are you sure ? you want to remove order ?');" title="Click to open order"
                                        class="btn btn-outline-secondary take-btn">Remove</a>
                                </td> -->
                                <!-- <td><a href="<?= base_url('admin/dispatches/'.$row->id);?>" class="btn btn-outline-info">Dispatches</a></td> -->
                                <td>
                                    <?= $row->createdby;?>
                                    </td>
                                <td>
                                    <a href="<?php echo base_url('admin/deleteorder/'.$row->id); ?>"
                                        onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "
                                        title="Delete"><i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                            <?php ++$count; }}
                        //  }
                          ?>
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
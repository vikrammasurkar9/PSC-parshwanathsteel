<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/jquery-3.3.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/bootstrap.js'?>"></script>
<script>
function getRates(bid, pid, index)
{
    $.ajax({
        url : "<?php echo base_url('admin/getrates');?>",
        method : "POST",
        data : {productid: pid, brandid: bid},
        async : true,
        dataType : 'json',
        success: function(data){
            document.getElementById("hrate_" + index).value =data.toFixed(2);
        },
        error: function(err)
        {
            
        }
    });
}
</script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><b>Multple Brand Quotation</b></h4>
            </div>
        </div>
        <div class="card-box" style="border-style:ridge">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Name: <?= $data->username ?></label>
                        </div>
                        <div class="col-sm-4">
                            <label>Email/Mobile: <?= $data->email . '/' . $data->mobileno ?></label>
                        </div>
                        <div class="col-sm-3">
                            <label>Firm Name: <?= $firm->firm; ?></label>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-success btn-sm pull-right" onclick="copyRates()">Get Rates</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-box" style="border-style:ridge">            
        <form action="<?php echo base_url('admin/saveQuotation'); ?>" method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="return  confirmSubmit();">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="userid" value="<?php echo $data->userid; ?>" />
                <input type="hidden" id="send" name="send" value="No" />
                <div class="row">
                    <div class="col-lg-12">                    
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped custom-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product</th>
                                        <th>Variety</th>
                                        <th style="width:110px;">Unit</th>
                                        <th>Quantity</th>
                                        <th>Weight (Kg)</th>
                                        <?php
                                            foreach ($producers as $producer) { 
                                                echo "<th>" . $producer->name . "</th>";
                                            } ?>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $qbpcount = 1;
                                    foreach ($result as $row) {
                                        $totalweight = 0;
                                            if($row->estimationin=='Meter')
                                                $totalweight  = $row->singleweight * $row->quantities;
                                            else if($row->estimationin=='Feet')
                                                $totalweight  = ($row->singleweight / 3.28) * $row->quantities;
                                            else if($row->estimationin=='Nos'){
                                                if($row->type == "Meter")
                                                    $totalweight  = ($row->singleweight * 6) * $row->quantities;
                                                else
                                                    $totalweight  = $row->singleweight * $row->quantities;
                                            }
                                            else if($row->estimationin=='Kgs')
                                                $totalweight  = $row->singleweight * $row->quantities;
                                        ?>
                                    <tr>
                                        <td class="text-center"><?php echo $count; ?>
                                            <input type="hidden" id="type<?= $count ?>" name="type<?= $count ?>" value="<?= $row->type; ?>" />
                                            <input type="hidden" id="id<?= $count ?>" name="id<?= $count ?>" value="<?= $row->id; ?>" />
                                            <input type="hidden" id="pwid<?= $count ?>" name="pwid<?= $count ?>" value="<?= $row->pwid; ?>" />
                                            <input type="hidden" id="hweight<?= $count; ?>" name="hweight<?= $count; ?>" value="<?= $row->singleweight; ?>" />
                                        </td>
                                        <td><?= $row->productname; ?></td>
                                        <td><?= $row->sizeinmm; ?></td>
                                        <td>           
                                            <?= $row->estimationin; ?>
                                            <select style="width:90px;display:none;" name="estimationin<?= $count; ?>" id="estimationin<?= $count; ?>" 
                                            onchange="calculateWeight(<?= $count;?>)" class="form-control">
                                                <?php                                                      
                                                    // if($row->type == "Meter"){
                                                    //     if($row->billingin == "Meter"){
                                                    //         echo "<option value='Meter' " . ($row->estimationin == "Meter" ? "selected" : "") . ">Meter</option>";
                                                    //     }
                                                    //     else if($row->billingin == "Feet"){
                                                    //         echo "<option value='Feet' " . ($row->estimationin == "Feet" ? "selected" : "") . ">Feet</option>";
                                                    //     }
                                                    //     else{
                                                    //         echo "<option value='Meter' " . ($row->estimationin == "Meter" ? "selected" : "") . ">Meter</option>";
                                                    //         echo "<option value='Feet' " . ($row->estimationin == "Feet" ? "selected" : "") . ">Feet</option>";
                                                    //         echo "<option value='Nos' " . ($row->estimationin == "Nos" ? "selected" : "") . ">Nos</option>";
                                                    //     }
                                                    // }
                                                    // else{
                                                    //      echo "<option value='Nos' " . ($row->estimationin == "Nos" ? "selected" : "") . ">Nos</option>";
                                                    // }
                                                    //echo "<option value='Kgs' " . ($row->estimationin == "Kgs" ? "selected" : "") . ">Kgs</option>";
                                                    echo "<option value='" . $row->estimationin . "'>" . $row->estimationin . "</option>";
                                                ?>
                                            <select>
                                        </td>
                                        <td>
                                            <input type="number" onkeypress="return isFloat(this);" onkeyup='calculateWeight(<?= $count;?>)'
                                                name="quantities<?= $count; ?>" value="<?= $row->quantities; ?>"
                                                id="quantities<?= $count; ?>" style="width:70px; text-align:center;<?= $row->estimationin == "Kgs" ? "display:none;" : "" ?>">
                                        </td>                                       
                                        <td style="text-align:right;">
                                            <span id="totalweight<?= $count; ?>"><?= number_format($totalweight, 1); ?></span>
                                            <input type="hidden" id="htotalweight<?= $count; ?>" name="htotalweight<?= $count; ?>" value="<?= $totalweight; ?>" />
                                        </td>
                                        <?php
                                            foreach ($producers as $producer) {
                                                echo "<td>";
                                                echo "<table>";
                                                foreach ($brands as $brand) { 
                                                    if($brand->producerid == $producer->id)
                                                    {
                                                        foreach ($brandproducts as $brandproduct) {
                                                            if($brandproduct->bid == $brand->id){
                                                                if($brandproduct->pwid == $row->pwid && ($brandproduct->pwid == $row->pwid || $row->bid == 0)){
                                                                    $rate = 0;
                                                                    $color = "pink";
                                                                    foreach ($quotationbrandprices as $qbp) {
                                                                        if($qbp->bid == $brand->id && $qbp->pwid == $row->pwid && $qbp->rate > 0)
                                                                        {
                                                                            $rate = $qbp->rate;                                                                            
                                                                            $color = "";
                                                                            break;
                                                                        }
                                                                    }
                                                                    echo "<tr style='background-color:white;'>";
                                                                    echo "<td>" . $brand->name;
                                                                    echo "<input type='hidden' name='countid_" . $qbpcount . "' value='" . $count . "' />";
                                                                    echo "<input type='hidden' id='pid_" . $qbpcount . "' name='pid_" . $qbpcount . "' value='" . $row->pwid . "' />";
                                                                    echo "<input type='hidden' id='bid_" . $qbpcount . "' name='bid_" . $qbpcount . "' value='" . $brand->id . "' />";
                                                                    echo "</td>";
                                                                    echo "<td><input  onkeypress='return isFloat(this)' placeholder='Rate' id='rate_" . $qbpcount . "' 
                                                                    name='rate_" . $qbpcount . "' style='width:80px;background-color:" . $color . "' type='text' min='0' value='"  .number_format($rate , 2). "'  />";
                                                                    echo "<input  type='hidden' id='hrate_" . $qbpcount . "' /></td>";
                                                                    echo "</tr>";
                                                                    echo "<script>getRates(" . $brand->id . ", " . $brandproduct->pwid . ", " . $qbpcount . ")</script>";
                                                                    $qbpcount++;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }                                                
                                                echo "</table>";
                                                echo "</td>";
                                            } ?>
                                            <td style="width:80px">
                                            <a onclick="Reset(<?= $count;?>);" style="display:<?= $count==1 ? 'none':'block' ?>"><i class="fa fa-times-circle fa-3x"
                                                    aria-hidden="true" style="color:red"></i></a>
                                        </td>
                                    </tr>                                    
                                    <?php ++$count;
                                        }?>
                                    <tr>
                                        <td colspan="5" style="text-align:right"><b>Total Weight:</b></td>
                                        <td style="text-align:right;"><span id="spnTotalWeight"></span></td>
                                        <td colspan="4"></td>
                                    </tr>

                                </tbody>
                            </table>
                            <input type="hidden" value="<?php echo $count; ?>" name="count" id="count" />
                            <input type="hidden" value="<?php echo $qbpcount; ?>" name="qbpcount" id="qbpcount" />
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-primary pull-left" value="Submit & Print" />
                    </div>
                </div>
            </form>
		</div>
		<a class="btn btn-danger pull-left" href="<?= base_url('admin/printrequest/'.$id); ?>" style="color:white;"> 
            <i class="fa fa-arrow-left fa-lg"></i> Lead</a><br/><br/><br/><br/>
    </div>
</div>
<script>
    function calculateTotalWeight()
    {
        var count = document.getElementById("count").value;
        $totalWeight = 0;
        for(var i = 1; i < count; i++)
        {
            $totalWeight += parseFloat("0" + document.getElementById("htotalweight" + i).value);
        }
        document.getElementById("spnTotalWeight").innerText = $totalWeight.toFixed(1);
    }

    function calculateWeight(i) {
        var quantities = parseFloat("0" + document.getElementById("quantities" + i).value);
        var unit = document.getElementById("estimationin" + i).value;
        var weight = parseFloat("0" + document.getElementById("hweight" + i).value);
        var type = document.getElementById("type" + i).value;
        var totalweight = 0;
        if(unit == 'Meter')
            totalweight  = weight * quantities;
        else if(unit == 'Feet')
            totalweight  = (weight / 3.28) * quantities;
        else if(unit == 'Nos')
        {
            if(type == 'Meter')
                totalweight  = (weight * 6) * quantities;
            else
                totalweight  = weight * quantities;
        }
        else if(unit == 'Kgs')
        {
            totalweight  = weight * quantities;
        }
        document.getElementById("htotalweight" + i).value = totalweight;
        document.getElementById("totalweight" + i).innerText = totalweight.toFixed(1);    
        calculateTotalWeight();
    }

    function copyRates()
    {
        var count = document.getElementById("qbpcount").value;
        for(var i = 1; i < count; i++)
        {
            document.getElementById("rate_" + i).value = document.getElementById("hrate_" + i).value;
            if(parseFloat("0" + document.getElementById("hrate_" + i).value) == 0)
                document.getElementById("rate_" + i).style.backgroundColor = "pink";
            else
                document.getElementById("rate_" + i).style.backgroundColor = "white";
        }
    }
    calculateTotalWeight();
</script>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-8">            
                <h4 class="page-title"><b>Single Brand Quotation</b></h4>
            </div>
            <div class="col-sm-4">
            <a href="<?= base_url('admin/editsquotation/'.$id ); ?>">
                    <span class="custom-badge status-green" style="padding:10px;"><b>Edit Single Brand Quotation</b></span>
				</a>    
            </div>
        </div>
        <div class="card-box" style="border-style:ridge">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <label> 
                            <?= $data->firmname ?>
                            </label>
                        </div>
                        <div class="col-sm-4">
                            <label>Contact Details: <?= $data->username . '/' . $data->mobileno ?></label>
                        </div>
                        <div class="col-sm-4">
                            <label>Firm Name: <?= $firm->firm ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-box" style="border-style:ridge">
            <form action="<?php echo base_url('admin/savesquotation'); ?>" method="post" 
            enctype="multipart/form-data" onsubmit="return  confirmSubmit();">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <input type="hidden" name="userid" value="<?php echo $data->userid; ?>" />
                <input type="hidden" id="send" name="send" value="No" />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered custom-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product</th>
                                        <th>Variety</th>
                                        <th style="width:100px;">Unit</th>
                                        <th>Quantity</th>
                                        <th style="width:100px;text-align:right;">Weight (Kg)</th>
                                        <th style="min-width:200px;">Brand</th>
                                        <th style="width:100px; text-align:right; padding-right:20px;">Rate (&#8377;)</th>
                                        <th style="width:170px; text-align:right; padding-right:20px;">Amount (&#8377;)</th>
                                        <th style="width:170px; text-align:right; padding-right:20px;">Narration</th>
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
                                            else if($row->estimationin == 'Kgs')
                                                $totalweight = $row->singleweight * $row->quantities;
                                        ?>
                                    <tr>
                                        <td class="text-center"><?php echo $count; ?>
                                            <input type="hidden" id="type<?= $count ?>" name="type<?= $count ?>" value="<?= $row->type; ?>" />
                                            <input type="hidden" id="id<?= $count ?>" name="id<?= $count ?>" value="<?= $row->id; ?>" />
                                            <input type="hidden" id="pwid<?= $count ?>" name="pwid<?= $count ?>" value="<?= $row->pwid; ?>" />
                                            <input type="hidden" id="singleweight<?= $count; ?>" name="singleweight<?= $count; ?>" value="<?= $row->pvweight; ?>" />
                                            <input type="hidden" id="billingin<?= $count; ?>" name="billingin<?= $count; ?>" value="<?= $row->billingin; ?>" />
                                            <input type="hidden" id="unit<?= $count; ?>" name="unit<?= $count; ?>" value="<?= $row->estimationin; ?>" />
                                        </td>
                                        <td><?= $row->productname; ?></td>
                                        <td><?= $row->sizeinmm; ?></td>    
                                        <td><?= $row->estimationin; ?></td>  
                                        <td><?= $row->quantities; ?></td>                                 
                                        <td style="text-align:right;"><span id="totalweight<?= $count; ?>"><?= number_format($totalweight, 1)." Kgs"; ?></span>
                                            <input type="hidden" id="htotalweight<?= $count; ?>" name="htotalweight<?= $count; ?>" value="<?= $totalweight; ?>" />
                                            <input type="hidden" id="quantities<?= $count; ?>" name="quantities<?= $count; ?>" value="<?= $row->quantities; ?>" />
                                        </td>
                                        <td>
                                            <select id="brandid<?= $count; ?>" name="brandid<?= $count; ?>" class="form-control" onchange="getRates(<?= $count; ?>)" required>
                                                <option rate="0" brandid="0" pwid="0" value="">Select Brand</option>
                                        <?php
                                            $selectedbrandid = $row->brandid;
                                            $selectedrate = $row->rate;
                                            foreach ($producers as $producer) {
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
                                                                    $selected = "";
                                                                    if($selectedbrandid == $brand->id)
                                                                        $selected = "selected";
                                                                    echo "<option rate='" . $rate . "' brandid='" . $brand->id . "' pwid='" . $brandproduct->pwid . "' value='" . $brand->id . "' " . $selected . ">" . $brand->name . "</option>";
                                                                    $qbpcount++;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } ?>
                                            </select>
                                        </td>
                                        <td style="width:100px">                                            
                                            <input type="number" step="any" id="rate<?= $count; ?>" name="rate<?= $count; ?>" value="<?= $selectedrate; ?>" class="form-control" onkeyup="calculateAmount('yes')" style="width:80px" />
                                        </td>
                                        <td style="text-align:right; padding-right:25px;">
                                                <input type="number" step="any" id="amount<?= $count; ?>" name="amount<?= $count; ?>" class="form-control" style="text-align:right;" readonly />
                                        </td>
                                        <td style="width:170px">
                                                    <input type="text" class="form-control" id="narration<?= $count; ?>" value="<?= $row->narration;?>" name="narration<?= $count; ?>" style="width:130px;border:1px solid black" /> 
                                                </td>
                                    </tr>
                                    <?php
                                            $count++; }
                                            ?>
                                      
                                    <input type="hidden" value="<?php echo $count; ?>" name="count" id="count" />
                                    <input type="hidden" value="<?php echo $qbpcount; ?>" name="qbpcount"
                                        id="qbpcount" />
                                        <tr>
                                            <td colspan="5" style="text-align:right;"><b>Total</b></td>
                                            <td style="text-align:right;border:2px solid black"><b><input id="totalweight" name="totalweight" style="text-align:right;border: 0px none;" readonly="true" min=0 required /></b></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:right; padding-right:25px;border:2px solid black"><input type="number" id="subtotal" name="subtotal" style="width:180px; text-align:right;border: 0px none;" readonly="true" min=0 required /> </td>
                                        </tr>
                                </tbody>
                            </table>
                            <!-- <table class="table table-bordered custom-table">
                                <tbody>
                                    <tr>
                                        <td style="text-align:right;">
                                                Loading Charges  (
                                                    <label>
                                                        <input type="radio" name="loading" value="Yes" id="lchargesyes" onchange="loadingchargeschanged()"  />
                                                        Yes
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="loading" value="No" id="lchargesno" onchange="loadingchargeschanged()" />
                                                        No
                                                    </label>
                                                ): <input type="number" step="any" id="lcharges" name="lcharges" style="width:180px; text-align:right;" onkeyup="calculateAmount('no')" min=0 value="" /><br />
                                                Cutting Charges : <input type="number" step="any" id="ccharges" name="ccharges" style="width:180px; text-align:right;" onkeyup="calculateAmount('no')" min=0 value="" /><br />
                                                Freight Charges (
                                                    <label>
                                                        <input type="radio" name="paidby" value="Free Delivery" id="free" onchange="freighttypechanged()" />
                                                        Free Delivery
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="paidby" value="Extra" id="extra"  onchange="freighttypechanged()"  />
                                                        Extra
                                                    </label>
                                                ): <input type="number" step="any" id="fcharges" name="fcharges" style="width:180px; text-align:right;" onkeyup="calculateAmount('no')" min=0 value="" /><br />
                                                Other Charges : <input type="number" step="any" id="ocharges" name="ocharges" style="width:180px; text-align:right;" onkeyup="calculateAmount('no')" min=0 value="" /><br />
                                                GST(18%) : <input type="number" step="any" id="gst" name="gst" readonly="true" style="width:180px; text-align:right;border: 0px none;" onkeyup="calculateAmount('no')" min=0 /><br />
                                                Round Off : <input type="number" step="any" id="roundoff" name="roundoff" readonly="true" style="width:180px; text-align:right;border: 0px none;" onkeyup="calculateAmount('no')" min=0 /><br />
                                                Total : <input type="number" step="any" id="total" name="total" readonly="true" style="width:180px; text-align:right;border: 0px none;" onkeyup="calculateAmount('no')" min=0 /><br />
                                                Vehicle No : <input type="text" id="vehicleno" name="vehicleno" style="width:180px;" value="" /><br />
                                            </td>
                                    </tr>
                                </tbody>
                            </table> -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <!-- <input type="submit" class="btn btn-primary pull-left" value="Submit & Print" /> -->
                        <a href="#" class="btn btn-primary pull-right" onclick="return validateForm()">Submit</a>
                    </div>
                </div>
                <!-- Modal start -->
                <div id="charges_modal" class="modal p-5" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h3 class="modal-title text-center text-white">Confirm Charges</h3>
                                <button type="button btn-danger" class="close" onclick="closeModal()"
                                    data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="m-b-30">
                                <table class="table table-bordered custom-table">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:right;">
                                                Loading Charges (
                                                <label>
                                                    <input type="radio" name="loading" value="Yes" id="lchargesyes"
                                                        onchange="loadingchargeschanged()" checked />
                                                    Yes
                                                </label>
                                                <label>
                                                    <input type="radio" name="loading" value="No" id="lchargesno"
                                                        onchange="loadingchargeschanged()" />
                                                    No
                                                </label>
                                                ): <input type="number" step="any" id="lcharges" name="lcharges"
                                                    style="width:180px; text-align:right;"
                                                    onkeyup="calculateAmount('no')" min=0 value="" /><br />
                                                Cutting Charges : <input type="number" step="any" id="ccharges"
                                                    name="ccharges" style="width:180px; text-align:right;"
                                                    onkeyup="calculateAmount('no')" min=0 value="0" /><br />
                                                Freight Charges (
                                                <label>
                                                    <input type="radio" name="paidby" value="Free Delivery" id="free"
                                                        onchange="freighttypechanged()" />
                                                    Free Delivery
                                                </label>
                                                <label>
                                                    <input type="radio" name="paidby" value="Extra" id="extra"
                                                        onchange="freighttypechanged()" checked />
                                                    Extra
                                                </label>
                                                ): <input type="number" step="any" id="fcharges" name="fcharges"
                                                    style="width:180px; text-align:right;"
                                                    onkeyup="calculateAmount('no')" min=0 value="0" /><br />
                                                <!-- Other Charges : <input type="number" step="any" id="ocharges"
                                                    name="ocharges" style="width:180px; text-align:right;"
                                                    onkeyup="calculateAmount('no')" min=0 value="" /><br /> -->

                                                    CD (
                                                    <label>
                                                        <input type="radio" name="cd" value="0" id="cd_zero" onchange="cdchanged()" checked  />
                                                        0%
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="cd" value="0.5" id="cd_half" onchange="cdchanged()"  />
                                                        0.5%
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="cd" value="1" id="cd_one" onchange="cdchanged()"  />
                                                        1%
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="cd" value="1.5" id="cd_one_half" onchange="cdchanged()"  />
                                                        1.5%
                                                    </label>
                                                ): <input type="number" step="any" id="ocharges" name="ocharges" style="width:180px; text-align:right;" onkeyup="calculateAmount('no')" min=0 value="0" /><br />
                                                GST(18%) : <input type="number" step="any" id="gst" name="gst"
                                                    readonly="true"
                                                    style="width:180px; text-align:right;border: 0px none;"
                                                    onkeyup="calculateAmount('no')" min=0 /><br />
                                                Round Off : <input type="number" step="any" id="roundoff"
                                                    name="roundoff" readonly="true"
                                                    style="width:180px; text-align:right;border: 0px none;"
                                                    onkeyup="calculateAmount('no')" min=0 /><br />
                                                Total : <input type="number" step="any" id="total" name="total"
                                                    readonly="true"
                                                    style="width:180px; text-align:right;border: 0px none;"
                                                    onkeyup="calculateAmount('no')" min=0 /><br />
                                                <input type="hidden" id="vehicleno" name="vehicleno"
                                                    style="width:180px;" value="" /><br />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                <div class="m-t-50 text-center">
                                    <button class="btn btn-primary submit-btn">submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal End -->
            </form>
        </div>
    <a class="btn btn-danger pull-left" href="<?= base_url('admin/printrequest/'.$id); ?>" style="color:white;"> 
            <i class="fa fa-arrow-left fa-lg"></i> Lead</a><br/><br/><br/><br/>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/jquery-3.3.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/bootstrap.js'?>"></script>
<script>

    function validateForm()
    {
        
        var count = document.getElementById("count").value;
        for (var i = 1; i < count; i++) {
        var brand = document.getElementById("brandid" + i).value;
        
            if (brand == "" || brand == 0) {
                showSnackbar("Please select brand");
                document.getElementById("brandid" + i).focus();
                return false;
            }
        openModal();

    }



    //confirmSubmit();
    }

    function cdchanged()
    {
        if(document.getElementById("cd_zero").checked == true){
            document.getElementById("ocharges").value = "0";
        }
        calculateAmount('yes');
    }

    function openModal() {
    var modal = document.getElementById('charges_modal');
    modal.style.display = 'block';
    console.log(modal);
}

function closeModal() {
    var modal = document.getElementById("charges_modal");
    modal.style.display = "none";
}

function getRates(index)
{
    var brands = document.getElementById("brandid" + index);
    var bid = brands.options[brands.selectedIndex].getAttribute('brandid');
    var pid = brands.options[brands.selectedIndex].getAttribute('pwid');
    var rate = parseFloat(brands.options[brands.selectedIndex].getAttribute('rate'));
    if(rate != 0){
        document.getElementById("rate" + index).value =  rate.toFixed(2);
        calculateAmount('no');
    }
    else{
        $.ajax({
            url : "<?php echo base_url('admin/getrates');?>",
            method : "POST",
            data : {productid: pid, brandid: bid},
            async : true,
            dataType : 'json',
            success: function(data){
                document.getElementById("rate" + index).value =data.toFixed(2);
                //calculateAmount();
                calculateAmount('no');
            },
            error: function(err)
            {
                
            }
        });
    }
}

function calculateAmount(considerloadingcharges) {
    var count = parseInt(document.getElementById("count").value);
    var subtotal = parseFloat("0");
    var total = parseFloat("0");
    var totalweight = parseFloat("0");
    for(var i = 1; i < count; i++)
    {
        var weight = parseFloat("0" + document.getElementById("singleweight" + i).value);
        var type = document.getElementById("type" + i).value;
        var quantities = parseFloat(document.getElementById("quantities" + i).value);        
        var brand = document.getElementById("brandid" + i);
        var rate = parseFloat("0" + document.getElementById("rate" + i).value);
        var billingin = document.getElementById("billingin" + i).value;
        var unit = document.getElementById("unit" + i).value;

        var productweight = 0;        
        if(unit == 'Meter')
            productweight  = weight * quantities;
        else if(unit == 'Feet')
            productweight  = (weight / 3.28) * quantities;
        else if(unit == 'Nos')
        {
            if(type == 'Meter')
                productweight  = (weight * 6) * quantities;
            else
                productweight  = weight * quantities;
        }
        else if(unit == 'Kgs')
        {
            productweight = parseFloat("0" + document.getElementById("htotalweight" + i).value);
            quantities = productweight / weight;
        }        
        var amount = 0;
        if(billingin == "Kgs")
            amount = rate * productweight;
        else
            amount = rate * quantities;  
        //alert(amount + " " +  rate + " " + totalweight + " " + quantities);
        totalweight += productweight;
        subtotal += amount;
        document.getElementById("amount" + i).value = amount.toFixed(1);
    }
    document.getElementById("totalweight").value = totalweight.toFixed(1) + " Kg";
    document.getElementById("subtotal").value = subtotal.toFixed(2);
    // var lcharges = totalweight * 0.25;
    // document.getElementById("lcharges").value = lcharges.toFixed(2);

    if(considerloadingcharges == 'yes'){
        if(document.getElementById("lchargesyes").checked == true){
            var lcharges = totalweight * 0.29;
            document.getElementById("lcharges").value = lcharges.toFixed(2);
        }
        else{
            document.getElementById("lcharges").value = '0';
        }
        if(document.getElementById("cd_half").checked == true){
            var ocharges = subtotal * (0.5 / 100);
            document.getElementById("ocharges").value = ocharges.toFixed(2);
        }
        else if(document.getElementById("cd_one").checked == true){
            var ocharges = subtotal * (1 / 100);
            document.getElementById("ocharges").value = ocharges.toFixed(2);
        }
        else if(document.getElementById("cd_one_half").checked == true){
            var ocharges = subtotal * (1.5 / 100);
            document.getElementById("ocharges").value = ocharges.toFixed(2);
        }
        else{
            document.getElementById("ocharges").value = '0';
        }
    }
    var lcharges = parseFloat("0" + document.getElementById("lcharges").value);
    var ccharges = parseFloat("0" + document.getElementById("ccharges").value);
    var fcharges = parseFloat("0" + document.getElementById("fcharges").value);
    var ocharges = parseFloat("0" + document.getElementById("ocharges").value);
    // subtotal += lcharges + ccharges + fcharges + ocharges;
    subtotal += (lcharges + ccharges + fcharges) - ocharges;
    var gst = subtotal * (18 / 100);
    document.getElementById("gst").value = gst.toFixed(2);
    subtotal += gst;

    var roundoff = subtotal - Math.floor(subtotal);
    total = Math.floor(subtotal);
    document.getElementById("roundoff").value = roundoff.toFixed(2);
    document.getElementById("total").value = total.toFixed(2);
}

function freighttypechanged()
    {
        if(document.getElementById("free").checked == true){
            document.getElementById("fcharges").value = "0";
            document.getElementById("fcharges").disabled= true;
        }
        calculateAmount('no');
    }
    
    function loadingchargeschanged()
    {
        if(document.getElementById("lchargesno").checked == true){
            document.getElementById("lcharges").value = "0";
        }
        calculateAmount('yes');
    }

calculateAmount('yes');
//calculateAmount();
</script>

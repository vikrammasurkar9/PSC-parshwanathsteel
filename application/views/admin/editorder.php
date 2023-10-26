<div class="page-wrapper">
    <div class="content"> 
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><b>Edit Delivery Order</b></h4>
            </div>
        </div>
         <div class="card-box" style="border-style:ridge">
            <form action="<?php echo base_url('admin/saveOrder'); ?>" method="post" enctype="multipart/form-data" onsubmit="return  confirmSubmit();">
                <input type="hidden" name="id" value="<?= $data->id; ?>" autocomplete="off" />
                <input type="hidden" id="send" name="send" value="No" />
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3"> 
                            <label>Select Firm</label>
                            <select id="" name="firmid" class="form-control">
                                <?php
                                    foreach($firms as $firm)
                                    {
                                        echo "<option value='" . $firm->id . "' " . ($id == 0 ? "" : ($data->firmid == $firm->id ? "selected" : "")) . ">" . $firm->firm . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Firm Name </label>
                                <input class="form-control" name="firmname" id="firmname" value="<?= $data->firmname; ?>" type="text" required />
                        </div>
                        <div class="col-sm-3">
                            <label>Name </label>
                                <input class="form-control" name="name" id="name" value="<?= $data->name; ?>" type="text"  />
                        </div>
                        <div class="col-sm-3" style="display:none">
                            <label>Email</label>
                                <input class="form-control" name="email" id="email" value="<?= $data->email; ?>" type="text" />
                        </div>
                        <div class="col-sm-3"> 
                            <label>Mobile</label>
                            <input type="number" id="mobileno" name="mobileno" class="form-control" value="<?= $data->mobileno; ?>" />
                        </div>
                        
                        
                            <div class="col-sm-3">
                                <label>State<span class="text-danger">*</span></label>
                                <select class="form-control" name="state" id="state" onchange="bindcities()" required>
                                    <option value="" id="">Select State</option>
                                    <?php foreach($states AS $state)
                                    {?>
                                    <option id="<?= $state->id;?>" value="<?= $state->name;?>"
                                        <?php echo $data->state == $state->name ? ' selected ' : ''; ?>>
                                        <?= $state->name;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>District <span class="text-danger">*</span></label>
                                
                                <select class="form-control" id="city" name="city">
                                    <option value="">Select City</option>
                                    <?php 
                                                foreach($cities AS $city)
                                                {
                                                    echo "<option value='" . $city->city . "' " . ($data->city == $city->city ? "selected" : "") . ">" . $city->city . "</option>";

                                                }
                                            ?>


                                </select>
                            </div>
                        <div class="col-sm-3"> 
                            <label>Address<span class="text-danger">*</span></label>
                            <input type="text"id="address"  name="address" class="form-control" value="<?= $data->address; ?>" />
                        </div>
                        <div class="col-sm-3"> 
                            <label>GST No</label>
                            <input type="text"  name="gstno" class="form-control" value="<?= $data->gstno; ?>" />
                        </div>
                          

                        <div class="col-sm-3"> 
                            <label>PO Number</label>
                            <input type="text" id="ponumber" name="ponumber" class="form-control" value="<?= $data->ponumber; ?>" />
                        </div>
                        <div class="col-sm-3">
                            <label>Payment Mode<span class="text-danger">*</span></label>
                            <select name="paymentmode" id="paymentmode" class="form-control" required>
                                <option value="">Select</option>         
                                <option value="Cash" <?= ($data->paymentmode == "Cash" ? "selected" : ""); ?>>Cash</option>
                                <option value="Cheque" <?= ($data->paymentmode == "Cheque" ? "selected" : ""); ?>>Cheque</option>
                                <option value="NEFT / RTGS" <?= ($data->paymentmode == "NEFT / RTGS" ? "selected" : ""); ?>>NEFT / RTGS</option>                                    
                                <option value="Against Delivery" <?= ($data->paymentmode == "Against Delivery" ? "selected" : ""); ?>>Against Delivery</option>
                                <option value="Other" <?= ($data->paymentmode == "Other" ? "selected" : ""); ?>>Other</option>                                    
                            </select>                         
                        </div>  
                        <div class="col-sm-3">
                            <label>Payment Details </label>
                                <input class="form-control" name="paymentdetails" id="paymentdetails" value="<?= $data->paymentdetails; ?>" type="text" />
                        </div>
                        <div class="col-sm-3">
                            <label>Order Status</label>
                            <select name="status" id="" class="form-control" required>
                                <option value="Open" <?= ($data->status == "Open" ? "selected" : ""); ?>>Open</option>         
                                <option value="Close" <?= ($data->status == "Close" ? "selected" : ""); ?>>Close</option>           
                            </select>                         
                        </div> 
                        <div class="col-sm-3">
                            <label>Profession<span class="text-danger">*</span></label>
                                <input class="form-control" list="professions" name="profession" id="profession" value="<?= $id == 0 ? '' : $data->profession; ?>" type="text" required>

                        <datalist id="professions">
                        <?php foreach($professions as $profession)
                        {
                          echo "<option value='".$profession->name."'>";
                        } ?>
                        </datalist>
                        </div>
                        <div class="col-sm-3">
                            <label>Enquiry Source</label>
                               
                        <select class="form-control" name="enquirysource" id="enquirysource" >
                            <option value="">Select Source</option>
                        <?php foreach($enquirysources as $enquirysource)
                        {
                          echo "<option value='".$enquirysource->name."' ". ($data->enquirysource == $enquirysource->name ? "selected" : "") ." >".$enquirysource->name."</option>";
                        } ?>

                                </select>
                        </div>
                        <div class="col-sm-3"> 
                            <label>Enquiry Ref.[Narration]</label>
                            <input type="text"  name="narration" class="form-control" value="<?= $data->narration; ?>" />
                        </div>
                        <div class="col-sm-3 pull-right">
                            <br />
                            <!-- <button class="btn btn-lg btn-primary pull-right" style="width:180px">Submit</button> -->
                            <a href="#" class="btn btn-primary" onclick="return validateForm()">Submit</a>
                        </div>                                 
                    </div> 
                    <hr/>
                    
                    <div class="row">
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
                                            <th>Total Weight</th>
                                            <th>Brand</th>
                                            <th>Rate</th>
                                            <th>Total</th>
                                            <th>Narration</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i=1;
                                            for($i=1;$i<=20;$i++){
                                                $pid = "";
                                                $pwid = "";
                                                $brandid = "";
                                                $estimationin = "";
                                                $quantities = "";
                                                $weight = "";
                                                $singleweight = "";
                                                $rate = "";
                                                $amount = "";
                                                $type = "";
                                                $billingin = "";
                                                $narration = "";
                                                if(count($result) >= $i)
                                                {
                                                    $row = $result[$i - 1];
                                                    $pid = $row->pid;
                                                    $pwid = $row->pwid;
                                                    $brandid = $row->brandid;
                                                    $estimationin = $row->estimationin;
                                                    $quantities = $row->quantities;
                                                    $singleweight = $row->singleweight;
                                                    $weight = $row->weight;
                                                    $rate = $row->rate;
                                                    $amount = $row->amount;
                                                    $narration = $row->narration;
                                                }
                                            ?>
                                        
                                            <tr>
                                                <td style="width:50px; text-align:center;"><?= $i;?></td>
                                                <td style="width:180px;">
                                                    <select class="form-control" name="pid<?= $i; ?>" id="pid<?= $i; ?>" onchange="bindvarieties(<?= $i; ?>)">
                                                        <option value="">Select</option>
                                                        <?php foreach($productlist as $row){
                                                            $selected = "";
                                                            if($pid == $row->id){
                                                                $selected = "selected";
                                                                $type = $row->type;
                                                                $billingin = $row->billingin;
                                                            }
                                                            ?>
                                                        <option type="<?php echo $row->type;?>" billingin="<?php echo $row->billingin;?>" value="<?php echo $row->id;?>" <?= $selected; ?>><?php echo $row->product;?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </td>
                                                <td style="width:180px;">
                                                    <select class="form-control" id="pwid<?= $i; ?>" name="pwid<?= $i; ?>" onchange="bindBrands(<?= $i;?>)"  >
                                                        <option value="">Select</option>
                                                        <?php 
                                                        if($pid != ""){
                                                            foreach($productvarietylist as $row){
                                                                if($pid == $row->pid){
                                                                    $selected = "";
                                                                    if($pwid == $row->id)
                                                                        $selected = "selected";
                                                            ?>
                                                        <option weight='<?= $row->weight; ?>' value='<?= $row->id ?>' <?= $selected; ?>><?= $row->sizeinmm; ?></option>
                                                        <?php  }}} ?>                                                        
                                                    </select>
                                                </td>
                                                <td style="width:100px;">
                                                    <select name="unit<?= $i; ?>" id="unit<?= $i; ?>" class="form-control" onchange="calculateWeight(<?= $i;?>)" style="width:80px;">
                                                    <?php
                                                        if($type == "Meter")
                                                        {
                                                            if($billingin == "Meter"){
                                                                echo "<option value='Meter' " . ($estimationin == "Meter" ? "selected" : "") . ">Meter</option>";
                                                            }
                                                            else if($billingin == "Feet"){
                                                                echo "<option value='Feet' " . ($estimationin == "Feet" ? "selected" : "") . ">Feet</option>";
                                                            }
                                                            else{
                                                                echo "<option value='Meter' " . ($estimationin == "Meter" ? "selected" : "") . ">Meter</option>";
                                                                echo "<option value='Feet' " . ($estimationin == "Feet" ? "selected" : "") . ">Feet</option>";
                                                                echo "<option value='Nos' " . ($estimationin == "Nos" ? "selected" : "") . ">Nos</option>";
                                                            }
                                                        }
                                                        else if($type == "Nos")
                                                        {
                                                            echo "<option value='Nos' " . ($estimationin == "Nos" ? "selected" : "") . ">Nos</option>";
                                                        }
                                                        echo "<option value='Kgs' " . ($estimationin == "Kgs" ? "selected" : "") . ">Kgs</option>";
                                                    ?>
                                                    </select>
                                                </td>
                                                <td style="width:50px;" >
                                                    <input type="hidden" class="form-control" id="singleweight<?= $i; ?>" name="singleweight<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)" style="width:100px; text-align:center;" value="<?= $singleweight; ?>"/> 
                                                    <input type="number" class="form-control" name="quantities<?= $i; ?>" id="quantities<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)" value="<?= $quantities; ?>" style="width:70px; text-align:center; <?= ($estimationin == "Kgs" ? "display:none" : "") ?>"/>
                                                </td>
                                                <td style="width:100px">
                                                    <input type="number" class="form-control" id="totalweight<?= $i; ?>" name="weight<?= $i; ?>" style="width:100px; text-align:center;" value="<?= $weight; ?>" onchange="copyWeightToSingle(<?= $i; ?>)"  <?= ($estimationin == "Kgs" ? "" : "readonly") ?> step="any" />
                                                </td>
                                                <td style="width:180px;">
                                                    <select class="form-control" id="brand<?= $i; ?>" name="brand<?= $i; ?>" onchange="getRate(<?= $i;?>)"  >
                                                        <option value="">Brand</option>
                                                        <?php
                                                            if($pid != ""){
                                                                foreach($brands as $row){
                                                                    if($pwid == $row->pwid){
                                                                        $selected = "";
                                                                        if($brandid == $row->bid)
                                                                            $selected = "selected";
                                                                ?>
                                                            <option billingrate="<?= $row->billingrate ?>" value="<?= $row->bid ?>" <?= $selected ?>><?= $row->name; ?></option>
                                                        <?php  }}} ?>    
                                                    </select>
                                                </td>
                                                <td style="width:50px;" >
                                                    <input type="number" class="form-control" name="rate<?= $i; ?>" id="rate<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)" value="<?= $rate; ?>"  style="width:70px; text-align:center; " step="any" />
                                                </td>
                                                <td style="width:100px">
                                                    <input type="number" class="form-control" id="totalAmount<?= $i; ?>" name="totalAmount<?= $i; ?>" style="width:100px; text-align:center;" value="<?= $amount; ?>" tabindex=-1 readonly/> 
                                                </td>
                                                <td style="width:100px">
                                                    <input type="text" class="form-control" id="narration<?= $i; ?>" name="narration<?= $i; ?>" style="width:100px;" value="<?= $narration; ?>" /> 
                                                </td>
                                                <td style="width:80px">
                                                    <a onclick="Reset(<?= $i;?>);" style="cursor:pointer;"><i class="fa fa-times-circle fa-3x" aria-hidden="true" style="color:red"></i></a>
                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>  
                                        <tr>
                                            <td colspan="5"></td>
                                            <td>
                                                <span id="spnTotalWeight"></span>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <span id="spnTotalAmount"></span>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>                                      
                                    </tbody>
                                </table>
                                <input type="hidden"  id="count" name="count" value="<?= $i ?>" />
                                
                            </div>
                        </div>
                    </div>                    
                </div>
                 <!-- Modal start -->
                 <div id="charges_modal" class="modal p-5" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h3 class="modal-title text-center text-white">Confirm Charges</h3>
                                <button type="button" class="close" onclick="closeModal()"
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
                                                        <input type="radio" name="loading" id="lchargesyes"
                                                            onchange="loadingchargeschanged()" value="Yes"
                                                            <?= $data->loading == "Yes" ? "checked" : ""; ?> />
                                                        Yes
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="loading" id="lchargesno"
                                                            onchange="loadingchargeschanged()" value="No"
                                                            <?= $data->loading == "No" ? "checked" : ""; ?> />
                                                        No
                                                    </label>
                                                    ): <input type="number" step="any" id="lcharges" name="lcharges"
                                                        style="width:150px; text-align:right;"
                                                        onkeyup="calculateTotalWeight('no')" min=0
                                                        value="<?= $data->lcharges; ?>" /><br />
                                                    Cutting Charges : <input type="number" step="any" id="ccharges"
                                                        name="ccharges" style="width:150px; text-align:right;"
                                                        onkeyup="calculateTotalWeight('no')" min=0
                                                        value="<?= $data->ccharges; ?>" /><br />
                                                    Freight Charges (
                                                    <label>
                                                        <input type="radio" name="paidby" value="Free Delivery"
                                                            id="free" onchange="freighttypechanged()"
                                                            <?= $data->paidby == "Free Delivery" ? "checked" : ""; ?> />
                                                        Free Delivery
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="paidby" value="Extra" id="extra"
                                                            onchange="freighttypechanged()"
                                                            <?= $data->paidby == "Extra" ? "checked" : ""; ?> />
                                                        Extra
                                                    </label>
                                                    ): <input type="number" step="any" id="fcharges" name="fcharges"
                                                        style="width:150px; text-align:right;"
                                                        onkeyup="calculateTotalWeight('no')" min=0
                                                        value="<?= $data->fcharges; ?>" /><br />
                                                        CD (
                                                    <label>
                                                        <input type="radio" name="cd" value="0" id="cd_zero" onchange="cdchanged()" <?= $data->cd == 0 ? "checked" : ""; ?>  />
                                                        0%
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="cd" value="0.5" id="cd_half" onchange="cdchanged()" <?= $data->cd == 0.5 ? "checked" : ""; ?>   />
                                                        0.5%
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="cd" value="1" id="cd_one" onchange="cdchanged()" <?= $data->cd == 1 ? "checked" : ""; ?>   />
                                                        1%
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="cd" value="1.5" id="cd_one_half" onchange="cdchanged()" <?= $data->cd == 1.5 ? "checked" : ""; ?>  />
                                                        1.5%
                                                    </label>
                                                ):  <input type="number" step="any" id="ocharges"
                                                        name="ocharges" style="width:150px; text-align:right;"
                                                        onkeyup="calculateTotalWeight('no')" min=0
                                                        value="<?= $data->ocharges; ?>" /><br />
                                                    GST(18%) : <input type="number" step="any" id="gst" name="gst"
                                                        readonly="true"
                                                        style="width:150px; text-align:right;border: 0px none;"
                                                        onkeyup="calculateTotalWeight('no')" min=0 /><br />
                                                    Round Off : <input type="number" step="any" id="roundoff"
                                                        name="roundoff" readonly="true"
                                                        style="width:150px; text-align:right;border: 0px none;"
                                                        onkeyup="calculateTotalWeight('no')" min=0 /><br />
                                                    Total : <input type="number" step="any" id="total" name="total"
                                                        readonly="true"
                                                        style="width:150px; text-align:right;border: 0px none;"
                                                        onkeyup="calculateTotalWeight('no')" min=0 /><br />

                                                    Vehicle No : <input type="text" id="vehicleno" name="vehicleno"
                                                        style="width:150px;" value="<?= $data->vehicleno; ?>"  /><br />
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
    </div>    
</div>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/jquery-3.3.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/bootstrap.js'?>"></script>
<script type="text/javascript">

function validateForm() {


    let firmname = document.getElementById("firmname").value;
    
    let name = document.getElementById("name").value;
    let mobileno = document.getElementById("mobileno").value;
    let address = document.getElementById("address").value;
    let city = document.getElementById("city").value;
    let state = document.getElementById("state").value;
    let paymentmode = document.getElementById("paymentmode").value;
    let profession = document.getElementById("profession").value;

    

    if (firmname == "") {
        showSnackbar("Please Enter Firmname");
        document.getElementById("firmname").focus();
        return false;
    }
    if (mobileno == "") {
        showSnackbar("Please Enter WhatsApp Number");
        document.getElementById("mobileno").focus();
        return false;
    }
    
    if (state == "") {
        showSnackbar("Please Select State ");
        document.getElementById("state").focus();
        return false;
    }
    if (city == "") {
        showSnackbar("Please Select city");
        document.getElementById("city").focus();
        return false;
    }
    if (address == "") {
        showSnackbar("Please Enter Address");
        document.getElementById("address").focus();
        return false;
    }
    if (paymentmode == "") {
        showSnackbar("Please Select Payment Mode");
        document.getElementById("paymentmode").focus();
        return false;
    }
    if (profession == "") {
        showSnackbar("Please Select Profession");
        document.getElementById("profession").focus();
        return false;
    }


    var count = document.getElementById("count").value;
    for (var i = 1; i < count; i++) {
        var pid = document.getElementById("pid" + i).value;

        if(i == 1)
        {
            if(pid == "")
            {
                showSnackbar("Please select product");
                document.getElementById("pid"+i).focus();
                return false;
            }
        }

        var pwid = document.getElementById("pwid" + i).value;
        var brand = document.getElementById("brand" + i).value;
        if (pid != "" || pwid != 0) {
            if (brand == "" || brand == 0) {
                showSnackbar("Please select brand");
                document.getElementById("brand" + i).focus();
                return false;
            }
        }
        openModal();

    }




    //confirmSubmit();


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
function cdchanged()
    {
        if(document.getElementById("cd_zero").checked == true){
            document.getElementById("ocharges").value = "0";
        }
        calculateTotalWeight('yes');
    }

    function copyWeightToSingle(i)
    {
        if(document.getElementById("unit" + i).value == "Kgs")
        {
            document.getElementById("singleweight" + i).value = document.getElementById("totalweight" + i).value;
            calculateWeight(i);
        }
    }

    function calculateTotalWeight(considerloadingcharges)
    {
        var count = document.getElementById("count").value;
        var totalweight = 0, subtotal = 0;
        for(var i = 1; i < count; i++)
        {
            totalweight +=  parseFloat("0" + document.getElementById("totalweight" + i).value);
            subtotal +=  parseFloat("0" + document.getElementById("totalAmount" + i).value);
        }

        document.getElementById("spnTotalWeight").innerText = "Total Weight : " + totalweight.toFixed(1);
        document.getElementById("spnTotalAmount").innerText = "Total Amount : " + subtotal.toFixed(1);

        // var lcharges = totalweight * 0.18;
        // document.getElementById("lcharges").value = lcharges.toFixed(2);
        if(considerloadingcharges == 'yes'){
        if(document.getElementById("lchargesyes").checked == true)
        {
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

    function bindvarieties(position){
        var pid = document.getElementById("pid" + position);  
        var type = pid.options[pid.selectedIndex].getAttribute('type');
        var billingin = pid.options[pid.selectedIndex].getAttribute('billingin');
        var units = "";
        if(type == "Meter")
        {
            if(billingin == "Meter"){
                units = "<option value='Meter'>Meter</option>";
            }
            else if(billingin == "Feet"){
                units += "<option value='Feet'>Feet</option>";
            }
            else{
                units = "<option value='Meter'>Meter</option>";
                units += "<option value='Feet'>Feet</option>";
                units += "<option value='Nos' selected>Nos</option>";
            }
        }
        else{
            units = "<option value='Nos' selected>Nos</option>";
        }
        units += "<option value='Kgs'>Kgs</option>";
        document.getElementById("unit" + position).innerHTML = units;
        $.ajax({
            url : "<?php echo base_url('admin/getvarieties');?>",
            method : "POST",
            data : {id: pid.value},
            async : true,
            dataType : 'json',
            success: function(data){                        
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option weight='+data[i].weight+' value='+data[i].id+'>'+data[i].sizeinmm+'</option>';
                }
                document.getElementById("pwid" + position).innerHTML = html;
                document.getElementById("quantities"+position).value = "1";
                copyWeight(document.getElementById("pwid" + position), position);
            }
        });
    }

    function copyWeight(ctrl, i)
    {
        document.getElementById("singleweight" + i).value = ctrl.options[ctrl.selectedIndex].getAttribute('weight');   
        bindBrands(i);
    }


    function bindBrands(position)
    {
        var pwid = document.getElementById("pwid" + position);  
        $.ajax({
            url : "<?php echo base_url('admin/getbrands');?>",
            method : "POST",
            data : {id: pwid.value},
            async : true,
            dataType : 'json',
            success: function(data){                        
                var html = '';
                var i;
                html += '<option rate="0" value="0">Brand</option>';
                for(i=0; i<data.length; i++){
                    html += '<option billingrate=' + data[i].billingrate + ' value='+data[i].id + '>' + data[i].name + '</option>';
                }
                document.getElementById("brand" + position).innerHTML = html;
                calculateWeight(position);
            }
        });
    }

    function getRate(position)
    {
        var brandid = document.getElementById("brand" + position);
        var billingrate = brandid.options[brandid.selectedIndex].getAttribute('billingrate');
        if(billingrate == 'null'){
             billingrate = "";
             showSnackbar("Rate not available in system.");
        }
        var rate = parseFloat("0" + billingrate);
        document.getElementById("rate" + position).value = rate.toFixed(1);
        calculateWeight(position);
    }

    function copyWeight(ctrl, i)
    {
        document.getElementById("singleweight" + i).value = ctrl.options[ctrl.selectedIndex].getAttribute('weight');   
        bindBrands(i);
    }

    function calculateWeight(i) {
        document.getElementById("quantities" + i).style.display = "block";
        document.getElementById("quantities" + i).readOnly = false;
        document.getElementById("totalweight" + i).readOnly = true;

        var quantities = parseFloat("0" + document.getElementById("quantities" + i).value);
        var unit = document.getElementById("unit" + i).value;
        var pid = document.getElementById("pid" + i);
        var type = pid.options[pid.selectedIndex].getAttribute('type');
        var billingin = pid.options[pid.selectedIndex].getAttribute('billingin');
        var pwid = document.getElementById("pwid" + i);

        if(unit != "Kgs")
            document.getElementById("singleweight" + i).value = pwid.options[pwid.selectedIndex].getAttribute('weight');   
        var weight = parseFloat("0" + document.getElementById("singleweight" + i).value);

        var weight = parseFloat("0" + document.getElementById("singleweight" + i).value);
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
            document.getElementById("quantities" + i).readOnly = true;
            document.getElementById("totalweight" + i).readOnly = false;
            document.getElementById("quantities" + i).style.display = "none";
            document.getElementById("quantities" + i).value = "1";

            // if(document.activeElement.id != 'rate' + i){                
                
            //     document.getElementById("singleweight" + i).value = "";            
            //     weight = 0;
            //     showSnackbar("Enter weight.");
            //     document.getElementById("totalweight"+i).focus();
            // }            
            quantities = 1;
            totalweight  = weight * quantities;            
        }
        if(totalweight == 0)
            document.getElementById("totalweight"+i).value = "";
        else
            document.getElementById("totalweight"+i).value = totalweight.toFixed(1);
        
        var rate = parseFloat("0" + document.getElementById("rate"+i).value);
        var total = 0;
        if(billingin == "Kgs")
            total = rate * totalweight;
        else
            total = rate * quantities;
        document.getElementById("totalAmount"+i).value = total.toFixed(2);
        calculateTotalWeight('yes');
    }

    function freighttypechanged()
    {
        if(document.getElementById("free").checked == true){
            document.getElementById("fcharges").value = "0";
            document.getElementById("fcharges").disabled= true;
    }
    
    else{
        document.getElementById("fcharges").disabled= false;
    }
        calculateTotalWeight('no');
    }
    
    function loadingchargeschanged()
    {
        if(document.getElementById("lchargesno").checked == true){
            document.getElementById("lcharges").value = "0";
        }
        calculateTotalWeight('yes');
    }


    function Reset(i) 
    {    
        var dropDown = document.getElementById("pid"+i);
        dropDown.selectedIndex = 0;
        var dropDown1 = document.getElementById("pwid"+i);
        dropDown1.selectedIndex = 0;
        var html = '<option weight=0 value=0>Select</option>';
        document.getElementById("pwid" + i).innerHTML = html;
        document.getElementById("quantities" + i).value = "";
        document.getElementById("singleweight" + i).value = "";
        document.getElementById("totalweight"+i).value = "";
        document.getElementById("unit" + i).innerHTML = "";
        document.getElementById("brand" + i).innerHTML = "";
        document.getElementById("rate"+i).value = "";        
        document.getElementById("narration"+i).value = "";
        document.getElementById("totalAmount"+i).value = "";
        bindvarieties(i);
        calculateTotalWeight('no');
    }

    calculateTotalWeight('no');
</script>




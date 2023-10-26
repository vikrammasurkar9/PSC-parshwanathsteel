<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><b>Quotations</b></h4>
            </div>
        </div>
        <div class="card-box" style="border-style:ridge">
            <form action="<?php echo base_url('admin/savenewquotation'); ?>" method="post" enctype="multipart/form-data"
                onsubmit="return confirmSubmit()" autocomplete="off">
                <input type="hidden" name="userid" value="0" />
                <input type="hidden" name="id" value="0" />
                <input type="hidden" id="send" name="send" value="No" />
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                        <label>Select Firm <span class="text-danger">*</span></label>
                                <select id="firmid" name="firmid" class="form-control" required>
                                <?php
                                        foreach($firms as $firm)
                                        {
                                            // echo "<option value='" . $firm->id . "' " . ($id == 0 ? "" : ($data->firmid == $firm->id ? "selected" : "")) . ">" . $firm->firm . "</option>";
                                            echo "<option value='" . $firm->id . "' " . ($_COOKIE['firmid'] == $firm->id ? "selected" : ""). ">" . $firm->firm . "</option>";
                                        }
                                    ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Firm Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="contactid" id="contactid" value="0" type="hidden" />
                            <input class="form-control" name="firmname" id="firmname" value="" type="text"
                                list="contacts" onchange="findcustomerdetails()" required />
                        </div>
                        <div class="col-sm-3">
                            <label>Name</label>
                            <input class="form-control" name="name" id="name" value="" type="text" />
                        </div>
                        <div class="col-sm-3">
                            <label>WhatsApp No. <span class="text-danger">*</span></label>
                            <input type="text" id="mobileno" name="mobileno" class="form-control" value="" required />
                        </div>
                        
                        
                        <div class="col-sm-3">
                            <label>State<span class="text-danger">*</span></label>
                            <select class="form-control" name="state" id="state" onchange="bindcities()" required>
                                <option value="" id="">Select State</option>
                                <?php foreach($states AS $state)
                                    {?>
                                <option  value="<?= $state->name;?>">
                                    <?= $state->name;?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>District<span class="text-danger">*</span></label>
                            <!-- <input type="text" id="city" name="city" class="form-control" value="" required /> -->
                            <select class="form-control" id="city" name="city">
                                        <option value="">Select City</option>
                                        <?php if($id !=0)
                                            {
                                                foreach($cities AS $city)
                                                {
                                                    echo "<option value='" . $city->city . "' " . ($data->city == $city->city ? "selected" : "") . ">" . $city->city . "</option>";

                                                }
                                            }?>


                                    </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Address<span class="text-danger">*</span></label>
                            <input type="text" id="address" name="address" class="form-control" value="" required />
                        </div>
                        <div class="col-sm-3">
                            <label>GST No.</label>
                            <input type="text" id="gstno" name="gstno" class="form-control" value="" />
                        </div>
                        
                        <div class="col-sm-3">
                            <label>Profession <span class="text-danger">*</span></label>

                            <select class="form-control" name="profession" id="profession" required>
                                <option value="">Select Profession</option>
                                <?php foreach($professions as $profession)
                        {
                          echo "<option value='".$profession->name."'>".$profession->name."</option>";
                        } ?>

                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Enquiry Source</label>
                               
                        <select class="form-control" name="enquirysource" id="enquirysource" >
                            <option value="">Select Source</option>
                        <?php foreach($enquirysources as $enquirysource)
                        {
                          echo "<option value='".$enquirysource->name."'>".$enquirysource->name."</option>";
                        } ?>

                                </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Enquiry Ref.[Narration]</label>
                            <input class="form-control" name="narration" id="" value="" type="text">
                        </div>

                        <div class="col-sm-3 pull-right">
                            <br />
                            <!-- <button class="btn btn-lg btn-primary pull-right" style="width:200px">Submit</button> -->

                            <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#charges_modal">Submit</a> -->

                            <a href="#" class="btn btn-primary" onclick="return validateForm()">Submit</a>


                        </div>
                        <datalist id="contacts">
                            <?php
                            foreach($contacts as $contact)
                            {
                                echo "<option contactid='" . $contact->id . "' mobileno='" . $contact->mobileno1 . "' personname='" . $contact->name . "' address='" . $contact->address . "' city='" . $contact->city . "' gstno='" . $contact->gstno . "' state='" . $contact->state . "' profession='" . $contact->profession . "'>" . $contact->firmname ."</option>";
                            }
                        ?>
                    </div>
                    <hr />

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
                                            for($i = 1; $i <= 20; $i++){
                                            ?>
                                        <tr>
                                            <td style="width:50px; text-align:center;"><?= $i;?></td>
                                            <td style="width:180px;">
                                                <select class="form-control" name="pid<?= $i; ?>" id="pid<?= $i; ?>"
                                                    onchange="bindvarieties(<?= $i; ?>)"
                                                    <?= ($i == 1 ? "required" : ""); ?>>
                                                    <option value="">Select</option>
                                                    <?php foreach($productlist as $row){
                                                            ?>
                                                    <option type="<?php echo $row->type;?>"
                                                        billingin="<?php echo $row->billingin;?>"
                                                        value="<?php echo $row->id;?>"><?php echo $row->product;?>
                                                    </option>
                                                    <?php  } ?>
                                                </select>
                                            </td>
                                            <td style="width:180px;">
                                                <select class="form-control" id="pwid<?= $i; ?>" name="pwid<?= $i; ?>"
                                                    onchange="bindBrands(<?= $i;?>)"
                                                    <?= ($i == 1 ? "required" : ""); ?>>
                                                    <option value="">Select</option>
                                                </select>
                                            </td>
                                            <td style="width:100px;">
                                                <select name="unit<?= $i; ?>" id="unit<?= $i; ?>" class="form-control"
                                                    onchange="calculateWeight(<?= $i;?>)" style="width:80px;">
                                                </select>
                                            </td>
                                            <td style="width:70px;">
                                                <input type="hidden" id="singleweight<?= $i; ?>"
                                                    name="singleweight<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)"
                                                    style="width:80px; text-align:center; " class="form-control" />
                                                <input type="number" class="form-control" name="quantities<?= $i; ?>"
                                                    id="quantities<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)"
                                                    value="" style="width:70px; text-align:center; " />
                                            </td>
                                            <td style="width:100px">
                                                <input type="number" class="form-control" id="totalweight<?= $i; ?>"
                                                    name="weight<?= $i; ?>" style="width:80px; text-align:center; "
                                                    onchange="copyWeightToSingle(<?= $i; ?>)" readonly />
                                            </td>
                                            <td style="width:180px;">
                                                <select class="form-control" id="brand<?= $i; ?>" name="brand<?= $i; ?>"
                                                    onchange="getRate(<?= $i;?>)">
                                                    <option value="">Select</option>
                                                </select>
                                            </td>
                                            <td style="width:50px;">
                                                <input type="number" class="form-control" step="any"
                                                    name="rate<?= $i; ?>" id="rate<?= $i; ?>"
                                                    onkeyup="calculateWeight(<?= $i;?>)" value=""
                                                    style="width:70px; text-align:center; "
                                                    <?= ($i == 1 ? "required" : ""); ?> autocomplete="off" />
                                            </td>
                                            <td style="width:100px">
                                                <input type="number" class="form-control" id="totalAmount<?= $i; ?>"
                                                    name="totalAmount<?= $i; ?>"
                                                    style="width:100px; text-align:center; " tabindex=-1 readonly />
                                            </td>
                                            <td style="width:100px">
                                                <input type="text" class="form-control" id="narration<?= $i; ?>"
                                                    name="narration<?= $i; ?>" style="width:100px;" />
                                            </td>
                                            <td style="width:80px">
                                                <a onclick="Reset(<?= $i;?>);"
                                                    style="display:<?= $i==1 ? 'none':'block' ?>"><i
                                                        class="fa fa-times-circle fa-3x" aria-hidden="true"
                                                        style="color:red"></i></a>
                                            </td>
                                        </tr>
                                        <?php 
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td>
                                                <span id="spnTotalWeight"></span>
                                                <input type="hidden" id="totalweight" name="totalweight" value="" />
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <span id="spnTotalAmount"></span>
                                                <input type="hidden" id="subtotal" name="subtotal" value="" />
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="count" name="count" value="<?= $i ?>" />
                                
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
                                                    style="width:150px; text-align:right;"
                                                    onkeyup="calculateTotalWeight('no')" min=0 value="" /><br />
                                                Cutting Charges : <input type="number" step="any" id="ccharges"
                                                    name="ccharges" style="width:150px; text-align:right;"
                                                    onkeyup="calculateTotalWeight('no')" min=0 value="0" /><br />
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
                                                    style="width:150px; text-align:right;"
                                                    onkeyup="calculateTotalWeight('no')" min=0 value="0" /><br />
                                                <!-- Other Charges : <input type="number" step="any" id="ocharges"
                                                    name="ocharges" style="width:150px; text-align:right;"
                                                    onkeyup="calculateTotalWeight('no')" min=0 value="" /><br /> -->

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
                                                ): <input type="number" step="any" id="ocharges" name="ocharges" style="width:150px; text-align:right;" onkeyup="calculateTotalWeight('no')" min=0 value="0" /><br />
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
                                                <input type="hidden" id="vehicleno" name="vehicleno"
                                                    style="width:150px;" value="" /><br />
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
   
}


function findcustomerdetails() {
    var inputValue = document.getElementById("firmname").value;
    var options = document.getElementById("contacts").options;
    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        if (option.innerText.trim() == inputValue.trim()) {
            document.getElementById('mobileno').value = option.getAttribute('mobileno');
            document.getElementById('name').value = option.getAttribute('personname');
            document.getElementById('state').value = option.getAttribute('state');
            document.getElementById('city').value = option.getAttribute('city');
            document.getElementById('gstno').value = option.getAttribute('gstno');
            document.getElementById('address').value = option.getAttribute('address');
            document.getElementById('profession').value = option.getAttribute('profession');
            document.getElementById('contactid').value = option.getAttribute('contactid');
            break;
        }
    }
    bindcities();
}

function copyWeightToSingle(i) {
    if (document.getElementById("unit" + i).value == "Kgs") {
        document.getElementById("singleweight" + i).value = document.getElementById("totalweight" + i).value;
    }
    calculateWeight(i);
}

function calculateTotalWeight(considerloadingcharges) {
    var count = document.getElementById("count").value;
    var totalweight = 0,
        subtotal = 0;
    for (var i = 1; i < count; i++) {
        totalweight += parseFloat("0" + document.getElementById("totalweight" + i).value);
        subtotal += parseFloat("0" + document.getElementById("totalAmount" + i).value);
    }
    document.getElementById("spnTotalWeight").innerText = "Total Weight : " + totalweight.toFixed(1);
    document.getElementById("spnTotalAmount").innerText = "Total Amount : " + subtotal.toFixed(1);

    document.getElementById("totalweight").value = totalweight.toFixed(1) + " Kg";
    document.getElementById("subtotal").value = subtotal.toFixed(2);

    // var lcharges = totalweight * 0.18;
    // document.getElementById("lcharges").value = lcharges.toFixed(2);
    if (considerloadingcharges == 'yes') {
        if (document.getElementById("lchargesyes").checked == true) {
            var lcharges = totalweight * 0.29;
            document.getElementById("lcharges").value = lcharges.toFixed(2);
        } else {
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
    subtotal += (lcharges + ccharges + fcharges) - ocharges;
    var gst = subtotal * (18 / 100);
    document.getElementById("gst").value = gst.toFixed(2);
    subtotal += gst;

    var roundoff = subtotal - Math.floor(subtotal);
    total = Math.floor(subtotal);
    document.getElementById("roundoff").value = roundoff.toFixed(2);
    document.getElementById("total").value = total.toFixed(2);
}

function bindvarieties(position) {
    var pid = document.getElementById("pid" + position);
    var type = pid.options[pid.selectedIndex].getAttribute('type');
    var billingin = pid.options[pid.selectedIndex].getAttribute('billingin');
    var units = "";
    if (type == "Meter") {
        if (billingin == "Meter") {
            units = "<option value='Meter'>Meter</option>";
        } else if (billingin == "Feet") {
            units += "<option value='Feet'>Feet</option>";
        } else {
            units = "<option value='Meter'>Meter</option>";
            units += "<option value='Feet'>Feet</option>";
            units += "<option value='Nos' selected>Nos</option>";
        }
    } else {
        units = "<option value='Nos' selected>Nos</option>";
    }
    units += "<option value='Kgs'>Kgs</option>";

    document.getElementById("unit" + position).innerHTML = units;
    $.ajax({
        url: "<?php echo base_url('admin/getvarieties');?>",
        method: "POST",
        data: {
            id: pid.value
        },
        async: true,
        dataType: 'json',
        success: function(data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html += '<option weight=' + data[i].weight + ' value=' + data[i].id + '>' + data[i]
                    .sizeinmm + '</option>';
            }
            document.getElementById("pwid" + position).innerHTML = html;
            document.getElementById("quantities" + position).value = "1";
            copyWeight(document.getElementById("pwid" + position), position);
        }
    });
}

function copyWeight(ctrl, i) {
    document.getElementById("singleweight" + i).value = ctrl.options[ctrl.selectedIndex].getAttribute('weight');
    bindBrands(i);
}

function bindBrands(position) {
    var pwid = document.getElementById("pwid" + position);
    $.ajax({
        url: "<?php echo base_url('admin/getbrands');?>",
        method: "POST",
        data: {
            id: pwid.value
        },
        async: true,
        dataType: 'json',
        success: function(data) {
            var html = '';
            var i;
            html += '<option rate="0" value="0">Brand</option>';
            for (i = 0; i < data.length; i++) {
                html += '<option billingrate=' + data[i].billingrate + ' value=' + data[i].id + '>' + data[
                    i].name + '</option>';
            }
            document.getElementById("brand" + position).innerHTML = html;
            calculateWeight(position);
        }
    });
}

function getRate(position) {
    var brandid = document.getElementById("brand" + position);
    var billingrate = brandid.options[brandid.selectedIndex].getAttribute('billingrate');
    if (billingrate == 'null') {
        billingrate = "";
        showSnackbar("Rate not available in system.");
    }
    var rate = parseFloat(billingrate);
    document.getElementById("rate" + position).value = rate.toFixed(1);
    calculateWeight(position);
}

function calculateWeight(i) {
    document.getElementById("quantities" + i).style.display = "block";
    document.getElementById("quantities" + i).readOnly = false;
    document.getElementById("totalweight" + i).readOnly = true;

    var pwid = document.getElementById("pwid" + i);
    var quantities = parseFloat("0" + document.getElementById("quantities" + i).value);
    var unit = document.getElementById("unit" + i).value;

    //if(unit != "Kgs")
    document.getElementById("singleweight" + i).value = pwid.options[pwid.selectedIndex].getAttribute('weight');

    var pid = document.getElementById("pid" + i);
    var type = pid.options[pid.selectedIndex].getAttribute('type');
    var billingin = pid.options[pid.selectedIndex].getAttribute('billingin');

    var weight = parseFloat("0" + document.getElementById("singleweight" + i).value);

    var totalweight = 0;
    if (unit == 'Meter')
        totalweight = weight * quantities;
    else if (unit == 'Feet')
        totalweight = (weight / 3.28) * quantities;
    else if (unit == 'Nos') {
        if (type == 'Meter')
            totalweight = (weight * 6) * quantities;
        else
            totalweight = weight * quantities;
    } else if (unit == 'Kgs') {
        document.getElementById("quantities" + i).style.display = "none";
        document.getElementById("quantities" + i).readOnly = true;
        document.getElementById("totalweight" + i).readOnly = false;
        document.getElementById("quantities" + i).value = "1";

        // if(document.activeElement.id != "rate" + i){                
        //     document.getElementById("singleweight" + i).value = "";                
        //     weight = 0;                
        //     showSnackbar("Enter weight.");
        //     document.getElementById("totalweight"+i).focus();                
        // }
        totalweight = parseFloat("0" + document.getElementById("totalweight" + i).value);
        quantities = totalweight / weight;

        // quantities = 1;
        // totalweight  = weight * quantities;
    }
    if (totalweight == 0)
        document.getElementById("totalweight" + i).value = "";
    else
        document.getElementById("totalweight" + i).value = totalweight.toFixed(1);

    var rate = parseFloat("0" + document.getElementById("rate" + i).value);
    var total = 0;
    if (billingin == "Kgs")
        total = rate * totalweight;
    else
        total = rate * quantities;
    document.getElementById("totalAmount" + i).value = total.toFixed(2);
    calculateTotalWeight('yes');
}

function freighttypechanged() {
    if (document.getElementById("free").checked == true) {
        document.getElementById("fcharges").value = "0";
        document.getElementById("fcharges").disabled= true;
    }
    else{
        document.getElementById("fcharges").disabled= false;
    }
    calculateTotalWeight('no');
}

function cdchanged()
    {
        if(document.getElementById("cd_zero").checked == true){
            document.getElementById("ocharges").value = "0";
        }
        calculateTotalWeight('yes');
    }

function loadingchargeschanged() {

    // if(id == "lchargesno")
    // {
    if (document.getElementById("lchargesno").checked == true) {
        document.getElementById("lcharges").value = "0";
    }
    // }
    calculateTotalWeight('yes');
}

function Reset(i) {
    var dropDown = document.getElementById("pid" + i);
    dropDown.selectedIndex = 0;
    var dropDown1 = document.getElementById("pwid" + i);
    dropDown1.selectedIndex = 0;
    var html = '<option weight=0 value=0>Select</option>';
    document.getElementById("pwid" + i).innerHTML = html;
    document.getElementById("quantities" + i).value = "";
    document.getElementById("singleweight" + i).value = "";
    document.getElementById("totalweight" + i).value = "";
    document.getElementById("unit" + i).innerHTML = "";
    document.getElementById("brand" + i).innerHTML = "";
    document.getElementById("rate" + i).value = "";
    document.getElementById("narration" + i).value = "";
    document.getElementById("totalAmount" + i).value = "";
    bindvarieties(i);
    calculateTotalWeight('no');
}

calculateTotalWeight('no');

function openModal() {
    var modal = document.getElementById('charges_modal');
    modal.style.display = 'block';
    console.log(modal);
}

function closeModal() {
    var modal = document.getElementById("charges_modal");
    modal.style.display = "none";
}
//   openModal();
</script>
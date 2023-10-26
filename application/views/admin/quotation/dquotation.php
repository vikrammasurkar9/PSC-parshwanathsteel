<div class="page-wrapper">
    <div class="content"> 
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><b>Quotations</b></h4>
            </div>
        </div>
         <div class="card-box" style="border-style:ridge">
            <form action="<?php echo base_url('admin/saveDquotation'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="id" value="0" />
                <div class="col-sm-12">
                    <div class="row">
                        
                        <div class="col-sm-3">
                            <label>Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" id="name" value="" type="text" required />
                        </div>
                        <div class="col-sm-2" style="display:none">
                            <label>Email</label>
                                <input class="form-control" name="email" id="email" value="" type="text" />
                        </div>
                        <div class="col-sm-3"> 
                            <label>Mobile</label>
                            <input type="text" id="mobileno" name="mobileno" class="form-control" value="" />
                        </div>
                        <div class="col-sm-2" style="display:none">
                            <label>Profession</label>
                            <select name="profession" id="profession" class="form-control">
                                <option value="Other">Other</option>         
                                <option value="Fabricator">Fabricator</option>
                                <option value="Structural Engineer">Structural Engineer</option>
                                <option value="Structural Consultant">Structural Consultant</option>                                    
                            </select>                         
                        </div>   
                        <div class="col-sm-2" style="display:none">
                            <label>Order Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="qname" id="qname" value="" type="text"/>
                        </div>
                        
                        <div class="col-sm-3">
                            <label>Select Firm</label>
                                <select id="categoryid" name="firmid" class="form-control">
                                    <?php
                                        foreach($firms as $firm)
                                        {
                                            echo "<option value='" . $firm->id . "' " . ($id == 0 ? "" : ($data->firmid == $firm->id ? "selected" : "")) . ">" . $firm->firm . "</option>";
                                        }
                                    ?>
                                </select>                     
                        </div>   
                        <div class="col-sm-3"> 
                            <label>PO Number</label>
                            <input type="text"  name="ponumber" class="form-control" value="" />
                        </div>
                        
                    </div>
                    <div class="row">   
                        
                        <div class="col-sm-3">
                            <label>Payment Mode</label>
                            <select name="paymentmode" id="paymentmode" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Cash">Cash</option>         
                                <option value="Cheque">Cheque</option>
                                <option value="NEFT / RTGS">NEFT / RTGS</option>
                                <option value="Against Delivery">Against Delivery</option>
                                <option value="Other">Other</option>                                    
                            </select>                         
                        </div>   
                        <div class="col-sm-3">
                            <label>Payment Details </label>
                                <input class="form-control" name="paymentdetails" id="paymentdetails" placeholder="" value="" type="text"/>
                        </div>                     
                        
                        <div class="col-sm-3 pull-right">
                            <br />
                            <button class="btn btn-lg btn-primary pull-right" style="width:200px">Submit</button>
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
                                            for($i = 1; $i <= 20; $i++){
                                            ?>                                        
                                            <tr>
                                                <td style="width:50px; text-align:center;"><?= $i;?></td>
                                                <td style="width:180px;">
                                                    <select class="form-control" name="pid<?= $i; ?>" id="pid<?= $i; ?>" onchange="bindvarieties(<?= $i; ?>)" <?= ($i == 1 ? "required" : ""); ?>>
                                                        <option value="">Select</option>
                                                        <?php foreach($productlist as $row){
                                                            ?>
                                                        <option type="<?php echo $row->type;?>" billingin="<?php echo $row->billingin;?>" value="<?php echo $row->id;?>"   ><?php echo $row->product;?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </td>
                                                <td style="width:180px;">
                                                    <select class="form-control" id="pwid<?= $i; ?>" name="pwid<?= $i; ?>" onchange="bindBrands(<?= $i;?>)"  >
                                                        <option value="">Select</option>
                                                    </select>
                                                </td>
                                                <td style="width:100px;">
                                                    <select name="unit<?= $i; ?>" id="unit<?= $i; ?>" class="form-control" onchange="calculateWeight(<?= $i;?>)" style="width:80px;">
                                                    </select>
                                                </td>                                                
                                                <td style="width:70px;" >
                                                <input type="hidden" id="singleweight<?= $i; ?>" name="singleweight<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)" style="width:80px; text-align:center; " class="form-control"/> 
                                                    <input type="number" class="form-control" name="quantities<?= $i; ?>" id="quantities<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)" value="" style="width:70px; text-align:center; "/>
                                                </td>
                                                <td style="width:100px">
                                                    <input type="number" class="form-control" id="totalweight<?= $i; ?>" name="weight<?= $i; ?>" style="width:80px; text-align:center; " onchange="copyWeightToSingle(<?= $i; ?>)"  readonly />
                                                </td>
                                                <td style="width:180px;">
                                                    <select class="form-control" id="brand<?= $i; ?>" name="brand<?= $i; ?>" onchange="getRate(<?= $i;?>)" >
                                                        <option value="">Select</option>
                                                    </select>
                                                </td>
                                                <td style="width:50px;" >
                                                    <input type="number" class="form-control" step="any" name="rate<?= $i; ?>" id="rate<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)"  value="" style="width:70px; text-align:center; " <?= ($i == 1 ? "required" : ""); ?> autocomplete="off" />
                                                </td>
                                                <td style="width:100px">
                                                    <input type="number" class="form-control" id="totalAmount<?= $i; ?>" name="totalAmount<?= $i; ?>" style="width:100px; text-align:center; " tabindex=-1 readonly/> 
                                                </td>
                                                <td style="width:100px">
                                                    <input type="text" class="form-control" id="narration<?= $i; ?>" name="narration<?= $i; ?>" style="width:100px;" /> 
                                                </td>
                                                <td style="width:80px">
                                                    <a onclick="Reset(<?= $i;?>);"><i class="fa fa-times-circle fa-3x" aria-hidden="true" style="color:red"></i></a>
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
                                <input type="hidden" id="count" name="count" value="<?= $i ?>" />
                                <table class="table table-bordered custom-table">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:right;">
                                                Loading Charges  (
                                                    <label>
                                                        <input type="radio" name="loading" value="Yes" id="lchargesyes" onchange="loadingchargeschanged()" checked />
                                                        Yes
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="loading" value="No" id="lchargesno" onchange="loadingchargeschanged()" />
                                                        No
                                                    </label>
                                                ): <input type="number" step="any" id="lcharges" name="lcharges" style="width:150px; text-align:right;" onkeyup="calculateTotalWeight('no')" min=0 value="" /><br />
                                                Cutting Charges : <input type="number" step="any" id="ccharges" name="ccharges" style="width:150px; text-align:right;" onkeyup="calculateTotalWeight('no')" min=0 value="" /><br />
                                                Freight Charges (
                                                    <label>
                                                        <input type="radio" name="paidby" value="Paid by Us" id="paidbyus" onchange="freighttypechanged()" />
                                                        Paid by Us
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="paidby" value="To Pay" id="paidbytopay"  onchange="freighttypechanged()" checked />
                                                        To Pay
                                                    </label>
                                                ): <input type="number" step="any" id="fcharges" name="fcharges" style="width:150px; text-align:right;" onkeyup="calculateTotalWeight('no')" min=0 value="" /><br />
                                                Other Charges : <input type="number" step="any" id="ocharges" name="ocharges" style="width:150px; text-align:right;" onkeyup="calculateTotalWeight('no')" min=0 value="" /><br />
                                                GST(18%) : <input type="number" step="any" id="gst" name="gst" readonly="true" style="width:150px; text-align:right;border: 0px none;" onkeyup="calculateTotalWeight('no')" min=0 /><br />
                                                Round Off : <input type="number" step="any" id="roundoff" name="roundoff" readonly="true" style="width:150px; text-align:right;border: 0px none;" onkeyup="calculateTotalWeight('no')" min=0 /><br />
                                                Total : <input type="number" step="any" id="total" name="total" readonly="true" style="width:150px; text-align:right;border: 0px none;" onkeyup="calculateTotalWeight('no')" min=0 /><br />
                                                Vehicle No : <input type="text" id="vehicleno" name="vehicleno" style="width:150px;" value="" /><br />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="submit" class="btn btn-lg btn-primary pull-right" style="width:200px" value="Submit" />
                            </div>
                        </div>
                    </div>                    
                </div>
            </form>
        </div>
    </div>    
</div>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/jquery-3.3.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/bootstrap.js'?>"></script>
<script type="text/javascript">

    function copyWeightToSingle(i)
    {
        if(document.getElementById("unit" + i).value == "Kgs")
        {
            document.getElementById("singleweight" + i).value = document.getElementById("totalweight" + i).value;
        }
        calculateWeight(i);
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
        var lcharges = totalweight * 0.25;
        document.getElementById("lcharges").value = lcharges.toFixed(2);
        }
        else{
            document.getElementById("lcharges").value = '0';
        }
        }
        var lcharges = parseFloat("0" + document.getElementById("lcharges").value);
        var ccharges = parseFloat("0" + document.getElementById("ccharges").value);
        var fcharges = parseFloat("0" + document.getElementById("fcharges").value);
        var ocharges = parseFloat("0" + document.getElementById("ocharges").value);
        subtotal += lcharges + ccharges + fcharges + ocharges;
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
        if(totalweight == 0)        
            document.getElementById("totalweight"+i).value = "";
        else
            document.getElementById("totalweight"+i).value = totalweight.toFixed(1);
            
        var rate = parseFloat("0" + document.getElementById("rate" + i).value);
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
        if(document.getElementById("paidbytopay").checked == true){
            document.getElementById("fcharges").value = "0";
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



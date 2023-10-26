<div class="page-wrapper">
    <div class="content"> 
        <div class="row">
			<div class="col-sm-12">
                <h4 class="page-title"><b>Edit Lead</b></h4>
            </div>
        </div>
         <div class="card-box" style="border-style:ridge">
            <form action="<?php echo base_url('admin/saveRequest'); ?>" method="post" enctype="multipart/form-data"  onsubmit="return  validateForm();" autocomplete="off">
                <input type="hidden" name="userid" value="<?= $user->id; ?>" />
                <input type="hidden" name="id" value="<?= $id ?>" />
                <div class="col-sm-12">
                    <div class="row">
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
                            <label>Firm Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="firmname"  type="text" value="<?= $user->firmname; ?>" required />
                        </div>
                        <div class="col-sm-3">
                            <label>Name</label>
                                <input class="form-control" name="name" id="name" type="text" value="<?= $user->name; ?>"  />
                        </div>
                        <div class="col-sm-3">
                            <label>WhatsApp Number <span class="text-danger">*</span></label>
                                <input class="form-control" name="mobileno"  value="<?= $user->mobileno; ?>" type="number" required />
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
                                <input type="text" id="address" name="address" class="form-control"
                                    value="<?= $data->address; ?>" required />
                            </div>
                            <div class="col-sm-3">
                                <label>GST No.</label>
                                <input type="text" id="gstno" name="gstno" class="form-control"
                                    value="<?= $data->gstno; ?>" />
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
                        <div class="col-sm-3">
                            <label>Enquiry Image1</label>
                                <input class="form-control" name="pic" id="" value="" type="file">
                        </div>
                        <div class="col-sm-3">
                            <label>Enquiry Image2</label>
                                <input class="form-control" name="pic1" id="" value="" type="file">
                        </div>
                        <div class="col-sm-6">
                            <label>Enquiry Details</label>
                                <!-- <input class="form-control" name="enquirydetails" id="" value="<?= $data->enquirydetails; ?>" type="text"> -->

                                <textarea class="form-control" name="enquirydetails" id="enquirydetails" rows="2"
                                            cols="30"><?= $data->enquirydetails; ?></textarea>
                                        <!-- <script>
                                        CKEDITOR.replace('enquirydetails');
                                        </script> -->
                        </div>
                        
                        <div class="col-sm-3 pull-right">
                            <br />
                            <button class="btn btn-lg btn-primary pull-right" style="width:200px">Submit</button>
                        </div>                                
                    </div> 
                    <br/>
                   
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
                                            <!-- <th>Weight</th> -->
                                            <th>Quantity</th>
                                            <th>Total Weight</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i=1;
                                            $quotationcount = sizeof($quotationsdetails);
                                            $qdtrackid = 0;
                                            for($i = 1; $i <= 20; $i++) {
                                                $productid = 0;
                                                $varietyid = 0;
                                                $estimationin = "";
                                                $producttype = "";
                                                $quantity = "";
                                                $weight = "0";
                                                $singleweight = "0";
                                                $billingin = "";
                                            ?>                                        
                                            <tr>
                                                <td style="width:50px; text-align:center;"><?= $i;?></td>
                                                <td style="width:180px;">
                                                    <select class="form-control" name="pid<?= $i; ?>" id="pid<?= $i; ?>" onchange="bindvarieties(<?= $i; ?>)">
                                                        <option value="">Select</option>
                                                        <?php foreach($productlist as $row) {                                                            
                                                            $narration = "";
                                                            if($i <= $quotationcount)
                                                            {
                                                                $qdtrackid = $i - 1;
                                                                $productid = $quotationsdetails[$qdtrackid]->pid;
                                                                $varietyid = $quotationsdetails[$qdtrackid]->pwid;
                                                                $estimationin = $quotationsdetails[$qdtrackid]->estimationin;                                                                
                                                                $quantity = $quotationsdetails[$qdtrackid]->quantities;
                                                                $weight = $quotationsdetails[$qdtrackid]->weight;
                                                                $singleweight = $quotationsdetails[$qdtrackid]->singleweight;
                                                                $narration = $quotationsdetails[$qdtrackid]->narration;
                                                                if($row->id == $productid){
                                                                    $producttype = $row->type;
                                                                    $billingin = $row->billingin;
                                                                }
                                                            }
                                                            ?>
                                                        <option type="<?php echo $row->type;?>" billingin="<?php echo $row->billingin;?>" value="<?php echo $row->id;?>" <?= $productid == $row->id ? "selected" : "" ?>><?php echo $row->product;?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </td>
                                                <td style="width:180px;">
                                                    <select class="form-control" id="pwid<?= $i; ?>" name="pwid<?= $i; ?>" onchange="calculateWeight(<?= $i;?>)">
                                                        <option value="">Select</option>
                                                        <?php
                                                            if($varietyid > 0){
                                                                foreach($productweightlist as $productweight)
                                                                {
                                                                    if($productweight->pid == $productid){
                                                                        echo "<option weight='" . $productweight->weight . "' value='" . $productweight->id . "' " . ($varietyid == $productweight->id ? "selected" : "") . ">" . $productweight->sizeinmm . "</option>";
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td style="width:100px;">                                                
                                                    <select name="unit<?= $i; ?>" id="unit<?= $i; ?>" class="form-control" onchange="calculateWeight(<?= $i;?>)">
                                                        <?php
                                                            if($estimationin != "")
                                                            { 
                                                            //    if($producttype == "Meter")
                                                            //     {
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
                                                                    echo "<option value='Kgs' " . ($estimationin == "Kgs" ? "selected" : "") . ">Kgs</option>";                                                            
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td style="width:50px;" >
                                                    <input type="hidden" class="form-control" id="singleweight<?= $i; ?>" name="singleweight<?= $i; ?>" value="<?= $singleweight; ?>" onkeyup="calculateWeight(<?= $i;?>)" style="width:100px; text-align:center; "/> 
                                                    <input type="number" class="form-control" name="quantities<?= $i; ?>" id="quantities<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)" value="<?= $quantity; ?>" style="width:70px; text-align:center; <?= $estimationin == "Kgs" ? "display:none;" : "" ?>" <?= $estimationin == "Kgs" ? "readonly" : "" ?> />
                                                </td>
                                                <td style="width:100px">
                                                    <input type="text" class="form-control" id="totalweight<?= $i; ?>" name="weight<?= $i; ?>" value="<?= $weight ?>" style="width:100px; text-align:center; " <?= $estimationin == "Kgs" ? "" : "readonly" ?> onkeyup="copyWeightToSingle(<?= $i; ?>)" onchange="copyWeightToSingle(<?= $i; ?>)" /> 
                                                </td>
                                                <td style="width:150px">
                                                    <input type="text" class="form-control" id="narration<?= $i; ?>" name="narration<?= $i; ?>" value="<?= $narration ?>" /> 
                                                </td>
                                                <td style="width:80px">
                                                    <a onclick="Reset(<?= $i;?>);" style="display:<?= $i==1 ? 'none':'block' ?>"><i class="fa fa-times-circle fa-3x" aria-hidden="true" style="color:red"></i></a>
                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>
                                        <input type="hidden" id="count" name="count" value="<?= $i ?>" />
                                        <tr>
                                            <td colspan="5"></td>
                                            <td>
                                                <span id="spnTotalWeight"></span>
                                            </td>
                                            <td></td>
                                        </tr>                                      
                                    </tbody>
                                </table>
                                <button class="btn btn-lg btn-primary" style="width:200px">Submit</button>
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

function validateForm() {
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
    }
}
    function copyWeightToSingle(i)
    {
        if(document.getElementById("unit" + i).value == "Kgs")
        {
            document.getElementById("singleweight" + i).value = document.getElementById("totalweight" + i).value;
            calculateTotalWeight();
        }
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
                document.getElementById("quantities" + position).value = "1";
                calculateWeight(position);
            }
        });            
    }

    function calculateWeight(i) {
        document.getElementById("quantities" + i).style.display = "block";
        document.getElementById("quantities" + i).readOnly = false;
        document.getElementById("totalweight" + i).readOnly = true;

        var quantities = parseFloat("0" + document.getElementById("quantities" + i).value);
        var unit = document.getElementById("unit" + i).value;
        var pid = document.getElementById("pid" + i);
        var type = pid.options[pid.selectedIndex].getAttribute('type');
        var pwid = document.getElementById("pwid" + i);
        
        if(unit != "Kgs")
            document.getElementById("singleweight" + i).value = pwid.options[pwid.selectedIndex].getAttribute('weight');   
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
        if(unit == 'Kgs')
        {
            document.getElementById("quantities" + i).style.display = "none";
            document.getElementById("quantities" + i).value = "1";
            document.getElementById("singleweight" + i).value = "";
            document.getElementById("quantities" + i).readOnly = true;
            document.getElementById("totalweight" + i).readOnly = false;
            weight = 0;
            quantities = 1;
            totalweight  = weight * quantities;
            showSnackbar("Enter weight.");
            document.getElementById("totalweight"+i).focus();
        }
        if(totalweight == 0)
            document.getElementById("totalweight"+i).value = "";
        else
            document.getElementById("totalweight"+i).value = totalweight.toFixed(1);
        calculateTotalWeight();
    }

    
    function calculateTotalWeight()
    {
        var count = document.getElementById("count").value;
        var totalWeight = 0;        
        for(var i = 1; i < count; i++)
        {
            totalWeight += parseFloat("0" + document.getElementById("totalweight" + i).value);
        }
        document.getElementById("spnTotalWeight").innerText = "Total Weight : " + totalWeight.toFixed(1);
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
        document.getElementById("narration" + i).innerHTML = "";
        bindvarieties(i);
        //calculateTotalWeight();
    }

    calculateTotalWeight();
</script>




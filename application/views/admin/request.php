<div class="page-wrapper">
    <div class="content"> 
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><b>Lead</b></h4>
            </div>
        </div>
         <div class="card-box" style="border-style:ridge">
            <form action="<?php echo base_url('admin/saveRequest'); ?>" method="post" enctype="multipart/form-data" onsubmit="return  validateForm();" autocomplete="off">
                <input type="hidden" name="userid" value="0" />
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Select Firm <span class="text-danger">*</span></label>
                                <select id="firmid" name="firmid" class="form-control" required>
                                <option value="">Select Firm </option>
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
                                <input class="form-control" name="firmname" id="firmname" value="" type="text" list="contacts" onchange="findcustomerdetails()" required />
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
                            
                            <select class="form-control" id="city" name="city">
                                        <option value="">Select City</option>
                                        <?php 
                                        // if($id !=0)
                                        //     {
                                                foreach($cities AS $city)
                                                {
                                                    echo "<option value='" . $city->city . "'>" . $city->city . "</option>";

                                                }
                                            // }
                                            ?>


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
                            <label>Profession<span class="text-danger">*</span></label>
                               
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
                        <div class="col-sm-3">
                            <label>Enquiry Image 1</label>
                                <input class="form-control" name="pic" id="" value="" type="file">
                        </div>
                        <div class="col-sm-3">
                            <label>Enquiry Image 2</label>
                                <input class="form-control" name="pic1" id="" value="" type="file">
                        </div>
                        <div class="col-sm-6">
                            <label>Enquiry Details</label>
                                <!-- <input class="form-control" name="enquirydetails" id="" value="" type="text"> -->

                                <textarea class="form-control" name="enquirydetails" id="enquirydetails" rows="1"
                                            cols="10"></textarea>
                                        <!-- <script>
                                        CKEDITOR.replace('enquirydetails');
                                        </script> -->
                        </div>
                       
                        <div class="col-sm-3 pull-right">
                            <br />
                            <button class="btn btn-lg btn-primary pull-right" style="width:200px">Submit</button>
                        </div>
                        <datalist id="contacts">
                            <!-- <option value=""><a href="">+ Add New Contact</a></option> -->
                        <?php
                            foreach($contacts as $contact)
                            {
                                echo "<option contactid='" . $contact->id . "' mobileno='" . $contact->mobileno1 . "' personname='" . $contact->name . "' address='" . $contact->address . "' city='" . $contact->city . "' gstno='" . $contact->gstno . "' state='" . $contact->state . "' profession='" . $contact->profession . "'>" . $contact->firmname ."</option>";
                            }
                        ?>
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
                                            <!-- <th>Weight</th> -->
                                            <th>Quantity</th>
                                            <th>Total Weight</th>
                                            <th>Narration</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i=1;
                                            for($i=1;$i<=20;$i++){
                                            ?>
                                        
                                            <tr>
                                                <td style="width:50px; text-align:center;"><?= $i;?></td>
                                                <td style="width:180px;">
                                                    <select class="form-control" name="pid<?= $i; ?>" id="pid<?= $i; ?>" onchange="bindvarieties(<?= $i; ?>)">
                                                        <option value="">Select</option>
                                                        <?php foreach($productlist as $row){
                                                            ?>
                                                        <option type="<?php echo $row->type;?>" billingin="<?php echo $row->billingin;?>" value="<?php echo $row->id;?>"><?php echo $row->product;?></option>
                                                        <?php  } ?>
                                                    </select>
                                                </td>
                                                <td style="width:180px;">
                                                    <select class="form-control" id="pwid<?= $i; ?>" name="pwid<?= $i; ?>" onchange="copyWeight(this, <?= $i;?>)">
                                                        <option value="">Select</option>
                                                    </select>
                                                </td>
                                                <td style="width:100px;">
                                                    <select name="unit<?= $i; ?>" id="unit<?= $i; ?>" class="form-control" onchange="calculateWeight(<?= $i;?>)"  >
                                                    </select>
                                                </td>
                                                <td style="width:50px;">
                                                    <input type="hidden" id="singleweight<?= $i; ?>" name="singleweight<?= $i; ?>"  onkeyup="calculateWeight(<?= $i;?>)" class="form-control" style="width:100px; text-align:center; "/> 
                                                    <input type="number" class="form-control" step="any" name="quantities<?= $i; ?>" id="quantities<?= $i; ?>" onkeyup="calculateWeight(<?= $i;?>)" value="" style="width:70px; text-align:center; "/>       
                                                </td>                                                
                                                <td style="width:100px">
                                                    <input type="text" class="form-control" id="totalweight<?= $i; ?>" name="weight<?= $i; ?>" style="width:100px; text-align:center; " onkeyup="copyWeightToSingle(<?= $i; ?>)" onchange="copyWeightToSingle(<?= $i; ?>)"  readonly/> 
                                                </td>
                                                <td style="width:150px">
                                                    <input type="text" class="form-control" id="narration<?= $i; ?>" name="narration<?= $i; ?>"/> 
                                                </td>
                                                <td style="width:80px">
                                                    <a onclick="Reset(<?= $i;?>);" style="display:<?= $i==1 ? 'none':'block' ?>"><i class="fa fa-times-circle fa-3x" aria-hidden="true" style="color:red"></i></a>
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
                                        </tr>                                      
                                    </tbody>
                                </table>  
                                <input type="hidden" id="count" name="count" value="<?= $i ?>" />
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

    function copyWeightToSingle(i)
    {
        if(document.getElementById("unit" + i).value == "Kgs")
        {
            document.getElementById("singleweight" + i).value = document.getElementById("totalweight" + i).value;
        }
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
        calculateWeight(i);
    }

    function calculateWeight(i) {
        document.getElementById("quantities" + i).style.display = "block";
        document.getElementById("quantities" + i).readOnly = false;
        document.getElementById("totalweight" + i).readOnly = true;

        var quantities = parseFloat("0" + document.getElementById("quantities" + i).value);
        var unit = document.getElementById("unit" + i).value;
        var pwid = document.getElementById("pwid" + i);

        if(unit != "Kgs")
            document.getElementById("singleweight" + i).value = pwid.options[pwid.selectedIndex].getAttribute('weight');   
        var weight = parseFloat("0" + document.getElementById("singleweight" + i).value);
        var pid = document.getElementById("pid" + i);
        var type = pid.options[pid.selectedIndex].getAttribute('type');
        
        //var weight = pwid.options[pwid.selectedIndex].getAttribute('weight');   

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
        bindvarieties(i);
    }

    calculateTotalWeight();

</script>




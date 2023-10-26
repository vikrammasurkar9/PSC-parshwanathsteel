<div class="page-wrapper">
    <div class="content"> 
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><b>Enquiry</b></h4>
            </div>
        </div>
         <div class="card-box" style="border-style:ridge">
            <form action="<?php echo base_url('admin/saveEnquiry'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="userid" value="<?= $id == 0 ? '' : $user->id; ?>" />
                <input type="hidden" name="id" value="<?= $id ?>" />
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3" hidden>
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
                            <input class="form-control" name="contactid" id="contactid" value="0" type="hidden" />
                                <input class="form-control" name="firmname" id="firmname" value="<?= $id == 0 ? '' : $user->firmname; ?>" type="text" list="contacts" onchange="findcustomerdetails()" required />
                        </div>
                        <div class="col-sm-3">
                            <label>Name</label>                                
                                <input class="form-control" name="name" id="name" value="<?= $id == 0 ? '' : $user->name; ?>" type="text" />
                        </div>
                        <div class="col-sm-3"> 
                            <label>WhatsApp No. <span class="text-danger">*</span></label>
                            <input type="text" id="mobileno" name="mobileno" class="form-control" value="<?= $id == 0 ? '' : $user->mobileno; ?>" required />
                        </div>
                        <div class="col-sm-3"> 
                            <label>GST No.</label>
                            <input type="text" id="gstno" name="gstno" class="form-control" value="<?= $id == 0 ? '' : $user->gstno; ?>" />
                        </div>
                        <div class="col-sm-3"> 
                            <label>Address</label>
                            <input type="text" id="address" name="address" class="form-control" value="<?= $id == 0 ? '' : $user->address; ?>" />
                        </div>
                        <div class="col-sm-3"> 
                            <label>City</label>
                            <input type="text" id="city" name="city" class="form-control" value="<?= $id == 0 ? '' : $user->city; ?>" required/>
                        </div>
                        <div class="col-sm-3">
                            <label>State<span class="text-danger">*</span></label>
                                <!-- <input class="form-control" name="state" id="state" value="Maharastra" type="text" required> -->
                                <select class="form-control" name="state" id="state" required>
                                        <!-- <option value="Maharastra">Maharastra</option>
                                        <option value="Maharastra">Karnataka</option>
                                        <option value="Maharastra">Goa</option> -->
                                        <option value="Maharastra" <?= $id == 0 ? '' :  ($user->state == "Maharastra" ? "selected" : ""); ?>>Maharastra</option>         
                                        <option value="Goa" <?= $id == 0 ? '' :  ($user->state == "Goa" ? "selected" : ""); ?>>Goa</option>           
                                        <option value="Karnataka" <?= $id == 0 ? '' :  ($user->state == "Karnataka" ? "selected" : ""); ?>>Karnataka</option>           

                                </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Profession</label>
                               
                        <select class="form-control" name="profession" id="profession" required>
                        <option value="">Select Profession</option>
                        <?php foreach($professions as $profession)
                        { ?>
                          <!-- <option value='".$profession->name."'  >".$profession->name."</option> -->
                          <option value="<?= $profession->name;?>" <?= $id == 0 ? '' :  ($profession == $user->profession ? "selected" : ""); ?>><?= $profession->name;?></option>           

                        <?php  } ?>

                                </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Enquiry Details</label>
                             <input class="form-control" name="description" id="" value="<?= $id == 0 ? '' : $data->description; ?>" type="text">
                        </div>
                        <div class="col-sm-3">
                            <label>Image</label>
                            <input type="file" class="form-control" name="pic" value="" placeholder="icon" accept="image/*" >
                        </div>
                       
                        <div class="col-sm-3 pull-right">
                            <br />
                            <button class="btn btn-lg btn-primary pull-right" style="width:200px">Submit</button>
                        </div>
                        <datalist id="contacts">
                        <?php
                            foreach($contacts as $contact)
                            {
                                echo "<option contactid='" . $contact->id . "' mobileno='" . $contact->mobileno1 . "' personname='" . $contact->name . "' address='" . $contact->address . "' city='" . $contact->city . "' gstno='" . $contact->gstno . "' state='" . $contact->state . "' profession='" . $contact->profession . "'>" . $contact->firmname . "</option>";
                            }
                        ?>
                    </div>
                    <hr/>                    
                                  
                </div>
            </form>
        </div>
    </div>    
</div>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/jquery-3.3.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/admin/js/bootstrap.js'?>"></script>
<script type="text/javascript">

    function findcustomerdetails() {
        var inputValue = document.getElementById("firmname").value;
        var options = document.getElementById("contacts").options;
        for (var i = 0; i < options.length; i++) {
            var option = options[i];
            if (option.innerText.trim() == inputValue.trim()) {
                document.getElementById('mobileno').value = option.getAttribute('mobileno');
                document.getElementById('name').value = option.getAttribute('personname');
                document.getElementById('city').value = option.getAttribute('city');
                document.getElementById('gstno').value = option.getAttribute('gstno');
                document.getElementById('address').value = option.getAttribute('address');
                document.getElementById('profession').value = option.getAttribute('profession');
                document.getElementById('contactid').value = option.getAttribute('contactid');
                break;
            }
        }
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




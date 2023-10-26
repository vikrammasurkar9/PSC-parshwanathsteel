<style>
thead,
tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}

tbody {
    display: block;
    height: 550px;
    overflow: auto;
}
</style>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Contacts [<?= sizeof($result); ?>]</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form action="<?= base_url('admin/saveContact'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id; ?>" />
                        <div class="col-sm-12">
                            <div class="row">

                                <div class="col-sm-4">
                                    <label>Firm Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="firmname" id="firmname"
                                        value="<?= $id == 0 ? '' : $data->firmname; ?>" type="text" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input class="form-control" name="name" id="name"
                                        value="<?= $id == 0 ? '' : $data->name; ?>" type="text" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>Email</label>
                                    <input class="form-control" name="email" id="email"
                                        value="<?= $id == 0 ? '' : $data->email; ?>" type="text" >
                                </div>
                                <div class="col-sm-3">
                                    <label>State<span class="text-danger">*</span></label>
                                    <!-- <input class="form-control" name="state" id="state"
                                        value="<?= $id == 0 ? 'Maharastra' : $data->state; ?>" type="text" required> -->
                                    <select class="form-control" name="state" id="state" onchange="bindcities()"
                                        required>
                                        <option value="" id="">Select State</option>
                                        <?php foreach($states AS $state)
                                    {?>
                                        <option id="<?= $state->id;?>" value="<?= $state->name;?>"
                                            <?php echo $id == 0 ? '' : ($data->state == $state->name ? ' selected ' : ''); ?>>
                                            <?= $state->name;?></option>
                                        <?php } ?>
                                        

                                    </select>

                                </div>

                                <div class="col-sm-3">
                                    <label>District <span class="text-danger">*</span></label>
                                    <!-- <input class="form-control" name="city" id="city"
                                        value="<?= $id == 0 ? '' : $data->city; ?>" type="text" required> -->
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

                                <div class="col-sm-6">
                                    <label>Address<span class="text-danger"></span></label>
                                    <textarea class="form-control" rows="1" name="address"
                                        id="address"><?= $id == 0 ? '' : $data->address; ?></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>Mobile No.1<span class="text-danger">*</span></label>
                                    <input class="form-control" name="mobileno1" id="mobileno1"
                                        value="<?= $id == 0 ? '' : $data->mobileno1; ?>" type="text" required>
                                </div>
                                <div class="col-sm-3">
                                    <label>Mobile No.2<span class="text-danger"></span></label>
                                    <input class="form-control" name="mobileno2" id="mobileno2"
                                        value="<?= $id == 0 ? '' : $data->mobileno2; ?>" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <label>GST No.<span class="text-danger"></span></label>
                                    <input class="form-control" name="gstno" id=""
                                        value="<?= $id == 0 ? '' : $data->gstno; ?>" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <label>Profession<span class="text-danger">*</span></label>
                                    <input class="form-control" list="professions" name="profession" id="profession"
                                        value="<?= $id == 0 ? '' : $data->profession; ?>" type="text" required>

                                    <datalist id="professions">
                                        <?php foreach($professions AS $profession)
                                        {
                                            echo "<option value='$profession->name'>";
                                        }
                                        ?>
                                        <!-- // <option value="Steel Trader">
                                        // <option value="Civil Engineer">
                                        // <option value="Purchase Head">
                                        // <option value="Stone Crusher">
                                        // <option value="End User"> -->
                                    </datalist>
                                </div>

                                <div class="col-sm-12 text-right">
                                    <br />
                                    <a href="<?= base_url('admin/contacts/0'); ?>" class="btn btn-danger">Cancel</a>
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Search by name , mobile number, email etc..."
                    autocomplete="off">
                <div class="row pt-3">
                    <div class="col-lg-3">
                    <?php
                    $type = "";
                    if(isset($_GET['profession']))
                        $type = $_GET['profession'];

					$s = "";
					if(isset($_GET['state']))
						$s = $_GET['state'];
                        
                    $c = "";
					if(isset($_GET['city']))
						$c = $_GET['city'];
				?>
                        <select class="form-control" name="states" id="states"onchange="binddata()"
                                        >
                                        <option value="0" id="">Select State</option>
                                        <?php foreach($states AS $state)
                                    {?>
                                        <option value="<?= $state->name;?>" <?= ($s == $state->name ? " selected " : "") ?>>
                                            <?= $state->name;?></option>
                                        <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" id="cities" name="cities" onchange="show()">
                            <option value="0">Select City</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control" name="type" id="type" onchange="show()"
                                        >
                                        <option value="0" id="">Select Profession</option>
                                        <?php foreach($professions AS $profession)
                                    {?>
                                        <option value="<?= $profession->name;?>" <?= ($type == $profession->name ? " selected " : "") ?>>
                                            <?= $profession->name;?></option>
                                        <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-3 ">
                    <a class="btn btn-danger btn-rounded" href="<?= base_url("admin/contacts/0"); ?>">Reset</a>&nbsp;&nbsp;
                    <a href="#" onclick="tableToExcel('myTable', 'W3C Example Table')" class="btn btn btn-success btn-rounded"><i class="fa fa-file-excel-o"></i> Export</a>
                    </div>
                    
                </div>
                <br>
                <!-- <input type="button" onclick="tableToExcel('myTable', 'W3C Example Table')"
                    class="btn btn btn-danger btn-rounded float-right" value="Export"> -->
                <!-- Display Table -->
                    <div class="table-responsive">
                    <table class="table table-striped custom-table" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width:30px">No</th>
                                <th>Firm Details</th>
                                <th>Address</th>
                                <th>City & State</th>
                                <th>Contact Details</th>
                                <th>Mobile</th>
                                <th>Profession</th>
                                <th>GST No.</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $count = 1;
                                    if(isset($result)){

                                        
                                    foreach ($result as $row) {
                                ?>
                            <tr>
                                <td style="width:30px"><?= $count; ?></td>

                                <td><?= $row->firmname;?></td>
                                <td><?= $row->address;?></td>
                                <td><?= $row->city;?> <br>
                                    <?= $row->state;?>
                                </td>
                                <td>
                                    <?= $row->name;?><br />
                                    <?= $row->email;?>
                                    
                                </td>
                                <td>
                                <a
                                        href="tel:+91<?= $row->mobileno1; ?>"><?= $row->mobileno1;?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a
                                        href="tel:+91<?= $row->mobileno2;?>"><?= $row->mobileno2;?></a>
                                </td>
                                <td><?= $row->profession;?></td>
                                <td><?= $row->gstno;?></td>
                                <td class="text-center" style="width:80px">
                                    <a href="<?= base_url('admin/contacts/'.$row->id);?>"><i class="fa fa-pencil"
                                            aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a href="<?= base_url('admin/deletecontact/'.$row->id);?>"><i class="fa fa-trash"
                                            style="color:red" aria-hidden="true"></i></a>
                                </td>

                            </tr>
                            <?php ++$count; } } ?>

                        </tbody>
                    </table>
                </div>
                <!-- End Display Table -->

                <!-- Printed Table -->

                <div class="table-responsive" style="display:none">
                    <table class="table table-striped custom-table" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width:30px">No</th>
                                <th>Firm Details</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Name</th>
                                <th>Mobile1</th>
                                <th>Mobile2</th>
                                <th>Email</th>
                                <th>Profession</th>
                                <th>GST No.</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $count = 1;
                                    if(isset($result)){

                                        
                                    foreach ($result as $row) {
                                ?>
                            <tr>
                                <td style="width:30px"><?= $count; ?></td>

                                <td><?= $row->firmname;?></td>
                                <td><?= $row->address;?></td>
                                <td><?= $row->city;?></td>
                                <td><?= $row->state;?></td>
                                <td>
                                    <?= $row->name;?>
                                </td>
                                <td>
                                    <a href="tel:+91<?= $row->mobileno1; ?>"><?= $row->mobileno1;?></a> 
                                    </td>
                                    <td>
                                        <a href="tel:+91<?= $row->mobileno2;?>"><?= $row->mobileno2;?></a>
                                </td>
                               
                                <td>
                                    <?= $row->email;?>
                                </td>
                                <td><?= $row->profession;?></td>
                                
                                <td><?= $row->gstno;?></td>
                                

                            </tr>
                            <?php ++$count; } } ?>

                        </tbody>
                    </table>
                </div>

                <!-- End Printed Table -->


            </div>
        </div>
    </div>
</div>
<script>
    function binddata()
    {
        let state = document.getElementById('states');
        
        $.ajax({
            url : "<?php echo base_url('admin/getcities');?>",
            method : "POST",
            data : {state: state.value},
            async : true,
            dataType : 'json',
            success: function(data){                        
                var html = '<option value="">Select City</option>';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option  value='+data[i].city+'>'+data[i].city+'</option>';
                }
                document.getElementById("cities").innerHTML = html;                
            }
        });

        // show();
    }
</script>
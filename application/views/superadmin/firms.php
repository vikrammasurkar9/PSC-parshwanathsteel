<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Firms [<?= sizeof($result); ?>]</h4>
            </div>
             
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form action="<?php echo base_url('superadmin/savefirm'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Firm Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="firm" value="<?= $id == 0 ? '' : $data->firm; ?>" required/>                                
                                </div>
                                <div class="col-sm-6">
                                    <label>Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" value="<?= $id == 0 ? '' : $data->address; ?>" required/>                                
                                </div>
                                <div class="col-sm-4">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" value="<?= $id == 0 ? '' : $data->email; ?>" required/>                                
                                </div>
                                <div class="col-sm-4">
                                    <label>Telephone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="telephone" value="<?= $id == 0 ? '' : $data->telephone; ?>" required/>                                
                                </div>
                                <div class="col-sm-4">
                                    <label>Mobile Numbers<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mobileno" value="<?= $id == 0 ? '' : $data->mobileno; ?>" required/>                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>GST Number<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="gst" value="<?= $id == 0 ? '' : $data->gst; ?>" required>                               
                                </div>
                                <div class="col-sm-6">
                                    <label>Acc Holder <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="accholder" value="<?= $id == 0 ? '' : $data->accholder; ?>" required>                               
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Acc Number <span class="text-danger"></span></label>
                                    <input type="number" class="form-control" name="accno" value="<?= $id == 0 ? '' : $data->accno; ?>" required>                                
                                </div>
                                <div class="col-sm-6">
                                    <label>IFSC Code <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="ifsc" value="<?= $id == 0 ? '' : $data->ifsc; ?>" required>                               
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Bank <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="bank" value="<?= $id == 0 ? '' : $data->bank; ?>" required>                                
                                </div>

                                <div class="col-sm-6">
                                    <label>Branch <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="branch" value="<?= $id == 0 ? '' : $data->branch; ?>" required>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-sm-6">
                                    <label>Firm Icon <span class="text-danger"></span></label>
                                    <input type="file" class="form-control" name="firmicon" value="<?= $id == 0 ? '' : $data->firmicon; ?>" required>                                
                                </div>

                                <div class="col-sm-6">
                                    <label>Firm Color Code <span class="text-danger"></span></label>
                                    
                                    <select name="firmcolor" id="" class="form-control">
                                        <option value="">Select Color</option>
                                        <option value="#F89504">PIPL</option>
                                        <option value="#8C252C">PSPL</option>
                                    </select>
                                </div>
                            </div> -->
                            
                            
                        
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn">Send</button><br><br>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
                </div>
                <br />
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>FirmName</th>
                                    <th>Contact Details</th>
                                    <th>Address</th>
                                    <th>RTGS Details</th>
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
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row->firm ."<br> GST  - ".$row->gst; ?></td>
                                    <td><?= $row->email ."<br> Tel - ".$row->telephone."<br> Mob - ".$row->mobileno;?></td>
                                    <td style="width:400px"><?php echo $row->address;?></td>
                                    <td>
                                    <?php echo $row->accholder . "<br> AccNo - " . $row->accno . "<br> IFSC - ". $row->ifsc . "<br> Bank - " . $row->bank." - ". $row->branch  ?>
                                    </td>
                                    <td>
                                    <a href="<?php echo base_url('superadmin/firms/'.$row->id); ?>" class="btn btn btn-success btn-rounded "><i class="fa fa-pencil"></i> </a> &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url('superadmin/deletefirms/'.$row->id); ?>" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                                <?php ++$count; } } ?>
                                                
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
            if(show)
                tr[i].style.display = "";
            else
                tr[i].style.display = "none";
        }
    }
</script>

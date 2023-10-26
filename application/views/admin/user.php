<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Edit Lead Customer </h4>
            </div>             
        </div>
        <div class="row">
            <div class="col-md-12">                
                <div class="card-box">
                    <form action="<?= base_url('admin/saveuser'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id; ?>" />                            
                            <div class="col-sm-12">
                                <div class="row">
                                    
                                    <div class="col-sm-4">
                                        <label>Firm Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="firmname" id="firmname" value="<?= $id == 0 ? '' : $data->firmname; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="name" id="name" value="<?= $id == 0 ? '' : $data->name; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>City<span class="text-danger">*</span></label>
                                            <input class="form-control" name="city" id="city" value="<?= $id == 0 ? '' : $data->city; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-8">
                                        <label>Address<span class="text-danger"></span></label>
                                        <textarea class="form-control" rows="1" name="address" id="address"><?= $id == 0 ? '' : $data->address; ?></textarea>  
                                    </div>
                                    <div class="col-sm-4">
                                        <label>State<span class="text-danger">*</span></label>
                                            <input class="form-control" name="state" id="state" value="<?= $id == 0 ? 'Maharastra' : $data->state; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Mobile No.<span class="text-danger">*</span></label>
                                            <input class="form-control" name="mobileno" id="mobileno1" value="<?= $id == 0 ? '' : $data->mobileno; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>GST No.<span class="text-danger"></span></label>
                                            <input class="form-control" name="gstno" id="" value="<?= $id == 0 ? '' : $data->gstno; ?>" type="text" >
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Profession<span class="text-danger">*</span></label>
                                            <input class="form-control" list="professions" name="profession" id="profession" value="<?= $id == 0 ? '' : $data->profession; ?>" type="text" required>
         
                                    <datalist id="professions">
                                        <option value="Steel Trader">
                                        <option value="Civil Engineer">
                                        <option value="Purchase Head">
                                        <option value="Stone Crusher">
                                        <option value="End User">
                                    </datalist>
                                    </div> 
                                    <div class="col-sm-2">
                                        <br />
                                        <button class="btn btn-primary">Save</button>
                                        <a href="<?= base_url('admin/contacts/0'); ?>" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                    </form>
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

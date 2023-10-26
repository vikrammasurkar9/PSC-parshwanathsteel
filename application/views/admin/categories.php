<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Categories[<?= sizeof($result); ?>]</h4>
            </div>
             
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card-box">
                    <form action="<?php echo base_url('admin/saveCategory'); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />                            
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Category <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">                                            
                                            <input type="text" class="form-control" name="name" id="category" value="<?php echo $id == 0 ? '' : $data->name; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Icon <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">                                            
                                        <input type="file" id="pic" name="pic" class="form-control"  />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Show On Website <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">                                            
                                    <select name="showonwebsite" class="form-control" required>
                                        <option value="">Select</option>
										<option value="Yes" <?php echo $id == 0 ? '' : ($data->showonwebsite == "Yes" ? "selected" : "") ?>>Yes</option>
										<option value="No" <?php echo $id == 0 ? '' : ($data->showonwebsite == "No" ? "selected" : "") ?>>No</option>
									</select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn">Save</button><br><br>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-7">
                <div class="col-md-12">
                    <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
                </div>
                <br />                
                <div class="col-md-12">
                <a class="pull-right" style="color:red;font-size:12px">If product count is more than 0 you can't delete categories</a>
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Icon</th>
                                    <th>Category</th>
                                    <th>Products</th>
                                    <th>Showonwebsite</th>
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
                                    <td>
                                        <img src="<?= base_url('categorypics/' . $row->id . '.png'); ?>" style="height:40px; width:40px;" class="img-thumbnail" /> 
                                    </td>
                                    <td><?php echo $row->name; ?></td>
                                    <td>
                                    <a class="btn btn-success" title="Product Count" style="color:white">
                                            <?php echo $row->productcount; ?>
                                        </a>
                                    </td>
                                    <td>
                                    <?= $row->showonwebsite; ?>
                                    </td>
                                    <td>
                                    <a href="<?php echo base_url('admin/categories/'.$row->id); ?>" class="btn btn btn-success btn-rounded "><i class="fa fa-pencil"></i> </a>
                                    <?php
                                        if($row->productcount == 0) { ?>
                                    <a href="<?php echo base_url('admin/deleteCategory/'.$row->id); ?>" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i> </a>
                                    <?php } ?>
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

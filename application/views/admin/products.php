<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Products [<?= sizeof($result); ?>]</h4>
            </div>             
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form action="<?php echo base_url('admin/saveProduct'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />                            
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label>SrNo <span class="text-danger">*</span></label>
                                            <input class="form-control" name="srno" id="srno" value="<?php echo $id == 0 ? (sizeof($result) + 1) : $data->srno; ?>" type="number" min="0" required>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Category <span class="text-danger">*</span></label>
                                        <select id="categoryid" name="categoryid" class="form-control">
                                            <?php
                                                foreach($categories as $category)
                                                {
                                                    echo "<option value='" . $category->id . "' " . ($id == 0 ? "" : ($data->categoryid == $category->id ? "selected" : "")) . ">" . $category->name . "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Product Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="product" id="product" value="<?php echo $id == 0 ? '' : $data->product; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Icon<span class="text-danger">*</span></label>
                                        <input type="file" id="pic" name="pic" class="form-control"  />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Weight In<span class="text-danger">*</span></label>
                                        <select id="type" name="type" class="form-control">
                                        <option value="Meter" <?php echo ($id == 0 ? '' : $data->type == "Meter") ? 'selected' : ''; ?>>Meter</option>                                        
                                        <option value="Nos" <?php echo ($id == 0 ? '' : $data->type == "Nos") ? 'selected' : ''; ?>>Nos</option>
                                    </select>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <label>Billing In<span class="text-danger">*</span></label>
                                        <select id="billingin" name="billingin" class="form-control">
                                        <option value="Meter" <?php echo ($id == 0 ? '' : $data->billingin== "Meter") ? 'selected' : ''; ?>>Meter</option>
                                        <option value="Feet" <?php echo ($id == 0 ? '' : $data->type == "Feet") ? 'selected' : ''; ?>>Feet</option>
                                        <option value="Kgs" <?php echo ($id == 0 ? '' : $data->billingin == "Kgs") ? 'selected' : ''; ?>>Kgs</option>
                                        <option value="Nos" <?php echo ($id == 0 ? '' : $data->billingin == "Nos") ? 'selected' : ''; ?>>Nos</option>
                                    </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <button class="btn btn-primary">Save</button>
                                        <a href="<?= base_url('admin/products/0'); ?>" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                    <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off">
                    <br />
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sr No</th>
                                    <th>Category</th>
                                    <th>Product Name</th>
                                    <th>Type</th>
                                    <th>Billing In</th>
                                    <th>Count</th>
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
                                    <td><?php echo $row->srno; ?></td>
                                    <td><?php echo $row->categoryname; ?></td>
                                    <td>
                                        <img src="<?= base_url('productpics/' . $row->id . '.png'); ?>" style="height:40px; width:40px;" class="img-thumbnail" /> <?php echo $row->product; ?>
                                    </td>
                                    <td><?php echo $row->type; ?></td>
                                    <td><?php echo $row->billingin; ?></td>
                                    <td>
                                        <a class="btn btn-success" href="<?php echo base_url('admin/productweights/'.$row->id.'/0');?>" title="Add product size, weight">
                                            <?php echo $row->pweightcount; ?>
                                        </a>
                                    </td>
                                    <td>
                                    <a href="<?php echo base_url('admin/products/'.$row->id); ?>" class="btn btn btn-primary btn-rounded "><i class="fa fa-edit"></i> </a>
                                    <?php
                                        if($row->pweightcount == 0)
                                            echo '<a href="' . base_url('admin/deleteProduct/'.$row->id) . '" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i> </a>';
                                    ?>
                                    
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

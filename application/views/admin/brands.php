<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Brands [<?= sizeof($result); ?>]</h4>
            </div>             
        </div>
        <div class="row">
            <div class="col-md-12">                
                <div class="card-box">
                    <form action="<?php echo base_url('admin/saveBrand'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />                            
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label>Sr No <span class="text-danger">*</span></label>
                                            <input class="form-control" name="srno" id="srno" value="<?php echo $id == 0 ? (sizeof($result) + 1) : $data->srno; ?>" type="number" min="0" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="name" id="name" value="<?php echo $id == 0 ? '' : $data->name; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Icon<span class="text-danger">*</span></label>
                                        <input type="file" id="pic" name="pic" class="form-control"  />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Show On Website<span class="text-danger">*</span></label>
                                        <select name="showonwebsite" class="form-control">
										<option value="Yes" <?php echo $id == 0 ? '' : ($data->showonwebsite == "Yes" ? "selected" : "") ?>>Yes</option>
										<option value="No" <?php echo $id == 0 ? '' : ($data->showonwebsite == "No" ? "selected" : "") ?>>No</option>
									</select>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Producer<span class="text-danger">*</span></label>
                                        <select name="producerid" class="form-control">
                                        <?php
                                            foreach ($producers as $producer) {
                                                ?>
                                            <option value="<?php echo $producer->id; ?>"
                                                <?php echo $id == 0 ? '' : ($data->producerid == $producer->id ? ' selected ' : ''); ?>>
                                                <?php echo $producer->name; ?></option>
                                            <?php
                                            } ?>
                                        <select>                                        
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <button class="btn btn-primary">Save</button>
                                        <a href="<?= base_url('admin/brands/0'); ?>" class="btn btn-danger">Cancel</a>
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
                                    <th>Brand</th>
                                    <th>Base Rate</th>
                                    <th>Producer</th>
                                    <th>Products Count</th>
                                    <th>Show on website</th>
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
                                    <td>
                                        <img src="<?= base_url('brandpics/' . $row->id . '.png'); ?>" style="height:40px; width:40px;" class="img-thumbnail" /> <?php echo $row->name; ?>
                                    </td>
                                    <td><?= number_format(floatval($row->baserate), 2);?></td>
                                    <td><?php echo $row->producername; ?></td>
                                    <td>
                                        <a class="btn btn-success" href="<?= base_url('admin/brandproducts/' . $row->id); ?>">
                                            <?php echo $row->productcount; ?>
                                        </a>
                                    </td>
                                    <td><?= $row->showonwebsite; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('admin/brands/'.$row->id); ?>" class="btn btn btn-primary btn-rounded "><i class="fa fa-edit"></i> </a>
                                        <?php
                                            if($row->productcount == 0)
                                                echo '<a href="' . base_url('admin/deleteBrand/' . $row->id) . '" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i> </a>';
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

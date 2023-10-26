<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="page-title"><img src="<?= base_url('brandpics/' . $brand->id . '.png'); ?>" 
                style="height:40px; width:40px;" class="img-thumbnail" /> 
                <?php echo $brand->name;?> <span style="color:red">Base Rate : <?= number_format(floatval($brand->baserate), 2);?></span></h4>
            </div>
            <div class="col-sm-2">
                <select id="category" class="form-control" onchange="show()">
                    <option value="0">Products</option>
                    <?php
                        $category = 0;
                        if (isset($_GET['category']))
                            $category = $_GET['category'];
                            foreach ($products as $product) {
                                echo '<option value="' . $product->id . '"' . ($category == $product->id ? " selected " : "") . '>'.$product->product.'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search Table 1" autocomplete="off"> 
            </div>
            <div class="col-sm-2">
                <input type="text" id="myInput2" onkeyup="searchtable2()" class="form-control"  placeholder="Search Table 2" autocomplete="off"> 
            </div>
        </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Size(in mm)</th>
                                    <th>Rate</th>
                                    <th>Weight (Kg)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    if(isset($result)){
                                    foreach ($result as $row) {
                                        if($row->bpid == "")
                                        {
                                            continue;
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row->categoryname;?></td>
                                    <td><?php echo $row->productname;?></td>
                                    <td><?php echo $row->sizeinmm;?></td>
                                    <td><?= number_format(floatval($brand->baserate) + floatval($row->parity), 2)." &#8377;" ?></td>
                                    <td><?php echo $row->weight." Kg";?></td>
                                    <td><?php
											echo '<span id="publish_' . $row->bpwid . '" onclick="publish(' . $row->bpwid . ')" ';
											echo 'class="btn btn-sm btn-primary" ';
											echo 'style="' . ($row->bpid == "" ? "display:block;" : "display:none;'") . '"';
											echo '>Add</span>';
											echo '<span id="unpublish_' . $row->bpwid . '" onclick="unpublish(' . $row->bpwid . ')" ';
											echo 'class="btn btn-sm btn-danger" ';
											echo 'style="' . ($row->bpid != "" ? "display:block;" : "display:none;'") . '"';
											echo '>Remove</span>';
									?></td>
                                </tr>
                                <?php ++$count; } } ?>
                                                
                            </tbody>
                        </table>
                    </div>
            </div>                       
        </div>
        
        <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Size(in mm)</th>
                                    <th>Rate</th>
                                    <th>Weight (Kg)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    if(isset($result)){
                                    foreach ($result as $row) {
                                        if($row->bpid != "")
                                        {
                                            continue;
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row->categoryname;?></td>
                                    <td><?php echo $row->productname;?></td>
                                    <td><?php echo $row->sizeinmm;?></td>
                                    <td><?= number_format(floatval($brand->baserate) + floatval($row->parity), 2)." &#8377;" ?></td>
                                    <td><?php echo $row->weight." Kg";?></td>
                                    <td><?php
											echo '<span id="publish_' . $row->bpwid . '" onclick="publish(' . $row->bpwid . ')" ';
											echo 'class="btn btn-sm btn-primary" ';
											echo 'style="' . ($row->bpid == "" ? "display:block;" : "display:none;'") . '"';
											echo '>Add</span>';
											echo '<span id="unpublish_' . $row->bpwid . '" onclick="unpublish(' . $row->bpwid . ')" ';
											echo 'class="btn btn-sm btn-danger" ';
											echo 'style="' . ($row->bpid != "" ? "display:block;" : "display:none;'") . '"';
											echo '>Remove</span>';
									?></td>
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
    
    function searchtable2() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable2");
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


    function publish(id)
	{
        $.ajax({
            url   : '<?php echo base_url('admin/addproductinbrand/' . $brand->id)?>/' + id,
            success: function (data) {
                if(data == "success")
                {
                    document.getElementById("publish_" + id).style.display="none";
                    document.getElementById("unpublish_" + id).style.display="block";
                }
            },
            cache: false
        }).fail(function (jqXHR, textStatus, error) {
        });
	}

	function unpublish(id)
	{
        $.ajax({
            url   : '<?php echo base_url('admin/removeproductinbrand/' . $brand->id)?>/' + id,
            success: function (data) {
                if(data == "success")
                {
                    document.getElementById("unpublish_" + id).style.display="none";
                    document.getElementById("publish_" + id).style.display="block";
                }
            },
            cache: false
        }).fail(function (jqXHR, textStatus, error) {
        });
	}
</script>



<script>
function show() {
    var category = document.getElementById("category").value;
    var parameter = "";
    if (category != 0)
        parameter = "?category=" + category;
    window.location.replace("<?php echo base_url('admin/brandproducts/' . $brand->id); ?>" + parameter);
}
</script>
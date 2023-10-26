<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title"><?= $pid == 0 ? "Product Varieties" : $product->product . "[" . sizeof($result) . "]" ;?></h4>
            </div>             
        </div>
        <div class="row">    
            <div class="col-md-12">
                    <div class="card-box">
                    <form action="<?php echo base_url('admin/saveProductweight'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />     
                        <div class="row">
                            <div class="col-sm-2">
                                    <label>SrNo <span class="text-danger">*</span></label>
                                        <input class="form-control" name="srno" id="srno" value="<?php echo $id == 0 ? (sizeof($result) + 1) : $data->srno; ?>" type="number" min="0" required>
                            </div>
                            <div class="col-sm-3">
                                <label>Product<span class="text-danger">*</span></label>
                                <select id="category" name="pid" class="form-control" required>
                                    <option value="">Product</option>
                                    <?php
                                        foreach ($products as $prod) {
                                            echo '<option value="' . $prod->id . '"' . ($prod->id == $data->pid ? " selected " : "") . '>'.$prod->product.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Size<span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input class="form-control" name="sizeinmm" id="sizeinmm"
                                        value="<?php echo $id == 0 ? '' : $data->sizeinmm; ?>" type="text" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label>Weight per <?= $product->type; ?><span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input class="form-control" name="weight" id="weight"
                                        value="<?php echo $id == 0 ? '' : $data->weight; ?>" type="text" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Brands<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <?php
                                                $count = 0;
                                            foreach ($brandwiseproductweights as $row) {
                                                $count++;
                                                echo "<input type='hidden' id='bid" . $count . "' name='bid" . $count . "' value='" . $row->id . "' />";
                                                echo "<label><input id='brand" . $count . "' name='brand" . $count . "' type='checkbox' " . ($row->presentcount == 0 ? "" : "checked") . " /> " . $row->name . "</label>&nbsp;&nbsp;&nbsp;";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="bcount" name="bcount" value="<?= $count; ?>" />
                            <div class="col-sm-12">
                                <button class="btn btn-primary">Save</button>
                                <a href="<?= base_url('admin/productweights/' . $pid . '/0'); ?>" class="btn btn-danger">Cancel</a>
                                <br><br>
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
                                <th>Product</th>
                                <th>Size(in mm)</th>
                                <th>Weight</th>
                                <!-- <th>Kg/Sq Meter</th>
                                <th>Length of Single in Meter</th> -->
                                <th>Brands</th>
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
                                <td><?php echo $row->srno;?></td>
                                <td><?php echo $row->categoryname;?></td>
                                <td><?php echo $row->sizeinmm;?></td>
                                <td><?php echo $row->weight; ?></td>                                
                                <td><?php echo $row->bcount; ?></td>
                                <td>
                                    <a href="<?php echo base_url('admin/productweights/'.$row->pid.'/'.$row->id); ?>" class="btn btn btn-primary btn-rounded "><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/deleteProductweight/'.$row->pid.'/'.$row->id); ?>" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i></a>
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

function setbrandChecked()
{
    var defaultbrandid = parseInt(document.getElementById("defaultbrandid").value);
    var bcount = parseInt(document.getElementById("bcount").value);
    for(var i = 1; i <= bcount; i++)
    {
        var brandid = parseInt(document.getElementById("bid" + i).value);
        if(brandid == defaultbrandid)
        {
            document.getElementById("brand" + i).checked = true;
            document.getElementById("brand" + i).disabled = true;
        }
        else{
            document.getElementById("brand" + i).disabled = false;
        }
    }    
}

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

    setbrandChecked();
</script>

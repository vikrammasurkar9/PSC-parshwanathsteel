<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="page-title"><img src="<?= base_url('brandpics/' . $brand->id . '.png'); ?>" 
                style="height:40px; width:40px;" class="img-thumbnail" /> 
                <?php echo $brand->name;?> [<?= sizeof($result); ?>] Base Rate : <?= number_format(floatval($brand->baserate), 2);?></h4>
                <input type="hidden" id="baserate" value="<?= $brand->baserate;?>"/>
                <input type="hidden" id="brandid" value="<?= $brandid;?>"/>
            </div>
            <div class="col-sm-3">
                <select id="category" class="form-control" onchange="show()">
                    <option value="0">Category</option>
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
            <div class="col-sm-3">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
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
                                    <th>Parity Group</th>
                                    <th>Parity</th>
                                    <th>Rate</th>
                                    <th>Weight</th>
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
                                    <td><?php echo $row->categoryname;?></td>
                                    <td><?php echo $row->productname;?></td>
                                    <td><?php echo $row->sizeinmm;?></td>
                                    <td>
                                        <select id="paritygroup<?= $count; ?>" style="height:30px;">
                                            <option value="0">Select</option>
                                            <?php
                                                $bpgid = 0;
                                                foreach($paritygroupproducts as $pgp)
                                                {
                                                    if($pgp->bpid == $row->bpid)
                                                    {
                                                        $bpgid = $pgp->pgroupid;
                                                        break;
                                                    }
                                                }
                                                foreach ($paritygroups as $paritygroup) {
                                                    echo '<option value="' . $paritygroup->id . '" ' . ($bpgid == $paritygroup->id ? "selected" : "") . '>'.$paritygroup->name.'</option>';
                                                }
                                            ?>
                                        </select>
                                        <button style="cursor:pointer;" onclick="updateParityGroup(<?= $count; ?>)"><i class="fa fa-check text-success fa-1x"></i></button>
                                    </td>
                                    <td>
                                        <input id="productid<?= $count; ?>" type="hidden" value="<?= $row->bpid; ?>" style="width:80px"/>
                                        <input id="parity<?= $count; ?>" type="number" step="any" value="<?= $row->parity == "" ? "" : number_format(floatval($row->parity), 2);?>" style="width:80px" min=0 />
                                        <button style="cursor:pointer;" onclick="updateParity(<?= $count; ?>)"><i class="fa fa-check text-success fa-1x"></i></button>                                        
                                    </td>
                                    <td style="text-align:right;"><span id="rate<?= $count; ?>"><?= $row->parity == "" ? "NA" : number_format(floatval($brand->baserate) + floatval($row->parity), 2) ?></span></td>
                                    <td style="text-align:right;"><?php echo $row->weight;?></td>
                                   
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
function updateParity(position){
        var productid = document.getElementById("productid" + position).value;
        var parity = document.getElementById("parity" + position).value;
        var baserate = document.getElementById("baserate").value;
        jQuery.ajax({
        url: "<?php echo base_url('superadmin/updateparity');?>",
        method : "POST",
        dataType: 'json',
        data: {parity: parity, productid: productid},
        success: function(data)
        {   
            if(parity != ""){
                // var rate = parseFloat(baserate) + parseFloat(parity);
                // document.getElementById("rate"+position).innerHTML = rate.toFixed(2);  
                showSnackbar("Updated");
            }
            else{
                //document.getElementById("rate"+position).innerHTML = ""; 
                showSnackbar("Updated");
            }
        }
        
        });
    }

    function updateParityGroup(position){
        var brandproductid = document.getElementById("productid" + position).value;
        var paritygroupid = document.getElementById("paritygroup" + position).value;
        jQuery.ajax({
            url: "<?php echo base_url('superadmin/updateparitygroup');?>",
            method : "POST",
            dataType: 'json',
            data: {paritygroupid: paritygroupid, brandproductid: brandproductid},
            success: function(data)
            {   
                showSnackbar("Updated");
            }        
        });
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

function show() {
    var category = document.getElementById("category").value;
    var parameter = "";
    if (category != 0)
        parameter = "?category=" + category;
    window.location.replace("<?php echo base_url('superadmin/brandproducts/' . $brand->id); ?>" + parameter);
}
</script>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-2">
                <h4 class="page-title">Report Maker</h4>
            </div>
            <div class="col-10">
                <form autocomplete="off">
                    <div class="row">
                        <div class="col-3">
                            <select name="productid" class="form-control">
                                <option value="0">Product</option>
                                <?php
                                    foreach ($products as $row) {
                                        $selected = "";
                                        if(isset($_GET['productid']))
                                        {
                                            if($_GET['productid'] == $row->id)
                                                $selected = "selected";
                                        }
                                        echo "<option value='" . $row->id . "' " . $selected . ">" . $row->product . "</option>";
                                    }    
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <select name="brandid" class="form-control">
                                <option value="0">Brand</option>
                                <?php
                                    foreach ($brands as $row) {
                                        $selected = "";
                                        if(isset($_GET['brandid']))
                                        {
                                            if($_GET['brandid'] == $row->id)
                                                $selected = "selected";
                                        }
                                        echo "<option value='" . $row->id . "' " . $selected . ">" . $row->name . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-2">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Report Name" style="<?=$showsave == "yes" ? "display:block;" : "display:none;" ?>" />
                        </div>
                        <div class="col-4 text-right">
                            <input type="submit" value="Preview" class="btn btn-primary" onclick="return clearname()" />
                            <input type="submit" value="Save" class="btn btn-success" <?= $showsave == "yes" ? "" : "style='display:none;'" ?> onclick="return validate()" />
                            <a class="btn btn-danger" href="newreport">Reset</a>
                            <a class="btn btn-warning" href="<?= base_url('reports'); ?>">Reports</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function clearname()
            {
                document.getElementById("name").value = "";
                return true;
            }

            function validate()
            {
                if(document.getElementById("name").value == "")
                {
                    document.getElementById("name").focus();
                    showSnackbar("Enter report name");
                    return false;
                }
                return true;
            }
        </script>

        <div class="row">
            <br /><br /><br />
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Product</th>
                                <th>Size</th>
                                <?php
                                    foreach ($brandsTable as $row) {
                                        echo "<th>" . $row->name . "</th>";
                                    }    
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($result as $row) {
                                ?>
                            <tr>
                                <td class="text-right"><?php echo $count; ?></td>                                
                                <td><?php echo $row->product; ?></td>
                                <td><?php echo $row->sizeinmm; ?></td>
                                <?php                                    
                                    foreach ($brandsTable as $brand) {
                                        $found = false;
                                        foreach ($brandproducts as $brandproduct) {
                                            if($brand->id == $brandproduct->bid && $row->id == $brandproduct->pwid){
                                                $billingrate = $brandproduct->billingrate;
                                                $billingrateplusgst = $brandproduct->billingrate + ($brandproduct->billingrate * 18/100);
                                                echo "<td>";
                                                if($billingrate > 0){
                                                    echo "<table><tr><td class='text-right'>" . number_format($billingrate, 1) . "</td>";
                                                    echo "<td class='text-right'>" . number_format($billingrateplusgst, 1) . "</td></tr></table>";
                                                }
                                                echo "</td>";
                                                $found = true;
                                                break;
                                            }
                                        }
                                        if($found == false)
                                        {
                                            echo "<td></td>";
                                        }
                                    }    
                                ?>
                            </tr>
                            <?php ++$count;
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
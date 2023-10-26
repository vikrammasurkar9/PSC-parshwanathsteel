<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-9">
                <h4 class="page-title">Reports [<?= sizeof($result); ?>]</h4>
            </div>             
            <div class="col-sm-3 text-right">
                <a class="btn btn-sm btn-primary" href="<?= base_url('reports/newreport'); ?>">New Report</a>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
                <br />
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
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
                                    <td><?php echo $row->name; ?></td>                                
                                    <td>
                                        <a class="btn btn btn-success btn-rounded" href="<?= base_url('reports/exportreport/' . $row->id);?>" title="Export"><i class="fa fa-file-excel-o"></i></a>&nbsp;&nbsp;
                                        <a class="btn btn btn-warning btn-rounded" href="<?= base_url('reports/printreport/' . $row->id);?>" title="Print"><i class="fa fa-print"></i></a>&nbsp;&nbsp;
                                        <a class="btn btn btn-danger btn-rounded" onclick="return returnConfirm()" href="<?= base_url('reports/deleteReport/' . $row->id);?>" title="Delete"><i class="fa fa-trash"></i></a>
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

    function validate()
    {
      if(document.getElementById("productid").value == "0"){
        showSnackbar("Please select product.");
        document.getElementById("productid").focus();
        return false;
      }
      if(document.getElementById("brandid").value == "0"){
        showSnackbar("Please select brand.");
        document.getElementById("brandid").focus();
        return false;
      }
    }
</script>

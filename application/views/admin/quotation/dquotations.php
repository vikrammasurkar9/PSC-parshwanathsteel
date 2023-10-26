<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-6">
                <h4 class="page-title"> Quotations [<?= $total_rows; ?>]</h4>
            </div>     
            <div class="col-6">
              <a href="<?php echo base_url('admin/dquotation');?>" class="btn  btn-primary pull-right"> + New</a> 
            </div>               
            <div class="col-12">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
            </div>       
        </div>
        <div class="row">
                <div class="col-md-12">
                    <br />
                    <div class="table-responsive">
                        <?= $links;   ?>
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="text-align:left;">Date</th>
                                    <th style="text-align:left;">User Details</th>
                                    <th style="text-align:left;">Quotation Name</th>
                                    <th></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    if(isset($result)){
                                        $date = "";
                                    foreach ($result as $row) {
                                        $rdate = date("d/m/Y", strtotime($row->createdon));
                                        if($date != $rdate){
                                            $date = $rdate;
                                        }
                                        else{
                                            $rdate = "";
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td style="color:green"><?php echo $rdate; ?></td>
                                    <td style="text-align:left;">
                                        <?php echo $row->name; ?>  &nbsp;&nbsp;
                                        <?php echo $row->email; ?>&nbsp;&nbsp;
                                        <?php echo $row->mobileno; ?>
                                    </td>
                                    <td style="text-align:left;">
										<a href="<?= base_url('admin/printdquotation/' . $row->id . '?printamount=yes'); ?>" style="color:green">
										<span class="custom-badge status-green">
                                        <?php echo $row->qname; ?>
                                        </span></a>
                                    </td>
                                    <td><a href="<?= base_url('admin/preparedo/'.$row->id); ?>" onclick="return confirm('Are you sure you want prepare DO ?');" class="btn btn-outline-primary take-btn">Prepare D.O.</a></td>
                                    <td>
                                    <a href="<?php echo base_url('admin/deletedquotation/'.$row->id); ?>" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded " title="Delete"><i class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                                <?php ++$count; } } ?>                                                
                            </tbody>
                        </table>
                        <?= $links; ?>
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

<?php
function does_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

?>

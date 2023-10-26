<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-3">
                <h4 class="page-title">Enquiries [<?= $total; ?>]</h4>
            </div>     
            <div class="col-9">
              
            <!-- <a class="btn btn-secondary" style="background-color:#F8D7DA">Multiple Brand Quotation</a>
            <a class="btn btn-secondary" style="background-color:#FFF3CD">Single Brand Quotation</a>
            <a class="btn btn-secondary" style="background-color:#D4EDDA">DO Prepared</a> -->
            <!-- <a onclick="return confirm('Sure to delete?');" href="<?php echo base_url('admin/deleterequests');?>" class="btn  btn-danger pull-right">Delete 10 Day Old Requests</a>  -->
            <a href="<?php echo base_url('admin/enquiry/0');?>" class="btn  btn-primary pull-right"> + New</a> 

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
                                    <th>Enquiry On</th>
                                    <th style="text-align:left;">User Details</th>
                                    
                                    <th style="">Description</th>
                                    <th>Image</th>
                                    <th></th>
                                    <th style="text-align:left;">Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    
                                    foreach ($result as $row) {
                                        
                                ?>
                                <tr>
                                    <td style="text-align:right;"><?php echo $count; ?></td>
                                    <td style="color:green"><?= date("d-m-Y", strtotime($row->createdon)); ?></td> 
                                     
                                    <td style="text-align:left;">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                    </td>
                                    <td><?= $row->description;?></td>
                                    <td><a  role="button" target="_blank" href="<?php echo base_url('enquirypics/'.$row->filename.'.png'); ?> "> <img src="<?= base_url('enquirypics/'.$row->filename.'.png');?>" height=80 width="110" alt=""></a></td>
                                    <td><a  role="button" target="_blank" href="<?= base_url('admin/printenquiry/'.$row->id); ?> " class="btn btn-outline-info"> View </a></td>
                                    
                                    <td style="text-align:left;">
                                        <?php echo $row->createdby; ?>
                                    </td>
                                    <td>
                                    <a href="<?php echo base_url('admin/enquiry/'.$row->id); ?>"  class="btn btn btn-primary btn-rounded " title="Edit"><i class="fa fa-pencil"></i> </a>
                                    <a href="<?php echo base_url('admin/deleteenquiry/'.$row->id); ?>" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded " title="Delete"><i class="fa fa-trash"></i> </a>
                                    </td>                             
                                </tr>
                                <?php ++$count; } ?>                                                
                            </tbody>
                        </table>
                        <?= $links;   ?>
                    </div>
                </div>
            </div>                       
        </div>
    </div>
</div>
<script>

function savetocontact(userid){
        //var userid = document.getElementById("userid").value;
        //alert(userid);
        jQuery.ajax({
            url: "<?php echo base_url('admin/savetocontacts');?>",
            method : "POST",
            dataType: 'json',
            data: {userid: userid},
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

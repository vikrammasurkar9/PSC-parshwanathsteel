<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-3">
                <h4 class="page-title">Leads [<?= $total; ?>]</h4>
            </div>     
            <div class="col-9">
            <a class="btn btn-secondary" style="background-color:#ecedf3">Lead</a>            
            <!-- <a class="btn btn-secondary" style="background-color:#F8D7DA">Multiple Brand Quotation</a>
            <a class="btn btn-secondary" style="background-color:#FFF3CD">Single Brand Quotation</a>
            <a class="btn btn-secondary" style="background-color:#D4EDDA">DO Prepared</a> -->
            <a onclick="return confirm('Sure to delete?');" href="<?php echo base_url('admin/deleterequests');?>" class="btn  btn-danger pull-right">Delete 10 Day Old Requests</a> 
            <a href="<?php echo base_url('admin/request');?>" class="btn  btn-primary pull-right"> + New</a> 

            </div>               
            <!-- <div class="col-12">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
            </div>        -->
        </div>
        <br>
        <form action="<?= base_url('admin/requests');?>" method="GET" >
        <div class="row filter-row">
            
            <div class="col-sm-6 col-md-5">
                <div class="form-group form-focus">
                    <label class="focus-label">Lead No.</label>
                    <input type="number" name="leadno"  class="form-control floating">
                </div>
            </div>
            <div class="col-sm-6 col-md-5">
                <div class="form-group form-focus">
                    <label class="focus-label">Search by Name</label>
                    <input type="text" name="qname" class="form-control floating">
                </div>
            </div>

            <div class="col-sm-6 col-md-2">
                <button type="submit" class="btn btn-success btn-block " style="color:white"> Search </button>
            </div>
            
        </div>
        </form>
        <div class="row">
                <div class="col-md-12">
                    <br />
                    <div class="table-responsive">
                        <?= $links;   ?>
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>                                    
                                    <th>Requested On</th>
                                    <th>Lead No.</th>
                                    <th style="text-align:left;">User Details</th>
                                    <th>Enquiry Source</th>
                                    <th>Narration</th>
                                    <th></th><th></th>
                                    <!-- <th style="text-align:left;">Lead Name & Enquiry Ref.</th> -->
                                    <th style="text-align:left;">Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    if(isset($result)){
                                        $date = "";
                                    foreach ($result as $row) {
                                        $backcolor = "";
                                        if($row->status == "Lead")
                                        {
                                            $backcolor = "#ecedf3";

                                        $rdate = date("d/m/Y", strtotime($row->requestdate));
                                        if($date != $rdate){
                                            $date = $rdate;
                                        }
                                        else{
                                            $rdate = "";
                                        }
                                ?>
                                <tr style="background-color:<?= $backcolor; ?>">
                                    <td style="text-align:right;"><?php echo $count; ?></td>
                                    <td style="color:green"><?php echo $rdate; ?></td> 
                                    <td><?php if($row->dostatus !='yes') {
                                        if($row->status == "Lead")
                                        {
                                            $leadno = substr("000000{$row->leadno}", -5);
                                            echo '<a href="'.base_url('admin/printrequest/' . $row->id).'" class="custom-badge status-green">Lead/'.$leadno.'</a>';
                                        }
                                        
                                    }?>
                                            
                                        
                                    </td>   
                                    <td style="text-align:left;">
                                    <a href="<?= base_url('admin/printrequest/' . $row->id); ?>" style="color:black">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                        </a>
                                    </td>
                                    <td><?= $row->enquirysource;?></td>
                                    <td><?= $row->narration;?></td>
                                    <td>
                                        <a title="Edit User Details" class="btn btn-sm btn-primary" href="<?= base_url('admin/user/'.$row->userid);?>" title="Edit User Details"><i class="fa fa-pencil-square-o"></i></a>
                                    </td>
                                    <td>
                                            <?php if($row->savedincontacts != "yes")
                                        {?>
                                        <button style="cursor:pointer;" title="Add To Contact" class="btn btn-sm btn-success" onclick="savetocontact(<?= $row->userid; ?>)"><i class="fa fa-save fa-1x"></i></button>
                                        <?php }?>                                            
                                    </td>
                                    <!-- <td style="text-align:left;">
                                    <?php if($row->status =="Lead") { ?>
										<a href="<?= base_url('admin/printrequest/' . $row->id); ?>" style="color:green">
										<span class="custom-badge status-green btn-block">
                                        <?php echo $row->qname; ?>
                                        </span></a>
                                    <?php } else if($row->status == "MBQuotation") {?>
                                        <a href="<?= base_url('admin/printquotation/' . $row->id); ?>" style="color:green">
										<span class="custom-badge status-green btn-block">
                                        <?php echo $row->qname; ?>
                                        </span></a>
                                    <?php } else if($row->status == "SBQuotation") {?>
                                        <a href="<?= base_url('admin/printsquotation/' . $row->id); ?>" style="color:green">
                                        <span class="custom-badge status-green btn-block">
                                        <?php echo $row->qname; ?>
                                        </span></a>
                                    <?php }?><br/>
                                    <?= $row->narration;?>
                                    </td>    -->
                                    <td style="text-align:left;">
                                        <?php echo $row->createdby; ?>
                                    </td>
                                    <td>
                                    <a href="<?php echo base_url('admin/deleterequest/'.$row->id); ?>" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded " title="Delete"><i class="fa fa-trash"></i> </a>
                                    </td>                             
                                </tr>
                                <?php ++$count; } }} ?>                                                
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

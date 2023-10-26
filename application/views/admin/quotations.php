<style type="text/css">
.star_rated {
    color: red;
}

.star {
    text-shadow: 0 0 1px #F48F0A;
    cursor: pointer;
}

.hide {
    display: none;
}

.star:hover+.hide {
    display: block;

}
</style>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-3">
                <!-- <h4 class="page-title">Quotations [<?= $total; ?>]</h4> -->
                <h4 class="page-title">Quotations</h4>
            </div>
            <div class="col-9">
                <!-- <a class="btn btn-secondary" style="background-color:#ecedf3">Lead</a>             -->
                <a class="btn btn-secondary" style="background-color:#F8D7DA">Multiple Brand Quotation</a>
                <a class="btn btn-secondary" style="background-color:#FFF3CD">Single Brand Quotation</a>
                <?php if(!isset($_GET["status"])){?>
                <a class="btn btn-secondary" style="background-color:#D1ECF1;color:black"
                    href="<?= base_url('admin/quotations?status=Yes'); ?>">Sent Quotation</a>
                <?php } else {?>
                <a class="btn btn-secondary" href="<?= base_url('admin/quotations'); ?>">All Quotations</a>
                <?php }?>
                <!-- <a onclick="return confirm('Sure to delete?');" href="<?php echo base_url('admin/deleterequests');?>" class="btn  btn-danger pull-right">Delete 10 Day Old Requests</a>  -->
                <a href="<?php echo base_url('admin/newquotation');?>" class="btn  btn-primary pull-right"> + New</a>


            </div>
            <!-- <div class="col-12">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Search..."
                    autocomplete="off">
            </div> -->
        </div>
        <br>
        <form action="<?= base_url('admin/quotations');?>" method="GET">
            <div class="row filter-row">

                <div class="col-sm-6 col-md-5">
                    <div class="form-group form-focus">
                        <label class="focus-label">Quotation No.</label>
                        <input type="number" name="qno" class="form-control floating">
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
                                <th>Quotation No.</th>
                                <th>Requested On</th>
                                <th style="text-align:left;">User Details</th>
                                <th>Enq. Source</th>
                                <th>Enq. Ref.</th>
                                <th style="text-align:center">Review</th>
                                <th></th>
                                <th></th>
                                <!-- <th style="text-align:left;">Lead Name & Enquiry Ref.</th> -->
                                <th style="text-align:left;">Created By</th>
                                <th>DO Status</th>
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

                                        if($row->followup !="No")
                                        continue;

                                        if($row->status != "Lead" )
                                        {

                                        $backcolor = "";
                                        if($row->status == "Lead")
                                            $backcolor = "#ecedf3";
                                        // else if($row->followup == "Yes")
                                        // $backcolor = "#FFFFFF";
                                        else if($row->dostatus == 'yes')
                                            $backcolor = "#cefff7";
                                        else if($row->sbqstatus == "yes")
                                            $backcolor = "#FFF3CD";
                                        else if($row->mbqstatus == "yes")
                                            $backcolor = "#F8D7DA";
                                        
                                        $rdate = date("d/m/Y", strtotime($row->createdon));
                                        
                                ?>
                            <tr style="background-color:<?= $backcolor; ?>">
                                <!-- <td style="text-align:right;"><?php echo $count; ?></td> -->

                                <td><?php if($row->status != "Lead" && $row->dostatus !='yes') {
                                        if($row->status == "SBQuotation")
                                        {
                                            $quotationno = substr("000{$row->sbqno}", -4);
                                            echo '<span class="custom-badge status-green">SBQ/'.$quotationno.'</span>';
                                        }
                                        else
                                        {
                                            $quotationno = substr("000{$row->mbqno}", -4);
                                            echo '<span class="custom-badge status-green">MBQ/'.$quotationno.'</span>';
                                        }
                                    }?>


                                </td>
                                <td style="color:green"><?php echo $rdate; ?></td>
                                <!-- <td style="text-align:left;">
                                    <?php echo $row->firmname; ?> <br>
                                    <?php echo $row->mobileno ." ". $row->city ; ?>
                                </td> -->

                                <td style="text-align:left;">
                                    <?php if($row->status =="Lead") { ?>
                                    <a href="<?= base_url('admin/printrequest/' . $row->id); ?>" style="color:black">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                    </a>
                                    <?php } else if($row->status == "MBQuotation") {?>
                                    <a href="<?= base_url('admin/printquotation/' . $row->id); ?>" style="color:black">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                    </a>
                                    <?php } else if($row->status == "SBQuotation") {?>
                                    <a href="<?= base_url('admin/printsquotation/' . $row->id); ?>" style="color:black">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                    </a>
                                    <?php }?>
                                </td>
                                <td><?= $row->enquirysource;?></td>
                                <td><?= $row->narration;?></td>

                                <td style="width:180px; text-align:center">
                                    <input type="hidden" name="id" id="quotationid<?= $count;?>"
                                        value="<?= $row->id; ?>">
                                     
                                    <?php 

                                        $query = "SELECT * FROM quotationreviews WHERE qid = ".$row->id;
                                        $query .= " ORDER BY id DESC LIMIT 1";			
                                        $reviews = $this->db->query($query)->result();                                       

                                        foreach($reviews AS $review)
                                        {      
                                            if($review->reviewstatus == 'Hot')  
                                            {
                                                $btnClass = 'btn-danger';
                                            }
                                            else if($review->reviewstatus == 'Warm')  
                                            {
                                                $btnClass = 'btn-warning';
                                            }                       
                                            else if($review->reviewstatus == 'Cold')  
                                            {
                                                $btnClass = 'btn-success';
                                            }            
                                    ?>

                                    <a class="btn <?= $btnClass;?> rounded text-white text-uppercase" style="width:100px" data-toggle="modal" data-target="#add_review"
                                        onclick="getQid(<?= $count; ?>)"><?= $review->reviewstatus;?>
                                         </a>
                                         

                                    <?php }?>
                                    <a href="#" id="review" data-toggle="modal" data-target="#add_review"
                                        onclick="getQid(<?= $count; ?>)">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                </td>
                                <td>
                                    <a title="Edit User Details" class="btn btn-sm btn-primary"
                                        href="<?= base_url('admin/user/'.$row->userid);?>" title="Edit User Details"><i
                                            class="fa fa-pencil-square-o"></i></a>
                                </td>
                                <td>
                                    <?php if($row->savedincontacts != "yes")
                                        {?>
                                    <button style="cursor:pointer;" title="Add To Contact"
                                        class="btn btn-sm btn-success" onclick="savetocontact(<?= $row->userid; ?>)"><i
                                            class="fa fa-save fa-1x"></i></button>
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
                                    <?php }?><br />
                                    <?= $row->narration;?>
                                </td> -->
                                <td style="text-align:left;">
                                    <?php echo $row->createdby; ?>
                                </td>
                                <td><?php 
                                if($row->dostatus == 'yes')
                                {
                                    echo "<a class='btn btn-secondary' style='background-color:#D1ECF1;color:black'>DO Prepared</a>";
                                }
                                
                                ?>
                                </td>
                                <td><?php if($row->followup =="No"){?>
                                    <a style="color:white" onclick="followup(<?= $row->id; ?>)"
                                        class="btn btn-secondary btn-sm">Send</a>
                                    <?php }?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('admin/deleterequest/'.$row->id); ?>"
                                        onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "
                                        title="Delete"><i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                            <?php ++$count;
                                 if($count == 201)
                                 break;
                            } } } ?>
                        </tbody>
                    </table>
                    <?= $links;   ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <br />
                <div class="table-responsive">
                    <!-- <?= $links;   ?> -->
                    <table class="table table-striped custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th>Quotation No.</th>
                                <th>Requested On</th>
                                <th style="text-align:left;">User Details</th>
                                <th>Enq. Source</th>
                                <th>Enq. Ref.</th>
                                <th style="text-align:center">Review</th>
                                <th></th>
                                <th></th>
                                <!-- <th style="text-align:left;">Lead Name & Enquiry Ref.</th> -->
                                <th>DO Prepared</th>
                                <th style="text-align:left;">Created By</th>
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

                                        if($row->followup =="No")
                                        continue;

                                        if($row->status != "Lead" )
                                        {

                                        $backcolor = "";
                                        if($row->status == "Lead")
                                            $backcolor = "#ecedf3";
                                        // else if($row->followup == "Yes")
                                        // $backcolor = "#FFFFFF";
                                        else if($row->dostatus == 'yes')
                                            $backcolor = "#cefff7";
                                        else if($row->sbqstatus == "yes")
                                            $backcolor = "#FFF3CD";
                                        else if($row->mbqstatus == "yes")
                                            $backcolor = "#F8D7DA";  
                                            $rdate = date("d/m/Y", strtotime($row->createdon));
                                        // if($date != $rdate){
                                        //     $date = $rdate;
                                        // }
                                        // else{
                                        //     $rdate = "";
                                        // }
                                ?>
                            <tr style="background-color:<?= $backcolor; ?>">
                                <!-- <td style="text-align:right;"><?php echo $count; ?></td> -->

                                <td><?php if($row->status != "Lead" && $row->dostatus !='yes') {
                                        if($row->status == "SBQuotation")
                                        {
                                            $quotationno = substr("000{$row->sbqno}", -4);
                                            echo '<span class="custom-badge status-green">SBQ/'.$quotationno.'</span>';
                                        }
                                        else
                                        {
                                            $quotationno = substr("000{$row->mbqno}", -4);
                                            echo '<span class="custom-badge status-green">MBQ/'.$quotationno.'</span>';
                                        }
                                    }?>


                                </td>
                                <td style="color:green"><?php echo $rdate; ?></td>
                                <td style="text-align:left;">
                                    <?php if($row->status =="Lead") { ?>
                                    <a href="<?= base_url('admin/printrequest/' . $row->id); ?>" style="color:black">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                    </a>
                                    <?php } else if($row->status == "MBQuotation") {?>
                                    <a href="<?= base_url('admin/printquotation/' . $row->id); ?>" style="color:black">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                    </a>
                                    <?php } else if($row->status == "SBQuotation") {?>
                                    <a href="<?= base_url('admin/printsquotation/' . $row->id); ?>" style="color:black">
                                        <?php echo $row->firmname; ?> <br>
                                        <?php echo $row->mobileno ." ". $row->city ; ?>
                                    </a>
                                    <?php }?>
                                </td>
                                <td><?= $row->enquirysource;?></td>
                                <td><?= $row->narration;?></td>
                                <td style="width:180px; text-align:center">
                                    <input type="hidden" name="id" id="quotation_id<?= $count;?>"
                                        value="<?= $row->id; ?>">
                                   
                                    <?php 

                                        $query = "SELECT * FROM quotationreviews WHERE qid = ".$row->id;
                                        $query .= " ORDER BY id DESC LIMIT 1";			
                                        $reviews = $this->db->query($query)->result();                                       

                                        foreach($reviews AS $review)
                                        {      
                                            if($review->reviewstatus == 'Hot')  
                                            {
                                                $btnClass = 'btn-danger';
                                            }
                                            else if($review->reviewstatus == 'Warm')  
                                            {
                                                $btnClass = 'btn-warning';
                                            }                       
                                            else if($review->reviewstatus == 'Cold')  
                                            {
                                                $btnClass = 'btn-success';
                                            }            
                                    ?>

                                    <a class="btn <?= $btnClass;?> rounded text-white text-uppercase" style="width:100px" data-toggle="modal" data-target="#add_review"
                                        onclick="getQ_id(<?= $count; ?>)"><?= $review->reviewstatus;?>
                                         </a>
                                         

                                    <?php }?>
                                    <a href="#" id="review" data-toggle="modal" data-target="#add_review"
                                        onclick="getQ_id(<?= $count; ?>)">
                                        <i class="fa fa-pencil"></i>
                                    </a>


                                </td>
                                <td>
                                    <a title="Edit User Details" class="btn btn-sm btn-primary"
                                        href="<?= base_url('admin/user/'.$row->userid);?>" title="Edit User Details"><i
                                            class="fa fa-pencil-square-o"></i></a>
                                </td>
                                <td>
                                    <?php if($row->savedincontacts != "yes")
                                        {?>
                                    <button style="cursor:pointer;" title="Add To Contact"
                                        class="btn btn-sm btn-success" onclick="savetocontact(<?= $row->userid; ?>)"><i
                                            class="fa fa-save fa-1x"></i></button>
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
                                    <?php }?><br />
                                    <?= $row->narration;?>
                                </td> -->
                                <td><?php 
                                if($row->dostatus == 'yes')
                                {
                                    echo "<a class='btn btn-secondary' style='background-color:#D1ECF1;color:black'>DO Prepared</a>";
                                }
                                
                                ?></td>
                                <td style="text-align:left;">
                                    <?php echo $row->createdby; ?>
                                </td>
                                <td><?php if($row->followup =="No"){?>
                                    <a style="color:white" onclick="followup(<?= $row->id; ?>)"
                                        class="btn btn-secondary btn-sm">Send</a>
                                    <?php }?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('admin/deleterequest/'.$row->id); ?>"
                                        onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "
                                        title="Delete"><i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                            <?php ++$count;
                                 if($count == 201)
                                 break;
                            } } } ?>
                        </tbody>
                    </table>
                    <!-- <?= $links;   ?> -->
                </div>
            </div>
        </div>
    </div>

    <div id="add_review" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Review on Quotation</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <form action="<?= base_url('admin/saveReview');?>" method="POST">
                        <input type="hidden" name="qid" id="qid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Review Status <span class="text-danger">*</span></label>
                                    <select name="reviewstatus" class="form-control" id="" required>
                                        <option value="">Select Status</option>
                                        <option value="Hot">HOT</option>
                                        <option value="Warm">WARM</option>
                                        <option value="Cold">COLD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Review</label>
                                    <input type="text" class="form-control" name="review" id=""
                                        placeholder="Enter Review in details" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="m-t-10 m-b-10 text-center">
                                    <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>



                    </form>
                    <div class="table-responsive" id="reviews">

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Script -->
<!-- <script type='text/javascript'>
	$(document).ready(function(){

		
		$('.ratingbar').rating({
	    	showCaption:false,
	    	showClear: false,
	    	size: 'sm'
	    });

		
	    $('.ratingbar').on('rating:change', function(event, value, caption) {
	    	var id = this.id;
	    	var splitid = id.split('_');
	    	var postid = splitid[1];
	    	
		   	$.ajax({
		   		url: '<?= base_url() ?>index.php/posts/updateRating',
		   		type: 'post',
		   		data: {postid: postid, rating: value},
		   		success: function(response){
		   			$('#averagerating_'+postid).text(response);
		   		}
		   	});
		});
	}); -->

</script>
<script>
function savetocontact(userid) {
    //var userid = document.getElementById("userid").value;
    //alert(userid);
    jQuery.ajax({
        url: "<?php echo base_url('admin/savetocontacts');?>",
        method: "POST",
        dataType: 'json',
        data: {
            userid: userid
        },
        success: function(data) {
            showSnackbar("Updated");
        }
    });
}

function followup(id) {

    jQuery.ajax({
        url: "<?php echo base_url('admin/updatefollowupstatus');?>",
        method: "POST",
        dataType: 'json',
        data: {
            id: id
        },
        success: function(data) {
            showSnackbar("Updated");
            location.reload();
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
        if (show)
            tr[i].style.display = "";
        else
            tr[i].style.display = "none";
    }
}

function getQid(srno) {
    var id = document.getElementById("quotationid" + srno).value;
    document.getElementById("qid").value = id;

    $.ajax({
        url: "<?php echo base_url('admin/getQuotationReviews');?>",
        method: "POST",
        data: {
            id: id
        },
        async: true,
        dataType: 'json',
        success: function(data) {
            var html ="";
            if(data.length>0)
            {
             html +=
                '<table class="table table-bordered"><tr><th>No</th><th>Status</th><th>Review</th><th>Date</th><th>Review By</th></tr>';
            var i;
            for (i = 0; i < data.length; i++) {
                html += '<tr>';
                html += '<td>' + (i+1) + '</td>';
                html += '<td>' + data[i].reviewstatus + '</td>';
                html += '<td>' + data[i].review + '</td>';
                html += '<td>' + data[i].updatedon + '</td>';
                html += '<td>' + data[i].createdby + '</td>';
                html += '</tr>';
            }
            html += "</table>";
        }
            document.getElementById("reviews").innerHTML = html;
        }
    });


}

function getQ_id(srno) {
    var id = document.getElementById("quotation_id" + srno).value;
    document.getElementById("qid").value = id;

    $.ajax({
        url: "<?php echo base_url('admin/getQuotationReviews');?>",
        method: "POST",
        data: {
            id: id
        },
        async: true,
        dataType: 'json',
        success: function(data) {
            var html ="";
            if(data.length>0)
            {
             html +=
                '<table class="table table-bordered"><tr><th>No</th><th>Status</th><th>Review</th><th>Date</th><th>Review By</th></tr>';
            var i;
            for (i = 0; i < data.length; i++) {
                html += '<tr>';
                html += '<td>' + (i+1) + '</td>';
                html += '<td>' + data[i].reviewstatus + '</td>';
                html += '<td>' + data[i].review + '</td>';
                html += '<td>' + data[i].updatedon + '</td>';
                html += '<td>' + data[i].createdby + '</td>';
                html += '</tr>';
            }
            html += "</table>";
        }
            document.getElementById("reviews").innerHTML = html;
        }
    });
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
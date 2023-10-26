<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Brands [<?= sizeof($result); ?>]</h4>
            </div>             
        </div>
        <div class="col-md-12">
            <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
            <br />
            <?php 
                if ($this->session->flashdata('delete_msg')) {
                    ?>
                    <div class="alert alert-danger " align="center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $this->session->flashdata('delete_msg'); ?>
                    </div>
                <?php  } ?>
            <div class="table-responsive">
                <table class="table table-striped custom-table" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sr No</th>
                            <th>Brand</th>
                            <th>Base Rate</th>
                            <th>Producer</th>
                            <th>Parity Groups</th>
                            <th>Products Count</th>
                            <th>Report</th>
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
                            <td>
                                <input id="brandid<?= $count; ?>" type="hidden" value="<?= $row->id;?>" style="width:80px"/>
                                <input id="baserate<?= $count; ?>" type="number" name="baserate" value="<?= number_format(floatval($row->baserate), 2);?>" style="width:80px"/>
                                <button style="cursor:pointer;" onclick="updateRate(<?= $count; ?>)"><i class="fa fa-check text-success fa-1x"></i></button>
                            </td>
                            <td><?php echo $row->producername; ?></td>
                            <td>
                                <a class="btn btn-warning btn-block" href="<?= base_url("superadmin/paritygroups/" . $row->id . "/0"); ?>">Parity Groups : <?= $row->paritygroupcount; ?></a>
                            </td>
                            <td>
                                <a class="btn btn-success btn-block" href="<?= base_url('superadmin/brandproducts/' . $row->id); ?>">
                                    <?php echo $row->productcount; ?>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-block" href="<?= base_url('superadmin/brandproductreport/' . $row->id); ?>">
                                    Report
                                </a>
                            </td>
                        </tr>
                        <?php ++$count; } } ?>
                                        
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script >
    function updateRate(position){
        var brandid = document.getElementById("brandid" + position).value;
        var baserate = document.getElementById("baserate" + position).value;
        jQuery.ajax({
        url: "<?php echo base_url('superadmin/updatebaserate');?>",
        method : "POST",
        dataType: 'json',
        data: {baserate: baserate, brandid: brandid},
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

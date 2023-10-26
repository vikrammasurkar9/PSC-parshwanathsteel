<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Parity Groups of <?= $brand->name; ?> [<?= sizeof($result); ?>]</h4>
            </div>
             
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form action="<?php echo base_url('superadmin/saveParityGroup'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="brandid" value="<?php echo $brandid; ?>" />
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="name" id="name" value="<?php echo $id == 0 ? '' : $data->name; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <br />
                                        <button class="btn btn-primary">Save</button>
                                        <a href="<?= base_url('admin/paritygroups/0'); ?>" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                    </form>
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
                                    <th>Name</th>
                                    <th>Products Count</th>
                                    <th>Parity</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    foreach ($result as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->productscount; ?></td>                                    
                                    <td>
                                        <input id="pgid<?= $count; ?>" type="hidden" value="<?= $row->id; ?>" />
                                        <input id="parity<?= $count; ?>" type="number" step="any" style="width:80px;" value="<?= $row->parity; ?>" min=0 />
                                        <button style="cursor:pointer;" onclick="updateParity(<?= $count; ?>)"><i class="fa fa-check text-success fa-1x"></i></button>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('superadmin/paritygroups/' . $row->brandid . '/' . $row->id); ?>" class="btn btn btn-primary btn-rounded "><i class="fa fa-edit"></i> </a>
                                        <?php
                                            echo '<a href="' . base_url('superadmin/deleteParityGroup/' . $row->brandid . '/' . $row->id) . '" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i> </a>';
                                        ?>
                                    </td>
                                </tr>
                                <?php ++$count; }  ?>
                                                
                            </tbody>
                        </table>
                </div>
            </div>                       
        </div>
    </div>
</div>

<script>
function updateParity(position){
        var pgid = document.getElementById("pgid" + position).value;
        var parity = document.getElementById("parity" + position).value;
        
        if(parity != ""){
            jQuery.ajax({
                url: "<?php echo base_url('superadmin/updateparitygroupparity');?>",
                method : "POST",
                dataType: 'json',
                data: {parity: parity, pgid: pgid},
                success: function(data)
                {              
                    showSnackbar("Updated.");
                }        
            });
        }
        else{
            alert("Enter parity");
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
</script>

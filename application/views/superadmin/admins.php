<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Admins [<?= sizeof($result); ?>]</h4>
            </div>
             
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                    if ($this->session->flashdata('exist_msg')) {
                    ?>
                        <div class="alert alert-danger " align="center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('exist_msg'); ?>
                        </div>
                    <?php
                    }
                    
                    if($this->session->flashdata('success_msg')){ ?>
                    <div class="alert alert-success " align="center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('success_msg'); ?>
                        </div>
                    <?php } ?>
                <div class="card-box">
                    <form action="<?php echo base_url('superadmin/saveAdmin'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />                            
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="name" id="name" value="<?php echo $id == 0 ? '' : $data->name; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Position<span class="text-danger">*</span></label>
                                            <input class="form-control" name="position" id="position" list="positions" value="<?php echo $id == 0 ? '' : $data->position; ?>" type="text" required>

                                            <datalist id="positions">
                                    <?php foreach($positions as $position)
                                    {
                                        echo "<option value='".$position->position."'>";
                                    }?>
                                    </datalist>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Mobile Number <span class="text-danger">*</span></label>
                                            <input class="form-control" name="mobileno" id="mobileno" value="<?php echo $id == 0 ? '' : $data->mobileno; ?>" type="number" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>UserName <span class="text-danger">*</span></label>
                                            <input class="form-control" name="username" id="username" value="<?php echo $id == 0 ? '' : $data->username; ?>" type="text" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Password <span class="text-danger">*</span></label>
                                            <input class="form-control" name="password" id="password" value="<?php echo $id == 0 ? '' : $data->password; ?>" type="text" required>
                                    </div>
                                   
                                    <div class="col-sm-4">
                                        <label>WhatsAppKey </label>
                                            <input class="form-control" name="wakey" id="" value="<?php echo $id == 0 ? '' : $data->wakey; ?>" type="text" >
                                    </div>
                                    <div class="col-sm-4">
                                        <br /><br>
                                        <button class="btn btn-primary">Save</button>
                                        <a href="<?= base_url('admin/brands/0'); ?>" class="btn btn-danger">Cancel</a>
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
                                    <th>Position</th>
                                    <th>UserName</th>
                                    <th>Password</th>
                                    <th>Mobile Number</th>
                                    <th>Key</th>
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
                                    <td><?= $row->position;?></td>
                                    <td><?php echo $row->username; ?></td>
                                    <td><?php echo $row->password; ?></td>
                                    <td><?php echo $row->mobileno; ?></td>
                                    <td><?= $row->wakey;?></td>
                                    <td>
                                        <a href="<?php echo base_url('superadmin/admins/'.$row->id); ?>" class="btn btn btn-primary btn-rounded "><i class="fa fa-edit"></i> </a>
                                        <?php
                                            echo '<a href="' . base_url('superadmin/deleteAdmin/' . $row->id) . '" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i> </a>';
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

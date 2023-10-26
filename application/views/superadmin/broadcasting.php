<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">News & Updates [<?= sizeof($result); ?>]</h4>
            </div>
             
        </div>

        <div class="row">
            <div class="col-md-6">
                    <?php
                    if($this->session->flashdata('success_msg')){ ?>
                    <div class="alert alert-success " align="center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('success_msg'); ?>
                        </div>
                    <?php } ?>
                <div class="card-box">
                    <form action="<?php echo base_url('admin/saveBroadcasting'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Message <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            
                                                <textarea class="form-control" name="text" id="text" required ><?php echo $id == 0 ? '' : $data->broadcasting; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn">Send</button><br><br>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
                </div>
                <br />
                <?php 
                    if ($this->session->flashdata('delete_msg')) {
                        ?>
                        <div class="alert alert-danger " align="center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('delete_msg'); ?>
                        </div>
                    <?php  } ?>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Message</th>
                                    <th>Date/Time</th>
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
                                    <td><?php echo $row->message; ?></td>
                                    <td><?php echo date_format(date_create($row->date),"d/m/Y H:i:s"); ?></td>
                                    <td>
                                    <a href="<?php echo base_url('admin/deleteBroadcasting/'.$row->id); ?>" onclick="return returnConfirm()" class="btn btn btn-danger btn-rounded "><i class="fa fa-trash"></i> </a>
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

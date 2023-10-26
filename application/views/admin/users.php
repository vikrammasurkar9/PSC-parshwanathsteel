  <div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-3">
                <h4 class="page-title">Users [<?= sizeof($results); ?>]</h4>
            </div>
            <div class="col-sm-6 col-3">
                <a class="btn btn-primary" href="<?= base_url('admin/users?type=app'); ?>">Application Users</a>
                <a class="btn btn-warning" href="<?= base_url('admin/users?type=web'); ?>">Direct Client/Order Placed Users</a>
                <a class="btn btn-danger" href="<?= base_url('admin/users'); ?>">Show All User</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"  placeholder="Search..." autocomplete="off"> 
            </div>
            <br /><br /><br />
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table" id="myTable">
                        <thead>
							<tr>
                            	<th>No</th>
                                <th>Name</th>
                                <th>Profession</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Registered/Created On</th>
                                <th>Source</th>
                                <!-- <th>Password</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$count = 1;
								foreach ($results as $row) {
								    
							?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->profession; ?></td>
                                <td><?php echo $row->email; ?></td>
                                <td><?php echo $row->mobileno; ?></td>
                                <td><?php echo $row->createdon; ?></td>
                                <td><?php echo $row->source; ?></td>
                                <!-- <td><?php echo $row->password; ?></td> -->
                            </tr>
                            <?php ++$count; }?>
											
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

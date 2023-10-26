<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <h4 class="page-title">Professions</h4>
            </div>
            <div class="col-md-6">
                <input type="text" value="" id="search" name="search" onkeyup="mySearch()"
                    class="form-control pull-right" autocomplete="off" placeholder="Search...">
            </div>
        </div>
        <div class="card-box">
            <div class="row">
                <div class="col-lg-6" style="border-style: solid;border-color:#b2dcf4;padding:20px;">
                    <form action="<?php echo base_url('admin/saveprofession'); ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label>Profession<span class="text-danger"></span></label>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" name="name" value="<?php echo $id == 0 ? '' : $data->name; ?>" type="text">
                                </div>
                            </div>
                            

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6">
                    <br />
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>No</th>
                                    <th>Title</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($result as $row) {

                                    ?>
                                <tr>
                                    <td class="text-center" style="width:100px;">
                                    <a href="<?= base_url('admin/profession/'.$row->id);?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="<?php echo base_url('admin/deleteprofession/' . $row->id); ?>"
                                            style="color:red;" title="click to delete"
                                            onclick="return confirm('Sure to delete?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row->name; ?></td>

                                </tr>
                                <?php ++$count;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
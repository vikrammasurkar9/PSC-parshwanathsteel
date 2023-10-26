<?php
date_default_timezone_set("Asia/Kolkata");
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <a href="<?php echo base_url('admin/brands/0'); ?>">
                    <div class="dash-widget">
                        <span class="dash-widget-bg4"><i class="fa fa-bitbucket-square" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?=$brands;?></h3>
                            <span class="widget-title3">Brands <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url('admin/products/0'); ?>">
                    <div class="dash-widget">
                        <span class="dash-widget-bg4"><i class="fa fa-list" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?=$categories;?></h3>
                            <span class="widget-title3">Categories <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="dash-widget">
                    <span class="dash-widget-bg4"><i class="fa fa-list" aria-hidden="true"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3><?=$productweights;?></h3>
                        <span class="widget-title3">Products <i class="fa fa-check" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url('admin/requests'); ?>">
                    <div class="dash-widget">
                        <span class="dash-widget-bg2"><i class="fa fa-rupee" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?=$quotations;?></h3>
                            <span class="widget-title3">Total Estimates Requests <i class="fa fa-check"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="dash-widget">
                    <span class="dash-widget-bg2"><i class="fa fa-rupee" aria-hidden="true"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3><?=$givenquotations;?></h3>
                        <span class="widget-title3">Responded Quotations <i class="fa fa-check"
                                aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dash-widget">
                    <span class="dash-widget-bg2"><i class="fa fa-rupee" aria-hidden="true"></i></span>
                    <div class="dash-widget-info text-right">
                        <h3><?=$pendingquotations;?></h3>
                        <span class="widget-title3">Pending Quotations <i class="fa fa-check"
                                aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url('admin/orders'); ?>">
                    <div class="dash-widget">
                        <span class="dash-widget-bg2"><i class="fa fa-rupee" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?=$orders;?></h3>
                            <span class="widget-title3">Total Delivery Orders<i class="fa fa-check"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url('admin/users'); ?>">
                    <div class="dash-widget">
                        <span class="dash-widget-bg1"><i class="fa fa-users" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?=$users;?></h3>
                            <span class="widget-title3">Users <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo base_url('admin/broadcasting'); ?>">
                    <div class="dash-widget">
                        <span class="dash-widget-bg1"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?=$news;?></h3>
                            <span class="widget-title3">News & Updates <i class="fa fa-check"
                                    aria-hidden="true"></i></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- <a href="#" class="add-user-icon" data-toggle="modal" data-target="#add_chat_user"><i
                class="fa fa-plus"></i></a> -->
        <!-- <div id="add_chat_user" class="modal fade " role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Create Chat Group</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group m-b-30">
                            <input placeholder="Search to start a chat" class="form-control search-input" id="btn-input"
                                type="text">
                            <span class="input-group-append">
                                <button class="btn btn-primary">Search</button>
                            </span>
                        </div>
                        <div class="m-t-50 text-center">
                            <button class="btn btn-primary submit-btn">Create Group</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
</div>
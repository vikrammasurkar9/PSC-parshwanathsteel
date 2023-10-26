<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li> 
                    <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i>
                        <span>Dashboard</span></a>
                </li>
                <?php 
                    $name = $_COOKIE['name'];
                    if($name == "ChetanOswal" || $name =="Mahesh"|| $name =="PritamOswal"|| $name =="KashmiraOswal"){
                ?>
                <li> 
                    <a href="<?php echo base_url('admin/brands/0'); ?>"><i class="fa fa-bitbucket-square"></i>
                        <span>Brands</span></a>
                </li>
                <li>
				    <a href="<?php echo base_url('admin/categories/0'); ?>"><i class="fa fa-book"></i>
				        <span>Product Categories</span>
                    </a>
				</li> 
                 <li> 
                    <a href="<?php echo base_url('admin/products/0'); ?>"><i class="fa fa-list"></i>
                        <span>Products</span></a>
                </li>
                <?php } ?>
                <!--<li> 
                    <a href="<?php echo base_url('admin/productweights/0/0'); ?>"><i class="fa fa-list"></i>
                        <span>Varieties</span></a>
                </li>-->
                <!-- <li> 
                    <a href="<?php echo base_url('admin/followupquotations'); ?>"><i class="fa fa-pencil"></i>
                        <span>Follow-Up</span></a>
                </li> -->
                <!-- <li> 
                    <a href="<?php echo base_url('admin/enquiries'); ?>"><i class="fa fa-rupee"></i>
                        <span>Enquiry</span></a>
                </li> -->
                <!-- <li> 
                    <a href="<?php echo base_url('admin/requests'); ?>"><i class="fa fa-rupee"></i>
                        <span>Leads</span></a>
                </li> -->
                <li> 
                    <a href="<?php echo base_url('admin/requests'); ?>"><i class="fa fa-rupee"></i>
                        <span>Leads</span></a>
                </li>
                <li> 
                    <a href="<?php echo base_url('admin/quotations'); ?>"><i class="fa fa-rupee"></i>
                        <span>Quotations</span></a>
                </li>
                <!-- <li> 
                    <a href="<?php echo base_url('admin/dquotations'); ?>"><i class="fa fa-rupee"></i>
                        <span>Estimates</span></a>
                </li> -->
                <li> 
                    <a href="<?php echo base_url('admin/orders?status=Open'); ?>"><i class="fa fa-rupee"></i>
                        <span>Delivery Orders</span></a>
                </li>
                 <li> 
                    <a href="<?php echo base_url('admin/allrequests'); ?>"><i class="fa fa-rupee"></i>
                        <span>All Leads</span></a>
                </li>
                <li>
				    <a href="<?php echo base_url('admin/contacts/0'); ?>"><i class="fa fa-users"></i>
				        <span>Contacts</span>
                    </a>
				</li> 
                <li>
                    <a href="<?= base_url(); ?>admin/profession/0"><i class="fa fa-edit"></i>
                        <span>Professions</span></a>
                </li>
                <?php 
                    $name = $_COOKIE['name'];
                    if($name == "ChetanOswal" || $name =="Mahesh"|| $name =="PritamOswal"|| $name =="KashmiraOswal"){
                ?>

                <li>
                    <a href="<?= base_url(); ?>admin/enquirysource/0"><i class="fa fa-edit"></i>
                        <span>Enquiry Sources</span></a>
                </li>

                <!-- <li> 
                    <a href="<?php echo base_url('admin/users'); ?>"><i class="fa fa-user"></i>
                        <span>Users</span></a>
                </li> -->
                <!-- <li>
				    <a href="<?php echo base_url('admin/archives/0'); ?>"><i class="fa fa-cloud-download"></i>
				        <span>Archives</span>
                    </a>
				</li>  -->
				<!-- <li>
                    <a href="<?= base_url(); ?>admin/slider/0"><i class="fa fa-picture-o"></i>
                        <span>App Slider</span></a>
                </li>
                <li>
				    <a href="<?php echo base_url('admin/broadcasting/0'); ?>"><i class="fa fa-paper-plane"></i>
				        <span>News & Updates</span>
                    </a>
				</li>  -->
                
                
                
                
                
                
                <?php } ?>
                <!-- <li class="submenu">
                    <a href="#"><i class="fa fa-file-excel-o"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a  href="<?= base_url('reports/productwisebrands');?>">Productwise Brands</a></li>
                        <li><a href="<?= base_url('reports');?>">All Reports</a></li>
                    </ul>
                </li> -->
                <li>
				    <a href="<?php echo base_url('reports'); ?>"><i class="fa fa-file-excel-o"></i>
				        <span>Reports</span>
                    </a>
				</li>
				<li>
				<a href="<?php echo base_url('admin/logout'); ?>"><i class="fa fa-sign-out"></i>
				<span>Logout</span></a>
				</li>
               
            </ul>
        </div>
    </div>
</div>




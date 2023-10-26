<?php
date_default_timezone_set("Asia/Kolkata");
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">	
            <div class="col-md-4">
				<a href="<?php echo base_url('superadmin/brands'); ?>">
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
				<a >
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
				<a>
					<div class="dash-widget">
						<span class="dash-widget-bg2"><i class="fa fa-rupee" aria-hidden="true"></i></span>
						<div class="dash-widget-info text-right">
							<h3><?=$quotations;?></h3>
							<span class="widget-title3">Total Quotation Requests <i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</div>
				</a>
			</div>
            <div class="col-md-4">
				<a >
					<div class="dash-widget">
						<span class="dash-widget-bg2"><i class="fa fa-rupee" aria-hidden="true"></i></span>
						<div class="dash-widget-info text-right">
							<h3><?=$givenquotations;?></h3>
							<span class="widget-title3">Responded Quotations <i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</div>
				</a>
			</div>
            <div class="col-md-4">
				<a>
					<div class="dash-widget">
						<span class="dash-widget-bg2"><i class="fa fa-rupee" aria-hidden="true"></i></span>
						<div class="dash-widget-info text-right">
							<h3><?=$pendingquotations;?></h3>
							<span class="widget-title3">Pending Quotations <i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a>
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
				<a href="<?php echo base_url('superadmin/broadcasting'); ?>">
					<div class="dash-widget">
						<span class="dash-widget-bg1"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
						<div class="dash-widget-info text-right">
							<h3><?=$news;?></h3>
							<span class="widget-title3">News & Updates <i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</div>
				</a>
			</div>
        </div>
    </div>
</div>

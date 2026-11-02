					<div class="col-xs-12 col-sm-12 col-md-12" style="background: #fff; padding: 20px 50px;">
						<div class="col-xs-12 col-sm-6 col-md-4">
							<span style="font-size: 25px;font-weight: bold;">Logo</span>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-8">
							<form action="<?php echo site_url('app_login/authenticate'); ?>" method="post">
								<div class="row">
									<div class="col-xs-12 col-sm-4 col-md-4">
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<input type="text" class="form-control" placeholder="Username"  autocomplete="off" 
				                                name="login_name" id="login_name" required = "required" tabindex="1" />
												<i class="ace-icon fa fa-user" style="position: absolute;right: 7px;top: 10px;color: #aaa;"></i>
											</span>
										</label>
										<a href="" tabindex="4">Forgotten Account?</a>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<label class="block clearfix">
											<span class="block input-icon input-icon-right">
												<input type="password" class="form-control" placeholder="password" 
	                                             name="password" id="password" autocomplete="off" required = "required" tabindex="2" />
												<i class="ace-icon fa fa-lock" style="position: absolute;right: 7px;top: 10px;color: #aaa;"></i>
											</span>
										</label>
										<a href="" tabindex="4">Forgotten Password?</a>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4">
										<div class="clearfix">													
											<button type="submit" class="form-control pull-right btn btn-sm btn-primary" tabindex="3" >
												<i class="ace-icon fa fa-key"></i>
												<span class="bigger-110">Login</span>
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
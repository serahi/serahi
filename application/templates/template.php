<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/960/reset_rtl.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/960/text_rtl.css" />
<!--		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/960/960_rtl.css" /> -->
		{block name=css}{/block}
		<title>{block name=title}{/block}</title>
		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/site.css" />
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-1.6.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/my_script.js"></script>
		{block name=script}{/block}
		
	</head>	
	<body>
		<div class="wrapper">  
			<div class="top">
				<span class="bblock">
					<span class="block">
						<span class="uinfo">
							<?php if($this->session->userdata('is_logged_in') == TRUE ): ?>
								<span>
									<?php echo $this->session->userdata('first_name')." " . $this->session->userdata('last_name'); ?>
								</span>
								<span>
									<?php echo anchor(base_url().'user/login/logout', 'خروج' ); ?>
								</span>
							<?php endif ?>
						</span>
					</span>
					<span class="block">
						<?php if( $this->session->userdata('is_logged_in') != TRUE ): ?>
						<?php echo anchor(base_url().'user/login', 'ورود'); ?>
						<?php echo anchor(base_url().'user/login/sign_up', 'ثبت نام'); ?>
						<?php echo anchor(base_url().'user/login/seller_sign_up', 'ثبت نام فروشندگان'); ?>
						<?php endif ?>
					</span>
					<span class="block center" id="serahi">
						<a href="<?php echo base_url().'home/'?>">سه راهــــــی</a>
					</span>
					
				</span>
			</div>  
			<div class="clear">
			</div>
		{block name=main_content}{/block}
		</div>
	</body>
</html>
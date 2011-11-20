<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/960/reset_rtl.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/960/text_rtl.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/validationEngine.jquery.css" />	 
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/style/site.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/confirm/jquery.confirm/jquery.confirm.css" />
		
		{block name=css}{/block}
		
		<title>{block name=title}{/block}</title>
		
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-1.6.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.validationEngine.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.validationEngine-en.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/my_script.js"></script>
		<script src="<?php echo base_url();?>assets/confirm/jquery.confirm/jquery.confirm.js"></script>
		<script src="<?php echo base_url();?>assets/confirm/js/script.js"></script>
		
		{block name=script}{/block}
	</head>
	<body>
		<div class="wrapper">
			<div class="top">
				<span class="bblock">
				<?php if($this->session->userdata('is_logged_in') == TRUE ):?>
					<span class="block">
						<span class="uinfo">
							<span>
								<?php echo $this->session->userdata('first_name') . " " . $this->session->userdata('last_name');?>
							</span>
							<span>
							<?php if ($this->session->userdata('user_type') == 'admin'):?>
								<a href = "<?php echo base_url() . 'admin/';?>">پنل مدیریت</a>
								<a href = "<?php echo base_url() . 'admin/userlist';?>">مدیریت کاربران</a>
							<?php elseif ($this->session->userdata('user_type') == 'Seller'):?>
								<a href = "<?php echo base_url() . 'seller/';?>">پنل فروشنده</a>
							<?php endif?>
							</span>
							<span>
								<?php echo anchor(base_url() . 'user/logout', 'خروج');?>
							</span>
						</span>
					</span>
				<?php endif?>
					<span class="block">
					<?php if( $this->session->userdata('is_logged_in') != TRUE ):?>
						<a href = "<?php echo base_url();?>user/login">ورود</a>
						<a href = "<?php echo base_url();?>user/signup">ثبت نام</a>
						<a href = "<?php echo base_url();?>user/seller_signup">ثبت نام فروشندگان</a>
					<?php endif?>
					</span>
					<span class="block center" id="serahi">
						<a href="<?php echo base_url();?>home/" class = "bconfirm">سه راهــــــی</a>
					</span>
				</span>
			</div>
			<div class="clear"></div>
			{block name=main_content}{/block}
		</div>
	</body>
</html>
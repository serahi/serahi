<html>
	<head>
		<title>test form</title>
	</head>
	<body>
		<form id = "test_form" method = "post" action = "<?php echo base_url() . "first/form/send";?>">
			username: <input name = "username">
			<input type = "submit" value = "submit">
		</form>
	</body>
</html>
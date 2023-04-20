<!DOCTYPE html>
<html>
<?php
 require_once ($_SERVER['DOCUMENT_ROOT'] . '/WC_2_SYS_select_date/WC_2_config/WC_2_config_first_include.php');
 ?>
<head>
	<title>Load file EXEL to Oracle</title>
	<script>
	function checkFile() {
		const fileInput = document.querySelector('input[type="file"]');
		const submitBtn = document.querySelector('input[type="submit"]');
		if (fileInput.value) {
			submitBtn.disabled = false;
		} else {
			submitBtn.disabled = true;
		}
	}
	</script>
</head>
<body>
	<form action="<?php echo "$Menu_3_load_xls_to_base_1";?>" method="POST" enctype="multipart/form-data" target="_self">
		<input type="file" name="Menu3_load_file" onchange="checkFile()">
		<input type="submit" value="Upload" disabled>
	</form>
</body>
</html>

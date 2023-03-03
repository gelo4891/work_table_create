<!DOCTYPE html>
<html>
<head>
	<title>Кнопки</title>
	<link rel="stylesheet" href="WC_1_css/WC_1_first.css">
</head>
<body class="WTK_index_body">
	<!-- Місце для відображення кнопок -->
	<div class="WTK_index_div"><a class="buttons-container"></a></div>

	<!-- Підключення JavaScript-файлів -->
	<script src="WC_1_js/WC_1_class_Create.js"></script>
	<script src="WC_1_config/WC_1_button.json"></script>
	<script>
		const buttonCreator_text = new WC_1_ButtonCreator("WC_1_config/WC_1_button.json", "buttons-container");
		buttonCreator_text.WC_1_createButtons_text();


	</script>
</body>
</html>

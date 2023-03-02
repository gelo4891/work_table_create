<!DOCTYPE html>
<html>
<head>
	<title>Кнопки</title>
	<link rel="stylesheet" href="WTC_css/WTC_first.css">
</head>
<body>
	<!-- Місце для відображення кнопок -->
	<div class="WTK_index_div"><a class="buttons-container"></a></div>

	<!-- Підключення JavaScript-файлів -->
	<script src="WTC_js/class_Create.js"></script>
	<script src="WTC_config/WTC_button.json"></script>
	<script>
		const buttonCreator = new ButtonCreator("WTC_config/WTC_button.json", "buttons-container");
		buttonCreator.createButtons();
	</script>
</body>
</html>

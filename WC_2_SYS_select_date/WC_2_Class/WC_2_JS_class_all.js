class WC_2_JS_classAll {


function loadContent() {
	$(document).ready(function() {
		// Обробник події при кліку на елемент меню
		$(".menu-item").on("click", function(event) {
			event.preventDefault();
			// Отримуємо адресу сторінки, яку потрібно відобразити у правому div-елементі
			var pageUrl = $(this).attr("href");
			// Виконуємо AJAX-запит і вставляємо відповідь у правий div-елемент
			$(".content").load(pageUrl);
		});
	});
}


}
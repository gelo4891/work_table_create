-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 22 2023 г., 13:02
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `base_o_zvit`
--

-- --------------------------------------------------------

--
-- Структура таблицы `boz_am_submenu`
--

CREATE TABLE `boz_am_submenu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `access_level` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `boz_am_submenu`
--

INSERT INTO `boz_am_submenu` (`id`, `menu_id`, `title`, `link`, `order`, `access_level`) VALUES
(1, 1, 'test 1', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_1_test.php', 0, 0),
(2, 2, 'test 2', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_2_test.php', 0, 0),
(3, 1, 'test 11111111111111111', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_3_test.php', 0, 0),
(4, 2, 'test2222222222222', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_3_test.php', 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  ADD CONSTRAINT `boz_am_submenu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `boz_am_menu` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

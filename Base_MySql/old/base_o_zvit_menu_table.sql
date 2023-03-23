-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 17 2023 г., 12:04
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
-- Структура таблицы `boz_am_menu`
--

CREATE TABLE `boz_am_menu` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `access_level` int(11) NOT NULL DEFAULT 0,
  `has_submenu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `boz_am_menu`
--

INSERT INTO `boz_am_menu` (`id`, `title`, `link`, `order`, `access_level`, `has_submenu`) VALUES
(1, 'Додавання пунктів меню', 'WC_2_SYS_select_date\\WC_2_php\\WC_2_php_menu\\Menu_1_admin\\Menu_1_test.php', 0, 0, 0);

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

-- --------------------------------------------------------

--
-- Структура таблицы `boz_perelik_table`
--

CREATE TABLE `boz_perelik_table` (
  `PT_number` varchar(255) NOT NULL,
  `PT_Name_Table` varchar(255) NOT NULL,
  `PT_Opus` varchar(255) NOT NULL,
  `PT_Key_Param` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `boz_perelik_table`
--

INSERT INTO `boz_perelik_table` (`PT_number`, `PT_Name_Table`, `PT_Opus`, `PT_Key_Param`) VALUES
('1', '1', '2', '3');

-- --------------------------------------------------------

--
-- Структура таблицы `boz_user`
--

CREATE TABLE `boz_user` (
  `BOZ_user_num` int(11) DEFAULT NULL,
  `BOZ_user_login` varchar(255) DEFAULT NULL,
  `BOZ_user_pass` varchar(255) DEFAULT NULL,
  `boz_riven_dostyp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `boz_user`
--

INSERT INTO `boz_user` (`BOZ_user_num`, `BOZ_user_login`, `BOZ_user_pass`, `boz_riven_dostyp`) VALUES
(NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `boz_am_menu`
--
ALTER TABLE `boz_am_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Индексы таблицы `boz_user`
--
ALTER TABLE `boz_user`
  ADD UNIQUE KEY `BOZ_user_num_index` (`BOZ_user_num`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `boz_am_menu`
--
ALTER TABLE `boz_am_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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

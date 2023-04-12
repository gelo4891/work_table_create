-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Квт 12 2023 р., 08:40
-- Версія сервера: 10.4.27-MariaDB
-- Версія PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `base_o_zvit`
--

-- --------------------------------------------------------

--
-- Структура таблиці `boz_am_menu`
--

CREATE TABLE `boz_am_menu` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `BOZ_AccessLevel` int(11) NOT NULL DEFAULT 0,
  `has_submenu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `boz_am_menu`
--

INSERT INTO `boz_am_menu` (`id`, `title`, `link`, `order`, `BOZ_AccessLevel`, `has_submenu`) VALUES
(1, '1 пункт меню', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_3_load_xls_to_base/Menu_3_test.php', 0, 1, 1),
(2, '2 пункт меню', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_3_test.php', 0, 2, 1),
(3, '3 пункт меню', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_2_test.php', 0, 0, 0),
(4, '4-Завантаження XLS в Oracle', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_3_load_xls_to_base/Menu3_load_start.php', 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблиці `boz_am_parametrs`
--

CREATE TABLE `boz_am_parametrs` (
  `boz_am_param` varchar(255) NOT NULL,
  `boz_am_znach` varchar(2000) NOT NULL,
  `boz_am_dont` varchar(255) NOT NULL,
  `boz_am_Server_root` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `boz_am_parametrs`
--

INSERT INTO `boz_am_parametrs` (`boz_am_param`, `boz_am_znach`, `boz_am_dont`, `boz_am_Server_root`) VALUES
('$dell720_ODBC', 'ODBS_dell720', 'dell720', '0'),
('$dell720_test_c_pass', 'test_c', 'dell720', '0'),
('$dell720_test_c_user', 'test_c', 'dell720', '0'),
('$ftp_password', 'FZ_Oleg_User', 'Ftp_stasik', '0'),
('$ftp_port', '21', 'Ftp_stasik', '0'),
('$ftp_server', '10.6.128.63', 'Ftp_stasik', '0'),
('$ftp_username', 'FZ_Oleg_User', 'Ftp_stasik', '0'),
('$Imporn_XLS', '\'PhpOffice\\PhpSpreadsheet\\IOFactory\'', 'Bibl', '0'),
('$Menu_3_load_xls_to_base_1', '\'/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_3_load_xls_to_base/Menu3_load_1.php\'', 'Conf_dir', '0'),
('$Menu_3_load_xls_to_base_2', '\'/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_3_load_xls_to_base/Menu3_load_2.php\'', 'Conf_dir', '0'),
('$WC_2_button_json ', '/WC_2_SYS_select_date/WC_2_config/WC_2_button.json', 'Conf_dir', '1'),
('$WC_2_class_all', '/WC_2_SYS_select_date/WC_2_Class/WC_2_class_all.php', 'Conf_dir', '1'),
('$WC_2_class_auth', '/WC_2_SYS_select_date/WC_2_Class/WC_2_class_auth.php', 'Conf_dir', '1'),
('$WC_2_class_load_XLS', '/WC_2_SYS_select_date/WC_2_Class/WC_2_class_load_XLS.php', 'Conf_dir', '1'),
('$WC_2_config ', '/WC_2_SYS_select_date/WC_2_config/WC_2_config.php', 'Conf_dir', '1'),
('$WC_2_config_table_colum', 'array(\'BOZ_user_login\', \'BOZ_user_pass\',\'boz_riven_dostyp\')', '0', ''),
('$WC_2_CSS_all', '/WC_2_SYS_select_date/WC_2_css/WC_2_file_start.css', 'CSS Conf_dir', '0'),
('$WC_2_CSS_menu_create', '/WC_2_SYS_select_date/WC_2_css/WC_2_CSS_menu_create.css', 'CSS Conf_dir', '0'),
('$WC_2_menu_create', '../WC_2_php/WC_2_php_menu/WC_2_menu_create.php', '0', ''),
('$WC_2_menu_CreateInFtame', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/WC_2_menu_CreateInFtame.php', 'Conf_dir', '1'),
('$WC_2_menu_php', '/WC_2_SYS_select_date/WC_2_config/WC_2_menu.php', 'Conf_dir', '1'),
('$WC_2_php_START_AUTH_header', '\"../WC_2_php/WC_2_php_menu/WC_2_menu_create.php\"', '0', '0'),
('$WC_2_start', '/WC_2_SYS_select_date/WC_2_start.php', 'Conf_dir', '1'),
('$WC_2_test', '\'/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_1_test.php\'', 'Conf_dir', '0'),
('Bibl_composer', 'c:/xampp/vendor/autoload.php', 'Bibl', '0'),
('SQL_create_menu', 'SELECT m.id, m.title, m.link, m.order, m.BOZ_AccessLevel, m.has_submenu, s.id as menu_id, s.title as sub_title, s.link as sub_link, s.order as sub_order, s.access_level as sub_access_level\n        FROM boz_am_menu m \n        LEFT JOIN boz_am_submenu s ON m.id = s.menu_id\n        WHERE :riven_dostypu <= m.BOZ_AccessLevel  AND (s.access_level IS NULL OR :riven_dostypu <= s.access_level )\n        ORDER BY m.order, m.id, s.order, s.id', 'SQL', '0');

-- --------------------------------------------------------

--
-- Структура таблиці `boz_am_submenu`
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
-- Дамп даних таблиці `boz_am_submenu`
--

INSERT INTO `boz_am_submenu` (`id`, `menu_id`, `title`, `link`, `order`, `access_level`) VALUES
(1, 1, 'test 1', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_1_test.php', 0, 1),
(2, 2, 'test 2', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_2_test.php', 0, 0),
(3, 1, 'test 11111111111111111', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_3_test.php', 0, 2),
(4, 2, 'test2222222222222', '/WC_2_SYS_select_date/WC_2_php/WC_2_php_menu/Menu_1_admin/Menu_3_test.php', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `boz_perelik_table`
--

CREATE TABLE `boz_perelik_table` (
  `PT_number` varchar(255) NOT NULL,
  `PT_Name_Table` varchar(255) NOT NULL,
  `PT_Opus` varchar(255) NOT NULL,
  `PT_Key_Param` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `boz_perelik_table`
--

INSERT INTO `boz_perelik_table` (`PT_number`, `PT_Name_Table`, `PT_Opus`, `PT_Key_Param`) VALUES
('1', '1', '2', '3');

-- --------------------------------------------------------

--
-- Структура таблиці `boz_user`
--

CREATE TABLE `boz_user` (
  `BOZ_user_num` int(11) NOT NULL,
  `BOZ_user_login` varchar(255) DEFAULT NULL,
  `BOZ_user_pass` varchar(255) DEFAULT NULL,
  `boz_riven_dostyp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `boz_user`
--

INSERT INTO `boz_user` (`BOZ_user_num`, `BOZ_user_login`, `BOZ_user_pass`, `boz_riven_dostyp`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0),
(2, '1', '21232f297a57a5a743894a0e4a801fc3', 1),
(3, '2', '21232f297a57a5a743894a0e4a801fc3', 2);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `boz_am_menu`
--
ALTER TABLE `boz_am_menu`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `boz_am_parametrs`
--
ALTER TABLE `boz_am_parametrs`
  ADD UNIQUE KEY `Boz_am_param` (`boz_am_param`);

--
-- Індекси таблиці `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Індекси таблиці `boz_user`
--
ALTER TABLE `boz_user`
  ADD UNIQUE KEY `BOZ_user_num_index` (`BOZ_user_num`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `boz_am_menu`
--
ALTER TABLE `boz_am_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `boz_am_submenu`
--
ALTER TABLE `boz_am_submenu`
  ADD CONSTRAINT `boz_am_submenu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `boz_am_menu` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

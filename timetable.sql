SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(10) unsigned NOT NULL,
  `lesson_day_id` int(10) unsigned DEFAULT NULL,
  `lesson_number` int(10) unsigned DEFAULT NULL,
  `school_class_id` int(10) unsigned NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `school_room_id` int(10) unsigned DEFAULT NULL,
  `teacher_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `lessons`
--

INSERT INTO `lessons` (`id`, `lesson_day_id`, `lesson_number`, `school_class_id`, `subject_id`, `school_room_id`, `teacher_id`) VALUES
(1, 1, NULL, 1, 1, 1, 1),
(2, 1, NULL, 1, 2, 1, NULL),
(3, 1, NULL, 1, 3, 1, 7),
(4, 1, NULL, 1, 3, 1, 7),
(5, 1, NULL, 1, 4, 1, 8),
(6, 1, NULL, 1, 5, 1, 9),
(7, 1, NULL, 2, 1, 2, 1),
(8, 1, NULL, 2, 2, 2, 3),
(9, 1, NULL, 2, 3, 2, 7),
(10, 1, NULL, 2, 3, 2, 7),
(11, 1, NULL, 2, 4, 2, 8),
(12, 1, NULL, 2, 5, 2, 9),
(13, 1, NULL, 3, 1, 3, 2),
(14, 1, NULL, 3, 1, 3, 2),
(15, 1, NULL, 3, 2, 3, 4),
(16, 1, NULL, 3, 3, 3, 6),
(17, 1, NULL, 3, 3, 3, 6),
(28, 1, NULL, 4, 8, 4, 14),
(29, 1, NULL, 4, 8, 4, 14),
(30, 1, NULL, 4, 7, 4, 12),
(31, 1, NULL, 4, 6, 4, 10),
(32, 1, NULL, 4, 1, 4, 2),
(33, 1, NULL, 5, 8, 5, 15),
(34, 1, NULL, 5, 8, 5, 15),
(35, 1, NULL, 5, 7, 5, 13),
(36, 1, NULL, 5, 6, 5, 11),
(37, 1, NULL, 5, 2, 5, 4),
(38, 2, NULL, 1, 8, 1, 15),
(39, 2, NULL, 1, 8, 1, 15),
(40, 2, NULL, 1, 7, 1, 13),
(41, 2, NULL, 1, 6, 1, 11),
(42, 2, NULL, 1, 2, 1, 4),
(43, 2, NULL, 2, 1, 2, 1),
(44, 2, NULL, 2, 2, 2, 3),
(45, 2, NULL, 2, 3, 2, 7),
(46, 2, NULL, 2, 3, 2, 7),
(47, 2, NULL, 2, 4, 2, 8),
(48, 2, NULL, 2, 5, 2, 9),
(49, NULL, NULL, 4, 1, NULL, 1),
(50, NULL, NULL, 4, 2, NULL, 3),
(51, NULL, NULL, 4, 3, NULL, 7),
(52, NULL, NULL, 4, 3, NULL, 7),
(53, NULL, NULL, 4, 4, NULL, 8),
(54, NULL, NULL, 4, 5, NULL, 9),
(55, NULL, NULL, 5, 1, NULL, 2),
(56, NULL, NULL, 5, 1, NULL, 2),
(57, NULL, NULL, 5, 2, NULL, 4),
(58, NULL, NULL, 5, 3, NULL, 6),
(59, NULL, NULL, 5, 3, NULL, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `lesson_days`
--

CREATE TABLE IF NOT EXISTS `lesson_days` (
  `id` int(10) unsigned NOT NULL,
  `lesson_week_id` int(10) unsigned NOT NULL,
  `wday` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lesson_max_count` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `lesson_days`
--

INSERT INTO `lesson_days` (`id`, `lesson_week_id`, `wday`, `name`, `lesson_max_count`) VALUES
(1, 1, 1, 'Понеділок', 8),
(2, 1, 2, 'Вівторок', 8),
(3, 1, 3, 'Середа', 8),
(4, 1, 4, 'Четвер', 8),
(5, 1, 5, 'П''ятниця', 6),
(6, 1, 6, 'Субота', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `lesson_weeks`
--

CREATE TABLE IF NOT EXISTS `lesson_weeks` (
  `id` int(10) unsigned NOT NULL,
  `number` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `lesson_weeks`
--

INSERT INTO `lesson_weeks` (`id`, `number`, `name`) VALUES
(1, 1, 'Перший тиждень');

-- --------------------------------------------------------

--
-- Структура таблицы `school_classses`
--

CREATE TABLE IF NOT EXISTS `school_classses` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `school_classses`
--

INSERT INTO `school_classses` (`id`, `name`) VALUES
(1, '6-А'),
(2, '6-Б'),
(3, '6-В'),
(4, '7-А'),
(5, '7-Б');

-- --------------------------------------------------------

--
-- Структура таблицы `school_rooms`
--

CREATE TABLE IF NOT EXISTS `school_rooms` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `school_rooms`
--

INSERT INTO `school_rooms` (`id`, `name`) VALUES
(1, '101'),
(2, '102'),
(3, '103'),
(4, '104'),
(5, '105'),
(6, '201'),
(7, '202'),
(8, '203'),
(9, '204'),
(10, '205'),
(11, '301'),
(12, '302'),
(13, '303'),
(14, '304'),
(15, '305');

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Геометрія'),
(2, 'Фізика'),
(3, 'Музика'),
(4, 'Фіз.культ.'),
(5, 'Укр. літ.'),
(6, 'Заруб.літ.'),
(7, 'Географія'),
(8, 'Праця');

-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(10) unsigned NOT NULL,
  `name_first` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_last` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_middle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `teachers`
--

INSERT INTO `teachers` (`id`, `name_first`, `name_last`, `name_middle`) VALUES
(1, 'Микола', 'Лобачевський', 'Іванович'),
(2, '', 'Евклід', ''),
(3, 'Альберт', 'Ейнштейн', ''),
(4, 'Пітер', 'Хіґс', ''),
(5, 'Стівен', 'Хокінг', ''),
(6, 'Роберт', 'Фріпп', ''),
(7, 'Адріан', 'Бєлью', ''),
(8, 'Алессандро', 'Дзанарді', ''),
(9, 'Олександр', 'Подерв''янський', ''),
(10, 'Толкієн', 'Крістофер', ''),
(11, 'Станислав', 'Лем', ''),
(12, 'Олексій', 'Коровін', ''),
(13, 'Жак-Ів', 'Кусто', ''),
(14, 'Адам', 'Севідж', ''),
(15, 'Джеймі', 'Гайнеман', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `lesson_day_id` (`lesson_day_id`,`lesson_number`,`teacher_id`), ADD UNIQUE KEY `lesson_day_id_2` (`lesson_day_id`,`lesson_number`,`school_class_id`), ADD KEY `fc_l_to_sc_idx` (`school_class_id`), ADD KEY `fc_l_to_sr_idx` (`school_room_id`), ADD KEY `fc_l_to_ld_idx` (`lesson_day_id`), ADD KEY `fc_l_to_s_idx` (`subject_id`), ADD KEY `fc_l_to_t_idx` (`teacher_id`);

--
-- Индексы таблицы `lesson_days`
--
ALTER TABLE `lesson_days`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `wday_in_week_uniq` (`lesson_week_id`,`wday`), ADD KEY `fc_ld_to_lw_idx` (`lesson_week_id`);

--
-- Индексы таблицы `lesson_weeks`
--
ALTER TABLE `lesson_weeks`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `week_number_uniq` (`number`);

--
-- Индексы таблицы `school_classses`
--
ALTER TABLE `school_classses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `school_rooms`
--
ALTER TABLE `school_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT для таблицы `lesson_days`
--
ALTER TABLE `lesson_days`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `lesson_weeks`
--
ALTER TABLE `lesson_weeks`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `school_classses`
--
ALTER TABLE `school_classses`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `school_rooms`
--
ALTER TABLE `school_rooms`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `lessons`
--
ALTER TABLE `lessons`
ADD CONSTRAINT `fc_l_to_ld` FOREIGN KEY (`lesson_day_id`) REFERENCES `lesson_days` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fc_l_to_s` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fc_l_to_sc` FOREIGN KEY (`school_class_id`) REFERENCES `school_classses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fc_l_to_sr` FOREIGN KEY (`school_room_id`) REFERENCES `school_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fc_l_to_t` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `lesson_days`
--
ALTER TABLE `lesson_days`
ADD CONSTRAINT `fc_ld_to_lw` FOREIGN KEY (`lesson_week_id`) REFERENCES `lesson_weeks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
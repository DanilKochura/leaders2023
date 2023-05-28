CREATE TABLE `class` (
                         `id` int UNSIGNED NOT NULL,
                         `sdat_s` date NOT NULL COMMENT 'точка съема (Дата записи данных)',
                         `sak` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'АК',
                         `flt_num` int NOT NULL COMMENT 'Рейс',
                         `dd` date NOT NULL COMMENT 'Дата полета ',
                         `seg_num` smallint NOT NULL COMMENT 'Номер плеча ',
                         `sorg` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Аэропорт вылета ',
                         `sdst` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Аэропорт прилета ',
                         `sscl1` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Салоны',
                         `seg_class_code` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Класс бронирования',
                         `nbcl` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Позиция класса в нестинге',
                         `fclcld` tinyint(1) NOT NULL COMMENT 'Признак закрытия класса к продаже (0– открыт,1 – закрыт)',
                         `pass_bk` int UNSIGNED NOT NULL COMMENT 'Кол-во забронированных пассажиров',
                         `sa` int NOT NULL COMMENT 'Уровень авторизации по салонам (выставлено к продаже с учетом перебронирования)',
                         `au` int NOT NULL COMMENT 'Доступные кресла по салонам ',
                         `pass_dep` int NOT NULL COMMENT 'Кол-во пролетевших пассажиров ',
                         `ns` int NOT NULL COMMENT 'No-Show',
                         `dtd` int NOT NULL COMMENT 'Кол-во дней до вылета '
);

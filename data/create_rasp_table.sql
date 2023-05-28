CREATE TABLE `rasp` (
    `id` int(11) NOT NULL,
    `ak` varchar(25) NOT NULL,
    `flt_numsh` int(11) NOT NULL,
    `leg_org` varchar(6) NOT NULL,
    `leg_dest` varchar(6) NOT NULL,
    `effv_date` date NOT NULL,
    `disc_date` date NOT NULL,
    `freq` varchar(64) NOT NULL,
    `num_legs` int(11) NOT NULL,
    `capture_date1` date NOT NULL,
    `dep_time1` varchar(64) NOT NULL,
    `arr_time1` varchar(64) NOT NULL,
    `equip1` varchar(16) NOT NULL
    );

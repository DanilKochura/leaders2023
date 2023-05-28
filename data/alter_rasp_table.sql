ALTER TABLE `rasp`
    ADD PRIMARY KEY (`id`),
    ADD KEY `flt_numsh` (`flt_numsh`,`leg_org`,`leg_dest`);

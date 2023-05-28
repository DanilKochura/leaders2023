ALTER TABLE `class`
    ADD PRIMARY KEY (`id`),
  ADD KEY `sdat_s` (`sdat_s`),
  ADD KEY `flt_num` (`flt_num`),
  ADD KEY `dd` (`dd`),
  ADD KEY `sdat_s_2` (`flt_num`,`dd`,`sorg`,`sdst`,`seg_class_code`),
  ADD KEY `sorg` (`sorg`,`sdst`),
  ADD KEY `flt_num_2` (`sorg`,`sdst`,`flt_num`),
  ADD KEY `flt_num_3` (`flt_num`,`sorg`,`sdst`,`dtd`,`seg_class_code`);

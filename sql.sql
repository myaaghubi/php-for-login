CREATE TABLE `users` (
  `ID` mediumint(9) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `fullname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `email`, `password`, `fullname`) VALUES
(1, 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'Administrator');

ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `users`
  MODIFY `ID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

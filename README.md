PHP for login 1.2.0
=================================

A simple php script for login via mysql.
<br>
![Alt text](/screenshot/shot1.jpg?raw=true "ScreenShot")

How to setup script
---
Create database "test" and create table "users" :
```
CREATE TABLE `users` (
  `ID` mediumint(9) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`ID`, `email`, `password`, `fullname`) VALUES
(1, 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'Administrator');

ALTER TABLE `users` ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `email` (`email`);
ALTER TABLE `users` MODIFY `ID` mediumint(9) NOT NULL AUTO_INCREMENT;
```
Default email/pass is admin@admin.com/admin.

Setup the config.php file
---
```
$config = array(
	"db_address" => ""; // "127.0.0.1"
	"db_name" => ""; // "test"
	"db_username" => ""; // "root"
	"db_password" => ""; // "123456"
	"session_ex" => 30 * 60, // session expire time(in second)
	"cookie_ex" => 7 * 3600, // cookie expire time(in second)
	"s_key" => "try_to_set_strong_key", // security key, you can mix it by user variables
);


```
You have done it!


License
---
```
Copyright 2017 Mohammad Yaghobi

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```

VHOST for WEB Application
-------------------------
<VirtualHost *:80> 
ServerAdmin rmdganesan@gmail.com
DocumentRoot "/var/work/smit/basic/web"
ServerName smit.in
ServerAlias http://smit.in
   <Directory "/var/work/smit/basic/web">
        Options FollowSymLinks
        AllowOverride All
    </Directory>
</VirtualHost>

WEB Application Config:
---------------------
#DB Config - /var/work/smit/basic/config/db.php
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=smit',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];



VHOST for API code
-------------------

<VirtualHost *:80>
    CustomLog /var/work/smit/basic/api/web/access.log combined
    ErrorLog /var/work/smit/basic/api/web/error.log
    ServerAdmin rmdganesan@gmail.com
    ServerName api.smit.in
    DocumentRoot /var/work/smit/basic/api/web
        <Directory /var/work/smit/basic/api/web>
            Options FollowSymLinks
            AllowOverride All
        </Directory>
</VirtualHost>

etc/hosts entery
----------------
127.0.0.1     smit.in
127.0.0.1    api.smit.in


Table structure:
---------------
--
-- Database: `smit`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `lastloginip` varchar(50) NOT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token_update_on` datetime NOT NULL,
  `authKey` varchar(32) NOT NULL,
  `password_reset_token` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


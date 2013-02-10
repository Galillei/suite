CREATE  TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) );
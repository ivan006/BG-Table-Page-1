CREATE TABLE `trips` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `events` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`trip_id` BIGINT UNSIGNED ,
`product_id` BIGINT UNSIGNED ,
`time` DATETIME NULL ,
`price` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `products` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_children` BIGINT UNSIGNED ,
`organization_id` BIGINT UNSIGNED ,
`rate` character varying(100) NOT NULL ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `organizations` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`product_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `payment_methods` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`payment_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `payments` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`payment_method_id` BIGINT UNSIGNED ,
`event_id` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `events` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`payment_children` BIGINT UNSIGNED ,
`attendee_id` BIGINT UNSIGNED ,
`product_id` BIGINT UNSIGNED ,
`fee_schedule_id` BIGINT UNSIGNED ,
`employee_id` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `attendees` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `product_types` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`product_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `products` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_children` BIGINT UNSIGNED ,
`fee_schedule_children` BIGINT UNSIGNED ,
`product_type_id` BIGINT UNSIGNED ,
`employee_id` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `fee_schedules` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_children` BIGINT UNSIGNED ,
`product_id` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `employees` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_children` BIGINT UNSIGNED ,
`product_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

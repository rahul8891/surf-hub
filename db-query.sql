CREATE TABLE `surfer_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `surfer_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `surfer_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



ALTER TABLE `user_profiles` ADD `business_name` VARCHAR(150) NOT NULL AFTER `address`, ADD `business_type` TINYINT NOT NULL DEFAULT '0' AFTER `business_name`; 

ALTER TABLE `user_profiles` ADD `resort_name` VARCHAR(150) NOT NULL AFTER `business_type`, ADD `resort_type` TINYINT NOT NULL DEFAULT '0' AFTER `resort_name`; 

ALTER TABLE `user_profiles` ADD `preferred_camera` TINYINT NOT NULL DEFAULT '0' AFTER `address`, ADD `paypal` VARCHAR(60) NOT NULL AFTER `preferred_camera`; 

ALTER TABLE `user_profiles` ADD `website` VARCHAR(100) NULL DEFAULT NULL AFTER `address`; 

ALTER TABLE `user_profiles` ADD `company_name` VARCHAR(100) NULL DEFAULT NULL AFTER `resort_type`, ADD `company_address` VARCHAR(150) NULL DEFAULT NULL AFTER `company_name`, ADD `industry` INT NULL DEFAULT NULL AFTER `company_address`; 


ALTER TABLE `user_profiles` CHANGE `gender` `gender` SMALLINT NULL DEFAULT NULL; 

ALTER TABLE `posts` CHANGE `local_beach_break_id` `local_beach_id` INT NOT NULL; 

ALTER TABLE `posts` ADD `local_break_id` INT NULL DEFAULT NULL AFTER `local_beach_id`;

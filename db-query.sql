ALTER TABLE `uploads` ADD `file_body` LONGBLOB NULL DEFAULT NULL AFTER `video`, ADD `aws_uploaded` TINYINT NOT NULL DEFAULT '0' AFTER `file_body`; 

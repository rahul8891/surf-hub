CREATE TABLE `spotify_users` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `spotify_user_id` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spotify_users`
--

INSERT INTO `spotify_users` (`id`, `user_id`, `spotify_user_id`, `token`, `refresh_token`, `created_at`, `updated_at`) VALUES
(11, 45, '3126wrnqm7otcbe6movbyrhvcyvi', 'BQAEm8tQzg9IAMlIP_adfTTkITaCtpxVCHAqsCHxYKg_ZlIPdz-zLe5pldsJ87n8v1R9oxf1KmMY1tGzEm3Mc7b70wZFcaO5fN6COzNnNxUBUFTZIJJjL6wn9t1eXR7D5eEyha8IYZiGDfUz9BD_kBVh2eQNV2CIZn7xnKk87vk2HsbohwWR3SMwuMwvfJee95ih-zhk-PL77qdrzRiXcci9b2-r_5m5DVgCy1ZsSJSb-g', 'AQA4VSSBCBTIYD5vNm2TBXKJ0wJSi8ruHuk7l1_jsrYss4XhsFg2ZGKmv-RMqA03E4RkQDM4gO7RhYALQt5pEchWS76B5AWnRBrV3L3fT8yXZ5m6E5b_51zVsiT3NWyQSb0', '2022-11-17 07:36:53', '2022-11-17 07:36:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `spotify_users`
--
ALTER TABLE `spotify_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spotify_users_user_id_foreign` (`user_id`);

ALTER TABLE `user_profiles` ADD `preferred_board` INT NULL DEFAULT NULL AFTER `preferred_camera`; 
ALTER TABLE `user_profiles` ADD `postal_code` VARCHAR(60) NULL DEFAULT NULL AFTER `paypal`; 


ALTER TABLE `posts` ADD `additional_info` VARCHAR(191) NULL DEFAULT NULL AFTER `optional_info`, ADD `fin_set_up` VARCHAR(100) NULL DEFAULT NULL AFTER `additional_info`, ADD `stance` VARCHAR(100) NULL DEFAULT NULL AFTER `fin_set_up`; 


CREATE TABLE `board_type_additional_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `board_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `board_type_additional_infos`
--

INSERT INTO `board_type_additional_infos` (`id`, `board_type`, `info_name`, `created_at`, `updated_at`) VALUES
(1, 'SHORTBOARD', 'Bottom Turn', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(2, 'SHORTBOARD', 'Carve', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(3, 'SHORTBOARD', 'Carve 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(4, 'SHORTBOARD', 'Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(5, 'SHORTBOARD', 'Layback Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(6, 'SHORTBOARD', 'Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(7, 'SHORTBOARD', 'Layback Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(8, 'SHORTBOARD', 'Roundhouse Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(9, 'SHORTBOARD', 'Off The Lip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(10, 'SHORTBOARD', 'Foam Climb', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(11, 'SHORTBOARD', 'Closeout Re-entry', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(12, 'SHORTBOARD', 'Tail Slide', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(13, 'SHORTBOARD', 'Switch Stance', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(14, 'SHORTBOARD', 'Kick Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(15, 'SHORTBOARD', 'Air 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(16, 'SHORTBOARD', 'Air Reverse', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(17, 'SHORTBOARD', 'Air Backflip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(18, 'SHORTBOARD', 'Air 540', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(19, 'SHORTBOARD', 'Air 720', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(20, 'SHORTBOARD', 'Alley-oop', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(21, 'SHORTBOARD', 'Superman', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(22, 'SHORTBOARD', 'Rodeo Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(23, 'SHORTBOARD', 'Kerrupt Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(24, 'SHORTBOARD', 'Flynnstone Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(25, 'SHORTBOARD', 'Sushi Roll', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(26, 'GUN', 'Bottom Turn', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(27, 'GUN', 'Carve', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(28, 'GUN', 'Carve 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(29, 'GUN', 'Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(30, 'GUN', 'Layback Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(31, 'GUN', 'Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(32, 'GUN', 'Layback Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(33, 'GUN', 'Roundhouse Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(34, 'GUN', 'Off The Lip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(35, 'GUN', 'Foam Climb', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(36, 'GUN', 'Closeout Re-entry', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(37, 'GUN', 'Tail Slide', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(38, 'GUN', 'Switch Stance', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(39, 'GUN', 'Cross Stepping', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(40, 'GUN', 'Nose Riding 5', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(41, 'GUN', 'Nose Riding 10', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(42, 'GUN', 'Air 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(43, 'GUN', 'Air Reverse', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(44, 'LONGBOARD', 'Bottom Turn', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(45, 'LONGBOARD', 'Carve', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(46, 'LONGBOARD', 'Carve 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(47, 'LONGBOARD', 'Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(48, 'LONGBOARD', 'Layback Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(49, 'LONGBOARD', 'Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(50, 'LONGBOARD', 'Layback Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(51, 'LONGBOARD', 'Roundhouse Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(52, 'LONGBOARD', 'Off The Lip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(53, 'LONGBOARD', 'Foam Climb', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(54, 'LONGBOARD', 'Closeout Re-entry', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(55, 'LONGBOARD', 'Switch Stance', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(56, 'LONGBOARD', 'Cross Stepping', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(57, 'LONGBOARD', 'Nose Riding 5', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(58, 'LONGBOARD', 'Nose Riding 10', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(59, 'BODYBOARD', 'Bottom Turn', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(60, 'BODYBOARD', 'Cut Back', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(61, 'BODYBOARD', 'Drop Knee', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(62, 'BODYBOARD', '360 Reverse', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(63, 'BODYBOARD', 'El Rollo', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(64, 'BODYBOARD', 'Reverse Rollo', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(65, 'BODYBOARD', 'Double El Rollo', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(66, 'BODYBOARD', 'Invert Air', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(67, 'BODYBOARD', 'Air 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(68, 'BODYBOARD', 'Air 360 Reverse', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(69, 'BODYBOARD', 'Air Roll Spin (ARS)', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(70, 'BODYBOARD', 'Back Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(71, 'BODYBOARD', 'Front Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(72, 'BODYBOARD', 'Hubb Air', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(73, 'BODYBOARD', 'Gyroll Air', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(74, 'SUP', 'Bottom Turn', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(75, 'SUP', 'Carve', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(76, 'SUP', 'Carve 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(77, 'SUP', 'Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(78, 'SUP', 'Layback Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(79, 'SUP', 'Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(80, 'SUP', 'Layback Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(81, 'SUP', 'Roundhouse Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(82, 'SUP', 'Off The Lip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(83, 'SUP', 'Foam Climb', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(84, 'SUP', 'Closeout Re-entry', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(85, 'SUP', 'Switch Stance', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(86, 'SUP', 'Cross Stepping', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(87, 'SUP', 'Nose Riding 5', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(88, 'SUP', 'Nose Riding 10', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(89, 'KNEEBOARD', 'Bottom Turn', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(90, 'KNEEBOARD', 'Carve', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(91, 'KNEEBOARD', 'Carve 360', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(92, 'KNEEBOARD', 'Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(93, 'KNEEBOARD', 'Snap', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(94, 'KNEEBOARD', 'Roundhouse Cutback', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(95, 'KNEEBOARD', 'Off The Lip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(96, 'KNEEBOARD', 'Foam Climb', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(97, 'KNEEBOARD', 'Closeout Re-entry', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(98, 'KNEEBOARD', 'Tail Slide', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(99, 'SKIMBOARD', 'Shuv-it', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(100, 'SKIMBOARD', '360 Shuv-it', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(101, 'SKIMBOARD', 'Backside 360 Shuv-it', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(102, 'SKIMBOARD', 'Big Spin', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(103, 'SKIMBOARD', 'Frontside Big Spin', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(104, 'SKIMBOARD', 'BS Big Spins', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(105, 'SKIMBOARD', 'Backside Big Spin', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(106, 'SKIMBOARD', 'Backside 3\'s', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(107, 'SKIMBOARD', 'Frontside 3 Shove', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(108, 'SKIMBOARD', 'Flat Spin', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(109, 'SKIMBOARD', 'The Kick Out', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(110, 'SKIMBOARD', 'One Footer', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(111, 'SKIMBOARD', 'Shoot The Duck (L-Ride)', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(112, 'SKIMBOARD', 'The Sit Down', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(113, 'SKIMBOARD', 'Kneel Down', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(114, 'SKIMBOARD', 'Hippy Jump', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(115, 'SKIMBOARD', 'Body Varial', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(116, 'SKIMBOARD', 'Sex Change', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(117, 'SKIMBOARD', 'Fast Plant', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(118, 'SKIMBOARD', 'Ollie', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(119, 'SKIMBOARD', '180 Ollie', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(120, 'SKIMBOARD', 'Backside 180', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(121, 'SKIMBOARD', 'Frontside 180', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(122, 'SKIMBOARD', 'Frontside Shuv', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(123, 'SKIMBOARD', 'Pop Shuv-it', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(124, 'SKIMBOARD', 'Shuv Indy', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(125, 'SKIMBOARD', '540 Shuv-it', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(126, 'SKIMBOARD', 'Varial Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(127, 'SKIMBOARD', 'Kick Flip', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(128, 'SKIMBOARD', 'Pretzels', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(129, 'SKIMBOARD', 'Hurricanes', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(130, 'SKIMBOARD', 'Butters', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(131, 'SKIMBOARD', 'Shifty', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(132, 'SKIMBOARD', 'Revert', '2022-11-16 10:39:03', '2022-11-16 10:39:12'),
(133, 'SKIMBOARD', 'Wrap', '2022-11-16 10:39:03', '2022-11-16 10:39:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board_type_additional_infos`
--
ALTER TABLE `board_type_additional_infos`
  ADD PRIMARY KEY (`id`);



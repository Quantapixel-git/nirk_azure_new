INSERT INTO `shipping_systems` (`id`, `name`, `active`, `addon_identifier`, `created_at`, `updated_at`) VALUES
(NULL, 'shiprocket', 1, 'shiprocket', current_timestamp() , current_timestamp());

CREATE TABLE `shiprocket_credentials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `shiprocket_credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`email`);

ALTER TABLE `shiprocket_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;
CREATE TABLE `tbl_user_bank_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `owner_name` varchar(191) NOT NULL,
  `account_number` varchar(191) NOT NULL,
  `ifsc` varchar(20) DEFAULT NULL,
  `branch_address` text NOT NULL,
  `is_approved` tinyint(4) NOT NULL DEFAULT '1',
  `verified_transaction_id` varchar(100) DEFAULT NULL,
  `verified_amount` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `tbl_user_bank_account`
--
ALTER TABLE `tbl_user_bank_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_bank_acc__userid_index` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for table `tbl_user_bank_account`
--
ALTER TABLE `tbl_user_bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

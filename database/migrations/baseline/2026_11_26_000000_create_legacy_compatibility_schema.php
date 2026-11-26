<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Compatibility baseline from the structure-only MySQL 8.4 export (2026-11-26).
 * Opt-in migration path only. Future module migrations should use Schema Builder.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->assertScratchDatabase();

        $tables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME <> 'migrations'");
        if ($tables !== []) {
            throw new \RuntimeException('Baseline requires a fresh empty refactor database.');
        }

        foreach ($this->statements() as $statement) {
            DB::statement($statement);
        }
    }

    public function down(): void
    {
        $this->assertScratchDatabase();
        Schema::disableForeignKeyConstraints();

        try {
            foreach (array_reverse($this->tableNames()) as $table) {
                Schema::dropIfExists($table);
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    private function assertScratchDatabase(): void
    {
        if (! app()->environment('local', 'testing')
            || DB::connection()->getDriverName() !== 'mysql'
            || ! str_ends_with(DB::connection()->getDatabaseName(), '_refactor')) {
            throw new \RuntimeException('Use a dedicated local/testing MySQL database ending in _refactor.');
        }
    }

    private function tableNames(): array
    {
        return [
            'accounts_logs',
            'action_logs',
            'activities',
            'activity_assignees',
            'activity_layouts',
            'activity_logs',
            'addition_payments',
            'attributes',
            'attribute_colors',
            'attribute_groups',
            'attribute_group_attributes',
            'attribute_group_layouts',
            'attribute_layouts',
            'attribute_on_unit_prices',
            'audits',
            'backup_summary_at_payments',
            'bulk_invoices',
            'bulk_order_entries',
            'card_refund_logs',
            'check_payments',
            'clouser_types',
            'color_masters',
            'column_layouts',
            'contacts',
            'contact_organizations',
            'customer_enquiries',
            'customer_enquiry_items',
            'customer_enquiry_items_details',
            'customer_portal_users',
            'debit_account_records',
            'debit_entries',
            'draft_emails',
            'email_filters',
            'email_notifications',
            'email_notification_template_users',
            'email_signatures',
            'email_templates',
            'embellishment_types',
            'embellishment_type_layouts',
            'em_customers',
            'em_customer_cart_items',
            'em_customer_children',
            'em_customer_credits',
            'em_customer_credit_logs',
            'em_customer_packages',
            'em_customer_package_cart',
            'em_customer_password_resets',
            'em_customer_session_bookings',
            'em_customer_session_users',
            'em_packages',
            'em_package_orders',
            'em_package_order_items',
            'em_package_payment_logs',
            'em_session_bookings',
            'em_session_events',
            'enquiries',
            'ex_factories',
            'ex_factory_date_logs',
            'fabrics',
            'fabric_layouts',
            'factories',
            'factory_bank_details',
            'factory_invoices',
            'factory_invoice_additions',
            'factory_layouts',
            'factory_price_user_filters',
            'failed_jobs',
            'finacial_year_dates',
            'genders',
            'inventory_order_layouts',
            'invoices_on_transactions',
            'invoice_products',
            'invoice_transactions',
            'in_hand_date_logs',
            'item_ex_factory_date_logs',
            'jobs',
            'lead_sources',
            'leave_types',
            'main_categories',
            'marketing_campaigns',
            'marketing_contacts',
            'marketing_sync_logs',
            'master_fits',
            'model_has_permissions',
            'model_has_roles',
            'notifications',
            'notification_templates',
            'notification_template_users',
            'orders',
            'order_billing_details',
            'order_folders',
            'order_items',
            'order_items_details',
            'order_items_detail_player_names',
            'order_item_attributes',
            'order_item_attribute_groups',
            'order_item_files',
            'order_item_sub_attributes',
            'order_layouts',
            'order_payment_update_logs',
            'order_shedule_colors',
            'order_shedule_comments',
            'order_shipping_addresses',
            'order_statuses',
            'organizations',
            'organization_colors',
            'organization_emails',
            'organization_layouts',
            'organization_received_samples',
            'organization_stores',
            'organization_store_products',
            'organization_store_product_sizes',
            'other_payments',
            'password_resets',
            'pattern_codes',
            'pattern_code_layouts',
            'payment_logs',
            'paypal_payments',
            'people_layouts',
            'permissions',
            'pipedrive_activities',
            'pipedrive_contacts',
            'pipedrive_organizations',
            'pm_inboxes',
            'pm_sections',
            'pm_section_discussions',
            'pm_section_discussion_comments',
            'pm_section_sub_discussions',
            'pm_task_assignees',
            'prices',
            'price_temps',
            'price_types',
            'production_approval_details',
            'products',
            'products_temp',
            'product_attributes',
            'product_catalog_tempory_users',
            'product_categories',
            'product_category_layouts',
            'product_category_lists',
            'product_catlog_quotes',
            'product_embellishment_types',
            'product_fabrics',
            'product_factories',
            'product_fits',
            'product_images',
            'product_image_temps',
            'product_layouts',
            'product_main_categories',
            'product_sizes',
            'product_sports',
            'product_taglines',
            'product_tagline_lists',
            'projects',
            'project_icons',
            'project_statuses',
            'project_types',
            'purchaseorder_receipts',
            'quickbooks_tokens',
            'quickbook_records',
            'remake_order_items',
            'roles',
            'role_has_permissions',
            'saved_reports',
            'shared_items',
            'shipped_orders',
            'shipping_information',
            'shipping_notification_drafts',
            'shipping_order_details',
            'sizes',
            'size_layouts',
            'size_types',
            'sizing_fits',
            'sports',
            'statement_layouts',
            'stores',
            'store_added_coupons',
            'store_added_custom_informations',
            'store_added_shipping_methods',
            'store_added_tax_categories',
            'store_card_payments',
            'store_carts',
            'store_cart_items',
            'store_cart_item_name_number',
            'store_category_orders',
            'store_coach_payments',
            'store_coupons',
            'store_customers',
            'store_customer_custom_informations',
            'store_custom_informations',
            'store_custom_information_templates',
            'store_email_templates',
            'store_flyers',
            'store_group_accesses',
            'store_individual_names',
            'store_individual_numbers',
            'store_orders',
            'store_order_items',
            'store_order_player_details',
            'store_order_receipts',
            'store_order_statuses',
            'store_payment_logs',
            'store_products',
            'store_product_added_variants',
            'store_product_bundles',
            'store_product_categories',
            'store_product_category_lists',
            'store_product_default_categories',
            'store_product_edited_categories',
            'store_product_extra_sizes',
            'store_product_images',
            'store_product_price_additions',
            'store_product_sizes',
            'store_product_variants',
            'store_shipments',
            'store_shipping_methods',
            'store_taxes',
            'store_tax_categories',
            'store_themes',
            'store_types',
            'subscribe_logs',
            'sub_products',
            'sub_products_temp',
            'sub_product_colors',
            'sub_product_embellishment_options',
            'sub_product_images',
            'sub_product_image_temps',
            'sub_product_prices',
            'summary_at_payments',
            'support_agents',
            'support_agent_departments',
            'support_conversations',
            'support_departments',
            'support_messages',
            'support_transfers',
            'system_a_p_is',
            'system_configurations',
            'teams',
            'team_store_orders',
            'team_store_player_reports',
            'team_store_product_reports',
            'theme_settings',
            'users',
            'user_details',
            'user_email_templates',
            'user_files',
            'user_folders',
            'user_groups',
            'user_group_layouts',
            'user_layouts',
            'user_leaves',
            'user_password_resets',
            'user_roles',
            'user_role_layouts',
            'user_shared_folders',
            'user_trash_folders',
            'user_trash_records',
            'usps_label_attempts',
            'usps_shipment_profiles',
            'venmo_payments',
            'webmail_accounts',
            'webmail_counts',
        ];
    }

    private function statements(): array
    {
        return [
            <<<'SQL'
CREATE TABLE `accounts_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `amount` float NOT NULL,
  `paid` float NOT NULL,
  `balance` float NOT NULL,
  `type` int NOT NULL,
  `user_id` int NOT NULL,
  `status` int NOT NULL,
  `debit_balance` double DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `document_url` varchar(100) DEFAULT NULL,
  `document_url_back` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `action_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `activities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_subject` varchar(255) DEFAULT NULL,
  `activity_note` longtext,
  `activity_deal` varchar(255) DEFAULT NULL,
  `assigned_to` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `contact_id` int DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `deal_stage` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `activity_type` tinyint DEFAULT '1' COMMENT '1=Call, 2=Meeting, 3=Task, 4=Email, 5=Other, 6=Deadline',
  `created_by` int DEFAULT NULL,
  `is_done` tinyint DEFAULT '0',
  `is_synced` int NOT NULL DEFAULT '0',
  `priority` int NOT NULL DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `modified_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `email_message_no` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `activity_assignees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `activity_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `activity_done` tinyint DEFAULT '1',
  `activity_description` tinyint DEFAULT '1',
  `activity_start_date` tinyint DEFAULT '1',
  `activity_start_time` tinyint DEFAULT '1',
  `activity_due_date` tinyint DEFAULT '1',
  `activity_notes` tinyint DEFAULT '1',
  `activity_assign_to` tinyint DEFAULT '1',
  `activity_order_no` tinyint DEFAULT '1',
  `activity_organization` tinyint DEFAULT '1',
  `activity_contact_person` tinyint DEFAULT '1',
  `activity_created_by` tinyint DEFAULT '1',
  `activity_priority` tinyint DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `addition_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `addition_type_name` varchar(250) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `description` varchar(3072) DEFAULT NULL,
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `image_4` varchar(255) DEFAULT NULL,
  `image_5` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `is_sub_attribute` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `attribute_colors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `attribute_id` int DEFAULT NULL,
  `color_master_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `attribute_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `product_category_id` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `attribute_group_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_category_id` varchar(255) DEFAULT NULL,
  `attribute_group_id` int NOT NULL,
  `attribute_id` int NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `attribute_group_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `attribute_group_name` tinyint DEFAULT NULL,
  `product_style` tinyint DEFAULT NULL,
  `attribute_name` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `attribute_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `attribute_name` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `attribute_on_unit_prices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_product_id` int NOT NULL,
  `attribute__id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `audits` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `auditable_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auditable_id` bigint UNSIGNED NOT NULL,
  `old_values` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `new_values` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `ip_address` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `source` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `parent_id` int NOT NULL DEFAULT '0',
  `order_item_id` int NOT NULL DEFAULT '0',
  `order_id` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  KEY `audits_user_id_user_type_index` (`user_id`,`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `backup_summary_at_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(10) DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `totalItemQty` int DEFAULT NULL,
  `subTotal` double(10,2) DEFAULT NULL,
  `shipping` double(10,2) DEFAULT NULL,
  `salesTax` double(10,2) DEFAULT NULL,
  `artwork` double(10,2) DEFAULT NULL,
  `processingFee` double(10,2) DEFAULT NULL,
  `orderTotal` double(10,2) DEFAULT NULL,
  `balancePayment` double(10,2) DEFAULT NULL,
  `payedAmount` double(10,2) DEFAULT NULL,
  `method` varchar(250) DEFAULT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `bulk_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_ids` varchar(100) NOT NULL,
  `organization_id` int NOT NULL,
  `active` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `bulk_order_entries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int NOT NULL,
  `other_payment_ids` varchar(255) DEFAULT NULL,
  `is_approved` int NOT NULL DEFAULT '1',
  `amount` float(10,2) NOT NULL DEFAULT '0.00',
  `document_url` varchar(255) DEFAULT NULL,
  `document_url_back` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `card_refund_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `is_success` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_refund_logs_order_id_index` (`order_id`),
  KEY `card_refund_logs_transaction_id_index` (`transaction_id`),
  KEY `card_refund_logs_user_id_index` (`user_id`),
  KEY `card_refund_logs_success_index` (`is_success`),
  KEY `card_refund_logs_order_transaction_index` (`order_id`,`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `check_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `customer_paid_amount` float(10,2) DEFAULT NULL,
  `check_front` varchar(255) DEFAULT NULL,
  `check_back` varchar(255) DEFAULT NULL,
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `amount` float(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reject_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `clouser_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clouser_name` varchar(100) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `color_masters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pantone_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hex` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `r` int NOT NULL,
  `g` int NOT NULL,
  `b` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `column_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `interface_name` varchar(255) DEFAULT NULL,
  `interface_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `column_order` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(512) DEFAULT NULL,
  `last_name` varchar(512) DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `lead_source` varchar(512) DEFAULT NULL,
  `phone_no` varchar(512) DEFAULT NULL,
  `personal_phone_no` varchar(512) DEFAULT NULL,
  `email` varchar(512) NOT NULL,
  `email_two` varchar(512) DEFAULT NULL,
  `title` varchar(512) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `shipping_po_box` varchar(512) DEFAULT NULL,
  `shipping_street` varchar(512) DEFAULT NULL,
  `shipping_city` varchar(512) DEFAULT NULL,
  `shipping_state` varchar(512) DEFAULT NULL,
  `shipping_zip` varchar(512) DEFAULT NULL,
  `shipping_country` varchar(512) DEFAULT NULL,
  `apartment2` varchar(100) DEFAULT NULL,
  `shipping_street_2` varchar(512) DEFAULT NULL,
  `shipping_city_2` varchar(512) DEFAULT NULL,
  `shipping_state_2` varchar(512) DEFAULT NULL,
  `shipping_zip_2` varchar(512) DEFAULT NULL,
  `shipping_country_2` varchar(512) DEFAULT NULL,
  `active` varchar(512) DEFAULT NULL,
  `updated_at` varchar(512) DEFAULT NULL,
  `created_at` varchar(512) DEFAULT NULL,
  `apartment` varchar(100) DEFAULT NULL,
  `sport` varchar(255) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `mailchimp_audience_id` varchar(64) DEFAULT NULL,
  `mailchimp_segment_id` varchar(64) DEFAULT NULL,
  `mailchimp_member_id` varchar(64) DEFAULT NULL,
  `mailchimp_subscriber_hash` char(32) DEFAULT NULL,
  `mailchimp_status` varchar(32) DEFAULT NULL,
  `mailchimp_rating` tinyint UNSIGNED DEFAULT NULL,
  `mailchimp_last_changed_at` datetime DEFAULT NULL,
  `mailchimp_synced_at` datetime DEFAULT NULL,
  `mailchimp_sync_error` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `contact_organizations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contact_id` int NOT NULL,
  `organization_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `customer_enquiries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int DEFAULT NULL,
  `contact_id` int DEFAULT NULL,
  `order_no` varchar(11) DEFAULT NULL,
  `order_status_id` int DEFAULT NULL,
  `user_id` varchar(11) DEFAULT NULL,
  `sub_total` double(10,2) NOT NULL DEFAULT '0.00',
  `sales_tax` double(10,2) NOT NULL DEFAULT '0.00',
  `shipping` double(10,2) NOT NULL DEFAULT '0.00',
  `artwork` double(10,2) NOT NULL DEFAULT '0.00',
  `processing_fee` double(10,2) NOT NULL DEFAULT '0.00',
  `order_total` double(10,2) NOT NULL DEFAULT '0.00',
  `active` tinyint DEFAULT '1',
  `is_editable` tinyint NOT NULL DEFAULT '1',
  `is_requested` tinyint NOT NULL DEFAULT '0',
  `request_reasons` varchar(255) DEFAULT NULL,
  `flag` varchar(50) NOT NULL DEFAULT '#f6f8f9',
  `open_date` varchar(20) DEFAULT NULL,
  `due_date` varchar(20) DEFAULT NULL,
  `production_date` varchar(20) DEFAULT NULL,
  `ex_factory_date` varchar(20) DEFAULT NULL,
  `encore_packing_date` varchar(20) DEFAULT NULL,
  `est_delivery_date` varchar(20) DEFAULT NULL,
  `order_description` text,
  `address_type` tinyint NOT NULL DEFAULT '2' COMMENT '1=Direct Ship to Customers, 2=Bulk Ship to Coach, 3=Pick Up, 4=Direct & Pick Up',
  `is_new_shipping_address` tinyint DEFAULT NULL,
  `street` longtext,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `phone_no` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `is_reordered` tinyint NOT NULL DEFAULT '0',
  `order_id` int DEFAULT NULL,
  `order_ref_no` varchar(100) DEFAULT NULL,
  `order_type` tinyint NOT NULL DEFAULT '0' COMMENT '0=Bulk, 1=Team Store',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `customer_enquiry_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_no` varchar(11) DEFAULT NULL,
  `order_id` varchar(25) DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `factory_id` int DEFAULT NULL,
  `support_agent_id` int DEFAULT NULL,
  `designer_id` int DEFAULT NULL,
  `shipping_method` varchar(50) DEFAULT NULL,
  `ex_factory_id` int DEFAULT NULL,
  `open_date` varchar(20) DEFAULT NULL,
  `close_date` varchar(20) DEFAULT NULL,
  `ex_factory_date` varchar(20) DEFAULT NULL,
  `encore_packing_date` varchar(20) DEFAULT NULL,
  `in_hand_due_date` varchar(20) DEFAULT NULL,
  `production_date` varchar(20) DEFAULT NULL,
  `est_delivery_date` varchar(20) DEFAULT NULL,
  `order_status_id` int DEFAULT NULL,
  `fabric_id` int DEFAULT NULL,
  `secondary_fabric_id` int DEFAULT NULL,
  `embellishment_type_id` int DEFAULT NULL,
  `sport` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `unit_price` double(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `extra_size` varchar(50) NOT NULL DEFAULT 'Extra Size One',
  `extra_size_two` varchar(100) DEFAULT 'Extra Size Two',
  `extra_size_three` varchar(100) DEFAULT 'Extra Size Three',
  `double_sided` int DEFAULT NULL,
  `individual_name` int DEFAULT NULL,
  `individual_no` int DEFAULT NULL,
  `pockets` int DEFAULT NULL,
  `zipper_pockets` int DEFAULT NULL,
  `dynamic_details` int DEFAULT NULL,
  `contrast_stratching` int DEFAULT NULL,
  `printing_over_sems` int DEFAULT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `tracking_link` varchar(255) DEFAULT NULL,
  `notify_status` tinyint NOT NULL DEFAULT '0' COMMENT '0=not sent, 1=sent	',
  `notified_user_id` int DEFAULT NULL,
  `item_description` varchar(100) DEFAULT NULL,
  `shipped_qty` int DEFAULT NULL,
  `backordered_qty` int DEFAULT NULL,
  `est_shipping_delivery_date` date DEFAULT NULL,
  `product_year` varchar(10) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `customer_enquiry_items_details` (
  `id` int NOT NULL,
  `order_item_id` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `size_id` int DEFAULT NULL,
  `blanks` int DEFAULT NULL,
  `numseq_one` varchar(5) DEFAULT NULL,
  `numseq_two` varchar(5) DEFAULT NULL,
  `numseq_three` varchar(5) DEFAULT NULL,
  `numseq_four` varchar(5) DEFAULT NULL,
  `numseq_five` varchar(5) DEFAULT NULL,
  `numseq_six` varchar(5) DEFAULT NULL,
  `numseq_seven` varchar(5) DEFAULT NULL,
  `numseq_eight` varchar(5) DEFAULT NULL,
  `numseq_nine` varchar(5) DEFAULT NULL,
  `numseq_ten` varchar(5) DEFAULT NULL,
  `numseq_eleven` varchar(5) DEFAULT NULL,
  `numseq_twelve` varchar(5) DEFAULT NULL,
  `numseq_thirteen` varchar(5) DEFAULT NULL,
  `numseq_fourteen` varchar(5) DEFAULT NULL,
  `numseq_fifteen` varchar(5) DEFAULT NULL,
  `numseq_sixteen` varchar(5) DEFAULT NULL,
  `numseq_seventeen` varchar(5) DEFAULT NULL,
  `numseq_eighteen` varchar(5) DEFAULT NULL,
  `numseq_nineteen` varchar(5) DEFAULT NULL,
  `numseq_twenty` varchar(5) DEFAULT NULL,
  `numseq_twenty_one` varchar(5) DEFAULT NULL,
  `numseq_twenty_two` varchar(5) DEFAULT NULL,
  `numseq_twenty_three` varchar(5) DEFAULT NULL,
  `numseq_twenty_four` varchar(5) DEFAULT NULL,
  `numseq_twenty_five` varchar(5) DEFAULT NULL,
  `numseq_twenty_six` varchar(5) DEFAULT NULL,
  `numseq_twenty_seven` varchar(5) DEFAULT NULL,
  `numseq_twenty_eight` varchar(5) DEFAULT NULL,
  `numseq_twenty_nine` varchar(5) DEFAULT NULL,
  `numseq_thirty` varchar(5) DEFAULT NULL,
  `numseq_thirty_one` varchar(5) DEFAULT NULL,
  `numseq_thirty_two` varchar(5) DEFAULT NULL,
  `numseq_thirty_three` varchar(5) DEFAULT NULL,
  `numseq_thirty_four` varchar(5) DEFAULT NULL,
  `numseq_thirty_five` varchar(5) DEFAULT NULL,
  `numseq_thirty_six` varchar(5) DEFAULT NULL,
  `numseq_thirty_seven` varchar(5) DEFAULT NULL,
  `numseq_thirty_eight` varchar(5) DEFAULT NULL,
  `numseq_thirty_nine` varchar(5) DEFAULT NULL,
  `numseq_forty` varchar(5) DEFAULT NULL,
  `numseq_forty_one` varchar(5) DEFAULT NULL,
  `numseq_forty_two` varchar(5) DEFAULT NULL,
  `numseq_forty_three` varchar(5) DEFAULT NULL,
  `numseq_forty_four` varchar(5) DEFAULT NULL,
  `numseq_forty_five` varchar(5) DEFAULT NULL,
  `numseq_forty_six` varchar(5) DEFAULT NULL,
  `numseq_forty_seven` varchar(5) DEFAULT NULL,
  `numseq_forty_eight` varchar(5) DEFAULT NULL,
  `numseq_forty_nine` varchar(5) DEFAULT NULL,
  `numseq_fifty` varchar(5) DEFAULT NULL,
  `numseq_fifty_one` varchar(5) DEFAULT NULL,
  `numseq_fifty_two` varchar(5) DEFAULT NULL,
  `numseq_fifty_three` varchar(5) DEFAULT NULL,
  `numseq_fifty_four` varchar(5) DEFAULT NULL,
  `numseq_fifty_five` varchar(5) DEFAULT NULL,
  `numseq_fifty_six` varchar(5) DEFAULT NULL,
  `numseq_fifty_seven` varchar(5) DEFAULT NULL,
  `numseq_fifty_eight` varchar(5) DEFAULT NULL,
  `numseq_fifty_nine` varchar(5) DEFAULT NULL,
  `numseq_sixty` varchar(5) DEFAULT NULL,
  `numseq_sixty_one` varchar(5) DEFAULT NULL,
  `numseq_sixty_two` varchar(5) DEFAULT NULL,
  `numseq_sixty_three` varchar(5) DEFAULT NULL,
  `numseq_sixty_four` varchar(5) DEFAULT NULL,
  `numseq_sixty_five` varchar(5) DEFAULT NULL,
  `numseq_sixty_six` varchar(5) DEFAULT NULL,
  `numseq_sixty_seven` varchar(5) DEFAULT NULL,
  `numseq_sixty_eight` varchar(5) DEFAULT NULL,
  `numseq_sixty_nine` varchar(5) DEFAULT NULL,
  `numseq_seventy` varchar(5) DEFAULT NULL,
  `numseq_seventy_one` varchar(5) DEFAULT NULL,
  `numseq_seventy_two` varchar(5) DEFAULT NULL,
  `numseq_seventy_three` varchar(5) DEFAULT NULL,
  `numseq_seventy_four` varchar(5) DEFAULT NULL,
  `numseq_seventy_five` varchar(5) DEFAULT NULL,
  `numseq_seventy_six` varchar(5) DEFAULT NULL,
  `numseq_seventy_seven` varchar(5) DEFAULT NULL,
  `numseq_seventy_eight` varchar(5) DEFAULT NULL,
  `numseq_seventy_nine` varchar(5) DEFAULT NULL,
  `numseq_eighty` varchar(5) DEFAULT NULL,
  `numseq_eighty_one` varchar(5) DEFAULT NULL,
  `numseq_eighty_two` varchar(5) DEFAULT NULL,
  `numseq_eighty_three` varchar(5) DEFAULT NULL,
  `numseq_eighty_four` varchar(5) DEFAULT NULL,
  `numseq_eighty_five` varchar(5) DEFAULT NULL,
  `numseq_eighty_six` varchar(5) DEFAULT NULL,
  `numseq_eighty_seven` varchar(5) DEFAULT NULL,
  `numseq_eighty_eight` varchar(5) DEFAULT NULL,
  `numseq_eighty_nine` varchar(5) DEFAULT NULL,
  `numseq_ninety` varchar(5) DEFAULT NULL,
  `numseq_ninety_one` varchar(5) DEFAULT NULL,
  `numseq_ninety_two` varchar(5) DEFAULT NULL,
  `numseq_ninety_three` varchar(5) DEFAULT NULL,
  `numseq_ninety_four` varchar(5) DEFAULT NULL,
  `numseq_ninety_five` varchar(5) DEFAULT NULL,
  `numseq_ninety_six` varchar(5) DEFAULT NULL,
  `numseq_ninety_seven` varchar(5) DEFAULT NULL,
  `numseq_ninety_eight` varchar(5) DEFAULT NULL,
  `numseq_ninety_nine` varchar(5) DEFAULT NULL,
  `numseq_hundred` varchar(5) DEFAULT NULL,
  `show_extra` tinyint NOT NULL DEFAULT '0',
  `created_at` varchar(100) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `customer_portal_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expire` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `debit_account_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `pay_for` varchar(100) DEFAULT NULL,
  `task` varchar(255) NOT NULL,
  `current_value` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `debit_entries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int NOT NULL,
  `order_id` int NOT NULL,
  `transaction_id` int NOT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `document_url_front` varchar(255) DEFAULT NULL,
  `document_url_back` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `draft_emails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `draft_id` varchar(512) NOT NULL,
  `email_id` varchar(512) NOT NULL,
  `type` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `email_filters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `filter` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `email_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_key` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `function_name` varchar(50) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `description` varchar(255) NOT NULL,
  `proccessing_rep` int NOT NULL DEFAULT '0',
  `sales_rep` int NOT NULL DEFAULT '0',
  `related_fac` int NOT NULL DEFAULT '0',
  `order_customer` int DEFAULT '0',
  `organization_user` varchar(255) DEFAULT NULL,
  `hr_users` varchar(255) DEFAULT NULL,
  `store_users` varchar(255) DEFAULT NULL,
  `pm_users` varchar(255) DEFAULT NULL,
  `custom_email` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL,
  `environment` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `email_notification_template_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_id` int NOT NULL,
  `type` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `email_signatures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `signature` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `email_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subject` longtext,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `publish_type` int NOT NULL,
  `user_id` int NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `embellishment_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `embellishment_name` varchar(150) DEFAULT NULL,
  `description` varchar(3072) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `image_4` varchar(255) DEFAULT NULL,
  `fabrics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `active` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `embellishment_type_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `embellishment_name` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `em_customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(190) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(500) DEFAULT NULL,
  `google_id` varchar(190) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `em_customers_email_unique` (`email`),
  KEY `em_customers_google_id_index` (`google_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_cart_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` varchar(30) NOT NULL DEFAULT 'cart',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_em_customer_cart_customer` (`customer_id`),
  KEY `idx_em_customer_cart_package` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_children` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `player_first` varchar(100) NOT NULL,
  `player_last` varchar(100) NOT NULL,
  `grad_year` int DEFAULT NULL,
  `positions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customer` (`customer_id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_credits` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `total_classes` int NOT NULL DEFAULT '0',
  `used_classes` int NOT NULL DEFAULT '0',
  `remaining_classes` int NOT NULL DEFAULT '0',
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `em_credits_customer_index` (`customer_id`),
  KEY `em_credits_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_credit_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `credit_id` bigint UNSIGNED DEFAULT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `classes` int NOT NULL DEFAULT '1',
  `note` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `em_credit_logs_customer_index` (`customer_id`),
  KEY `em_credit_logs_credit_index` (`credit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_packages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(80) NOT NULL,
  `classes_total` int NOT NULL DEFAULT '0',
  `classes_used` int NOT NULL DEFAULT '0',
  `classes_remaining` int NOT NULL DEFAULT '0',
  `amount_paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_status` varchar(30) NOT NULL DEFAULT 'paid',
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_em_customer_packages_customer` (`customer_id`),
  KEY `idx_em_customer_packages_package` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_package_cart` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `em_cart_customer_index` (`customer_id`),
  KEY `em_cart_package_index` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_password_resets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `token` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `em_customer_password_resets_customer_unique` (`customer_id`),
  UNIQUE KEY `em_customer_password_resets_token_unique` (`token`),
  KEY `em_customer_password_resets_expires_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_session_bookings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `customer_child_id` bigint UNSIGNED NOT NULL,
  `session_event_id` bigint UNSIGNED NOT NULL,
  `credit_id` bigint UNSIGNED NOT NULL,
  `booking_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `player_first` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `player_last` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grad_year` smallint UNSIGNED DEFAULT NULL,
  `positions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('booked','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'booked',
  `booked_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `em_booking_no_unique` (`booking_no`),
  KEY `em_booking_customer_index` (`customer_id`),
  KEY `em_booking_child_index` (`customer_child_id`),
  KEY `em_booking_session_index` (`session_event_id`),
  KEY `em_booking_credit_index` (`credit_id`),
  KEY `em_booking_status_index` (`status`),
  KEY `em_booking_customer_session_index` (`customer_id`,`session_event_id`),
  KEY `em_booking_child_session_index` (`customer_child_id`,`session_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_customer_session_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(190) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_packages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `package_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `available_classes` int UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `em_packages_slug_unique` (`slug`),
  KEY `em_packages_user_active_idx` (`user_id`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_package_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `processing_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` varchar(50) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `card_last_four` varchar(10) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `em_orders_order_no_unique` (`order_no`),
  KEY `em_orders_customer_index` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_package_order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `package_name` varchar(190) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `classes_per_package` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `em_order_items_order_index` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_package_payment_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `package_order_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `gateway` varchar(50) NOT NULL DEFAULT 'authorize_net',
  `environment` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'card',
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `processing_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `response_code` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `auth_id` varchar(100) DEFAULT NULL,
  `message_code` varchar(100) DEFAULT NULL,
  `message_text` text,
  `ref_id` varchar(100) DEFAULT NULL,
  `name_on_card` varchar(190) DEFAULT NULL,
  `card_last_four` varchar(10) DEFAULT NULL,
  `billing_first_name` varchar(100) DEFAULT NULL,
  `billing_last_name` varchar(100) DEFAULT NULL,
  `billing_email` varchar(190) DEFAULT NULL,
  `billing_phone` varchar(50) DEFAULT NULL,
  `billing_street` varchar(190) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(30) DEFAULT NULL,
  `billing_country` varchar(100) DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `em_package_payment_logs_order_index` (`package_order_id`),
  KEY `em_package_payment_logs_customer_index` (`customer_id`),
  KEY `em_package_payment_logs_transaction_index` (`transaction_id`),
  KEY `em_package_payment_logs_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `em_session_bookings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `customer_child_id` bigint UNSIGNED DEFAULT NULL,
  `session_event_id` bigint UNSIGNED NOT NULL,
  `credit_id` bigint UNSIGNED DEFAULT NULL,
  `booking_no` varchar(100) NOT NULL,
  `player_first` varchar(100) DEFAULT NULL,
  `player_last` varchar(100) DEFAULT NULL,
  `grad_year` int DEFAULT NULL,
  `positions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` varchar(50) NOT NULL DEFAULT 'booked',
  `booked_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `em_session_bookings_no_unique` (`booking_no`),
  KEY `em_session_bookings_customer_index` (`customer_id`),
  KEY `em_session_bookings_event_index` (`session_event_id`),
  KEY `em_session_bookings_status_index` (`status`),
  KEY `idx_customer_child` (`customer_child_id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `em_session_events` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `documentation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_lat` decimal(10,7) DEFAULT NULL,
  `location_lng` decimal(10,7) DEFAULT NULL,
  `instructor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `what_to_bring` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `capacity` int NOT NULL DEFAULT '10',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_em_session_events_user` (`user_id`),
  KEY `idx_em_session_events_date` (`event_date`),
  KEY `idx_em_session_events_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `enquiries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `team_name` varchar(255) DEFAULT NULL,
  `sport` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `product_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `ex_factories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_item_id` int NOT NULL,
  `contact_id` int DEFAULT NULL,
  `ex_factory_name` varchar(255) DEFAULT NULL,
  `apartment` varchar(50) DEFAULT NULL,
  `po_box` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `ex_factory_date_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `pre_date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `new_date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `fabrics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fabric_name` varchar(150) DEFAULT NULL,
  `description` varchar(3072) DEFAULT NULL,
  `available_for_hats` int NOT NULL DEFAULT '0',
  `active` tinyint DEFAULT '1',
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `image_4` varchar(255) DEFAULT NULL,
  `image_5` varchar(255) DEFAULT NULL,
  `colors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `embellishments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `fabric_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `fabric_name` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `factories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `factory_name` varchar(255) DEFAULT NULL,
  `factory_code` varchar(20) DEFAULT NULL,
  `factory_color` varchar(50) DEFAULT NULL,
  `street` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `postal_code` varchar(250) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `permission_id` int NOT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `factory_bank_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `factory_id` int NOT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `account_no` varchar(250) DEFAULT NULL,
  `bank` varchar(250) DEFAULT NULL,
  `branch` varchar(250) DEFAULT NULL,
  `swift_code` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `factory_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(250) DEFAULT NULL,
  `company_invoice` varchar(250) DEFAULT NULL,
  `order_id` int NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `reduce_value` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transaction_id` varchar(20) DEFAULT NULL,
  `status` tinyint NOT NULL,
  `reject_reason` varchar(250) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `factory_invoice_additions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int NOT NULL,
  `addition_payment_id` int DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `if_other_reson` varchar(250) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `factory_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `factory_name` tinyint DEFAULT NULL,
  `factory_code` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `factory_price_user_filters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_status` int DEFAULT NULL,
  `pricing` int DEFAULT NULL,
  `pricetype` int DEFAULT NULL,
  `search_value` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `finacial_year_dates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `financial_year` int DEFAULT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `time_zone` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `genders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(255) DEFAULT NULL,
  `gender_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `inventory_order_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `order_flag` tinyint DEFAULT '1',
  `order_no` tinyint DEFAULT '1',
  `order_organization` tinyint DEFAULT '1',
  `order_factories` tinyint DEFAULT '1',
  `order_due_date` tinyint DEFAULT '1',
  `order_open_date` tinyint DEFAULT '1',
  `est_sippping_date` tinyint DEFAULT '1',
  `order_sales_rep` tinyint DEFAULT '1',
  `order_status` tinyint DEFAULT '1',
  `contact_person` tinyint DEFAULT '1',
  `order_description` tinyint DEFAULT '1',
  `created` tinyint DEFAULT '1',
  `updated` tinyint DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `invoices_on_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(50) NOT NULL,
  `invoice_id` int NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `invoice_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `order_item_id` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `invoice_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `cash_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `debit_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_description` varchar(255) NOT NULL,
  `invoice_ids` varchar(255) NOT NULL,
  `invoice_total` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `in_hand_date_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `pre_date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `new_date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `item_ex_factory_date_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_item_id` int NOT NULL,
  `user_id` int NOT NULL,
  `pre_date` varchar(100) NOT NULL,
  `new_date` varchar(100) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `lead_sources` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_source_name` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `leave_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `annual` int NOT NULL,
  `medical` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `main_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) DEFAULT NULL,
  `style_image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `marketing_campaigns` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `mailchimp_campaign_id` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subject_line` varchar(255) DEFAULT NULL,
  `audience_id` varchar(255) DEFAULT NULL,
  `segment_id` varchar(255) DEFAULT NULL,
  `template_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `send_time` timestamp NULL DEFAULT NULL,
  `emails_sent` int UNSIGNED NOT NULL DEFAULT '0',
  `open_rate` decimal(8,5) DEFAULT NULL,
  `click_rate` decimal(8,5) DEFAULT NULL,
  `mailchimp_data` json DEFAULT NULL,
  `last_synced_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `marketing_campaigns_mailchimp_campaign_id_unique` (`mailchimp_campaign_id`),
  KEY `marketing_campaigns_audience_id_index` (`audience_id`),
  KEY `marketing_campaigns_segment_id_index` (`segment_id`),
  KEY `marketing_campaigns_status_index` (`status`),
  KEY `marketing_campaigns_send_time_index` (`send_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `marketing_contacts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `audience_id` varchar(255) NOT NULL,
  `mailchimp_member_id` varchar(255) DEFAULT NULL,
  `subscriber_hash` varchar(32) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `contact_type` varchar(100) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `sport` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `mailchimp_data` json DEFAULT NULL,
  `last_synced_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `marketing_contacts_audience_email_unique` (`audience_id`,`email`),
  KEY `marketing_contacts_audience_id_index` (`audience_id`),
  KEY `marketing_contacts_mailchimp_member_id_index` (`mailchimp_member_id`),
  KEY `marketing_contacts_subscriber_hash_index` (`subscriber_hash`),
  KEY `marketing_contacts_email_index` (`email`),
  KEY `marketing_contacts_contact_type_index` (`contact_type`),
  KEY `marketing_contacts_platform_index` (`platform`),
  KEY `marketing_contacts_sport_index` (`sport`),
  KEY `marketing_contacts_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `marketing_sync_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `resource_type` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `processed` int UNSIGNED NOT NULL DEFAULT '0',
  `failed` int UNSIGNED NOT NULL DEFAULT '0',
  `message` text,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marketing_sync_logs_resource_type_index` (`resource_type`),
  KEY `marketing_sync_logs_status_index` (`status`),
  KEY `marketing_sync_logs_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `master_fits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fit_name` varchar(255) DEFAULT NULL,
  `description` varchar(3072) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notification_title` varchar(255) DEFAULT NULL,
  `notification_message` longtext,
  `is_read` tinyint NOT NULL DEFAULT '0',
  `user_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `activity_id` int DEFAULT NULL,
  `order_item_id` longtext,
  `check_payment_id` int DEFAULT NULL,
  `venmo_payment_id` int DEFAULT NULL,
  `other_payment_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `is_payment` tinyint NOT NULL DEFAULT '0',
  `is_comment` tinyint NOT NULL DEFAULT '0',
  `is_order_edit` tinyint NOT NULL DEFAULT '0',
  `task_id` int DEFAULT NULL,
  `sub_task_id` int DEFAULT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `task_comments` text,
  `target_field` varchar(300) DEFAULT NULL,
  `comment_mention_id` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `chatDiscussionStatus` int NOT NULL DEFAULT '0',
  `sectionValue` varchar(1000) DEFAULT NULL,
  `is_urgent` int DEFAULT NULL,
  `order_ex_fac_date` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `order_in_hand_due_date` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `order_reject_or_confirm` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;
SQL,
            <<<'SQL'
CREATE TABLE `notification_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_key` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `function_name` varchar(50) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `notification_body` longtext,
  `description` varchar(255) DEFAULT NULL,
  `proccessing_rep` tinyint NOT NULL DEFAULT '0',
  `sales_rep` tinyint NOT NULL DEFAULT '0',
  `related_fac` tinyint DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `notification_template_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notification_template_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int DEFAULT NULL,
  `contact_id` int DEFAULT NULL,
  `order_no` varchar(11) DEFAULT NULL,
  `order_status_id` int DEFAULT '1',
  `user_id` int DEFAULT NULL,
  `order_procesing_user_id` int DEFAULT NULL,
  `sub_total` double(10,2) NOT NULL DEFAULT '0.00',
  `sales_tax` double(10,2) NOT NULL DEFAULT '0.00',
  `shipping` double(10,2) NOT NULL DEFAULT '0.00',
  `artwork` double(10,2) NOT NULL DEFAULT '0.00',
  `processing_fee` double(10,2) NOT NULL DEFAULT '0.00',
  `discountType` int DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `discount_hidation` int DEFAULT NULL,
  `order_total` double(10,2) NOT NULL DEFAULT '0.00',
  `collect_payment_via_ec` int NOT NULL DEFAULT '0',
  `active` tinyint DEFAULT '1',
  `is_editable` tinyint NOT NULL DEFAULT '1',
  `is_requested` tinyint NOT NULL DEFAULT '0',
  `request_reasons` varchar(255) DEFAULT NULL,
  `flag` varchar(50) NOT NULL DEFAULT '#d7dadb',
  `open_date` varchar(20) DEFAULT NULL,
  `due_date` varchar(20) DEFAULT NULL,
  `production_date` varchar(20) DEFAULT NULL,
  `ex_factory_date` varchar(20) DEFAULT NULL,
  `encore_packing_date` varchar(20) DEFAULT NULL,
  `est_delivery_date` varchar(20) DEFAULT NULL,
  `order_description` text,
  `address_type` tinyint NOT NULL DEFAULT '2' COMMENT '1=Direct Ship to Customers, 2=Bulk Ship to Coach, 3=Pick Up, 4=Direct & Pick Up',
  `is_new_shipping_address` tinyint DEFAULT NULL,
  `wl_receiver_name` varchar(100) DEFAULT NULL,
  `apartment` varchar(100) DEFAULT NULL,
  `street` longtext,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `phone_no` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `is_reordered` tinyint NOT NULL DEFAULT '0',
  `order_id` int DEFAULT NULL,
  `order_ref_no` varchar(100) DEFAULT NULL,
  `order_type` tinyint NOT NULL DEFAULT '0' COMMENT '0=Bulk, 1=Team Store',
  `is_urgent` int DEFAULT NULL,
  `factory_confirmation_date` varchar(255) DEFAULT NULL,
  `reject_or_confirm` int DEFAULT NULL,
  `is_studio_item` int NOT NULL DEFAULT '0',
  `studio_item_sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `reject_reason` varchar(250) DEFAULT NULL,
  `suggested_ex_fac_date` varchar(20) DEFAULT NULL,
  `upcoming_status` int NOT NULL DEFAULT '0',
  `write_off_order` tinyint(1) NOT NULL DEFAULT '0',
  `actual_delivery_date` date DEFAULT NULL,
  `plorder` int NOT NULL DEFAULT '0',
  `cancel_reason` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `order_billing_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `order_folders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `order_folder_id` varchar(255) DEFAULT NULL,
  `tech_pack_folder_id` varchar(255) DEFAULT NULL,
  `mockups_folder_id` varchar(255) DEFAULT NULL,
  `production_layouts_folder_id` varchar(255) DEFAULT NULL,
  `production_pics_folder_id` varchar(255) DEFAULT NULL,
  `discussions_folder_id` varchar(255) DEFAULT NULL,
  `test_print_folder_id` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_no` varchar(11) DEFAULT NULL,
  `order_id` varchar(25) DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `sub_product_no` varchar(10) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `factory_id` int DEFAULT NULL,
  `support_agent_id` int DEFAULT NULL,
  `designer_id` int DEFAULT NULL,
  `shipping_method` varchar(50) DEFAULT NULL,
  `ex_factory_id` int DEFAULT NULL,
  `open_date` varchar(20) DEFAULT NULL,
  `close_date` varchar(20) DEFAULT NULL,
  `ex_factory_date` varchar(20) DEFAULT NULL,
  `encore_packing_date` varchar(20) DEFAULT NULL,
  `in_hand_due_date` varchar(20) DEFAULT NULL,
  `production_date` varchar(20) DEFAULT NULL,
  `est_delivery_date` varchar(20) DEFAULT NULL,
  `order_status_id` int DEFAULT NULL,
  `fabric_id` int DEFAULT NULL,
  `clouser_type` int DEFAULT NULL,
  `secondary_fabric_id` int DEFAULT NULL,
  `embellishment_type_id` int DEFAULT NULL,
  `sport` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `unit_price` double(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `extra_size` varchar(50) NOT NULL DEFAULT 'Extra Size One',
  `extra_size_two` varchar(100) DEFAULT 'Extra Size Two',
  `extra_size_three` varchar(100) DEFAULT 'Extra Size Three',
  `double_sided` int DEFAULT NULL,
  `individual_name` int DEFAULT NULL,
  `individual_no` int DEFAULT NULL,
  `pockets` int DEFAULT NULL,
  `zipper_pockets` int DEFAULT NULL,
  `dynamic_details` int DEFAULT NULL,
  `contrast_stratching` int DEFAULT NULL,
  `printing_over_sems` int DEFAULT NULL,
  `test_print_needed` int NOT NULL DEFAULT '0',
  `test_print_due_date` varchar(100) DEFAULT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `tracking_link` varchar(255) DEFAULT NULL,
  `notify_status` tinyint NOT NULL DEFAULT '0' COMMENT '0=not sent, 1=sent	',
  `notified_user_id` int DEFAULT NULL,
  `item_description` varchar(100) DEFAULT NULL,
  `shipped_qty` int DEFAULT NULL,
  `backordered_qty` int DEFAULT NULL,
  `est_shipping_delivery_date` date DEFAULT NULL,
  `product_year` varchar(10) DEFAULT NULL,
  `parent_order_id` int DEFAULT NULL,
  `is_urgent` int DEFAULT NULL,
  `reject_or_confirm` int DEFAULT NULL,
  `reject_reason` varchar(250) DEFAULT NULL,
  `suggested_ex_fac_date` varchar(250) DEFAULT NULL,
  `remake_status` int NOT NULL DEFAULT '0',
  `has_remake_item` int NOT NULL DEFAULT '0',
  `is_studio_item` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `sort_order` varchar(10) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `order_items_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_item_id` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `size_id` int DEFAULT NULL,
  `blanks` int DEFAULT NULL,
  `numseq_one` varchar(7) DEFAULT NULL,
  `numseq_two` varchar(7) DEFAULT NULL,
  `numseq_three` varchar(7) DEFAULT NULL,
  `numseq_four` varchar(7) DEFAULT NULL,
  `numseq_five` varchar(7) DEFAULT NULL,
  `numseq_six` varchar(7) DEFAULT NULL,
  `numseq_seven` varchar(7) DEFAULT NULL,
  `numseq_eight` varchar(7) DEFAULT NULL,
  `numseq_nine` varchar(7) DEFAULT NULL,
  `numseq_ten` varchar(7) DEFAULT NULL,
  `numseq_eleven` varchar(7) DEFAULT NULL,
  `numseq_twelve` varchar(7) DEFAULT NULL,
  `numseq_thirteen` varchar(7) DEFAULT NULL,
  `numseq_fourteen` varchar(7) DEFAULT NULL,
  `numseq_fifteen` varchar(7) DEFAULT NULL,
  `numseq_sixteen` varchar(7) DEFAULT NULL,
  `numseq_seventeen` varchar(7) DEFAULT NULL,
  `numseq_eighteen` varchar(7) DEFAULT NULL,
  `numseq_nineteen` varchar(7) DEFAULT NULL,
  `numseq_twenty` varchar(7) DEFAULT NULL,
  `numseq_twenty_one` varchar(7) DEFAULT NULL,
  `numseq_twenty_two` varchar(7) DEFAULT NULL,
  `numseq_twenty_three` varchar(7) DEFAULT NULL,
  `numseq_twenty_four` varchar(7) DEFAULT NULL,
  `numseq_twenty_five` varchar(7) DEFAULT NULL,
  `numseq_twenty_six` varchar(7) DEFAULT NULL,
  `numseq_twenty_seven` varchar(7) DEFAULT NULL,
  `numseq_twenty_eight` varchar(7) DEFAULT NULL,
  `numseq_twenty_nine` varchar(7) DEFAULT NULL,
  `numseq_thirty` varchar(7) DEFAULT NULL,
  `numseq_thirty_one` varchar(7) DEFAULT NULL,
  `numseq_thirty_two` varchar(7) DEFAULT NULL,
  `numseq_thirty_three` varchar(7) DEFAULT NULL,
  `numseq_thirty_four` varchar(7) DEFAULT NULL,
  `numseq_thirty_five` varchar(7) DEFAULT NULL,
  `numseq_thirty_six` varchar(7) DEFAULT NULL,
  `numseq_thirty_seven` varchar(7) DEFAULT NULL,
  `numseq_thirty_eight` varchar(7) DEFAULT NULL,
  `numseq_thirty_nine` varchar(7) DEFAULT NULL,
  `numseq_forty` varchar(7) DEFAULT NULL,
  `numseq_forty_one` varchar(7) DEFAULT NULL,
  `numseq_forty_two` varchar(7) DEFAULT NULL,
  `numseq_forty_three` varchar(7) DEFAULT NULL,
  `numseq_forty_four` varchar(7) DEFAULT NULL,
  `numseq_forty_five` varchar(7) DEFAULT NULL,
  `numseq_forty_six` varchar(7) DEFAULT NULL,
  `numseq_forty_seven` varchar(7) DEFAULT NULL,
  `numseq_forty_eight` varchar(7) DEFAULT NULL,
  `numseq_forty_nine` varchar(7) DEFAULT NULL,
  `numseq_fifty` varchar(7) DEFAULT NULL,
  `numseq_fifty_one` varchar(7) DEFAULT NULL,
  `numseq_fifty_two` varchar(7) DEFAULT NULL,
  `numseq_fifty_three` varchar(7) DEFAULT NULL,
  `numseq_fifty_four` varchar(7) DEFAULT NULL,
  `numseq_fifty_five` varchar(7) DEFAULT NULL,
  `numseq_fifty_six` varchar(7) DEFAULT NULL,
  `numseq_fifty_seven` varchar(7) DEFAULT NULL,
  `numseq_fifty_eight` varchar(7) DEFAULT NULL,
  `numseq_fifty_nine` varchar(7) DEFAULT NULL,
  `numseq_sixty` varchar(7) DEFAULT NULL,
  `numseq_sixty_one` varchar(7) DEFAULT NULL,
  `numseq_sixty_two` varchar(7) DEFAULT NULL,
  `numseq_sixty_three` varchar(7) DEFAULT NULL,
  `numseq_sixty_four` varchar(7) DEFAULT NULL,
  `numseq_sixty_five` varchar(7) DEFAULT NULL,
  `numseq_sixty_six` varchar(7) DEFAULT NULL,
  `numseq_sixty_seven` varchar(7) DEFAULT NULL,
  `numseq_sixty_eight` varchar(7) DEFAULT NULL,
  `numseq_sixty_nine` varchar(7) DEFAULT NULL,
  `numseq_seventy` varchar(7) DEFAULT NULL,
  `numseq_seventy_one` varchar(7) DEFAULT NULL,
  `numseq_seventy_two` varchar(7) DEFAULT NULL,
  `numseq_seventy_three` varchar(7) DEFAULT NULL,
  `numseq_seventy_four` varchar(7) DEFAULT NULL,
  `numseq_seventy_five` varchar(7) DEFAULT NULL,
  `numseq_seventy_six` varchar(7) DEFAULT NULL,
  `numseq_seventy_seven` varchar(7) DEFAULT NULL,
  `numseq_seventy_eight` varchar(7) DEFAULT NULL,
  `numseq_seventy_nine` varchar(7) DEFAULT NULL,
  `numseq_eighty` varchar(7) DEFAULT NULL,
  `numseq_eighty_one` varchar(7) DEFAULT NULL,
  `numseq_eighty_two` varchar(7) DEFAULT NULL,
  `numseq_eighty_three` varchar(7) DEFAULT NULL,
  `numseq_eighty_four` varchar(7) DEFAULT NULL,
  `numseq_eighty_five` varchar(7) DEFAULT NULL,
  `numseq_eighty_six` varchar(7) DEFAULT NULL,
  `numseq_eighty_seven` varchar(7) DEFAULT NULL,
  `numseq_eighty_eight` varchar(7) DEFAULT NULL,
  `numseq_eighty_nine` varchar(7) DEFAULT NULL,
  `numseq_ninety` varchar(7) DEFAULT NULL,
  `numseq_ninety_one` varchar(7) DEFAULT NULL,
  `numseq_ninety_two` varchar(7) DEFAULT NULL,
  `numseq_ninety_three` varchar(7) DEFAULT NULL,
  `numseq_ninety_four` varchar(7) DEFAULT NULL,
  `numseq_ninety_five` varchar(7) DEFAULT NULL,
  `numseq_ninety_six` varchar(7) DEFAULT NULL,
  `numseq_ninety_seven` varchar(7) DEFAULT NULL,
  `numseq_ninety_eight` varchar(7) DEFAULT NULL,
  `numseq_ninety_nine` varchar(7) DEFAULT NULL,
  `numseq_hundred` varchar(7) DEFAULT NULL,
  `numseq_hundred_one` varchar(7) DEFAULT NULL,
  `numseq_hundred_two` varchar(7) DEFAULT NULL,
  `numseq_hundred_three` varchar(7) DEFAULT NULL,
  `numseq_hundred_four` varchar(7) DEFAULT NULL,
  `numseq_hundred_five` varchar(7) DEFAULT NULL,
  `numseq_hundred_six` varchar(7) DEFAULT NULL,
  `numseq_hundred_seven` varchar(7) DEFAULT NULL,
  `numseq_hundred_eight` varchar(7) DEFAULT NULL,
  `numseq_hundred_nine` varchar(7) DEFAULT NULL,
  `numseq_hundred_ten` varchar(7) DEFAULT NULL,
  `numseq_hundred_eleven` varchar(7) DEFAULT NULL,
  `numseq_hundred_twelve` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirteen` varchar(7) DEFAULT NULL,
  `numseq_hundred_fourteen` varchar(7) DEFAULT NULL,
  `numseq_hundred_fifteen` varchar(7) DEFAULT NULL,
  `numseq_hundred_sixteen` varchar(7) DEFAULT NULL,
  `numseq_hundred_seventeen` varchar(7) DEFAULT NULL,
  `numseq_hundred_eighteen` varchar(7) DEFAULT NULL,
  `numseq_hundred_nineteen` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_one` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_two` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_three` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_four` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_five` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_six` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_seven` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_eight` varchar(7) DEFAULT NULL,
  `numseq_hundred_twenty_nine` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_one` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_two` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_three` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_four` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_five` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_six` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_seven` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_eight` varchar(7) DEFAULT NULL,
  `numseq_hundred_thirty_nine` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_one` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_two` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_three` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_four` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_five` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_six` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_seven` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_eight` varchar(7) DEFAULT NULL,
  `numseq_hundred_forty_nine` varchar(7) DEFAULT NULL,
  `numseq_hundred_fifty` varchar(7) DEFAULT NULL,
  `show_extra` tinyint NOT NULL DEFAULT '0',
  `created_at` varchar(100) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `order_items_detail_player_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_items_detail_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `player_one` varchar(100) DEFAULT NULL,
  `player_two` varchar(100) DEFAULT NULL,
  `player_three` varchar(100) DEFAULT NULL,
  `player_four` varchar(100) DEFAULT NULL,
  `player_five` varchar(100) DEFAULT NULL,
  `player_six` varchar(100) DEFAULT NULL,
  `player_seven` varchar(100) DEFAULT NULL,
  `player_eight` varchar(100) DEFAULT NULL,
  `player_nine` varchar(100) DEFAULT NULL,
  `player_ten` varchar(100) DEFAULT NULL,
  `player_eleven` varchar(100) DEFAULT NULL,
  `player_twelve` varchar(100) DEFAULT NULL,
  `player_thirteen` varchar(100) DEFAULT NULL,
  `player_fourteen` varchar(100) DEFAULT NULL,
  `player_fifteen` varchar(100) DEFAULT NULL,
  `player_sixteen` varchar(100) DEFAULT NULL,
  `player_seventeen` varchar(100) DEFAULT NULL,
  `player_eighteen` varchar(100) DEFAULT NULL,
  `player_nineteen` varchar(100) DEFAULT NULL,
  `player_twenty` varchar(100) DEFAULT NULL,
  `player_twenty_one` varchar(100) DEFAULT NULL,
  `player_twenty_two` varchar(100) DEFAULT NULL,
  `player_twenty_three` varchar(100) DEFAULT NULL,
  `player_twenty_four` varchar(100) DEFAULT NULL,
  `player_twenty_five` varchar(100) DEFAULT NULL,
  `player_twenty_six` varchar(100) DEFAULT NULL,
  `player_twenty_seven` varchar(100) DEFAULT NULL,
  `player_twenty_eight` varchar(100) DEFAULT NULL,
  `player_twenty_nine` varchar(100) DEFAULT NULL,
  `player_thirty` varchar(100) DEFAULT NULL,
  `player_thirty_one` varchar(100) DEFAULT NULL,
  `player_thirty_two` varchar(100) DEFAULT NULL,
  `player_thirty_three` varchar(100) DEFAULT NULL,
  `player_thirty_four` varchar(100) DEFAULT NULL,
  `player_thirty_five` varchar(100) DEFAULT NULL,
  `player_thirty_six` varchar(100) DEFAULT NULL,
  `player_thirty_seven` varchar(100) DEFAULT NULL,
  `player_thirty_eight` varchar(100) DEFAULT NULL,
  `player_thirty_nine` varchar(100) DEFAULT NULL,
  `player_forty` varchar(100) DEFAULT NULL,
  `player_forty_one` varchar(100) DEFAULT NULL,
  `player_forty_two` varchar(100) DEFAULT NULL,
  `player_forty_three` varchar(100) DEFAULT NULL,
  `player_forty_four` varchar(100) DEFAULT NULL,
  `player_forty_five` varchar(100) DEFAULT NULL,
  `player_forty_six` varchar(100) DEFAULT NULL,
  `player_forty_seven` varchar(100) DEFAULT NULL,
  `player_forty_eight` varchar(100) DEFAULT NULL,
  `player_forty_nine` varchar(100) DEFAULT NULL,
  `player_fifty` varchar(100) DEFAULT NULL,
  `player_fifty_one` varchar(100) DEFAULT NULL,
  `player_fifty_two` varchar(100) DEFAULT NULL,
  `player_fifty_three` varchar(100) DEFAULT NULL,
  `player_fifty_four` varchar(100) DEFAULT NULL,
  `player_fifty_five` varchar(100) DEFAULT NULL,
  `player_fifty_six` varchar(100) DEFAULT NULL,
  `player_fifty_seven` varchar(100) DEFAULT NULL,
  `player_fifty_eight` varchar(100) DEFAULT NULL,
  `player_fifty_nine` varchar(100) DEFAULT NULL,
  `player_sixty` varchar(100) DEFAULT NULL,
  `player_sixty_one` varchar(100) DEFAULT NULL,
  `player_sixty_two` varchar(100) DEFAULT NULL,
  `player_sixty_three` varchar(100) DEFAULT NULL,
  `player_sixty_four` varchar(100) DEFAULT NULL,
  `player_sixty_five` varchar(100) DEFAULT NULL,
  `player_sixty_six` varchar(100) DEFAULT NULL,
  `player_sixty_seven` varchar(100) DEFAULT NULL,
  `player_sixty_eight` varchar(100) DEFAULT NULL,
  `player_sixty_nine` varchar(100) DEFAULT NULL,
  `player_seventy` varchar(100) DEFAULT NULL,
  `player_seventy_one` varchar(100) DEFAULT NULL,
  `player_seventy_two` varchar(100) DEFAULT NULL,
  `player_seventy_three` varchar(100) DEFAULT NULL,
  `player_seventy_four` varchar(100) DEFAULT NULL,
  `player_seventy_five` varchar(100) DEFAULT NULL,
  `player_seventy_six` varchar(100) DEFAULT NULL,
  `player_seventy_seven` varchar(100) DEFAULT NULL,
  `player_seventy_eight` varchar(100) DEFAULT NULL,
  `player_seventy_nine` varchar(100) DEFAULT NULL,
  `player_eighty` varchar(100) DEFAULT NULL,
  `player_eighty_one` varchar(100) DEFAULT NULL,
  `player_eighty_two` varchar(100) DEFAULT NULL,
  `player_eighty_three` varchar(100) DEFAULT NULL,
  `player_eighty_four` varchar(100) DEFAULT NULL,
  `player_eighty_five` varchar(100) DEFAULT NULL,
  `player_eighty_six` varchar(100) DEFAULT NULL,
  `player_eighty_seven` varchar(100) DEFAULT NULL,
  `player_eighty_eight` varchar(100) DEFAULT NULL,
  `player_eighty_nine` varchar(100) DEFAULT NULL,
  `player_ninety` varchar(100) DEFAULT NULL,
  `player_ninety_one` varchar(100) DEFAULT NULL,
  `player_ninety_two` varchar(100) DEFAULT NULL,
  `player_ninety_three` varchar(100) DEFAULT NULL,
  `player_ninety_four` varchar(100) DEFAULT NULL,
  `player_ninety_five` varchar(100) DEFAULT NULL,
  `player_ninety_six` varchar(100) DEFAULT NULL,
  `player_ninety_seven` varchar(100) DEFAULT NULL,
  `player_ninety_eight` varchar(100) DEFAULT NULL,
  `player_ninety_nine` varchar(100) DEFAULT NULL,
  `player_hundred` varchar(100) DEFAULT NULL,
  `player_hundred_one` varchar(100) DEFAULT NULL,
  `player_hundred_two` varchar(100) DEFAULT NULL,
  `player_hundred_three` varchar(100) DEFAULT NULL,
  `player_hundred_four` varchar(100) DEFAULT NULL,
  `player_hundred_five` varchar(100) DEFAULT NULL,
  `player_hundred_six` varchar(100) DEFAULT NULL,
  `player_hundred_seven` varchar(100) DEFAULT NULL,
  `player_hundred_eight` varchar(100) DEFAULT NULL,
  `player_hundred_nine` varchar(100) DEFAULT NULL,
  `player_hundred_ten` varchar(100) DEFAULT NULL,
  `player_hundred_eleven` varchar(100) DEFAULT NULL,
  `player_hundred_twelve` varchar(100) DEFAULT NULL,
  `player_hundred_thirteen` varchar(100) DEFAULT NULL,
  `player_hundred_fourteen` varchar(100) DEFAULT NULL,
  `player_hundred_fifteen` varchar(100) DEFAULT NULL,
  `player_hundred_sixteen` varchar(100) DEFAULT NULL,
  `player_hundred_seventeen` varchar(100) DEFAULT NULL,
  `player_hundred_eighteen` varchar(100) DEFAULT NULL,
  `player_hundred_nineteen` varchar(100) DEFAULT NULL,
  `player_hundred_twenty` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_one` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_two` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_three` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_four` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_five` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_six` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_seven` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_eight` varchar(100) DEFAULT NULL,
  `player_hundred_twenty_nine` varchar(100) DEFAULT NULL,
  `player_hundred_thirty` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_one` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_two` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_three` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_four` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_five` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_six` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_seven` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_eight` varchar(100) DEFAULT NULL,
  `player_hundred_thirty_nine` varchar(100) DEFAULT NULL,
  `player_hundred_forty` varchar(100) DEFAULT NULL,
  `player_hundred_forty_one` varchar(100) DEFAULT NULL,
  `player_hundred_forty_two` varchar(100) DEFAULT NULL,
  `player_hundred_forty_three` varchar(100) DEFAULT NULL,
  `player_hundred_forty_four` varchar(100) DEFAULT NULL,
  `player_hundred_forty_five` varchar(100) DEFAULT NULL,
  `player_hundred_forty_six` varchar(100) DEFAULT NULL,
  `player_hundred_forty_seven` varchar(100) DEFAULT NULL,
  `player_hundred_forty_eight` varchar(100) DEFAULT NULL,
  `player_hundred_forty_nine` varchar(100) DEFAULT NULL,
  `player_hundred_fifty` varchar(100) DEFAULT NULL,
  `number_sequence` int DEFAULT NULL,
  `blank_qty` int NOT NULL DEFAULT '0',
  `blank_player_names` text,
  `name` varchar(100) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `order_item_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_item_id` int DEFAULT NULL,
  `attribute_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `order_item_attribute_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_item_id` int NOT NULL,
  `attribute_group_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `order_item_files` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `organization_id` int NOT NULL,
  `contact_id` int NOT NULL,
  `order_id` int NOT NULL,
  `order_item_id` int NOT NULL,
  `mockup_files` text,
  `mockup_file_name` text,
  `mockup_images` text,
  `mockup_image_name` text,
  `tech_pack_files` text,
  `tech_pack_file_name` text,
  `tech_pack_images` text,
  `tech_pack_image_name` text,
  `production_layout_files` text,
  `production_layout_file_name` text,
  `production_layout_images` text,
  `production_layout_image_name` text,
  `product_picture_raw_images` text,
  `product_picture_raw_image_name` text,
  `product_picture_edited_images` text,
  `product_picture_edited_image_name` text,
  `factory_photos_files` text,
  `factory_photos_file_name` text,
  `factory_photos_images` text,
  `factory_photos_image_name` text,
  `cropped_photos_files` text,
  `cropped_photos_file_name` text,
  `test_print_images` text,
  `test_print_image_name` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `order_item_sub_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_item_id` int DEFAULT NULL,
  `attribute_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `order_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `order_flag` tinyint DEFAULT '1',
  `order_no` tinyint DEFAULT '1',
  `order_organization` tinyint DEFAULT '1',
  `order_factories` tinyint DEFAULT '1',
  `order_due_date` tinyint DEFAULT '1',
  `order_open_date` tinyint DEFAULT '1',
  `est_sippping_date` tinyint DEFAULT '1',
  `order_sales_rep` tinyint DEFAULT '1',
  `order_total` tinyint DEFAULT '1',
  `order_status` tinyint DEFAULT '1',
  `contact_person` tinyint DEFAULT '1',
  `order_description` tinyint DEFAULT '1',
  `sub_total` tinyint DEFAULT '1',
  `sales_tax` tinyint DEFAULT '1',
  `shipping` tinyint DEFAULT '1',
  `artwork` tinyint DEFAULT '1',
  `processing_fee` tinyint DEFAULT '1',
  `payment_status` tinyint DEFAULT '1',
  `team_store_file` tinyint DEFAULT '1',
  `created` tinyint DEFAULT '1',
  `updated` tinyint DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `order_payment_update_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `invoice_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `artwork` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_availability` int NOT NULL DEFAULT '0',
  `discount_type` int DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sales_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `card_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `check_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venmo_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paypal_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `po_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `other_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_processing_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `order_shedule_colors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `color_code` varchar(50) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `order_shedule_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `special_comment` longtext,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `order_shipping_addresses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `apartment` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address_type` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `order_statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `organizations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `sport` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `size_of_club` varchar(50) DEFAULT NULL,
  `colors` varchar(50) DEFAULT NULL,
  `organization_logo` varchar(255) DEFAULT NULL,
  `shipping_po_box` varchar(1024) DEFAULT NULL,
  `shipping_street` longtext,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(50) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `shipping_country` varchar(50) DEFAULT NULL,
  `same_as_shipping_address` int NOT NULL DEFAULT '1',
  `sales_tax` double(10,3) DEFAULT '0.000',
  `sales_tax_active` tinyint DEFAULT NULL,
  `lead_source` int DEFAULT NULL,
  `received_sample` timestamp NULL DEFAULT NULL,
  `received_samples_note` text,
  `ordering_timeline` varchar(255) DEFAULT NULL,
  `pl_status` int NOT NULL DEFAULT '0',
  `organization_note` longtext,
  `internal_team` int NOT NULL DEFAULT '0',
  `active` tinyint DEFAULT NULL,
  `unique_password` varchar(255) DEFAULT NULL,
  `password_text` varchar(255) DEFAULT NULL,
  `debit_balance` decimal(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `same_as_shipping` tinyint(1) NOT NULL DEFAULT '0',
  `billing_country` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_street` varchar(255) DEFAULT NULL,
  `billing_postal_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;
SQL,
            <<<'SQL'
CREATE TABLE `organization_colors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int DEFAULT NULL,
  `color_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `organization_emails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `organization_id` int NOT NULL,
  `sender` varchar(300) DEFAULT NULL,
  `sender_email` varchar(100) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `email_id` text,
  `message_no` varchar(400) NOT NULL,
  `conversation_id` varchar(400) DEFAULT NULL,
  `internetmessage_id` varchar(400) DEFAULT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `body` longtext NOT NULL,
  `toRecipients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ccRecipients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `bccRecipients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `date` datetime DEFAULT NULL,
  `active` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `organization_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `organization_name` tinyint DEFAULT NULL,
  `website` tinyint DEFAULT NULL,
  `email` tinyint DEFAULT NULL,
  `sport` tinyint DEFAULT NULL,
  `user` tinyint DEFAULT NULL,
  `size_of_club` tinyint DEFAULT NULL,
  `colors` tinyint DEFAULT NULL,
  `organization_logo` tinyint DEFAULT NULL,
  `shipping_po_box` tinyint DEFAULT NULL,
  `shipping_street` tinyint DEFAULT NULL,
  `shipping_city` tinyint DEFAULT NULL,
  `shipping_state` tinyint DEFAULT NULL,
  `shipping_postal_code` tinyint DEFAULT NULL,
  `shipping_country` tinyint DEFAULT NULL,
  `sales_tax` tinyint DEFAULT NULL,
  `sales_tax_active` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `organization_received_samples` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int NOT NULL,
  `product_id` int NOT NULL,
  `active` tinyint DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `organization_stores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int NOT NULL,
  `store_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cover_pic` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `profile_pic` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `store_sport` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `store_description` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `active_status` int DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `organization_store_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_store_id` int NOT NULL,
  `product_id` int NOT NULL,
  `in_stock_status` int NOT NULL,
  `sku_no` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `discount` float(10,2) DEFAULT NULL,
  `short_description` varchar(10000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `pic_one` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `pic_two` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `pic_three` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `category` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `active_status` int DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `organization_store_product_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_store_product_id` int NOT NULL,
  `size_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `other_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `is_approved` int NOT NULL DEFAULT '1',
  `amount` float(10,2) NOT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `document_url_back` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `is_bulk` int NOT NULL DEFAULT '0',
  `from_debit` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pattern_codes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_product_id` int DEFAULT NULL,
  `sub_product_id` int DEFAULT NULL,
  `pattern_code` varchar(50) DEFAULT NULL,
  `pattern_attribute` text,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pattern_code_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `pattern_code` tinyint DEFAULT NULL,
  `product_name` tinyint DEFAULT NULL,
  `attribute_name` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `payment_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `amount` float(8,2) DEFAULT NULL,
  `name_on_card` varchar(100) DEFAULT NULL,
  `response_code` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `auth_id` varchar(100) DEFAULT NULL,
  `message_code` varchar(100) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `auto_generated` int NOT NULL DEFAULT '0',
  `store_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `paypal_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `paypal_receipt` varchar(255) DEFAULT NULL,
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `amount` float(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reject_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `people_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `first_name` tinyint DEFAULT NULL,
  `last_name` tinyint DEFAULT NULL,
  `organization_id` tinyint DEFAULT NULL,
  `lead_source` tinyint DEFAULT NULL,
  `phone_no` tinyint DEFAULT NULL,
  `personal_phone_no` tinyint DEFAULT NULL,
  `email` tinyint DEFAULT NULL,
  `title` tinyint DEFAULT NULL,
  `user` tinyint DEFAULT NULL,
  `shipping_po_box` tinyint DEFAULT NULL,
  `shipping_street` tinyint DEFAULT NULL,
  `shipping_city` tinyint DEFAULT NULL,
  `shipping_state` tinyint DEFAULT NULL,
  `shipping_zip` tinyint DEFAULT NULL,
  `shipping_country` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pipedrive_activities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `done` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `deal` varchar(255) DEFAULT NULL,
  `note` longtext,
  `contact_name` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `due_date` varchar(20) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `assigned_user_name` varchar(50) DEFAULT NULL,
  `is_synced` int NOT NULL DEFAULT '0',
  `active` tinyint DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pipedrive_contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_id` int DEFAULT NULL,
  `is_synced` tinyint NOT NULL DEFAULT '0',
  `label` varchar(50) DEFAULT NULL,
  `pd_organization` varchar(255) DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `no_of_closed_deals` int DEFAULT NULL,
  `no_of_opened_deals` int DEFAULT NULL,
  `next_activity_date` varchar(20) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `pd_created_date` varchar(50) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pipedrive_organizations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(255) DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `is_synced` tinyint NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `size_of_club` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `no_of_people` int DEFAULT NULL,
  `no_of_closed_deals` int DEFAULT NULL,
  `no_of_opened_deals` int DEFAULT NULL,
  `next_activity_date` varchar(20) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pm_inboxes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `section_id` int DEFAULT NULL,
  `discussion_id` int DEFAULT NULL,
  `is_sub_discussion` tinyint NOT NULL DEFAULT '0',
  `sub_discussion_id` int DEFAULT NULL,
  `is_comment` tinyint NOT NULL DEFAULT '0',
  `comment_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `assigned_by` int DEFAULT NULL,
  `is_read` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pm_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `sort_index` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pm_section_discussions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL,
  `project_id` int NOT NULL,
  `assignee_id` int DEFAULT NULL,
  `assigned_by` int DEFAULT NULL,
  `discussion_name` varchar(255) DEFAULT NULL,
  `discussion_description` text,
  `due_date` date DEFAULT NULL,
  `is_completed` tinyint NOT NULL DEFAULT '0',
  `priority` enum('Critical','High','Medium','Low') NOT NULL DEFAULT 'Medium',
  `user_id` int NOT NULL,
  `sort_index` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pm_section_discussion_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL,
  `project_id` int NOT NULL,
  `section_discussion_id` int DEFAULT NULL,
  `is_sub_discussion` tinyint NOT NULL DEFAULT '0',
  `sub_section_discussion_id` int DEFAULT NULL,
  `comment` text,
  `date` datetime DEFAULT NULL,
  `is_liked` tinyint NOT NULL DEFAULT '0',
  `mentioned_groups` text,
  `mentioned_users` text,
  `user_id` int DEFAULT NULL,
  `edit_count` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pm_section_sub_discussions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL,
  `project_id` int NOT NULL,
  `assignee_id` int DEFAULT NULL,
  `assigned_by` int DEFAULT NULL,
  `discussion_id` int NOT NULL,
  `discussion_name` varchar(255) DEFAULT NULL,
  `discussion_description` text,
  `due_date` date DEFAULT NULL,
  `is_completed` tinyint NOT NULL DEFAULT '0',
  `priority` enum('Critical','High','Medium','Low') NOT NULL DEFAULT 'Medium',
  `user_id` int NOT NULL,
  `sort_index` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `pm_task_assignees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `section_id` int DEFAULT NULL,
  `discussion_id` int DEFAULT NULL,
  `is_sub_discussion` tinyint NOT NULL DEFAULT '0',
  `sub_discussion_id` int DEFAULT NULL,
  `assignee_id` int NOT NULL,
  `assigned_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `prices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `price_type` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `price_temps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `price_type` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `product_level` int DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `price_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `production_approval_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `ip_address` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `show_in_catalog_name` varchar(255) DEFAULT NULL,
  `product_no` varchar(10) DEFAULT NULL,
  `pattern_code` varchar(50) DEFAULT NULL,
  `product_category_id` varchar(255) DEFAULT NULL,
  `main_category_id` int DEFAULT NULL,
  `sport` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `MOQ` int DEFAULT NULL,
  `default_price` decimal(10,2) DEFAULT '0.00',
  `size_id` int DEFAULT NULL,
  `standard_fabric` varchar(255) DEFAULT NULL,
  `fabric_options` varchar(255) DEFAULT NULL,
  `attributes` varchar(255) DEFAULT NULL,
  `type_of_embellishment` varchar(255) DEFAULT NULL,
  `factory` varchar(100) DEFAULT NULL,
  `description` text,
  `who_we_made_this_for` varchar(3072) DEFAULT NULL,
  `product_features` varchar(3072) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `fabric_id` int DEFAULT NULL,
  `weight` decimal(10,3) DEFAULT NULL,
  `mockup_img` varchar(100) DEFAULT NULL,
  `mockup_img_1` varchar(255) DEFAULT NULL,
  `mockup_img_2` varchar(255) DEFAULT NULL,
  `mockup_img_3` varchar(255) DEFAULT NULL,
  `mockup_caption_1` varchar(3072) DEFAULT NULL,
  `mockup_caption_2` varchar(3072) DEFAULT NULL,
  `mockup_caption_3` varchar(3072) DEFAULT NULL,
  `product_reference_link` varchar(255) DEFAULT NULL,
  `2D_mockup` varchar(255) DEFAULT NULL,
  `3D_mockup` varchar(255) DEFAULT NULL,
  `tech_pack` varchar(255) DEFAULT NULL,
  `measurement` varchar(255) DEFAULT NULL,
  `product_layout` varchar(255) DEFAULT NULL,
  `pattern` varchar(255) DEFAULT NULL,
  `technical_tech_pack` varchar(255) DEFAULT NULL,
  `size_chart` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `show_in_catalog` int NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fits_true_to_size` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `products_temp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` bigint DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `show_in_catalog_name` varchar(255) DEFAULT NULL,
  `product_no` varchar(100) DEFAULT NULL,
  `pattern_code` varchar(100) DEFAULT NULL,
  `product_category_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `main_category_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `gender` varchar(50) DEFAULT NULL,
  `MOQ` int DEFAULT NULL,
  `default_price` decimal(10,2) DEFAULT NULL,
  `standard_fabric` varchar(255) DEFAULT NULL,
  `fabric_options` text,
  `type_of_embellishment` varchar(255) DEFAULT NULL,
  `description` text,
  `who_we_made_this_for` text,
  `product_features` text,
  `notes` text,
  `weight` varchar(50) DEFAULT NULL,
  `mockup_img` varchar(255) DEFAULT NULL,
  `mockup_img_1` varchar(255) DEFAULT NULL,
  `mockup_img_2` varchar(255) DEFAULT NULL,
  `mockup_img_3` varchar(255) DEFAULT NULL,
  `mockup_caption_1` varchar(255) DEFAULT NULL,
  `mockup_caption_2` varchar(255) DEFAULT NULL,
  `mockup_caption_3` varchar(255) DEFAULT NULL,
  `product_reference_link` text,
  `2D_mockup` varchar(255) DEFAULT NULL,
  `3D_mockup` varchar(255) DEFAULT NULL,
  `tech_pack` varchar(255) DEFAULT NULL,
  `measurement` varchar(255) DEFAULT NULL,
  `product_layout` varchar(255) DEFAULT NULL,
  `pattern` varchar(255) DEFAULT NULL,
  `technical_tech_pack` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `show_in_catalog` tinyint(1) DEFAULT '1',
  `fits_true_to_size` tinyint(1) DEFAULT NULL,
  `attribute_on_price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `size_id` int DEFAULT NULL,
  `size_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_size_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `fabric_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sport_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_category_list_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_attribute_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_factory_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_tagline_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_fit_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `new_default_price` decimal(10,0) DEFAULT NULL,
  `transferred` int DEFAULT NULL COMMENT 'product transferred to master table',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `product_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `attribute_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_catalog_tempory_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `product_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_category_name` varchar(255) DEFAULT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_category_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_category_name` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_category_lists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `product_category_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_catlog_quotes` (
  `id` int NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `product_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `qty` int DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `est_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `product_embellishment_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `embellishment_type_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_fabrics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `fabric_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_factories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `product_factory_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_fits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `fit_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `image_type` int DEFAULT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `image_name` varchar(250) DEFAULT NULL,
  `image_caption` varchar(3072) DEFAULT NULL,
  `active` int DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_image_temps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_type` int NOT NULL,
  `image_link` varchar(255) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_caption` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `product_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_name` tinyint DEFAULT NULL,
  `product_no` tinyint DEFAULT NULL,
  `product_category_id` tinyint DEFAULT NULL,
  `main_category_id` tinyint DEFAULT NULL,
  `sport` tinyint DEFAULT NULL,
  `gender` tinyint DEFAULT NULL,
  `default_price` tinyint DEFAULT NULL,
  `pattern_code` tinyint DEFAULT NULL,
  `product_size` tinyint DEFAULT NULL,
  `standard_fabric` tinyint NOT NULL,
  `fabric_options` tinyint DEFAULT NULL,
  `embellishment_options` tinyint DEFAULT NULL,
  `attributes` tinyint DEFAULT NULL,
  `weight` tinyint DEFAULT NULL,
  `factories` tinyint DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `description` tinyint DEFAULT NULL,
  `notes` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_main_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `main_category_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `product_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `size_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_sports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `sport_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `product_taglines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tagline_name` varchar(255) DEFAULT NULL,
  `description` varchar(3072) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `product_tagline_lists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `tagline_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `projects` (
  `project_status_id` varchar(50) DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) DEFAULT NULL,
  `project_no` varchar(25) DEFAULT NULL,
  `project_description` varchar(255) DEFAULT NULL,
  `project_assignee` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `project_assignee_users` text,
  `project_assignee_groups` text,
  `project_type_id` varchar(50) DEFAULT NULL,
  `project_color` varchar(50) DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `projectDetail` text,
  `project_icon_url` text,
  `status` int DEFAULT NULL COMMENT 'created by using project management tab',
  `product_level` int DEFAULT NULL COMMENT 'product level->1 - main product, 2 sub product',
  `created_by` int DEFAULT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `project_icons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `icon` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `project_statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `project_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `purchaseorder_receipts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `amount` float NOT NULL,
  `receipt` varchar(255) NOT NULL,
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reject_reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `quickbooks_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `refresh_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `realm_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_token_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `quickbook_records` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `is_refund` int NOT NULL DEFAULT '0',
  `record_id` int DEFAULT NULL,
  `transaction_created_at` timestamp NULL DEFAULT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `send_later` int NOT NULL DEFAULT '1',
  `receipt_date` date DEFAULT NULL,
  `billing_address` text,
  `shipping_address` text,
  `ship_via` varchar(255) DEFAULT NULL,
  `shipping_date` date DEFAULT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `sales_rep` varchar(255) DEFAULT NULL,
  `shipping_from` varchar(255) DEFAULT NULL,
  `payment_method_id` varchar(50) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `deposit_account_id` varchar(50) DEFAULT NULL,
  `line_items` longtext,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sales_receipt_id` varchar(50) DEFAULT NULL,
  `from_tsr_module` int NOT NULL DEFAULT '0',
  `qb_doc_number` varchar(50) DEFAULT NULL,
  `qb_sync_token` varchar(50) DEFAULT NULL,
  `qb_raw_response` longtext,
  `export_status` tinyint DEFAULT '0' COMMENT '0=Saved,1=Exported,2=Failed',
  `error_message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `remake_order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shipping_order_details_id` int NOT NULL,
  `order_id` varchar(25) NOT NULL,
  `order_item_id` int NOT NULL,
  `size_id` int NOT NULL,
  `player_name` varchar(100) DEFAULT NULL,
  `player_nunmber` int DEFAULT NULL,
  `est_delivery_date` varchar(20) NOT NULL,
  `ex_factory_date` varchar(20) NOT NULL,
  `qty` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `reason` varchar(100) DEFAULT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `narration` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `saved_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `end_date` varchar(20) NOT NULL,
  `rep_id` int NOT NULL,
  `processing_rep_id` int NOT NULL,
  `sport` varchar(50) NOT NULL,
  `lead_type_id` int NOT NULL,
  `sale_type` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `product_id` int NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `shared_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `share_path` varchar(255) DEFAULT NULL,
  `share_type` tinyint DEFAULT NULL,
  `owner_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `shipped_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `order_item_id` int NOT NULL,
  `order_item_qty` int NOT NULL,
  `order_item_shipped_qty` int NOT NULL,
  `order_item_backordered_qty` int NOT NULL,
  `est_delivery_date` date NOT NULL,
  `order_item_tracking_no` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `shipping_information` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `est_delivery_date` date DEFAULT NULL,
  `tracking_no` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tracking_link` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `notify_status` tinyint NOT NULL DEFAULT '0',
  `created_by` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `shipping_notification_drafts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `send_to` text,
  `copy_to` text,
  `subject` text,
  `message` text,
  `items` text,
  `status` tinyint NOT NULL COMMENT '0 = inactive,\r\n1 = active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `shipping_order_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `shipping_information_id` int DEFAULT NULL,
  `order_id` int NOT NULL,
  `order_item_id` int NOT NULL,
  `order_item_detail_id` int NOT NULL,
  `size_id` int NOT NULL,
  `size_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `has_blank_qty` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'has blanks = yes, has no blanks = no',
  `has_blank_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'no' COMMENT 'has blank names = yes, has no blank names = no',
  `order_qty` int NOT NULL,
  `shipped_qty` int DEFAULT NULL,
  `back_ordered_qty` int DEFAULT NULL,
  `is_back_ordered` tinyint NOT NULL DEFAULT '0',
  `initail_order_qty` int DEFAULT NULL,
  `seq_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'related field name of the player name table',
  `player_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'player name ',
  `seq_number` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'related field name for the player number in order_items_details table',
  `player_number` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'player number',
  `est_delivery_date` date DEFAULT NULL,
  `tracking_no` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `CourierService` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tracking_link` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `notify_status` tinyint NOT NULL DEFAULT '0',
  `is_saved` tinyint NOT NULL DEFAULT '0',
  `notified_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `size_name` varchar(50) DEFAULT NULL,
  `size_type` int DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `size_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `size_name` tinyint DEFAULT NULL,
  `size_type` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `size_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(111) NOT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `sizing_fits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `size_id` int DEFAULT NULL,
  `size_from` varchar(255) DEFAULT NULL,
  `size_to` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size_type` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `sports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sport_name` varchar(50) DEFAULT NULL,
  `sport_image` varchar(300) DEFAULT NULL,
  `catalog_image` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `statement_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` tinyint DEFAULT '1',
  `order_no` tinyint DEFAULT '1',
  `payment_type` tinyint DEFAULT '1',
  `transaction_type` tinyint DEFAULT '1',
  `note` tinyint DEFAULT '1',
  `amount` tinyint DEFAULT '1',
  `payment` tinyint DEFAULT '1',
  `paid_processing_fee` tinyint DEFAULT '1',
  `total_paid_amount` tinyint DEFAULT '1',
  `debit_entry` tinyint DEFAULT '1',
  `balance` tinyint DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `stores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organization_id` int DEFAULT NULL,
  `sport_id` int DEFAULT NULL,
  `store_name` varchar(255) NOT NULL,
  `salese_person` int DEFAULT NULL,
  `direct_access_url` varchar(255) DEFAULT NULL,
  `product_prefix` varchar(255) DEFAULT NULL,
  `set_store_deadline` int NOT NULL DEFAULT '1',
  `open_date` varchar(20) DEFAULT NULL,
  `close_date` varchar(20) DEFAULT NULL,
  `contact_coach_id` int DEFAULT NULL,
  `coach_name` varchar(100) DEFAULT NULL,
  `coach_email` varchar(255) DEFAULT NULL,
  `sales_assistant` int DEFAULT NULL,
  `service_phone` varchar(20) DEFAULT NULL,
  `service_website` varchar(255) DEFAULT NULL,
  `service_email` varchar(255) DEFAULT NULL,
  `shipping_method` int DEFAULT NULL,
  `sales_tax` decimal(10,2) DEFAULT '0.00',
  `handling_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `service_charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `other` decimal(10,2) NOT NULL DEFAULT '0.00',
  `store_amount` float(10,2) DEFAULT NULL,
  `store_status` int NOT NULL DEFAULT '1' COMMENT '1 = open, 2 = closed, 3 = archived',
  `send_closing_soon_email` int NOT NULL DEFAULT '1',
  `send_store_close_email` int NOT NULL DEFAULT '1',
  `send_order_production_completed_email` int NOT NULL DEFAULT '1',
  `send_final_update_email` int NOT NULL DEFAULT '1',
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_added_coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `coupon_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_added_custom_informations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `custom_information_id` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_added_shipping_methods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `shipping_method` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_added_tax_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `tax_category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_card_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) DEFAULT NULL,
  `store_id` int NOT NULL,
  `store_order_no` varchar(100) NOT NULL,
  `card_owner` varchar(255) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `processing_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_success` int NOT NULL DEFAULT '0',
  `is_refund` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `store_product_id` int DEFAULT NULL,
  `store_id` int DEFAULT NULL,
  `sub_team` varchar(255) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `store_cart_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_cart_id` int NOT NULL,
  `store_id` int NOT NULL,
  `store_product_id` int NOT NULL,
  `size_id` int DEFAULT NULL,
  `custom_name` varchar(10) DEFAULT NULL,
  `custom_number` int DEFAULT NULL,
  `product_variant` varchar(255) DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `type` int DEFAULT NULL COMMENT '1 = single\r\n2 = multiple',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `store_cart_item_name_number` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int DEFAULT NULL,
  `store_product_id` int DEFAULT NULL,
  `session_id` varchar(250) DEFAULT NULL,
  `store_cart_item_id` int NOT NULL,
  `customer_number` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `type` int DEFAULT NULL COMMENT '1 = single \r\n2 = multiple',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sub_team` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `store_category_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `order_array` varchar(255) NOT NULL,
  `all_category_product_order` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_coach_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` bigint UNSIGNED NOT NULL,
  `request_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coach_name` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coach_email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_count` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `processing_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_success` tinyint(1) NOT NULL DEFAULT '0',
  `card_owner` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_digits` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_response_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_reason_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_message` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_store_coach_payment_uuid` (`request_uuid`),
  UNIQUE KEY `uq_store_coach_payment_token` (`payment_token`),
  KEY `ix_store_coach_payment_store` (`store_id`,`created_at`),
  KEY `ix_store_coach_payment_status` (`store_id`,`status`,`is_success`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_coupons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int DEFAULT NULL,
  `coupon_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'flat_from_sub',
  `amount` float(10,2) NOT NULL DEFAULT '0.00',
  `coupon_code` varchar(100) DEFAULT NULL,
  `limit_coupon_usage` int NOT NULL DEFAULT '0',
  `coupon_valid_times` int NOT NULL DEFAULT '1',
  `expire_date` varchar(200) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `store_id` int DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` int DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `is_shipping_address_available` int NOT NULL DEFAULT '0',
  `shipping_first_name` varchar(100) DEFAULT NULL,
  `shipping_last_name` varchar(100) DEFAULT NULL,
  `shipping_street` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `shipping_postal_code` varchar(255) DEFAULT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(100) DEFAULT NULL,
  `option_1` varchar(255) DEFAULT NULL,
  `option_2` varchar(255) DEFAULT NULL,
  `option_3` varchar(255) DEFAULT NULL,
  `is_ordered` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `store_customer_custom_informations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `custom_information_id` int NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_custom_informations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int DEFAULT NULL,
  `custom_name` varchar(255) NOT NULL,
  `make_as_sub_team` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '1' COMMENT '1 = ''input_text'', \r\n2=''select'', \r\n3=''input_number''',
  `options` longtext,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_custom_information_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_name` varchar(100) DEFAULT NULL,
  `custom_information_ids` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_email_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_flyers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `flyer_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `website` varchar(100) NOT NULL,
  `flyer_url` varchar(100) NOT NULL,
  `layout_type` int NOT NULL DEFAULT '1',
  `logo_size` int NOT NULL DEFAULT '1',
  `flyer_message` longtext,
  `show_instructions` int NOT NULL DEFAULT '1',
  `show_prices` int NOT NULL DEFAULT '1',
  `show_description` int NOT NULL DEFAULT '1',
  `include_ship_date` int NOT NULL DEFAULT '1',
  `include_store_deadline` int NOT NULL DEFAULT '1',
  `include_qr_code` int NOT NULL DEFAULT '1',
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_group_accesses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_individual_names` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `store_product_id` int NOT NULL,
  `name_required` int NOT NULL DEFAULT '0',
  `name_exlusive` int NOT NULL DEFAULT '0',
  `name_not_for_printing` int NOT NULL DEFAULT '0',
  `name_extra_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `name_character_limit` int NOT NULL DEFAULT '6',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_individual_numbers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `store_product_id` int NOT NULL,
  `number_required` int NOT NULL DEFAULT '0',
  `number_exlusive` int NOT NULL DEFAULT '0',
  `number_extra_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `number_type` varchar(50) NOT NULL DEFAULT '"0-99"',
  `min_number_count` int DEFAULT NULL,
  `max_number_count` int DEFAULT NULL,
  `min_number` int DEFAULT NULL,
  `max_number` int DEFAULT NULL,
  `exclude_numbers` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_no` varchar(10) DEFAULT NULL,
  `shippo_order_id` varchar(200) DEFAULT NULL,
  `store_id` int NOT NULL,
  `store_customer_id` int DEFAULT NULL,
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `handling_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sales_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_invoice_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_processing_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `coupon_code` varchar(100) DEFAULT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(100) NOT NULL,
  `shipping_method` int NOT NULL DEFAULT '3',
  `is_shipping_removed` int NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `notes` longtext,
  `tracking_no` varchar(255) DEFAULT NULL,
  `tracking_link` longtext,
  `carrier` varchar(10) NOT NULL,
  `order_status` int NOT NULL DEFAULT '1',
  `shippo_order_status` varchar(10) DEFAULT NULL,
  `is_payment_success` int NOT NULL DEFAULT '0',
  `send_store_close_soon_email` int NOT NULL DEFAULT '0',
  `send_store_closed_email` int NOT NULL DEFAULT '0',
  `send_order_shipped_email` int NOT NULL DEFAULT '0',
  `system_order_no` varchar(10) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_order_id` int NOT NULL,
  `store_product_id` int NOT NULL,
  `store_id` int NOT NULL,
  `qty` int NOT NULL,
  `system_order_reference` varchar(20) DEFAULT NULL,
  `is_updated` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_order_player_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `sub_team` varchar(255) DEFAULT NULL,
  `store_product_id` int NOT NULL,
  `store_order_item_id` int NOT NULL,
  `is_name_available` int NOT NULL DEFAULT '0',
  `is_number_available` int NOT NULL DEFAULT '0',
  `color` int DEFAULT NULL,
  `size` int NOT NULL,
  `player_number` varchar(10) DEFAULT NULL,
  `player_name` varchar(20) DEFAULT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `order_date` varchar(100) DEFAULT NULL,
  `item_status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_order_receipts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `store_order_no` varchar(20) NOT NULL,
  `order_items` longtext,
  `order_details` longtext,
  `shipping_details` longtext,
  `customer_details` longtext,
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_order_statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(100) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `color` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_payment_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `sum_of_sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sum_of_shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sum_of_sales_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sum_of_other` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sum_of_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `size_type_id` int DEFAULT NULL,
  `product_default_name` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `embellishment_option` int DEFAULT NULL,
  `mandotary` int NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) DEFAULT NULL,
  `style` longtext,
  `product_availability` int DEFAULT '1',
  `set_individual_name` int NOT NULL DEFAULT '0',
  `set_individual_number` int NOT NULL DEFAULT '0',
  `tax_category` int DEFAULT NULL,
  `shipping_weight` decimal(10,2) DEFAULT NULL,
  `moq` int NOT NULL DEFAULT '1',
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_added_variants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_product_id` int NOT NULL,
  `variant_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_bundles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `category_id` int NOT NULL,
  `is_required` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) DEFAULT NULL,
  `is_default` int NOT NULL DEFAULT '0',
  `store_id` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_category_lists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_default_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_edited_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `edited_name` varchar(100) NOT NULL,
  `store_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_extra_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_product_id` int DEFAULT NULL,
  `size_id` int DEFAULT NULL,
  `size_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `store_product_id` int NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `image_caption` varchar(255) DEFAULT NULL,
  `variant` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `order_index` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_price_additions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_product_id` int NOT NULL,
  `price_addition_name` varchar(100) NOT NULL,
  `is_addition_value` int NOT NULL DEFAULT '1',
  `addition_value` decimal(10,2) NOT NULL,
  `addition_amount` decimal(10,2) NOT NULL,
  `is_fundraising` int NOT NULL DEFAULT '1',
  `hide_from_customer` int NOT NULL DEFAULT '1',
  `addition_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `store_product_id` int NOT NULL,
  `size_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_product_variants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `variant_name` varchar(50) DEFAULT NULL,
  `variant_value` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `store_shipments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_order_no` varchar(100) NOT NULL,
  `store_id` int NOT NULL,
  `shipment_id` varchar(255) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `selected_rate` varchar(100) DEFAULT NULL,
  `carrier` varchar(100) NOT NULL,
  `tracking_object_id` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `tracking_url` longtext,
  `label_url` longtext,
  `rate` decimal(10,2) DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `estimated_days` varchar(100) DEFAULT NULL,
  `is_shipping_removed` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_shipping_methods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shipping_method_name` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_taxes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `amount` int NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_tax_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tax_category_name` varchar(255) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `store_themes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int DEFAULT NULL,
  `event_no` varchar(255) DEFAULT NULL,
  `theme` int NOT NULL DEFAULT '0',
  `event_name` varchar(250) DEFAULT NULL,
  `store_banner` varchar(255) DEFAULT 'assets/img/teamStore/banner_img_2.jpg',
  `primary_logo` varchar(255) DEFAULT 'assets/img/teamStore/logo_dark.png',
  `secondary_logo` varchar(255) DEFAULT 'assets/img/teamStore/sec_logo.png',
  `fundraising` varchar(255) DEFAULT 'assets/img/teamStore/welcome_banner.jpg',
  `fundraising_text` varchar(255) DEFAULT NULL,
  `fundraising_font_color` varchar(10) DEFAULT NULL,
  `primary_color` varchar(10) DEFAULT '#47D6B6',
  `secondary_color` varchar(255) DEFAULT 'rgb(242, 242, 242)',
  `header_text_color` varchar(20) NOT NULL DEFAULT '#717070',
  `footer_text_color` varchar(20) NOT NULL DEFAULT '#717070',
  `button_text_color` varchar(20) NOT NULL DEFAULT '#ffffff',
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `store_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_type_name` varchar(100) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `subscribe_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `platform` varchar(255) DEFAULT NULL,
  `sport` varchar(255) NOT NULL DEFAULT 'lacrosse',
  `email` varchar(255) DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `parent_cell` varchar(255) DEFAULT NULL,
  `player_name` varchar(255) DEFAULT NULL,
  `player_grade` varchar(255) DEFAULT NULL,
  `player_rec` varchar(255) DEFAULT NULL,
  `player_position` varchar(255) DEFAULT NULL,
  `player_years` varchar(255) DEFAULT NULL,
  `player_high_school` varchar(255) DEFAULT NULL,
  `player_youth_rec` varchar(255) DEFAULT NULL,
  `player_club` varchar(255) DEFAULT NULL,
  `other_comments` longtext,
  `note` varchar(255) DEFAULT NULL,
  `type` int DEFAULT NULL,
  `team_store_id` int DEFAULT NULL,
  `mailchimp_audience_id` varchar(64) DEFAULT NULL,
  `mailchimp_member_id` varchar(64) DEFAULT NULL,
  `mailchimp_subscriber_hash` char(32) DEFAULT NULL,
  `mailchimp_status` varchar(32) DEFAULT NULL,
  `mailchimp_rating` tinyint UNSIGNED DEFAULT NULL,
  `mailchimp_last_changed_at` datetime DEFAULT NULL,
  `mailchimp_synced_at` datetime DEFAULT NULL,
  `mailchimp_sync_error` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` varchar(100) DEFAULT NULL,
  `mailchimp_segment_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `sub_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_product_id` int NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `show_in_catalog_name` varchar(255) DEFAULT NULL,
  `sub_product_no` varchar(10) NOT NULL,
  `pattern_code` varchar(50) DEFAULT NULL,
  `default_price` decimal(10,2) DEFAULT '0.00',
  `standard_fabric` varchar(255) DEFAULT NULL,
  `type_of_embellishment` varchar(255) DEFAULT NULL,
  `attribute_on_price` varchar(255) DEFAULT NULL,
  `description` text,
  `who_we_made_this_for` varchar(3072) DEFAULT NULL,
  `product_features` varchar(3072) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `fabric_id` int DEFAULT NULL,
  `weight` decimal(10,3) DEFAULT NULL,
  `mockup_img` varchar(100) DEFAULT NULL,
  `mockup_img_1` varchar(255) DEFAULT NULL,
  `mockup_img_2` varchar(255) DEFAULT NULL,
  `mockup_img_3` varchar(255) DEFAULT NULL,
  `product_reference_link` varchar(255) DEFAULT NULL,
  `pattern_file` varchar(255) DEFAULT NULL,
  `technical_tech_pack` varchar(255) DEFAULT NULL,
  `size_chart` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `show_in_catalog` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `sub_products_temp` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `sub_product_id` int DEFAULT NULL,
  `product_no` varchar(100) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `show_in_catalog_name` varchar(255) DEFAULT NULL,
  `main_category_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pattern_code` varchar(100) DEFAULT NULL,
  `product_category_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `gender` varchar(50) DEFAULT NULL,
  `MOQ` int DEFAULT NULL,
  `default_price` decimal(10,2) DEFAULT NULL,
  `standard_fabric` varchar(255) DEFAULT NULL,
  `fabric_options` text,
  `attributes` text,
  `type_of_embellishment` varchar(255) DEFAULT NULL,
  `description` text,
  `who_we_made_this_for` text,
  `product_features` text,
  `notes` text,
  `fabric_id` bigint UNSIGNED DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `mockup_img` varchar(255) DEFAULT NULL,
  `mockup_img_1` varchar(255) DEFAULT NULL,
  `mockup_img_2` varchar(255) DEFAULT NULL,
  `mockup_img_3` varchar(255) DEFAULT NULL,
  `mockup_caption_1` varchar(255) DEFAULT NULL,
  `mockup_caption_2` varchar(255) DEFAULT NULL,
  `mockup_caption_3` varchar(255) DEFAULT NULL,
  `product_reference_link` text,
  `2D_mockup` varchar(255) DEFAULT NULL,
  `3D_mockup` varchar(255) DEFAULT NULL,
  `tech_pack` varchar(255) DEFAULT NULL,
  `measurement` varchar(255) DEFAULT NULL,
  `product_layout` varchar(255) DEFAULT NULL,
  `pattern` varchar(255) DEFAULT NULL,
  `technical_tech_pack` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `show_in_catalog` tinyint DEFAULT '1',
  `fits_true_to_size` tinyint DEFAULT '0',
  `attribute_on_price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `size_id` bigint UNSIGNED DEFAULT NULL,
  `size_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `fabric_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sport_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_category_list_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_attribute_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_factory_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_tagline_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_fit_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `transferred` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_product_id` (`product_id`)
) ;
SQL,
            <<<'SQL'
CREATE TABLE `sub_product_colors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_product_no` varchar(255) DEFAULT NULL,
  `color_master_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `sub_product_embellishment_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_product_id` int NOT NULL,
  `embellishment_option` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `sub_product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_product_no` varchar(255) DEFAULT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_type` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `sub_product_image_temps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` varchar(255) DEFAULT NULL,
  `sub_product_no` varchar(255) DEFAULT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_type` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `sub_product_prices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_product_no` varchar(20) DEFAULT NULL,
  `price_type` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `summary_at_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(10) DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `totalItemQty` int DEFAULT NULL,
  `subTotal` double(10,2) DEFAULT NULL,
  `shipping` double(10,2) DEFAULT NULL,
  `salesTax` double(10,2) DEFAULT NULL,
  `artwork` double(10,2) DEFAULT NULL,
  `processingFee` double(10,2) DEFAULT NULL,
  `orderTotal` double(10,2) DEFAULT NULL,
  `balancePayment` double(10,2) DEFAULT NULL,
  `payedAmount` double(10,2) DEFAULT NULL,
  `method` varchar(250) DEFAULT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` datetime(3) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `support_agents` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `max_active_chats` int UNSIGNED NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `support_agents_user_id_unique` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `support_agent_departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `support_agent_id` bigint UNSIGNED NOT NULL,
  `support_department_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sad_unique_agent_department` (`support_agent_id`,`support_department_id`),
  KEY `support_agent_departments_support_department_id_foreign` (`support_department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `support_conversations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `support_department_id` bigint UNSIGNED NOT NULL,
  `assigned_agent_id` bigint UNSIGNED DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` enum('waiting','active','closed') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'waiting',
  `priority` enum('low','normal','high') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'normal',
  `started_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_conversations_customer_id_foreign` (`customer_id`),
  KEY `support_conversations_support_department_id_foreign` (`support_department_id`),
  KEY `support_conversations_assigned_agent_id_foreign` (`assigned_agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `support_departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `support_departments_slug_unique` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `support_conversation_id` bigint UNSIGNED NOT NULL,
  `sender_type` enum('customer','agent') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sender_id` bigint UNSIGNED DEFAULT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `attachment_path` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `attachment_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `attachment_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `attachment_mime` bigint UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_messages_support_conversation_id_foreign` (`support_conversation_id`),
  KEY `support_messages_sender_type_sender_id_index` (`sender_type`,`sender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `support_transfers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `support_conversation_id` bigint UNSIGNED NOT NULL,
  `from_agent_id` bigint UNSIGNED DEFAULT NULL,
  `to_agent_id` bigint UNSIGNED DEFAULT NULL,
  `from_department_id` bigint UNSIGNED DEFAULT NULL,
  `to_department_id` bigint UNSIGNED DEFAULT NULL,
  `reason` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_transfers_support_conversation_id_foreign` (`support_conversation_id`),
  KEY `support_transfers_from_agent_id_foreign` (`from_agent_id`),
  KEY `support_transfers_to_agent_id_foreign` (`to_agent_id`),
  KEY `support_transfers_from_department_id_foreign` (`from_department_id`),
  KEY `support_transfers_to_department_id_foreign` (`to_department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `system_a_p_is` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `api_type_key` varchar(191) NOT NULL,
  `api_token` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `system_configurations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) DEFAULT NULL,
  `team_logo` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `team_store_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `organization_id` int DEFAULT NULL,
  `team_store_report_name` varchar(255) DEFAULT NULL,
  `team_store_report` varchar(255) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `team_store_player_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_store_order_id` int DEFAULT NULL,
  `player_name` varchar(100) DEFAULT NULL,
  `billing_name` varchar(100) DEFAULT NULL,
  `order_number` int DEFAULT NULL,
  `order_quantity` int DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `player_no` varchar(7) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `team_store_product_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_store_order_id` int DEFAULT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_year` varchar(10) DEFAULT NULL,
  `fabric` varchar(50) DEFAULT NULL,
  `embellishment` varchar(50) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `factory_code` varchar(20) DEFAULT NULL,
  `item_description` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `theme_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(255) DEFAULT NULL,
  `action` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
SQL,
            <<<'SQL'
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `role_id` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_role_id` int DEFAULT '1',
  `user_group_id` int DEFAULT '1',
  `profile_pic` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mail_server_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `m_number` varchar(15) DEFAULT NULL,
  `w_number` int DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `job_title` varchar(20) DEFAULT NULL,
  `joined_date` varchar(20) DEFAULT NULL,
  `leavetype_id` int DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `Marital_Status` varchar(10) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Nationality` varchar(25) DEFAULT NULL,
  `Languages` varchar(100) DEFAULT NULL,
  `Employment_Status` varchar(10) DEFAULT NULL,
  `Department` varchar(25) DEFAULT NULL,
  `Private_Email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_email_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `template_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_files` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_files_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_folders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `user_folder_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_group_name` varchar(255) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `user_group_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `user_group_name` tinyint DEFAULT NULL,
  `narration` tinyint DEFAULT NULL,
  `permissions` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `user_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `profile_pic` tinyint DEFAULT NULL,
  `name` tinyint DEFAULT NULL,
  `email` tinyint DEFAULT NULL,
  `user_role_name` tinyint DEFAULT NULL,
  `user_group_name` tinyint DEFAULT NULL,
  `action` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `user_leaves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leave_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL,
  `day_type` int DEFAULT NULL,
  `request_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approve_by` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `user_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_role_name` varchar(255) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `user_role_layouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `user_role_name` tinyint DEFAULT NULL,
  `narration` tinyint DEFAULT NULL,
  `created` tinyint DEFAULT NULL,
  `updated` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL,
            <<<'SQL'
CREATE TABLE `user_shared_folders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `user_shared_folder_id` longtext,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_trash_folders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `user_trash_folder_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user_trash_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `original_location` longtext,
  `trashed_location` longtext,
  `file_id` longtext,
  `folder_id` longtext,
  `user_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `usps_label_attempts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_shipment_id` bigint UNSIGNED NOT NULL,
  `request_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label_type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'outbound',
  `state` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitting',
  `tracking_number` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_message` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usps_attempt_uuid` (`request_uuid`),
  KEY `ix_usps_attempt_shipment` (`store_shipment_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `usps_shipment_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_shipment_id` bigint UNSIGNED NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `recipient_first_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_street` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_street2` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_state` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_zip` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_phone` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_email` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_country` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'US',
  `weight_lb` decimal(10,4) DEFAULT NULL,
  `length_in` decimal(8,2) NOT NULL DEFAULT '14.00',
  `width_in` decimal(8,2) NOT NULL DEFAULT '12.00',
  `height_in` decimal(8,2) NOT NULL DEFAULT '4.00',
  `rate_indicator` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SP',
  `processing_category` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MACHINABLE',
  `destination_entry_facility_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NONE',
  `mailing_date` date DEFAULT NULL,
  `suppress_postage` tinyint(1) NOT NULL DEFAULT '1',
  `usps_label_request_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actual_postage` decimal(10,2) DEFAULT NULL,
  `label_metadata` longtext COLLATE utf8mb4_unicode_ci,
  `label_created_at` datetime DEFAULT NULL,
  `reprint_count` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `refund_dispute_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refund_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usps_store_shipment` (`store_shipment_id`),
  KEY `ix_usps_label_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
            <<<'SQL'
CREATE TABLE `venmo_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `customer_paid_amount` float(10,2) DEFAULT NULL,
  `venmo_receipt` varchar(255) DEFAULT NULL,
  `is_approved` tinyint NOT NULL DEFAULT '0',
  `amount` float(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reject_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `webmail_accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `active` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
CREATE TABLE `webmail_counts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `inbox_count` int DEFAULT NULL,
  `spam_count` int DEFAULT NULL,
  `draft_count` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
SQL,
            <<<'SQL'
ALTER TABLE `em_customer_password_resets`
  ADD CONSTRAINT `em_customer_password_resets_customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `em_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SQL,
            <<<'SQL'
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
SQL,
            <<<'SQL'
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
SQL,
            <<<'SQL'
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
SQL,
        ];
    }
};

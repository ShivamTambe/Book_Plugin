<?php
// includes/schema.php

global $wpdb;

$table_name = $wpdb->prefix . 'book_meta';

$sql = "CREATE TABLE $table_name (
    meta_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    book_id bigint(20) UNSIGNED NOT NULL,
    meta_key varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    meta_value longtext COLLATE utf8mb4_unicode_ci,
    PRIMARY KEY (meta_id),
    KEY book_id (book_id),
    KEY meta_key (meta_key(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

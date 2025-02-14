ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
DROP COLUMN `idopr`,
DROP COLUMN `jam`,
DROP COLUMN `iddesa`,
DROP COLUMN `idkec`,
DROP COLUMN `kcds`;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
CHANGE `ket` `jawaban` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
CHANGE `jawaban` `ket` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
ADD COLUMN `ddk_questioner_id` int NOT NULL AFTER `id`;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
ADD COLUMN `parent` int NULL AFTER `ddk_questioner_id`;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
CHANGE `ket` `jawaban` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
CHANGE `jawaban` `jawaban` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
ADD COLUMN `satuan` varchar(255) NULL AFTER `jawaban`;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
ADD COLUMN `tipe` varchar(255) NULL DEFAULT 'checkbox' AFTER `satuan`,
ADD COLUMN `created_at` timestamp NULL AFTER `satuan`,
ADD COLUMN `updated_at` timestamp NULL AFTER `satuan`;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
CHANGE `updated_at` `updated_at` timestamp NULL AFTER `tipe`;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
CHANGE `created_at` `created_at` timestamp NULL AFTER `updated_at`;

ALTER TABLE `2024sid_website_laravel`.`ddk_cacat`
CHANGE `updated_at` `updated_at` timestamp NULL AFTER `created_at`;

-- update ddk_questioner_id
UPDATE `2024sid_website_laravel`.`ddk_cacat` SET `ddk_questioner_id` = 41;

# UPDATE `2024sid_website_laravel`.`ddk_cacat`
# SET `id` = CASE 
#     WHEN `id` = 1 THEN 593
#     WHEN `id` = 2 THEN 594
#     WHEN `id` = 3 THEN 595
#     WHEN `id` = 4 THEN 596
#     WHEN `id` = 5 THEN 597
#     WHEN `id` = 6 THEN 598
#     WHEN `id` = 7 THEN 599
#     WHEN `id` = 8 THEN 600
#     WHEN `id` = 9 THEN 601
#     WHEN `id` = 10 THEN 602
#     WHEN `id` = 11 THEN 603
#     WHEN `id` = 12 THEN 604
#     WHEN `id` = 13 THEN 605
#     WHEN `id` = 14 THEN 606
#     WHEN `id` = 15 THEN 607
#     WHEN `id` = 16 THEN 608
#     WHEN `id` = 17 THEN 609
#     WHEN `id` = 18 THEN 610
#     WHEN `id` = 19 THEN 611
#     WHEN `id` = 20 THEN 612
#     WHEN `id` = 21 THEN 613
#     WHEN `id` = 22 THEN 614
#     WHEN `id` = 23 THEN 615
#     WHEN `id` = 24 THEN 616
#     WHEN `id` = 25 THEN 617
#     WHEN `id` = 26 THEN 618
#     WHEN `id` = 27 THEN 619
#     WHEN `id` = 28 THEN 620
#     WHEN `id` = 29 THEN 621
#     WHEN `id` = 30 THEN 622
#     WHEN `id` = 31 THEN 623
#     WHEN `id` = 32 THEN 624
#     WHEN `id` = 33 THEN 625
#     WHEN `id` = 34 THEN 626
#     WHEN `id` = 35 THEN 627
#     WHEN `id` = 36 THEN 628
#     WHEN `id` = 37 THEN 629
#     WHEN `id` = 38 THEN 630
#     WHEN `id` = 39 THEN 631
#     WHEN `id` = 40 THEN 632
#     WHEN `id` = 41 THEN 633
#     WHEN `id` = 42 THEN 634
#     WHEN `id` = 43 THEN 635
#     WHEN `id` = 44 THEN 636
#     WHEN `id` = 45 THEN 637
#     WHEN `id` = 46 THEN 638
#     # WHEN `id` = 47 THEN 589
#     # WHEN `id` = 48 THEN 590
#     # WHEN `id` = 49 THEN 591
#     # WHEN `id` = 50 THEN 592
#     ELSE `id`
# END
# WHERE `id` IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46);


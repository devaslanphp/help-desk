SET foreign_key_checks = 0;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`,
                     `updated_at`, `role`, `register_token`, `deleted_at`)
VALUES (4, 'Dark Vador', 'darkvador@gmail.com', NULL, '$2y$10$4f8HPTwKhVzpAP5kas6PN.VP5TlJrgZ0nEcbhrnk6OFtkiUA9czbK',
        'OHEZUT3JTudVaM98f52WUSEIBYt2iFVe4x3fIIh5ppc6mbLQkfcvdd7g7Rcq', '2022-09-09 20:04:18', '2022-09-12 14:43:54',
        'administrator', NULL, NULL),
       (5, 'John DOE', 'johndoe@gmail.com', NULL, '$2y$10$dhwupOVEiVsQpQZeSIJhWutsBYF8pde7/BTViD5j9f8c1CregT9Gq', NULL,
        '2022-09-11 14:37:09', '2022-09-12 11:39:04', 'employee', NULL, NULL),
       (6, 'Jane DOE', 'janedoe@gmail.com', NULL, '$2y$10$l1pWnJh2iUDttzLLlmG5weeTNT7O/UAwsWnPrD8XH8yszCzrhFh82', NULL,
        '2022-09-11 14:48:37', '2022-09-11 15:08:21', 'customer', NULL, NULL),
       (10, 'Thomas Edison', 'thomasedison@gmail.com', NULL,
        '$2y$10$MR51TVg3xzUXs308oTxp8.Pw9sjs7ijaeGYLJZsq85CdY/azYD0bG', NULL, '2022-09-11 15:31:51',
        '2022-09-11 15:31:55', 'employee', '82c93eba-9a33-4dbe-abac-22f11f5c1f54', NULL);

INSERT INTO `projects` (`id`, `name`, `description`, `owner_id`, `deleted_at`, `created_at`, `updated_at`)
VALUES (1, 'Default project',
        '<p>This is the default project to associate to any created ticket that are not related to any other projects.</p>',
        4, NULL, '2022-09-11 16:29:08', '2022-09-11 16:35:48'),
       (2, 'IDEAO', '<p>Project for managing tickets linked to the IDEAO project</p>', 4, NULL, '2022-09-11 17:09:31',
        '2022-09-11 17:12:47'),
       (3, 'Arena job', '<p>Project for managing tickets linked to the Arena job project</p>', 4, NULL,
        '2022-09-11 17:13:05', '2022-09-11 17:13:17'),
       (4, 'ARP', '<p>Project for managing tickets linked to the ARP project</p>', 5, NULL, '2022-09-11 17:13:25',
        '2022-09-11 17:15:04');

INSERT INTO `favorite_projects` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`)
VALUES (6, 4, 2, '2022-09-11 17:09:33', '2022-09-11 17:09:33'),
       (9, 4, 4, '2022-09-11 17:20:53', '2022-09-11 17:20:53'),
       (10, 5, 4, '2022-09-11 17:30:49', '2022-09-11 17:30:49'),
       (11, 4, 1, '2022-09-12 11:50:42', '2022-09-12 11:50:42');

INSERT INTO `tickets` (`id`, `title`, `content`, `status`, `priority`, `owner_id`, `responsible_id`, `deleted_at`,
                       `created_at`, `updated_at`, `project_id`, `type`, `number`)
VALUES (2, 'Cannot access the platform',
        '<p>Hello,</p><p>I cannot access the platform with the credentials received by email.</p><p>Can you see what is the problem, please?</p><p>Thanks</p>',
        'validated', 'highest', 4, 5, NULL, '2022-09-11 18:27:55', '2022-09-12 11:48:00', 1, 'bug', '0001'),
       (3, 'Design enhancement', '<p>Add a logo of the company to the login page.</p>', 'created', 'low', 5, 4, NULL,
        '2022-09-11 18:45:55', '2022-09-12 13:08:05', 2, 'improvement', '0001'),
       (4, 'Quiz wizard', '<p>Add a wizard system to the quiz page</p>', 'created', 'normal', 4, NULL, NULL,
        '2022-09-11 20:37:14', '2022-09-11 20:37:14', 2, 'improvement', '0002'),
       (9, 'Internal error - Login page',
        '<p>We got an internal error when we visit the login page (url: /auth/login)</p>', 'created', 'highest', 5, 4,
        NULL, '2022-09-11 20:58:37', '2022-09-12 13:08:12', 4, 'bug', '0001');

INSERT INTO `comments` (`id`, `owner_id`, `ticket_id`, `content`, `deleted_at`, `created_at`, `updated_at`)
VALUES (1, 4, 2, '<p>Hello,</p><p>We are working on it, I let you know ASAP.</p><p>Best regards.</p>', NULL,
        '2022-09-12 09:40:33', '2022-09-12 14:23:36'),
       (5, 4, 2,
        '<p>FYI</p><p>We have reproduced the error, and we are working on it.</p><p><figure data-trix-attachment=\"{&quot;contentType&quot;:&quot;image&quot;,&quot;height&quot;:683,&quot;url&quot;:&quot;https://i.stack.imgur.com/nwIvJ.png&quot;,&quot;width&quot;:532}\" data-trix-content-type=\"image\" data-trix-attributes=\"{&quot;caption&quot;:&quot;Error while accessing with valid credentials&quot;}\" class=\"attachment attachment--preview\"><img src=\"https://i.stack.imgur.com/nwIvJ.png\" width=\"532\" height=\"683\"><figcaption class=\"attachment__caption attachment__caption--edited\">Error while accessing with valid credentials</figcaption></figure></p>',
        NULL, '2022-09-12 09:54:44', '2022-09-12 14:15:56'),
       (9, 5, 2, '<p>A fix has been deployed.</p><p>Can you please test it and let me know.</p><p>Best regards.</p>',
        NULL, '2022-09-12 11:47:38', '2022-09-12 14:15:56'),
       (10, 4, 2, '<p>Hello,</p><p>The fix is working good.&nbsp;</p><p>Thanks.</p>', NULL, '2022-09-12 11:48:13',
        '2022-09-12 14:43:08');

INSERT INTO `ticket_priorities` (`id`, `title`, `text_color`, `bg_color`, `icon`, `deleted_at`, `created_at`,
                                 `updated_at`, `slug`)
VALUES (1, 'Lowest', '#dcfce7', '#22c55e', 'fa-arrow-down', NULL, '2022-09-19 10:29:52', '2022-09-19 11:30:57',
        'lowest'),
       (2, 'Low', '#10b981', '#d1fae5', 'fa-angle-down', NULL, '2022-09-19 10:32:24', '2022-09-19 11:30:57', 'low'),
       (3, 'Normal', '#6b7280', '#f3f4f6', 'fa-minus', NULL, '2022-09-19 10:32:50', '2022-09-19 11:30:57', 'normal'),
       (4, 'High', '#f97316', '#ffedd5', 'fa-angle-up', NULL, '2022-09-19 10:37:09', '2022-09-19 11:30:57', 'high'),
       (5, 'Highest', '#ef4444', '#fee2e2', 'fa-arrow-up', NULL, '2022-09-19 10:37:37', '2022-09-19 11:41:39',
        'highest');

INSERT INTO `ticket_statuses` (`id`, `title`, `text_color`, `bg_color`, `default`, `deleted_at`, `created_at`,
                               `updated_at`, `slug`)
VALUES (1, 'Created', '#6b7280', '#f3f4f6', 1, NULL, '2022-09-19 09:17:50', '2022-09-19 11:30:48', 'created'),
       (2, 'In progress', '#0ea5e9', '#e0f2fe', 0, NULL, '2022-09-19 09:19:17', '2022-09-19 11:30:48', 'in_progress'),
       (3, 'Done', '#f97316', '#ffedd5', 0, NULL, '2022-09-19 09:21:17', '2022-09-19 11:30:48', 'done'),
       (4, 'Validated', '#22c55e', '#dcfce7', 0, NULL, '2022-09-19 09:21:29', '2022-09-19 11:30:48', 'validated'),
       (5, 'Rejected', '#ef4444', '#fee2e2', 0, NULL, '2022-09-19 09:21:41', '2022-09-19 11:30:48', 'rejected');

INSERT INTO `ticket_types` (`id`, `title`, `text_color`, `bg_color`, `icon`, `deleted_at`, `created_at`, `updated_at`,
                            `slug`)
VALUES (1, 'Improvement', '#dbeafe', '#3b82f6', 'fa-arrow-up', NULL, '2022-09-19 10:29:52', '2022-09-19 11:31:04',
        'improvement'),
       (2, 'New feature', '#10b981', '#d1fae5', 'fa-plus-square-o', NULL, '2022-09-19 10:32:24', '2022-09-19 11:31:04',
        'new-feature'),
       (4, 'Task', '#f97316', '#ffedd5', 'fa-check-square-o', NULL, '2022-09-19 10:37:09', '2022-09-19 11:31:04',
        'task'),
       (5, 'Bug', '#ef4444', '#fee2e2', 'fa-bug', NULL, '2022-09-19 10:37:37', '2022-09-19 11:31:04', 'bug');

SET foreign_key_checks = 1;

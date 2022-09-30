INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at,
                   updated_at, register_token, deleted_at)
VALUES (4, 'Dark Vador', 'darkvador@gmail.com', NULL, '$2y$10$4f8HPTwKhVzpAP5kas6PN.VP5TlJrgZ0nEcbhrnk6OFtkiUA9czbK',
        'OHEZUT3JTudVaM98f52WUSEIBYt2iFVe4x3fIIh5ppc6mbLQkfcvdd7g7Rcq', '2022-09-09 20:04:18', '2022-09-12 14:43:54',
        NULL, NULL),
       (5, 'John DOE', 'johndoe@gmail.com', NULL, '$2y$10$dhwupOVEiVsQpQZeSIJhWutsBYF8pde7/BTViD5j9f8c1CregT9Gq', NULL,
        '2022-09-11 14:37:09', '2022-09-12 11:39:04', NULL, NULL),
       (6, 'Jane DOE', 'janedoe@gmail.com', NULL, '$2y$10$l1pWnJh2iUDttzLLlmG5weeTNT7O/UAwsWnPrD8XH8yszCzrhFh82', NULL,
        '2022-09-11 14:48:37', '2022-09-11 15:08:21', NULL, NULL),
       (10, 'Thomas Edison', 'thomasedison@gmail.com', NULL,
        '$2y$10$MR51TVg3xzUXs308oTxp8.Pw9sjs7ijaeGYLJZsq85CdY/azYD0bG', NULL, '2022-09-11 15:31:51',
        '2022-09-11 15:31:55', '82c93eba-9a33-4dbe-abac-22f11f5c1f54', NULL);

INSERT INTO projects (id, name, description, owner_id, deleted_at, created_at, updated_at, ticket_prefix)
VALUES (1, 'Default project',
        '<p>This is the default project to associate to any created ticket that are not related to any other projects.</p>',
        4, NULL, '2022-09-11 16:29:08', '2022-09-11 16:35:48', 'DEFP'),
       (2, 'IDEAO', '<p>Project for managing tickets linked to the IDEAO project</p>', 4, NULL, '2022-09-11 17:09:31',
        '2022-09-11 17:12:47', 'IDEA'),
       (3, 'Arena job', '<p>Project for managing tickets linked to the Arena job project</p>', 4, NULL,
        '2022-09-11 17:13:05', '2022-09-11 17:13:17', 'ARJO'),
       (4, 'ARP', '<p>Project for managing tickets linked to the ARP project</p>', 5, NULL, '2022-09-11 17:13:25',
        '2022-09-11 17:15:04', 'ARPT');

INSERT INTO favorite_projects (id, user_id, project_id, created_at, updated_at)
VALUES (6, 4, 2, '2022-09-11 17:09:33', '2022-09-11 17:09:33'),
       (9, 4, 4, '2022-09-11 17:20:53', '2022-09-11 17:20:53'),
       (10, 5, 4, '2022-09-11 17:30:49', '2022-09-11 17:30:49'),
       (11, 4, 1, '2022-09-12 11:50:42', '2022-09-12 11:50:42');

INSERT INTO tickets (id, title, content, status, priority, owner_id, responsible_id, deleted_at,
                     created_at, updated_at, project_id, type, number)
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

INSERT INTO comments (id, owner_id, ticket_id, content, deleted_at, created_at, updated_at)
VALUES (1, 4, 2, '<p>Hello,</p><p>We are working on it, I let you know ASAP.</p><p>Best regards.</p>', NULL,
        '2022-09-12 09:40:33', '2022-09-12 14:23:36'),
       (5, 4, 2,
        '<p>FYI</p><p>We have reproduced the error, and we are working on it.</p><p><figure data-trix-attachment=\"{&quot;contentType&quot;:&quot;image&quot;,&quot;height&quot;:683,&quot;url&quot;:&quot;https://i.stack.imgur.com/nwIvJ.png&quot;,&quot;width&quot;:532}\" data-trix-content-type=\"image\" data-trix-attributes=\"{&quot;caption&quot;:&quot;Error while accessing with valid credentials&quot;}\" class=\"attachment attachment--preview\"><img src=\"https://i.stack.imgur.com/nwIvJ.png\" width=\"532\" height=\"683\"><figcaption class=\"attachment__caption attachment__caption--edited\">Error while accessing with valid credentials</figcaption></figure></p>',
        NULL, '2022-09-12 09:54:44', '2022-09-12 14:15:56'),
       (9, 5, 2, '<p>A fix has been deployed.</p><p>Can you please test it and let me know.</p><p>Best regards.</p>',
        NULL, '2022-09-12 11:47:38', '2022-09-12 14:15:56'),
       (10, 4, 2, '<p>Hello,</p><p>The fix is working good.&nbsp;</p><p>Thanks.</p>', NULL, '2022-09-12 11:48:13',
        '2022-09-12 14:43:08');

INSERT INTO ticket_priorities (id, title, text_color, bg_color, icon, deleted_at, created_at,
                               updated_at, slug)
VALUES (1, 'Lowest', '#dcfce7', '#22c55e', 'fa-arrow-down', NULL, '2022-09-19 10:29:52', '2022-09-19 11:30:57',
        'lowest'),
       (2, 'Low', '#10b981', '#d1fae5', 'fa-angle-down', NULL, '2022-09-19 10:32:24', '2022-09-19 11:30:57', 'low'),
       (3, 'Normal', '#6b7280', '#f3f4f6', 'fa-minus', NULL, '2022-09-19 10:32:50', '2022-09-19 11:30:57', 'normal'),
       (4, 'High', '#f97316', '#ffedd5', 'fa-angle-up', NULL, '2022-09-19 10:37:09', '2022-09-19 11:30:57', 'high'),
       (5, 'Highest', '#ef4444', '#fee2e2', 'fa-arrow-up', NULL, '2022-09-19 10:37:37', '2022-09-19 11:41:39',
        'highest');

INSERT INTO ticket_statuses (id, title, text_color, bg_color, "default", deleted_at, created_at,
                             updated_at, slug)
VALUES (1, 'Created', '#6b7280', '#f3f4f6', true, NULL, '2022-09-19 09:17:50', '2022-09-19 11:30:48', 'created'),
       (2, 'In progress', '#0ea5e9', '#e0f2fe', false, NULL, '2022-09-19 09:19:17', '2022-09-19 11:30:48',
        'in_progress'),
       (3, 'Done', '#f97316', '#ffedd5', false, NULL, '2022-09-19 09:21:17', '2022-09-19 11:30:48', 'done'),
       (4, 'Validated', '#22c55e', '#dcfce7', false, NULL, '2022-09-19 09:21:29', '2022-09-19 11:30:48', 'validated'),
       (5, 'Rejected', '#ef4444', '#fee2e2', false, NULL, '2022-09-19 09:21:41', '2022-09-19 11:30:48', 'rejected');

INSERT INTO ticket_types (id, title, text_color, bg_color, icon, deleted_at, created_at, updated_at,
                          slug)
VALUES (1, 'Improvement', '#dbeafe', '#3b82f6', 'fa-arrow-up', NULL, '2022-09-19 10:29:52', '2022-09-19 11:31:04',
        'improvement'),
       (2, 'New feature', '#10b981', '#d1fae5', 'fa-plus-square-o', NULL, '2022-09-19 10:32:24', '2022-09-19 11:31:04',
        'new-feature'),
       (4, 'Task', '#f97316', '#ffedd5', 'fa-check-square-o', NULL, '2022-09-19 10:37:09', '2022-09-19 11:31:04',
        'task'),
       (5, 'Bug', '#ef4444', '#fee2e2', 'fa-bug', NULL, '2022-09-19 10:37:37', '2022-09-19 11:31:04', 'bug');


INSERT INTO companies (id, name, logo, description, is_disabled, responsible_id, deleted_at, created_at, updated_at)
VALUES (1, 'Google', null,
        '<p>Google is an American technology services company founded in 1998 in Silicon Valley, California, by Larry Page and Sergey Brin, creators of the Google search engine. It has been a subsidiary of the Alphabet company since August 2015.</p>',
        false, 4, NULL, '2022-09-24 23:31:50', '2022-09-24 23:44:50'),
       (2, 'Meta', null,
        '<p>Meta Platforms, Inc., better known by the trade name Meta, is an American company created in 2004 by Mark Zuckerberg. It is one of the giants of the Web, grouped under the acronym GAFAM, alongside Google, Apple, Amazon and Microsoft.</p>',
        true, 5, NULL, '2022-09-24 23:46:26', '2022-09-24 23:46:47');


TRUNCATE TABLE permissions CASCADE;
TRUNCATE TABLE permissions CASCADE;
TRUNCATE TABLE roles CASCADE;
TRUNCATE TABLE role_has_permissions CASCADE;
TRUNCATE TABLE model_has_roles CASCADE;

INSERT INTO permissions (id, name, guard_name, created_at, updated_at)
VALUES (1, 'View all projects', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (2, 'Update all projects', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (3, 'Delete all projects', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (4, 'Create projects', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (5, 'View own projects', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (6, 'Update own projects', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (7, 'Delete own projects', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (8, 'View all tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (9, 'Update all tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (10, 'Delete all tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (11, 'Create tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (12, 'View own tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (13, 'Update own tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (14, 'Delete own tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (15, 'Assign tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (16, 'Change status tickets', 'web', '2022-09-25 14:51:10', '2022-09-25 14:51:10'),
       (17, 'Can view Analytics page', 'web', '2022-09-25 15:32:37', '2022-09-25 15:32:37'),
       (18, 'Can view Tickets page', 'web', '2022-09-25 15:32:37', '2022-09-25 15:32:37'),
       (19, 'Can view Kanban page', 'web', '2022-09-25 15:32:37', '2022-09-25 15:32:37'),
       (20, 'Can view Administration page', 'web', '2022-09-25 15:32:37', '2022-09-25 15:32:37'),
       (21, 'View all users', 'web', '2022-09-25 15:41:08', '2022-09-25 15:41:08'),
       (22, 'View company users', 'web', '2022-09-25 15:41:08', '2022-09-25 15:41:08'),
       (25, 'Manage ticket statuses', 'web', '2022-09-25 15:41:08', '2022-09-25 15:41:08'),
       (26, 'Manage ticket priorities', 'web', '2022-09-25 15:41:08', '2022-09-25 15:41:08'),
       (27, 'Manage ticket types', 'web', '2022-09-25 15:41:08', '2022-09-25 15:41:08'),
       (28, 'View activity log', 'web', '2022-09-25 15:41:08', '2022-09-25 15:41:08'),
       (29, 'Create users', 'web', '2022-09-25 16:05:37', '2022-09-25 16:05:37'),
       (30, 'Update users', 'web', '2022-09-25 16:05:37', '2022-09-25 16:05:37'),
       (31, 'Delete users', 'web', '2022-09-25 16:05:37', '2022-09-25 16:05:37'),
       (32, 'Assign permissions', 'web', '2022-09-25 16:05:37', '2022-09-25 16:05:37'),
       (33, 'View all companies', 'web', '2022-09-25 16:14:01', '2022-09-25 16:14:01'),
       (34, 'View own companies', 'web', '2022-09-25 16:14:02', '2022-09-25 16:14:02'),
       (38, 'Create companies', 'web', '2022-09-25 16:19:38', '2022-09-25 16:19:38'),
       (39, 'Update companies', 'web', '2022-09-25 16:19:38', '2022-09-25 16:19:38'),
       (40, 'Delete companies', 'web', '2022-09-25 16:19:38', '2022-09-25 16:19:38'),
       (41, 'Manage user roles', 'web', '2022-09-30 07:40:23', '2022-09-30 07:40:23'),
       (42, 'Create user roles', 'web', '2022-09-30 08:10:52', '2022-09-30 08:10:52'),
       (43, 'Update user roles', 'web', '2022-09-30 08:10:52', '2022-09-30 08:10:52'),
       (44, 'Delete user roles', 'web', '2022-09-30 08:10:52', '2022-09-30 08:10:52');

INSERT INTO roles (id, name, guard_name, created_at, updated_at)
VALUES (1, 'Super administrator', 'web', '2022-09-30 08:11:23', '2022-09-30 08:11:23'),
       (2, 'Employee', 'web', '2022-09-30 08:14:58', '2022-09-30 08:14:58'),
       (3, 'Customer', 'web', '2022-09-30 08:17:01', '2022-09-30 08:17:01');

INSERT INTO model_has_roles (role_id, model_type, model_id)
VALUES (1, 'App\Models\User', 4),
       (2, 'App\Models\User', 5),
       (3, 'App\Models\User', 6);

INSERT INTO role_has_permissions (permission_id, role_id)
VALUES (1, 1),
       (2, 1),
       (3, 1),
       (4, 1),
       (5, 1),
       (5, 2),
       (5, 3),
       (6, 1),
       (7, 1),
       (8, 1),
       (9, 1),
       (10, 1),
       (11, 1),
       (11, 2),
       (11, 3),
       (12, 1),
       (12, 2),
       (12, 3),
       (13, 1),
       (13, 2),
       (13, 3),
       (14, 1),
       (14, 2),
       (14, 3),
       (15, 1),
       (15, 2),
       (16, 1),
       (16, 2),
       (17, 1),
       (17, 2),
       (17, 3),
       (18, 1),
       (18, 2),
       (18, 3),
       (19, 1),
       (19, 2),
       (19, 3),
       (20, 1),
       (20, 3),
       (21, 1),
       (22, 1),
       (22, 3),
       (25, 1),
       (26, 1),
       (27, 1),
       (28, 1),
       (29, 1),
       (29, 3),
       (30, 1),
       (30, 3),
       (31, 1),
       (32, 1),
       (33, 1),
       (34, 1),
       (34, 3),
       (38, 1),
       (39, 1),
       (39, 3),
       (40, 1),
       (41, 1),
       (42, 1),
       (43, 1),
       (44, 1);

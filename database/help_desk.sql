-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : lun. 12 sep. 2022 à 14:49
-- Version du serveur : 8.0.30
-- Version de PHP : 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `help_desk`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `owner_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `owner_id`, `ticket_id`, `content`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 2, '<p>Hello,</p><p>We are working on it, I let you know ASAP.</p><p>Best regards.</p>', NULL, '2022-09-12 09:40:33', '2022-09-12 14:23:36'),
(5, 4, 2, '<p>FYI</p><p>We have reproduced the error, and we are working on it.</p><p><figure data-trix-attachment=\"{&quot;contentType&quot;:&quot;image&quot;,&quot;height&quot;:683,&quot;url&quot;:&quot;https://i.stack.imgur.com/nwIvJ.png&quot;,&quot;width&quot;:532}\" data-trix-content-type=\"image\" data-trix-attributes=\"{&quot;caption&quot;:&quot;Error while accessing with valid credentials&quot;}\" class=\"attachment attachment--preview\"><img src=\"https://i.stack.imgur.com/nwIvJ.png\" width=\"532\" height=\"683\"><figcaption class=\"attachment__caption attachment__caption--edited\">Error while accessing with valid credentials</figcaption></figure></p>', NULL, '2022-09-12 09:54:44', '2022-09-12 14:15:56'),
(9, 5, 2, '<p>A fix has been deployed.</p><p>Can you please test it and let me know.</p><p>Best regards.</p>', NULL, '2022-09-12 11:47:38', '2022-09-12 14:15:56'),
(10, 4, 2, '<p>Hello,</p><p>The fix is working good.&nbsp;</p><p>Thanks.</p>', NULL, '2022-09-12 11:48:13', '2022-09-12 14:43:08');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, 'aac0e9f1-0869-4c78-86b6-f4035041f5a7', 'database', 'default', '{\"uuid\":\"aac0e9f1-0869-4c78-86b6-f4035041f5a7\",\"displayName\":\"App\\\\Notifications\\\\CommentCreateNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:5;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\CommentCreateNotification\\\":3:{s:52:\\\"\\u0000App\\\\Notifications\\\\CommentCreateNotification\\u0000comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:6:\\\"ticket\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:49:\\\"\\u0000App\\\\Notifications\\\\CommentCreateNotification\\u0000user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"2db6d204-f757-4838-86bf-ecd937bf15cd\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"}}', 'Symfony\\Component\\Mailer\\Exception\\TransportException: Connection could not be established with host \"mailhog:1025\": stream_socket_client(): php_network_getaddresses: getaddrinfo for mailhog failed: nodename nor servname provided, or not known in /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php:154\nStack trace:\n#0 [internal function]: Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\{closure}(2, \'stream_socket_c...\', \'/Users/heloufir...\', 157)\n#1 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php(157): stream_socket_client(\'mailhog:1025\', 0, \'\', 60.0, 4, Resource id #1300)\n#2 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(253): Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->initialize()\n#3 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(192): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#4 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/AbstractTransport.php(68): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#5 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(136): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mailer\\SentMessage), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#6 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(521): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(285): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#8 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(67): Illuminate\\Mail\\Mailer->send(Object(Illuminate\\Support\\HtmlString), Array, Object(Closure))\n#9 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(148): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(App\\Models\\User), Object(App\\Notifications\\CommentCreateNotification))\n#10 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(106): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(App\\Models\\User), \'9127de44-b400-4...\', Object(App\\Notifications\\CommentCreateNotification), \'mail\')\n#11 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#12 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(109): Illuminate\\Notifications\\NotificationSender->withLocale(NULL, Object(Closure))\n#13 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\CommentCreateNotification), Array)\n#14 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(104): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\CommentCreateNotification), Array)\n#15 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#16 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#18 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#19 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Container.php(651): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#20 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#21 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(141): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#22 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#23 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#24 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#25 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(141): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#26 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#27 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(126): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#29 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#30 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(425): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(375): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#32 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(150): Illuminate\\Queue\\Worker->runNextJob(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(134): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#35 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#38 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#39 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Container.php(651): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#40 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Console/Command.php(144): Illuminate\\Container\\Container->call(Array)\n#41 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Command/Command.php(308): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Console/Command.php(126): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Application.php(1002): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Application.php(299): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Console/Application.php(102): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 {main}', '2022-09-12 09:52:58'),
(2, 'ab29785e-5ef6-483b-9d7c-c5b9527ffd36', 'database', 'default', '{\"uuid\":\"ab29785e-5ef6-483b-9d7c-c5b9527ffd36\",\"displayName\":\"App\\\\Notifications\\\\CommentCreateNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:5;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\CommentCreateNotification\\\":3:{s:52:\\\"\\u0000App\\\\Notifications\\\\CommentCreateNotification\\u0000comment\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Comment\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:1:{i:0;s:6:\\\"ticket\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:49:\\\"\\u0000App\\\\Notifications\\\\CommentCreateNotification\\u0000user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"727fc035-77fe-4df1-9758-44526d77bec6\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"}}', 'Symfony\\Component\\Mailer\\Exception\\TransportException: Connection could not be established with host \"mailhog:1025\": stream_socket_client(): php_network_getaddresses: getaddrinfo for mailhog failed: nodename nor servname provided, or not known in /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php:154\nStack trace:\n#0 [internal function]: Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\{closure}(2, \'stream_socket_c...\', \'/Users/heloufir...\', 157)\n#1 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php(157): stream_socket_client(\'mailhog:1025\', 0, \'\', 60.0, 4, Resource id #1272)\n#2 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(253): Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->initialize()\n#3 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(192): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#4 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/AbstractTransport.php(68): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#5 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(136): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mailer\\SentMessage), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#6 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(521): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(285): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#8 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(67): Illuminate\\Mail\\Mailer->send(Object(Illuminate\\Support\\HtmlString), Array, Object(Closure))\n#9 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(148): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(App\\Models\\User), Object(App\\Notifications\\CommentCreateNotification))\n#10 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(106): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(App\\Models\\User), \'65c16a14-b01d-4...\', Object(App\\Notifications\\CommentCreateNotification), \'mail\')\n#11 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#12 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(109): Illuminate\\Notifications\\NotificationSender->withLocale(NULL, Object(Closure))\n#13 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\CommentCreateNotification), Array)\n#14 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(104): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\CommentCreateNotification), Array)\n#15 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#16 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#18 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#19 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Container.php(651): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#20 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#21 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(141): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#22 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#23 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#24 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#25 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(141): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#26 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#27 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(126): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#29 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#30 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(425): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(375): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#32 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(150): Illuminate\\Queue\\Worker->runNextJob(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(134): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#35 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#38 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#39 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Container/Container.php(651): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#40 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Console/Command.php(144): Illuminate\\Container\\Container->call(Array)\n#41 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Command/Command.php(308): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Console/Command.php(126): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Application.php(1002): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Application.php(299): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/symfony/console/Application.php(171): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Console/Application.php(102): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 /Users/heloufir/Documents/Workspace/DEVASLAN/Ticket system/help-desk/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 {main}', '2022-09-12 09:52:59');

-- --------------------------------------------------------

--
-- Structure de la table `favorite_projects`
--

CREATE TABLE `favorite_projects` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `favorite_projects`
--

INSERT INTO `favorite_projects` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(6, 4, 2, '2022-09-11 17:09:33', '2022-09-11 17:09:33'),
(9, 4, 4, '2022-09-11 17:20:53', '2022-09-11 17:20:53'),
(10, 5, 4, '2022-09-11 17:30:49', '2022-09-11 17:30:49'),
(11, 4, 1, '2022-09-12 11:50:42', '2022-09-12 11:50:42');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2022_09_09_220749_create_tickets_table', 2),
(8, '2022_09_10_205032_create_projects_table', 3),
(9, '2022_09_10_205612_create_user_projects_table', 4),
(10, '2022_09_10_205915_add_project_to_tickets', 4),
(11, '2022_09_10_220736_add_role_to_users', 5),
(12, '2022_09_11_142205_add_register_token_to_users', 6),
(13, '2022_09_11_153059_add_soft_deletes_to_users', 7),
(14, '2022_09_11_163751_create_favorite_projects_table', 8),
(15, '2022_09_11_202013_add_type_to_tickets', 9),
(16, '2022_09_12_090928_create_comments_table', 10),
(17, '2022_09_12_095043_create_jobs_table', 11);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `owner_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `owner_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Default project', '<p>This is the default project to associate to any created ticket that are not related to any other projects.</p>', 4, NULL, '2022-09-11 16:29:08', '2022-09-11 16:35:48'),
(2, 'IDEAO', '<p>Project for managing tickets linked to the IDEAO project</p>', 4, NULL, '2022-09-11 17:09:31', '2022-09-11 17:12:47'),
(3, 'Arena job', '<p>Project for managing tickets linked to the Arena job project</p>', 4, NULL, '2022-09-11 17:13:05', '2022-09-11 17:13:17'),
(4, 'ARP', '<p>Project for managing tickets linked to the ARP project</p>', 5, NULL, '2022-09-11 17:13:25', '2022-09-11 17:15:04');

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` bigint UNSIGNED NOT NULL,
  `responsible_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `content`, `status`, `priority`, `owner_id`, `responsible_id`, `deleted_at`, `created_at`, `updated_at`, `project_id`, `type`) VALUES
(2, 'Cannot access the platform', '<p>Hello,</p><p>I cannot access the platform with the credentials received by email.</p><p>Can you see what is the problem, please?</p><p>Thanks</p>', 'validated', 'highest', 4, 5, NULL, '2022-09-11 18:27:55', '2022-09-12 11:48:00', 1, 'bug'),
(3, 'Design enhancement', '<p>Add a logo of the company to the login page.</p>', 'created', 'low', 5, 4, NULL, '2022-09-11 18:45:55', '2022-09-12 13:08:05', 2, 'improvement'),
(4, 'Quiz wizard', '<p>Add a wizard system to the quiz page</p>', 'created', 'normal', 4, NULL, NULL, '2022-09-11 20:37:14', '2022-09-11 20:37:14', 2, 'improvement'),
(9, 'Internal error - Login page', '<p>We got an internal error when we visit the login page (url: /auth/login)</p>', 'created', 'highest', 5, 4, NULL, '2022-09-11 20:58:37', '2022-09-12 13:08:12', 4, 'bug');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_token` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `register_token`, `deleted_at`) VALUES
(4, 'Dark Vador', 'darkvador@gmail.com', NULL, '$2y$10$4f8HPTwKhVzpAP5kas6PN.VP5TlJrgZ0nEcbhrnk6OFtkiUA9czbK', 'OHEZUT3JTudVaM98f52WUSEIBYt2iFVe4x3fIIh5ppc6mbLQkfcvdd7g7Rcq', '2022-09-09 20:04:18', '2022-09-12 14:43:54', 'administrator', NULL, NULL),
(5, 'John DOE', 'johndoe@gmail.com', NULL, '$2y$10$dhwupOVEiVsQpQZeSIJhWutsBYF8pde7/BTViD5j9f8c1CregT9Gq', NULL, '2022-09-11 14:37:09', '2022-09-12 11:39:04', 'employee', NULL, NULL),
(6, 'Jane DOE', 'janedoe@gmail.com', NULL, '$2y$10$l1pWnJh2iUDttzLLlmG5weeTNT7O/UAwsWnPrD8XH8yszCzrhFh82', NULL, '2022-09-11 14:48:37', '2022-09-11 15:08:21', 'customer', NULL, NULL),
(10, 'Thomas Edison', 'thomasedison@gmail.com', NULL, '$2y$10$MR51TVg3xzUXs308oTxp8.Pw9sjs7ijaeGYLJZsq85CdY/azYD0bG', NULL, '2022-09-11 15:31:51', '2022-09-11 15:31:55', 'employee', '82c93eba-9a33-4dbe-abac-22f11f5c1f54', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_projects`
--

CREATE TABLE `user_projects` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `project_id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_owner_id_foreign` (`owner_id`),
  ADD KEY `comments_ticket_id_foreign` (`ticket_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `favorite_projects`
--
ALTER TABLE `favorite_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorite_projects_user_id_foreign` (`user_id`),
  ADD KEY `favorite_projects_project_id_foreign` (`project_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_owner_id_foreign` (`owner_id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_owner_id_foreign` (`owner_id`),
  ADD KEY `tickets_responsible_id_foreign` (`responsible_id`),
  ADD KEY `tickets_project_id_foreign` (`project_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `user_projects`
--
ALTER TABLE `user_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_projects_user_id_foreign` (`user_id`),
  ADD KEY `user_projects_project_id_foreign` (`project_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `favorite_projects`
--
ALTER TABLE `favorite_projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user_projects`
--
ALTER TABLE `user_projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Contraintes pour la table `favorite_projects`
--
ALTER TABLE `favorite_projects`
  ADD CONSTRAINT `favorite_projects_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `favorite_projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `tickets_responsible_id_foreign` FOREIGN KEY (`responsible_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `user_projects`
--
ALTER TABLE `user_projects`
  ADD CONSTRAINT `user_projects_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `user_projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

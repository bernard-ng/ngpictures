INSERT INTO `users` (`id`, `facebook_id`, `name`, `email`, `password`, `phone`, `bio`, `avatar`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `status`, `rank`) VALUES
(1, NULL, 'bernard ng', 'ngandubernard@gmail.com', '$2y$10$SJ/uP.LEYwejSkVGnCEMbO/RDZGdK2w3q8Bc9pi9aTqnNlpJ/hTnu', '+24389253-482', 'Hey, suis sur ngpictures 2.0', 'default.jpg', 'dkdkd', '2018-07-13 00:00:00', NULL, NULL, NULL, 'public', 'admin'),
(2, NULL, 'gervais', 'gervais@gmail.com', '$2y$10$SJ/uP.LEYwejSkVGnCEMbO/RDZGdK2w3q8Bc9pi9aTqnNlpJ/hTnu', '+24389253-482', 'Hey, suis sur ngpictures 2.0', 'ngpictures-avatar-2.jpg', 'dkdkd', '2018-07-13 00:00:00', NULL, NULL, '6316.5b4880a656', 'public', 'user');

INSERT INTO `photographers` (`id`, `label`, `location`, `phone`, `email`, `users_id`)
VALUES (1, 'Ngpictures', 'lackipop 10465', '+243892530482', 'ngandubernard@gmail.com', 1);

INSERT INTO `albums` (`id`, `title`, `description`, `slug`, `code`, `status`, `online`, `date_created`, `photographers_id`)
VALUES (1, 'Général', 'Ngpictures est une galerie photo et un mini résau sociale pour photographe et passionné de la photographie, Nous vous proposons de découvrir la photographie autrement, avec nos différents services étant chrétiens l\'application vous propose une fonctionnalité incroyable, godfirst : partagez et lisez la parole de Dieu avec plus de 500 versets choisis pour vous à l\'avance. En savoir plus', 'general', '5b48f', 'public', 1, '2018-07-13 20:48:57', 1);

INSERT INTO `categories` (`id`, `title`, `slug`, `description`, `date_created`)
VALUES (1, 'Autre', 'autre', 'autre', '2018-07-13 01:26:34'), (2, 'Shooting', 'shooting', 'toutes les photos shooting', '2018-07-13 20:26:07');

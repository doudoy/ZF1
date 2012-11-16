CREATE TABLE IF NOT EXISTS `messages` (
  `idmessage` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `comment` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`idmessage`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

--
-- Contenu de la table `messages`
--

INSERT INTO `messages` (`idmessage`, `email`, `comment`, `created`) VALUES
(1, 'truc@free.fr', 'Message d''exemple', '2012-11-15 23:19:00'),
(2, 'machin@free.fr', 'TEST POUR NEW MESSAGE', '2012-11-15 22:09:00');
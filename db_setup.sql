/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `secreto` varchar(300) NOT NULL,
  `permiso_pagos` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `admins` (`id`, `nombre`, `email`, `secreto`, `permiso_pagos`) VALUES (NULL, 'Admin', 'admin', MD5('admin'), '1');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `name` varchar(50) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `cuota_costo`
--

CREATE TABLE `cuota_costo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_admin` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `tag` varchar(50) NOT NULL,
  `mensaje` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_socio` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `razon` varchar(200) NOT NULL,
  `fecha_pago` date NOT NULL,
  `modo` varchar(100) NOT NULL,
  `notas` text NOT NULL,
  `cancelado` tinyint(1) NOT NULL,
  `descuento` decimal(10,2) NOT NULL,
  `descuento_json` text NOT NULL,
  `rubro` varchar(50) NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `socios`
--

CREATE TABLE `socios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `documento` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tags` varchar(500) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `observaciones` varchar(500) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `hash` varchar(300) NOT NULL,
  `balance_efectivo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recordatorios_deuda`
--

CREATE TABLE `recordatorios_deuda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_socio` int(11) NOT NULL,
  `monto` decimal(10,0) NOT NULL,
  `razon` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `color` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `transacciones_cobrosya`
--

CREATE TABLE `transacciones_cobrosya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_socio` int(11) NOT NULL,
  `cancelado` tinyint(1) NOT NULL,
  `error` text NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `talon` int(20) NOT NULL,
  `talon_url` text NOT NULL,
  `id_secreto` varchar(32) NOT NULL,
  `id_medio_pago` varchar(2) NOT NULL,
  `medio_pago` varchar(50) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_hora_pago` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `transacciones_cobrosya`
--

CREATE TABLE `descuentos_por_trabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_socio` int(11) NOT NULL,
  `razon` varchar(20) NOT NULL,
  `notas` text NOT NULL,
  `descuento` decimal(10,1) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
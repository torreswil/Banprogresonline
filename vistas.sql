-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.10 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-05 17:13:28
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for view bancos.vistaabonos
DROP VIEW IF EXISTS `vistaabonos`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vistaabonos` (
	`id` INT(11) NOT NULL DEFAULT '0',
	`banco` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`cliente` INT(20) NOT NULL,
	`credito` INT(30) NOT NULL,
	`valor` INT(11) NOT NULL,
	`fecha` DATE NOT NULL,
	`soporte` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Dumping structure for view bancos.vistabanco
DROP VIEW IF EXISTS `vistabanco`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vistabanco` (
	`Departamento` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`Muncipio` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`Vereda` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`Nombre` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`Fecha` DATE NULL DEFAULT NULL,
	`Latitud` DOUBLE NULL DEFAULT NULL,
	`longitud` DOUBLE NULL DEFAULT NULL,
	`Direccion` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Id` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Dumping structure for view bancos.vistacliente
DROP VIEW IF EXISTS `vistacliente`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vistacliente` (
	`Identificacion` INT(20) NOT NULL,
	`Nombre1` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`Apellido1` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`Celular` VARCHAR(20) NOT NULL COLLATE 'utf8_general_ci',
	`Direccion` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Municipio` INT(10) NOT NULL,
	`Vereda` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Banco` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`ocupacion` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Dumping structure for view bancos.vistacreditos
DROP VIEW IF EXISTS `vistacreditos`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vistacreditos` (
	`cliente` INT(20) NOT NULL,
	`banco` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`id_credito` INT(30) NOT NULL DEFAULT '0',
	`monto` DECIMAL(20,0) NOT NULL,
	`plazo` INT(3) NOT NULL,
	`periodo_intereses` INT(3) NOT NULL,
	`periodo_capital` INT(3) NOT NULL,
	`fecha_desembolso` DATE NOT NULL,
	`interes_corriente` DOUBLE NOT NULL,
	`interes_mora` DOUBLE NOT NULL
) ENGINE=MyISAM;


-- Dumping structure for view bancos.vistaabonos
DROP VIEW IF EXISTS `vistaabonos`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vistaabonos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vistaabonos` AS select `abonos`.`id_abono` AS `id`,`abonos`.`banco` AS `banco`,`abonos`.`persona` AS `cliente`,`abonos`.`credito` AS `credito`,`transacciones`.`valor` AS `valor`,`transacciones`.`fecha`,abonos.soporte  from (transacciones join abonos on(abonos.transaccion = transacciones.id and abonos.banco=transacciones.banco)) ;


-- Dumping structure for view bancos.vistabanco
DROP VIEW IF EXISTS `vistabanco`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vistabanco`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vistabanco` AS select `departamentos`.`nombre` AS `Departamento`,`municipios`.`nombre_municipio` AS `Muncipio`,`banco`.`localidad` AS `Vereda`,`banco`.`nombre_banco` AS `Nombre`,`banco`.`fecha_creacion` AS `Fecha`,`banco`.`latitud` AS `Latitud`,`banco`.`longitud` AS `longitud`,`banco`.`direccion` AS `Direccion`,`banco`.`id` AS `Id` from ((`municipios` join `banco` on((`banco`.`municipio` = `municipios`.`id`))) join `departamentos` on((`banco`.`departamento` = `departamentos`.`id`))) ;


-- Dumping structure for view bancos.vistacliente
DROP VIEW IF EXISTS `vistacliente`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vistacliente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vistacliente` AS select personas.id as Identificacion, personas.nombre1 as Nombre1, 
personas.apellido1 as Apellido1,personas.celular as Celular, personas.direccion as Direccion,
personas.municipio_residencia as Municipio, personas.localidad as Vereda, clientes.banco as Banco, clientes.ocupacion

 from (personas join clientes on(clientes.persona=personas.id)) ;


-- Dumping structure for view bancos.vistacreditos
DROP VIEW IF EXISTS `vistacreditos`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vistacreditos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vistacreditos` AS select `creditos`.`persona` AS `cliente`,`creditos`.`banco` AS `banco`,`creditos`.`id_credito` AS `id_credito`,`creditos`.`monto` AS `monto`,`creditos`.`plazo` AS `plazo`,`creditos`.`periodo_intereses` AS `periodo_intereses`,`creditos`.`periodo_capital` AS `periodo_capital`,transacciones.fecha as fecha_desembolso, linea_credito.int_corriente as interes_corriente, linea_credito.int_mora as interes_mora from ((transacciones join creditos on((creditos.transaccion = transacciones.id and creditos.banco=transacciones.banco))) join linea_credito on((creditos.linea_credito = linea_credito.id and creditos.banco=linea_credito.banco))) ;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

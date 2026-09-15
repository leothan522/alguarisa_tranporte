-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para alguarisa_transporte
CREATE DATABASE IF NOT EXISTS `alguarisa_transporte_latest` ;
USE `alguarisa_transporte_latest`;

-- Volcando estructura para tabla alguarisa_transporte.choferes
CREATE TABLE IF NOT EXISTS `choferes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `empresas_id` int NOT NULL,
  `vehiculos_id` int DEFAULT NULL,
  `cedula` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.choferes: ~85 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rif` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `responsable` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.empresas: ~21 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.firmantes
CREATE TABLE IF NOT EXISTS `firmantes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cargo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `band` int NOT NULL DEFAULT '1',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.firmantes: ~2 rows (aproximadamente)
INSERT INTO `firmantes` (`id`, `nombre`, `cargo`, `created_at`, `updated_at`, `band`, `rowquid`) VALUES
	(1, 'zorelbis villegas', 'Jefe de Atencion al Ciudadano', '2023-03-20', NULL, 1, 'VURXSdlUwlN0hFku'),
	(2, 'cesar llovera', 'Jefe de Almacen', '2023-03-20', NULL, 1, 'xdLSY2YChZN5RIet');

-- Volcando estructura para tabla alguarisa_transporte.guias
CREATE TABLE IF NOT EXISTS `guias` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `guias_tipos_id` int NOT NULL,
  `tipos_nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `vehiculos_id` int NOT NULL,
  `vehiculos_tipo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `vehiculos_marca` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `vehiculos_placa_batea` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `vehiculos_placa_chuto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `vehiculos_color` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `vehiculos_capacidad` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `choferes_id` int NOT NULL,
  `choferes_cedula` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `choferes_nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `choferes_telefono` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `territorios_origen` int NOT NULL,
  `territorios_destino` int NOT NULL,
  `rutas_id` int NOT NULL,
  `rutas_origen` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rutas_destino` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rutas_ruta` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `users_id` int NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `auditoria` text COLLATE utf8mb4_spanish_ci,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `pdf_id` int DEFAULT '1',
  `pdf_impreso` int DEFAULT '0',
  `estatus` int DEFAULT '1',
  `precinto` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `precinto_2` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `precinto_3` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `version` int DEFAULT '0',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.guias: ~2.171 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.guias_carga
CREATE TABLE IF NOT EXISTS `guias_carga` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `guias_id` int NOT NULL,
  `cantidad` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.guias_carga: ~3.719 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.guias_tipos
CREATE TABLE IF NOT EXISTS `guias_tipos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.guias_tipos: ~2 rows (aproximadamente)
INSERT INTO `guias_tipos` (`id`, `nombre`, `codigo`, `rowquid`) VALUES
	(1, 'BOLSAS CLAP', 'BC', 'EHajXzLjLu7munMq'),
	(2, 'RUBROS', 'RB', 'mujJswTWS9jlfC9H');

-- Volcando estructura para tabla alguarisa_transporte.municipios
CREATE TABLE IF NOT EXISTS `municipios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mini` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parroquias` int DEFAULT '0',
  `familias` int unsigned DEFAULT NULL,
  `estatus` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.municipios: ~16 rows (aproximadamente)
INSERT INTO `municipios` (`id`, `nombre`, `mini`, `parroquias`, `familias`, `estatus`, `created_at`, `updated_at`, `rowquid`) VALUES
	(1, 'JUAN GERMAN ROSCIO NIEVES', 'ROSCIO', 3, 32586, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'AArStB2MRjRCchOl'),
	(2, 'FRANCISCO DE MIRANDA', 'MIRANDA', 4, 34452, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'vEftUemVBCvbdfBj'),
	(3, 'LEONARDO INFANTE', 'INFANTE', 2, 24811, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'TYZ0omx5bJahfRFC'),
	(4, 'PEDRO ZARAZA', 'ZARAZA', 2, 20063, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'OFWxTg6Ex0AXvXuL'),
	(5, 'JOSE TADEO MONAGAS', 'MONAGAS', 7, 14086, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', '1uAnDzoz00OUOjmK'),
	(6, 'JOSE FELIX RIBAS', 'RIBAS', 2, 9551, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'XMPRBprGjahohgA6'),
	(7, 'CAMAGUAN', 'CAMAGUAN', 3, 1235, 1, '2023-10-23 18:47:26', '2024-01-09 04:00:00', 'YlvXaYwdm8c0GhTt'),
	(8, 'JULIAN MELLADO', 'MELLADO', 2, 6838, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'ZdCp8BN5pjZ8xkps'),
	(9, 'EL SOCORRO', 'EL SOCORRO', 1, 7146, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'fKoBwSe5gzFiZHTp'),
	(10, 'SANTA MARIA DE IPIRE', 'SANTA MARIA', 2, 4631, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'ItX5hGeOoCz3E8hg'),
	(11, 'CHAGUARAMAS', 'CHAGUARAMAS', 1, 1588, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'ueHvKuofMlBJFw8E'),
	(12, 'JUAN JOSE RONDON', 'RONDON', 3, 420, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', '1BsAKkFusv8mBxg9'),
	(13, 'SAN JOSE DE GUARIBE', 'GUARIBE', 1, 2936, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'VZFnTH3syLtk1itT'),
	(14, 'SAN GERONIMO DE GUAYABAL', 'GUAYABAL', 2, 7096, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'JdmuYrC2EfV99vkV'),
	(15, 'ORTIZ', 'ORTIZ', 4, 6581, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', 'cD38cVMqDTEsPFAa'),
	(19, 'PERSONALIZADO', 'PERSONALIZADO', 1, 1, 1, '2024-12-18 04:00:00', NULL, 'ht0t6F0UyC0KtFRk');

-- Volcando estructura para tabla alguarisa_transporte.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tabla_id` int DEFAULT NULL,
  `valor` text COLLATE utf8mb4_spanish_ci,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.parametros: ~7 rows (aproximadamente)
INSERT INTO `parametros` (`id`, `nombre`, `tabla_id`, `valor`, `rowquid`) VALUES
	(1, 'fecha_compilacion', NULL, '2026-09-15 18:04:22', 'wElXmrXnhpoxejba'),
	(2, 'php_version', NULL, 'v.8', 'm1LUC6zQAVSfJRJr'),
	(6, 'guias_num_init', NULL, '2912', 'Q7GqIajOjdEpL6XX'),
	(9, 'id_capital_estado', 1, '', 'ApNDV9AyAsNrO0Xq'),
	(11, 'numRowsPaginate', NULL, '10', 'VoHC7E0TlzLIXNnW'),
	(12, 'Transporte', -1, '{"guias.index":true,"guias.create":true,"guias.edit":true,"guias.anular":true,"guias.descargar":true,"choferes.index":true,"choferes.create":true,"choferes.edit":true,"choferes.destroy":true,"choferes.descargar":true,"choferes.estatus":true,"vehiculos.index":true,"vehiculos.create":true,"vehiculos.edit":true,"vehiculos.destroy":true,"empresas.index":true,"empresas.create":true,"empresas.edit":true,"empresas.destroy":true,"rutas.index":true,"rutas.create":true,"rutas.edit":true,"rutas.destroy":true}', 'mFlSnhMYX8iim2A0'),
	(13, 'guias_formatos_pdf', NULL, 'format_2026', '5QO6MVW4Car3aQGe');

-- Volcando estructura para tabla alguarisa_transporte.parroquias
CREATE TABLE IF NOT EXISTS `parroquias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mini` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipios_id` bigint unsigned NOT NULL,
  `familias` int unsigned DEFAULT NULL,
  `estatus` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `parroquias_municipios_id_foreign` (`municipios_id`),
  CONSTRAINT `parroquias_municipios_id_foreign` FOREIGN KEY (`municipios_id`) REFERENCES `municipios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.parroquias: ~40 rows (aproximadamente)
INSERT INTO `parroquias` (`id`, `nombre`, `mini`, `municipios_id`, `familias`, `estatus`, `created_at`, `updated_at`, `rowquid`) VALUES
	(1, 'CAMAGUAN', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'XKcEK9jiuJPaRJsm'),
	(2, 'PUERTO MIRANDA', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'KruIjBqDgahj3aNK'),
	(3, 'UVERITO', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'RN6cWE286ANChTxc'),
	(4, 'CHAGUARAMAS', NULL, 11, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'oxe41wkqpd0lfzaR'),
	(5, 'EL SOCORRO', NULL, 9, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'BzvOb42HrU3L6qyq'),
	(6, 'CALABOZO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'eOB5oRHuwX4bA3ST'),
	(7, 'EL RASTRO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', '1tL1MTq5pXRS6GWF'),
	(8, 'GUARDATINAJAS', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'XC7ZUUTC4X6kVfUN'),
	(9, 'EL CALVARIO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'iofbJacFWU5kzgz3'),
	(10, 'TUCUPIDO', NULL, 6, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'pF4xalUuP9RdCNtC'),
	(11, 'SAN RAFAEL DE LAYA', NULL, 6, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'GajW7PAlZ73Qv6yY'),
	(12, 'ALTAGRACIA DE ORITUCO', 'ALTAGRACIA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', '9QPKq45rFca8NHRR'),
	(13, 'SAN RAFAEL DE ORITUCO', 'SAN RAFAEL', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'wEmvLffJCjTLASxg'),
	(14, 'LIBERTAD DE ORITUCO', 'LIBERTAD', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'tL04Al2FJDBQYs10'),
	(15, 'SAN FRANCISCO DE MACAIRA', 'MACAIRA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'kxDAfSjPj8OAQeqJ'),
	(16, 'PASO REAL DE MACAIRA', 'PASO REAL', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'BDOK8p3SkaTSpLV9'),
	(17, 'CARLOS SOUBLETTE', 'SOUBLETTE', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'PJUMttpEOUUTHdnt'),
	(18, 'FRANCISCO JAVIER DE LAZAMA', 'LEZAMA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'BR06C5gqKBAKOLxw'),
	(19, 'SAN JUAN DE LOS MORROS', 'SAN JUAN', 1, 1, 1, '2023-09-27 12:03:48', '2024-08-14 04:00:00', 'IQ8lFAun7iWVHLvf'),
	(20, 'PARAPARA', NULL, 1, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'PYrX0RfrfdCux2Dq'),
	(21, 'CANTAGALLO', NULL, 1, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'Da3f1Wq0vOmKN0Dm'),
	(22, 'LAS MERCEDES DEL LLANO', 'LAS MERCEDES', 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'HHB1jiU0IO5RK8jy'),
	(23, 'SANTA RITA DE MANAPIRE', 'SANTA RITA', 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'q6CYxf1LijUFjZFs'),
	(24, 'CABRUTA', NULL, 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', '4Lo7iT7rDM2SOonu'),
	(25, 'EL SOMBRERO', NULL, 8, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'qBtC60SgN5DXuzhM'),
	(26, 'SOSA', NULL, 8, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'vt091VtriS3OUA9n'),
	(27, 'VALLE DE LA PASCUA', NULL, 3, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'Wt2f0Fo4jBMgc8ht'),
	(28, 'ESPINO', NULL, 3, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'kCsCBC5bdAkTt1y1'),
	(29, 'ORTIZ', 'ORTIZ', 15, 1, 1, '2023-09-27 12:03:48', '2024-08-15 04:00:00', 'li3RMk36Nq6KKhFz'),
	(30, 'SAN JOSE DE TIZNADOS', 'SAN JOSE', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'I2Vdvrc3oJUT0xda'),
	(31, 'SAN LORENZO DE TIZNADOS', 'SAN LORENZO', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'JJOjysqxxZY6dtGI'),
	(32, 'SAN FRANCISCO DE TIZNADOSº', 'SAN FRANCISCO', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'XKhHraqMQaBVMPD0'),
	(33, 'ZARAZA', NULL, 4, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'JCbD1Cs36YxAPWR8'),
	(34, 'SAN JOSE DE UNARE', NULL, 4, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', '0hzgV5dLVEZMIoj9'),
	(35, 'GUAYABAL', NULL, 14, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'HJefc53m9hl5Aq5S'),
	(36, 'CAZORLA', NULL, 14, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'J8qpvTOFnKGFsPha'),
	(37, 'GUARIBE', NULL, 13, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'VrtVcUNFiApSR7rV'),
	(38, 'SANTA MARIA', NULL, 10, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'oGHSitZG1LyihNpo'),
	(39, 'ALTAMIRA', NULL, 10, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', 'JOeJquiaQwokNAc2'),
	(42, 'PERSONALIZADO', 'PERSONALIZADO', 19, 1, 1, '2024-12-18 04:00:00', NULL, 'Ahs4L576oD7KM1mM');

-- Volcando estructura para tabla alguarisa_transporte.rutas
CREATE TABLE IF NOT EXISTS `rutas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `origen` int unsigned NOT NULL,
  `destino` int unsigned NOT NULL,
  `ruta` text COLLATE utf8mb4_spanish_ci,
  `band` int DEFAULT '1',
  `version` int DEFAULT '0',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.rutas: ~39 rows (aproximadamente)
INSERT INTO `rutas` (`id`, `origen`, `destino`, `ruta`, `band`, `version`, `created_at`, `updated_at`, `rowquid`) VALUES
	(1, 1, 11, '["EL TOCO ","PARAPARA"]', 1, 0, '2023-05-16', NULL, 'V6rHmEFxleGounsT'),
	(2, 1, 6, '["EL TOCO ","PARAPARA","ORTIZ","DOS CAMINOS"]', 1, 0, '2023-05-16', NULL, 'SXoeixOA777nfD9g'),
	(3, 1, 4, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","CALABOZO","COROZOPANDO"]', 1, 0, '2023-05-16', NULL, 'aG6KMSvehg5XBpkd'),
	(4, 1, 12, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","CALABOZO","COROZOPANDO","CAMAGUAN"]', 1, 0, '2023-05-16', NULL, '2hBYr5WyU7QMOan4'),
	(5, 1, 3, '["EL TOCO ","PARAPARA","ORTIZ","DOS CAMINO","TIGUIGUE","EL SOMBRERO"]', 1, 0, '2023-05-16', NULL, 'hFhO5omcSpW5R6Wx'),
	(6, 1, 5, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMA","VALLE DE LA PASCUA"]', 1, 0, '2023-05-16', NULL, 'oA1yDE77HQCCE6AT'),
	(7, 1, 13, '["SAN JUAN ","SAN SEBASTIAN","TAGUAI","ALTAGRACIA DE ORITUCO"]', 1, 0, '2023-05-16', NULL, '2EFDkMDYYMhEmFzx'),
	(8, 1, 7, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMA"]', 1, 0, '2023-05-16', NULL, 'SzmqM4ubpfJI7YPt'),
	(9, 1, 16, '["SAN SEBASTIAN","PARDILLAL","TAGUAI"]', 1, 0, '2023-05-16', '2023-05-24', '296i546rZtQxnzMT'),
	(10, 1, 10, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE"]', 1, 0, '2023-05-16', NULL, 'cKfHrJdlDT6P5iJD'),
	(11, 1, 9, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMA","VALLE DE LA PASCUA"]', 1, 0, '2023-05-16', NULL, 'u3jr3lDbVmK8StiS'),
	(12, 1, 8, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMA"]', 1, 0, '2023-05-16', NULL, 'h1utzM0DV4NRuQJr'),
	(13, 1, 14, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMA","VALLE DE LA PASCUA","EL SOCORRO"]', 1, 0, '2023-05-16', NULL, 'EAA1OFHWI3zEQLlE'),
	(14, 1, 15, '["EL TOCO ","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMA","VALLE DE LA PASCUA","TUCUPIDO"]', 1, 0, '2023-05-16', NULL, 'XExbWGUXIiJYa7Ah'),
	(15, 1, 2, '["EL TOCO","PARAPARA","ORTIZ","DOS CAMINOS"]', 1, 0, '2023-05-30', NULL, 'Ghmy8556dsmFwzAn'),
	(16, 5, 9, '["valle de la pascua"]', 1, 0, '2023-07-20', NULL, '89kN9Y4A6RgJX8aN'),
	(21, 19, 29, '["EL TOCO","PARAPARA"]', 1, 1, '2024-08-13', NULL, 'jMrLw5KNNUdDIGwG'),
	(22, 19, 6, '["EL TOCO","PARAPARA","ORTIZ","DOS CAMINOS"]', 1, 1, '2024-08-13', NULL, '08CVuCwILQi4ws1y'),
	(23, 19, 1, '["EL TOCO"," PAPARARA","ORTIZ","DOS CAMINOS","CALABOZO","COROZOPANDO"]', 1, 1, '2024-08-13', NULL, 'UvlsgPu7hf2xNm3Q'),
	(24, 19, 35, '["EL TOCO","PAPARARA","ORTIZ","DOS CAMINOS","CALABOZO","COROZOPANDO","CAMAGUAN"]', 1, 1, '2024-08-13', NULL, 'CbPGXYz7N1cTEsBr'),
	(25, 19, 4, '["EL TOCO","PARAPARA","ORTIZ","DOS CAMINO","TIGUIGUE","EL SOMBRERO"]', 1, 1, '2024-08-13', NULL, '8C0tVLJX2JwxRm06'),
	(26, 19, 5, '["EL TOCO","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMAS","VALLE DE LA PASCUA"]', 1, 1, '2024-08-19', NULL, 'tHUybHFl8ExSh5MY'),
	(27, 19, 37, '["SAN JUAN"," SAN SEBASTIAN","TAGUAI","ALTAGRACIA DE ORITUCO"]', 1, 1, '2024-08-19', NULL, 'Kw9vxNS2HbYdQLR6'),
	(28, 19, 27, '["EL TOCO","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE"," EL SOMBRERO","CHAGUARAMAS"]', 1, 1, '2024-08-19', NULL, 'G68TaTGc9jNPH6Eo'),
	(29, 19, 12, '["SAN SEBASTIAN","PARDILLAL","TAGUAI"]', 1, 1, '2024-08-19', NULL, 'Vld3V6xLP43ZaXoL'),
	(30, 19, 25, '["EL TOCO","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE"]', 1, 1, '2024-08-19', NULL, '5ka9nboQgil3HfVx'),
	(31, 19, 10, '["EL TOCO","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMA","VALLE DE LA PASCUA"]', 1, 1, '2024-08-19', NULL, 'hR0rNnUlYgX9Q9HB'),
	(32, 19, 22, '["EL TOCO","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMAS"]', 1, 1, '2024-08-19', NULL, 'Qxw1DUshkLfLLOFI'),
	(33, 19, 38, '["EL TOCO","PAPARARA","ORTIZ","DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMAS","VALLE DE LA PASCUA"," EL SOCORRO"]', 1, 1, '2024-08-19', NULL, '77TNrQwx02zeJFPf'),
	(34, 19, 33, '["EL TOCO","PAPARARA","ORTIZ"," DOS CAMINOS","TIGUIGUE","EL SOMBRERO","CHAGUARAMAS","VALLE DE LA PASCUA","TUCUPIDO"]', 1, 1, '2024-08-19', NULL, 'xZGcRikbR0uAt076'),
	(35, 19, 30, '["EL TOCO","PARAPARA","ORTIZ","DOS CAMINOS"]', 1, 1, '2024-08-19', NULL, 'EEd5eEEec4eZu8w0'),
	(36, 5, 10, '["VALLE DE LA PASCUA"]', 1, 1, '2024-08-19', NULL, 'q1iTBW3B7OvDuBzo'),
	(37, 22, 27, '["CHAGUARAMAS"]', 1, 1, '2024-08-22', NULL, 'vBgCioevw0nSEeJ6'),
	(38, 35, 4, '["CAMAGUAN ","COROZOPANDO","CALABOZO","DOS CAMINOS","TIGUIGUE","EL SOMBRERO"]', 1, 1, '2024-10-14', NULL, 'vftgoCLJfvBkvYTV'),
	(39, 25, 32, '["TIGUIGUE","DOS CAMINOS"]', 1, 1, '2024-10-19', NULL, 'Y5yknEHjgCy4BIJZ'),
	(40, 19, 42, '["SAN SEBASTIAN ","SAN CASIMIRO"]', 1, 1, '2024-12-18', NULL, 'qNqgByZXbIt4uMEy'),
	(41, 33, 32, '["Tucupido, Valle de la Pascua, Chaguaramas, El Sombrero, Dos Caminos , San Francisco de Tiznados"]', 1, 1, '2025-05-26', NULL, '7aKwLKOj5O6XxqjT'),
	(42, 19, 23, '["EL TOCO, PARAPARA, ORTIZ, DOS CAMINOS, TIGUIGUE, EL SOMBRERO, CHAGUARAMAS,  LAS MERCEDES, "]', 1, 1, '2026-02-06', NULL, 'lcKvmSRMoX2mWGN2'),
	(43, 19, 24, '["EL TOCO, PARAPARA, ORTIZ, DOS CAMINOS, TIGUIGUE, EL SOMBRERO, CHAGUARAMAS,  LAS MERCEDES, ","santa rita"]', 1, 1, '2026-08-07', NULL, 'qR15fD9CR45ayeCi');

-- Volcando estructura para tabla alguarisa_transporte.rutas_territorio
CREATE TABLE IF NOT EXISTS `rutas_territorio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `municipio` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `parroquia` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.rutas_territorio: ~16 rows (aproximadamente)
INSERT INTO `rutas_territorio` (`id`, `municipio`, `parroquia`, `rowquid`) VALUES
	(1, 'JUAN GERMAN ROSCIO NIEVES CAPITAL', 'SAN JUAN DE LOS MORROS', 'qIAof3DhLbgK2kq2'),
	(2, 'ORTIZ', 'SAN JOSE DE TIZNADO', 'GtN93PVwNx4DXaF1'),
	(3, 'CHAGUARAMAS', 'CHAGUARAMAS', 'IUXsPbem3slk2Mfv'),
	(4, 'CAMAGUAN', 'CAMAGUAN', 'f40G3FRYLUdjIgGk'),
	(5, 'EL SOCORRO', 'EL SOCORRO', 'QAW0OIBffGqYyJ5w'),
	(6, 'FRANCISCO DE MIRANDA', 'CALABOZO', 'WfrVyqRrsk7xZpPA'),
	(7, 'LEONARDO INFANTE', 'VALLE DE LA PASCUA', 'dUtIGL3qf8hwMgJu'),
	(8, 'JUAN JOSE RONDON', 'LAS MERCEDES', 'hLuVbeZpmyHbM9sh'),
	(9, 'JOSE FELIX RIBAS', 'TUCUPIDO', 'Gbotrqnk7BHpRery'),
	(10, 'JULIAN MELLADO', 'EL SOMBRERO', 'qQGlyBH2aIDDM7TU'),
	(11, 'ORTIZ', 'ORTIZ', 'QyRFgGT3OZu5IeRH'),
	(12, 'SAN GERONIMO DE GUAYABAL', 'GUAYABAL', 'anBrkfJskpdCUKj5'),
	(13, 'SAN JOSE DE GUARIBE', 'GUARIBE', '1LrLIQwrTXzJSIiV'),
	(14, 'SANTA MARIA DE IPIRE', 'SANTA MARIA', '7Dzjowh7bogHJvr1'),
	(15, 'PEDRO ZARAZA', 'ZARAZA', 'yx0IHvxxKTzryxUY'),
	(16, 'JOSE TADEOS MONAGAS', 'ALTAGRACIA DE ORITUCO', 'QPfelA8aQWckml81');

-- Volcando estructura para tabla alguarisa_transporte.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `token` text COLLATE utf8mb4_spanish_ci,
  `date_token` datetime DEFAULT NULL,
  `path` text COLLATE utf8mb4_spanish_ci,
  `role` int NOT NULL DEFAULT '0',
  `role_id` int DEFAULT '0',
  `permisos` text COLLATE utf8mb4_spanish_ci,
  `acceso_municipio` text COLLATE utf8mb4_spanish_ci,
  `estatus` int NOT NULL DEFAULT '1',
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `dispositivo` int DEFAULT '0',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.users: ~3 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `telefono`, `token`, `date_token`, `path`, `role`, `role_id`, `permisos`, `acceso_municipio`, `estatus`, `band`, `created_at`, `updated_at`, `deleted_at`, `dispositivo`, `rowquid`) VALUES
	(1, 'Yonathan Castillo', 'leothan522@gmail.com', '$2y$10$P7uNBW6cLTouGVhfpkv80O.7LxYNBYY6POFuu6SBGey3ZFgB9V556', '(0424) 338-66.00', 'qvXhRQZjWE1XZW6HfbU07WPP2cxZ71sPpjI07pGvIXDMfrr95M', '2025-07-02 23:36:52', 'public/img/profile/user_id_LzxIXC.png', 100, 0, NULL, NULL, 1, 1, '2023-08-12', '2024-08-19', NULL, 0, 'hlzwbyiCAx7p5dDk'),
	(2, 'Antonny Maluenga', 'gabrielmalu15@gmail.com', '$2y$10$/0DPqN9CcJbwyUUPqNYiM.bDY1Grnz96s7lLSagQLmQXe.14A56kq', '(0412) 199-56.47', 'l7R4j5oqsZWnEQaNNywS1CdlHJ2ILLzYsEfvVI37HObo7sTn8Q', '2024-11-21 16:02:33', 'public/img/profile/user_id_C6OXn3.jpg', 100, 0, NULL, NULL, 1, 1, '2023-08-28', '2024-08-22', NULL, 0, 'WEIKNb70fswJkzm1'),
	(3, 'Transporte', 'alguarisa.transporte@gmail.com', '$2y$10$iGJMuMx8toiKmZpeYR30NuBbWJxmCaAjd9KvndGYB7vHjDDvRZC16', '(0414) 493-10.87', NULL, NULL, 'public/img/profile/user_id_jmTLKa.png', 2, 12, '{"guias.index":true,"guias.create":true,"guias.edit":true,"guias.anular":true,"guias.descargar":true,"choferes.index":true,"choferes.create":true,"choferes.edit":true,"choferes.destroy":true,"choferes.descargar":true,"choferes.estatus":true,"vehiculos.index":true,"vehiculos.create":true,"vehiculos.edit":true,"vehiculos.destroy":true,"empresas.index":true,"empresas.create":true,"empresas.edit":true,"empresas.destroy":true,"rutas.index":true,"rutas.create":true,"rutas.edit":true,"rutas.destroy":true}', NULL, 1, 1, '2024-08-22', '2024-08-22', NULL, 0, '9h30k4rZnrkiKHUL');

-- Volcando estructura para tabla alguarisa_transporte.vehiculos
CREATE TABLE IF NOT EXISTS `vehiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `empresas_id` int NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `marca` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `placa_batea` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `placa_chuto` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `capacidad` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.vehiculos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.vehiculos_tipo
CREATE TABLE IF NOT EXISTS `vehiculos_tipo` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.vehiculos_tipo: ~3 rows (aproximadamente)
INSERT INTO `vehiculos_tipo` (`id`, `nombre`, `rowquid`) VALUES
	(1, 'GANDOLA PLATAFORMA', 'ks8fw3tGawm9F5iU'),
	(2, 'CAMION PLATAFORMA', 'vHHPiEou98BHM1IX'),
	(3, 'CAMION CAVA', 'dozLPMVkLi8Ni99t');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

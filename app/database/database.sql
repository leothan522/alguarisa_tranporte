-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
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
CREATE DATABASE IF NOT EXISTS `alguarisa_transporte` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `alguarisa_transporte`;

-- Volcando estructura para tabla alguarisa_transporte.cargos
CREATE TABLE IF NOT EXISTS `cargos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cargo` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.cargos: ~64 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.casos
CREATE TABLE IF NOT EXISTS `casos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personas_id` int NOT NULL,
  `fecha` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '',
  `hora` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '',
  `donativo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `observacion` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.casos: ~281 rows (aproximadamente)

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

-- Volcando datos para la tabla alguarisa_transporte.choferes: ~67 rows (aproximadamente)

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

-- Volcando datos para la tabla alguarisa_transporte.empresas: ~19 rows (aproximadamente)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.firmantes: ~2 rows (aproximadamente)

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

-- Volcando datos para la tabla alguarisa_transporte.guias: ~1.478 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.guias_carga
CREATE TABLE IF NOT EXISTS `guias_carga` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `guias_id` int NOT NULL,
  `cantidad` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.guias_carga: ~2.682 rows (aproximadamente)

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
	(1, 'BOLSAS CLAP', 'BC', NULL),
	(2, 'RUBROS', 'RB', NULL);

-- Volcando estructura para tabla alguarisa_transporte.instituciones
CREATE TABLE IF NOT EXISTS `instituciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rif` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.instituciones: ~20 rows (aproximadamente)

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.municipios: ~15 rows (aproximadamente)
INSERT INTO `municipios` (`id`, `nombre`, `mini`, `parroquias`, `familias`, `estatus`, `created_at`, `updated_at`, `rowquid`) VALUES
	(1, 'JUAN GERMAN ROSCIO NIEVES', 'ROSCIO', 3, 32586, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(2, 'FRANCISCO DE MIRANDA', 'MIRANDA', 4, 34452, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(3, 'LEONARDO INFANTE', 'INFANTE', 2, 24811, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(4, 'PEDRO ZARAZA', 'ZARAZA', 2, 20063, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(5, 'JOSE TADEO MONAGAS', 'MONAGAS', 7, 14086, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(6, 'JOSE FELIX RIBAS', 'RIBAS', 2, 9551, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(7, 'CAMAGUAN', 'CAMAGUAN', 3, 1235, 1, '2023-10-23 18:47:26', '2024-01-09 04:00:00', NULL),
	(8, 'JULIAN MELLADO', 'MELLADO', 2, 6838, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(9, 'EL SOCORRO', 'EL SOCORRO', 1, 7146, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(10, 'SANTA MARIA DE IPIRE', 'SANTA MARIA', 2, 4631, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(11, 'CHAGUARAMAS', 'CHAGUARAMAS', 1, 1588, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(12, 'JUAN JOSE RONDON', 'RONDON', 3, 420, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(13, 'SAN JOSE DE GUARIBE', 'GUARIBE', 1, 2936, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(14, 'SAN GERONIMO DE GUAYABAL', 'GUAYABAL', 2, 7096, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL),
	(15, 'ORTIZ', 'ORTIZ', 4, 6581, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26', NULL);

-- Volcando estructura para tabla alguarisa_transporte.nomina
CREATE TABLE IF NOT EXISTS `nomina` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cedula` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellido` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cargos_id` int DEFAULT NULL,
  `administrativa_id` int DEFAULT NULL,
  `geografica_id` int DEFAULT NULL,
  `cargo` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ubicacion_administrativa` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ubicacion_geografica` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `band` int NOT NULL DEFAULT '1',
  `carnet` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `path` text COLLATE utf8mb4_spanish_ci,
  `mini` text COLLATE utf8mb4_spanish_ci,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.nomina: ~269 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.nomina_cargos
CREATE TABLE IF NOT EXISTS `nomina_cargos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cargo` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.nomina_cargos: ~64 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.nomina_ubicaciones
CREATE TABLE IF NOT EXISTS `nomina_ubicaciones` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.nomina_ubicaciones: ~34 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.oficios
CREATE TABLE IF NOT EXISTS `oficios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `instituciones_id` int NOT NULL,
  `personas_id` int NOT NULL,
  `fecha` date NOT NULL,
  `requerimientos` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `band` int NOT NULL DEFAULT '1',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.oficios: ~2 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tabla_id` int DEFAULT NULL,
  `valor` text COLLATE utf8mb4_spanish_ci,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.parametros: ~6 rows (aproximadamente)
INSERT INTO `parametros` (`id`, `nombre`, `tabla_id`, `valor`, `rowquid`) VALUES
	(1, 'fecha_compilacion', NULL, '2024-05-07 14:39:21', NULL),
	(2, 'php_version', NULL, 'v.8', NULL),
	(3, 'id_capital_estado', 1, '', NULL),
	(4, 'Transporte', -1, '{"guias.index":true,"guias.create":true,"guias.edit":true,"guias.anular":true,"guias.descargar":true,"choferes.index":true,"choferes.create":true,"choferes.edit":true,"choferes.destroy":true,"choferes.descargar":true,"vehiculos.index":true,"vehiculos.create":true,"vehiculos.edit":true,"vehiculos.destroy":true,"empresas.index":true,"empresas.create":true,"empresas.edit":true,"empresas.destroy":true,"rutas.index":true,"rutas.create":true,"rutas.edit":true,"rutas.destroy":true}', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.parroquias: ~39 rows (aproximadamente)
INSERT INTO `parroquias` (`id`, `nombre`, `mini`, `municipios_id`, `familias`, `estatus`, `created_at`, `updated_at`, `rowquid`) VALUES
	(1, 'CAMAGUAN', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(2, 'PUERTO MIRANDA', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(3, 'UVERITO', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(4, 'CHAGUARAMAS', NULL, 11, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(5, 'EL SOCORRO', NULL, 9, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(6, 'CALABOZO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(7, 'EL RASTRO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(8, 'GUARDATINAJAS', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(9, 'EL CALVARIO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(10, 'TUCUPIDO', NULL, 6, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(11, 'SAN RAFAEL DE LAYA', NULL, 6, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(12, 'ALTAGRACIA DE ORITUCO', 'ALTAGRACIA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(13, 'SAN RAFAEL DE ORITUCO', 'SAN RAFAEL', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(14, 'LIBERTAD DE ORITUCO', 'LIBERTAD', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(15, 'SAN FRANCISCO DE MACAIRA', 'MACAIRA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(16, 'PASO REAL DE MACAIRA', 'PASO REAL', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(17, 'CARLOS SOUBLETTE', 'SOUBLETTE', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(18, 'FRANCISCO JAVIER DE LAZAMA', 'LEZAMA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(19, 'SAN JUAN DE LOS MORROS', 'SAN JUAN', 1, 1, 1, '2023-09-27 12:03:48', '2024-08-14 04:00:00', NULL),
	(20, 'PARAPARA', NULL, 1, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(21, 'CANTAGALLO', NULL, 1, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(22, 'LAS MERCEDES DEL LLANO', 'LAS MERCEDES', 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(23, 'SANTA RITA DE MANAPIRE', 'SANTA RITA', 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(24, 'CABRUTA', NULL, 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(25, 'EL SOMBRERO', NULL, 8, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(26, 'SOSA', NULL, 8, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(27, 'VALLE DE LA PASCUA', NULL, 3, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(28, 'ESPINO', NULL, 3, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(29, 'ORTIZ', 'ORTIZ', 15, 1, 1, '2023-09-27 12:03:48', '2024-08-15 04:00:00', NULL),
	(30, 'SAN JOSE DE TIZNADOS', 'SAN JOSE', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(31, 'SAN LORENZO DE TIZNADOS', 'SAN LORENZO', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(32, 'SAN FRANCISCO DE TIZNADOSº', 'SAN FRANCISCO', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(33, 'ZARAZA', NULL, 4, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(34, 'SAN JOSE DE UNARE', NULL, 4, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(35, 'GUAYABAL', NULL, 14, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(36, 'CAZORLA', NULL, 14, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(37, 'GUARIBE', NULL, 13, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(38, 'SANTA MARIA', NULL, 10, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL),
	(39, 'ALTAMIRA', NULL, 10, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48', NULL);

-- Volcando estructura para tabla alguarisa_transporte.personas
CREATE TABLE IF NOT EXISTS `personas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cedula` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.personas: ~169 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `casos_id` int NOT NULL,
  `producto` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `band` int NOT NULL DEFAULT '1',
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.productos: ~0 rows (aproximadamente)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.rutas: ~0 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.rutas_territorio
CREATE TABLE IF NOT EXISTS `rutas_territorio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `municipio` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `parroquia` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rowquid` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.rutas_territorio: ~0 rows (aproximadamente)

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.users: ~0 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `telefono`, `token`, `date_token`, `path`, `role`, `role_id`, `permisos`, `acceso_municipio`, `estatus`, `band`, `created_at`, `updated_at`, `deleted_at`, `dispositivo`, `rowquid`) VALUES
	(1, 'Yonathan Castillo', 'leothan522@gmail.com', '$2y$10$P7uNBW6cLTouGVhfpkv80O.7LxYNBYY6POFuu6SBGey3ZFgB9V556', '(0424) 338-66.00', NULL, NULL, 'public/img/profile/user_id_XGQj9n.png', 100, 0, NULL, NULL, 1, 1, '2023-08-12', '2024-08-19', NULL, 0, NULL),
	(2, 'Antonny Maluenga', 'gabrielmalu15@gmail.com', '$2y$10$/0DPqN9CcJbwyUUPqNYiM.bDY1Grnz96s7lLSagQLmQXe.14A56kq', '(0412) 199-56.47', NULL, NULL, 'public/img/profile/user_id_C6OXn3.jpg', 100, 0, NULL, NULL, 1, 1, '2023-08-28', '2024-08-22', NULL, 0, NULL);

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
	(1, 'GANDOLA PLATAFORMA', NULL),
	(2, 'CAMION PLATAFORMA', NULL),
	(3, 'CAMION CAVA', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

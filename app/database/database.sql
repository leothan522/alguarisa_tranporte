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
CREATE DATABASE IF NOT EXISTS `alguarisa_transporte` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `alguarisa_transporte`;

-- Volcando estructura para tabla alguarisa_transporte.municipios
CREATE TABLE IF NOT EXISTS `municipios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mini` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parroquias` int DEFAULT '0',
  `familias` int unsigned DEFAULT NULL,
  `estatus` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.municipios: ~14 rows (aproximadamente)
INSERT INTO `municipios` (`id`, `nombre`, `mini`, `parroquias`, `familias`, `estatus`, `created_at`, `updated_at`) VALUES
	(2, 'FRANCISCO DE MIRANDA', 'MIRANDA', 4, 34452, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(3, 'LEONARDO INFANTE', 'INFANTE', 2, 24811, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(4, 'PEDRO ZARAZA', 'ZARAZA', 2, 20063, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(5, 'JOSE TADEO MONAGAS', 'MONAGAS', 7, 14086, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(6, 'JOSE FELIX RIBAS', 'RIBAS', 2, 9551, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(7, 'CAMAGUAN', 'CAMAGUAN', 3, 1235, 1, '2023-10-23 18:47:26', '2024-01-09 04:00:00'),
	(8, 'JULIAN MELLADO', 'MELLADO', 2, 6838, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(9, 'EL SOCORRO', 'EL SOCORRO', 1, 7146, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(10, 'SANTA MARIA DE IPIRE', 'SANTA MARIA', 2, 4631, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(11, 'CHAGUARAMAS', 'CHAGUARAMAS', 1, 1588, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(12, 'JUAN JOSE RONDON', 'RONDON', 3, 420, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(13, 'SAN JOSE DE GUARIBE', 'GUARIBE', 1, 2936, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(14, 'SAN GERONIMO DE GUAYABAL', 'GUAYABAL', 2, 7096, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26'),
	(15, 'ORTIZ', 'ORTIZ', 4, 6581, 1, '2023-10-23 18:47:26', '2023-10-23 18:47:26');

-- Volcando estructura para tabla alguarisa_transporte.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tabla_id` int DEFAULT NULL,
  `valor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.parametros: ~3 rows (aproximadamente)
INSERT INTO `parametros` (`id`, `nombre`, `tabla_id`, `valor`) VALUES
	(1, 'fecha_compilacion', NULL, '2024-05-07 14:39:21'),
	(2, 'php_version', NULL, 'v.8'),
	(3, 'guias_num_init', 0, '1806');

-- Volcando estructura para tabla alguarisa_transporte.parroquias
CREATE TABLE IF NOT EXISTS `parroquias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mini` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipios_id` bigint unsigned NOT NULL,
  `familias` int unsigned DEFAULT NULL,
  `estatus` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parroquias_municipios_id_foreign` (`municipios_id`),
  CONSTRAINT `parroquias_municipios_id_foreign` FOREIGN KEY (`municipios_id`) REFERENCES `municipios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.parroquias: ~36 rows (aproximadamente)
INSERT INTO `parroquias` (`id`, `nombre`, `mini`, `municipios_id`, `familias`, `estatus`, `created_at`, `updated_at`) VALUES
	(1, 'CAMAGUAN', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(2, 'PUERTO MIRANDA', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(3, 'UVERITO', NULL, 7, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(4, 'CHAGUARAMAS', NULL, 11, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(5, 'EL SOCORRO', NULL, 9, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(6, 'CALABOZO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(7, 'EL RASTRO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(8, 'GUARDATINAJAS', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(9, 'EL CALVARIO', NULL, 2, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(10, 'TUCUPIDO', NULL, 6, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(11, 'SAN RAFAEL DE LAYA', NULL, 6, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(12, 'ALTAGRACIA DE ORITUCO', 'ALTAGRACIA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(13, 'SAN RAFAEL DE ORITUCO', 'SAN RAFAEL', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(14, 'LIBERTAD DE ORITUCO', 'LIBERTAD', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(15, 'SAN FRANCISCO DE MACAIRA', 'MACAIRA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(16, 'PASO REAL DE MACAIRA', 'PASO REAL', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(17, 'CARLOS SOUBLETTE', 'SOUBLETTE', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(18, 'FRANCISCO JAVIER DE LAZAMA', 'LEZAMA', 5, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(22, 'LAS MERCEDES DEL LLANO', 'LAS MERCEDES', 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(23, 'SANTA RITA DE MANAPIRE', 'SANTA RITA', 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(24, 'CABRUTA', NULL, 12, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(25, 'EL SOMBRERO', NULL, 8, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(26, 'SOSA', NULL, 8, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(27, 'VALLE DE LA PASCUA', NULL, 3, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(28, 'ESPINO', NULL, 3, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(29, 'Ortiz', NULL, 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(30, 'SAN JOSE DE TIZNADOS', 'SAN JOSE', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(31, 'SAN LORENZO DE TIZNADOS', 'SAN LORENZO', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(32, 'SAN FRANCISCO DE TIZNADOSº', 'SAN FRANCISCO', 15, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(33, 'ZARAZA', NULL, 4, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(34, 'SAN JOSE DE UNARE', NULL, 4, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(35, 'GUAYABAL', NULL, 14, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(36, 'CAZORLA', NULL, 14, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(37, 'GUARIBE', NULL, 13, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(38, 'SANTA MARIA', NULL, 10, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(39, 'ALTAMIRA', NULL, 10, NULL, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48');

-- Volcando estructura para tabla alguarisa_transporte.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `date_token` datetime DEFAULT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `role` int NOT NULL DEFAULT '0',
  `role_id` int DEFAULT '0',
  `permisos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `acceso_municipio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `estatus` int NOT NULL DEFAULT '1',
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `dispositivo` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.users: ~4 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `telefono`, `token`, `date_token`, `path`, `role`, `role_id`, `permisos`, `acceso_municipio`, `estatus`, `band`, `created_at`, `updated_at`, `deleted_at`, `dispositivo`) VALUES
	(1, 'Yonathan Castillo', 'leothan522@gmail.com', '$2y$10$D2ohRbgCgGaECIjGLM0GHunPKCf9xsJIl1T0a4KOQIW0iIFRTInJm', '(0424) 338-66.00', NULL, NULL, NULL, 100, 0, NULL, NULL, 1, 1, '2023-08-12', '2023-10-02', NULL, 0),
	(2, 'Antonny Maluenga', 'gabrielmalu15@gmail.com', '$2y$10$ikRcKe/5Q1B/br8w3r5M4Ot1l8q9vZLaQDZ7FkvdzTZhu/7A9Ycd2', '(0412) 199-56.47', NULL, NULL, 'public/img/profile/user_id_3lKfHa.jpg', 100, 0, NULL, NULL, 1, 1, '2023-08-28', '2024-05-10', NULL, 0),
	(3, 'Administrador', 'admin@alguarisa.com', '$2y$10$5Fl3weju4a/JQi/x92lIMuXgXUr0dsxp6CIIikPNtNRyjDUlxj4ge', '(0424) 338-66.00', NULL, NULL, NULL, 99, 0, '{"usuarios.index":true}', NULL, 0, 0, '2023-09-28', NULL, '2023-09-29', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

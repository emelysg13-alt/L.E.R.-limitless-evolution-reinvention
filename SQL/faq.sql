-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-10-2025 a las 01:45:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lerxport`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `pregunta_clave` varchar(255) NOT NULL,
  `respuesta` text NOT NULL,
  `palabras_clave` text DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `confianza` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `faq`
--

INSERT INTO `faq` (`id`, `pregunta_clave`, `respuesta`, `palabras_clave`, `categoria`, `confianza`) VALUES
(1, 'hola', '¡Hola! Soy L∞py 🤖✨. Estoy aquí para ayudarte con productos deportivos, información y tips. ¿Qué necesitas hoy?', 'buenas, hey, qué tal, holis, saludos', 'Saludo', 5),
(2, 'adiós', '¡Hasta luego! 🌀⚡ Recuerda que siempre puedes volver cuando necesites algo deportivo.', 'chao, bye, nos vemos, hasta pronto, chau', 'Despedida', 3),
(3, 'gracias', '¡De nada! ⚡ Me alegra ayudarte. ¿Quieres explorar algo más?', 'muchas gracias, gracias loopy, te agradezco', '', 3),
(4, 'cómo estás', '¡Con toda la energía deportiva! 🌀🤖 ¿Listo para hablar de entrenamiento, productos o tips?', 'qué tal, cómo va todo, todo bien loopy, estás bien', '', 3),
(5, 'Como comprar', 'Si quieres comprar⚡. Solo eliges el producto que te gusta en el catálogo de LerXport y das clic en el enlace. Eso te llevará a Vento, nuestra página asociada, donde finalizas tu compra con total seguridad. O haz una cotización desde el carrito', 'comprar, adquisición, proceso de compra, quiero comprar, cómo hago una compra', 'Información', 5),
(6, 'métodos de pago', 'Los pagos se realizan en Vento 💳✅. Allí podrás usar tarjeta de crédito, débito y otros métodos seguros.', 'formas de pago, cómo pagar, qué medios aceptan, métodos disponibles', 'Pagos', 5),
(7, 'sobre nosotros', 'Somos LerXport 🚀, una plataforma digital que impulsa el deporte con productos y soluciones simples, cercanas e innovadoras.', 'quiénes son, acerca de, quién es lerxport, empresa, lerxport', 'Información', 5),
(10, 'Tips', 'Lo siento, nuestros tips y conocimientos estarán muy pronto', 'consejo, conocimiento, tip', '', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

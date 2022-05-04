CREATE DATABASE `tiendas`;

CREATE TABLE `Op_Productos` (
  `idOp_Productos` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `kilo` int NOT NULL DEFAULT '0',
  `cantidad` double NOT NULL,
  `precio` double NOT NULL,
  `comision` int NOT NULL DEFAULT '0',
  `cantidad_comision` int DEFAULT '0',
  `fecha_utlima_actualizacion` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `estado` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idOp_Productos`)
) ENGINE=InnoDB AUTO_INCREMENT=0;

CREATE TABLE `Op_Usuarios` (
  `idOp_Usuarios` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `tipo` int NOT NULL,
  `fecha_utlima_actualizacion` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `estado` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idOp_Usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=0;

CREATE TABLE `Op_Ventas` (
  `idOp_Ventas` int NOT NULL AUTO_INCREMENT,
  `idOp_Productos` int NOT NULL DEFAULT '0',
  `idOp_productosIndividual` int NOT NULL DEFAULT '0',
  `idOp_Usuarios` int NOT NULL,
  `cantidad` double NOT NULL,
  `precio` double NOT NULL,
  `Fecha_venta` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `tipo` int NOT NULL,
  PRIMARY KEY (`idOp_Ventas`),
  KEY `Op_Ventas_FK` (`idOp_Productos`),
  KEY `Op_Ventas_FK_1` (`idOp_Usuarios`),
  CONSTRAINT `Op_Ventas_FK_1` FOREIGN KEY (`idOp_Usuarios`) REFERENCES `Op_Usuarios` (`idOp_Usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=0;

CREATE TABLE `Op_productosIndividual` (
  `idOp_productosIndividual` int NOT NULL AUTO_INCREMENT,
  `idOp_Productos` int NOT NULL,
  `cantidad_caja` int NOT NULL DEFAULT '0',
  `disponibles_caja` int NOT NULL DEFAULT '0',
  `precio_individual` double NOT NULL DEFAULT '0',
  `estado` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idOp_productosIndividual`),
  KEY `Op_productosIndividual_FK` (`idOp_Productos`),
  CONSTRAINT `Op_productosIndividual_FK` FOREIGN KEY (`idOp_Productos`) REFERENCES `Op_Productos` (`idOp_Productos`)
) ENGINE=InnoDB AUTO_INCREMENT=0;

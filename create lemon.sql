-- MySQL Script generated by MySQL Workbench
-- 10/22/17 12:21:00
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema lemonclub
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `lemonclub` ;

-- -----------------------------------------------------
-- Schema lemonclub
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `lemonclub` DEFAULT CHARACTER SET utf8 ;
USE `lemonclub` ;

-- -----------------------------------------------------
-- Table `lemonclub`.`pedido_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`pedido_estado` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`pedido_estado` (
  `id_pedido_estado` INT NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_pedido_estado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`sucursal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`sucursal` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`sucursal` (
  `id_sucursal` INT NOT NULL,
  `descripcion` VARCHAR(45) NULL,
  `localidad` VARCHAR(45) NULL,
  `latitud` VARCHAR(45) NULL,
  `longitud` VARCHAR(45) NULL,
  PRIMARY KEY (`id_sucursal`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`pedido` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`pedido` (
  `id_pedido` INT NOT NULL,
  `id_pedido_estado` INT NOT NULL,
  `id_sucursal` INT NOT NULL,
  PRIMARY KEY (`id_pedido`),
  CONSTRAINT `fk_pedido_pedido_estado1`
    FOREIGN KEY (`id_pedido_estado`)
    REFERENCES `lemonclub`.`pedido_estado` (`id_pedido_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_sucursal1`
    FOREIGN KEY (`id_sucursal`)
    REFERENCES `lemonclub`.`sucursal` (`id_sucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_pedido_pedido_estado1_idx` ON `lemonclub`.`pedido` (`id_pedido_estado` ASC);

CREATE INDEX `fk_pedido_sucursal1_idx` ON `lemonclub`.`pedido` (`id_sucursal` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`producto_tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto_tipo` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto_tipo` (
  `id_producto_tipo` INT NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_producto_tipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto` (
  `id_producto` INT NOT NULL,
  `id_producto_tipo` INT NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` VARCHAR(2000) NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_producto`),
  CONSTRAINT `fk_producto_producto_tipo1`
    FOREIGN KEY (`id_producto_tipo`)
    REFERENCES `lemonclub`.`producto_tipo` (`id_producto_tipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_producto_producto_tipo1_idx` ON `lemonclub`.`producto` (`id_producto_tipo` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`ingrediente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`ingrediente` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`ingrediente` (
  `id_ingrediente` INT NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `calorias` INT NOT NULL,
  PRIMARY KEY (`id_ingrediente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`producto_ingrediente_tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto_ingrediente_tipo` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto_ingrediente_tipo` (
  `id_producto_ingrediente_tipo` INT NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_producto_ingrediente_tipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`producto_ingrediente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto_ingrediente` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto_ingrediente` (
  `id_producto` INT NOT NULL,
  `id_ingrediente` INT NOT NULL,
  `id_producto_ingrediente_tipo` INT NOT NULL,
  `ingrediente_default` TINYINT(1) NOT NULL,
  `ingrediente_fijo` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_producto`, `id_ingrediente`, `id_producto_ingrediente_tipo`),
  CONSTRAINT `fk_producto_has_ingrediente_producto`
    FOREIGN KEY (`id_producto`)
    REFERENCES `lemonclub`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_has_ingrediente_ingrediente1`
    FOREIGN KEY (`id_ingrediente`)
    REFERENCES `lemonclub`.`ingrediente` (`id_ingrediente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_ingrediente_producto_ingrediente_tipo1`
    FOREIGN KEY (`id_producto_ingrediente_tipo`)
    REFERENCES `lemonclub`.`producto_ingrediente_tipo` (`id_producto_ingrediente_tipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_producto_has_ingrediente_ingrediente1_idx` ON `lemonclub`.`producto_ingrediente` (`id_ingrediente` ASC);

CREATE INDEX `fk_producto_has_ingrediente_producto_idx` ON `lemonclub`.`producto_ingrediente` (`id_producto` ASC);

CREATE INDEX `fk_producto_ingrediente_producto_ingrediente_tipo1_idx` ON `lemonclub`.`producto_ingrediente` (`id_producto_ingrediente_tipo` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`combo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`combo` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`combo` (
  `id_producto` INT NOT NULL,
  PRIMARY KEY (`id_producto`),
  CONSTRAINT `fk_combo_producto1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `lemonclub`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`combo_producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`combo_producto` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`combo_producto` (
  `id_producto_combo` INT NOT NULL,
  `id_producto_componente` INT NOT NULL,
  PRIMARY KEY (`id_producto_combo`, `id_producto_componente`),
  CONSTRAINT `fk_combo_has_producto_combo1`
    FOREIGN KEY (`id_producto_combo`)
    REFERENCES `lemonclub`.`combo` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_combo_has_producto_producto1`
    FOREIGN KEY (`id_producto_componente`)
    REFERENCES `lemonclub`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_combo_has_producto_producto1_idx` ON `lemonclub`.`combo_producto` (`id_producto_componente` ASC);

CREATE INDEX `fk_combo_has_producto_combo1_idx` ON `lemonclub`.`combo_producto` (`id_producto_combo` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`pedido_producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`pedido_producto` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`pedido_producto` (
  `id_pedido` INT NOT NULL,
  `id_producto` INT NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_pedido`, `id_producto`),
  CONSTRAINT `fk_pedido_has_producto_pedido1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `lemonclub`.`pedido` (`id_pedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_has_producto_producto1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `lemonclub`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_pedido_has_producto_producto1_idx` ON `lemonclub`.`pedido_producto` (`id_producto` ASC);

CREATE INDEX `fk_pedido_has_producto_pedido1_idx` ON `lemonclub`.`pedido_producto` (`id_pedido` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`caracteristica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`caracteristica` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`caracteristica` (
  `id_caracteristica` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_caracteristica`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`producto_caracteristica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto_caracteristica` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto_caracteristica` (
  `id_producto` INT NOT NULL,
  `id_caracteristica` INT NOT NULL,
  PRIMARY KEY (`id_producto`, `id_caracteristica`),
  CONSTRAINT `fk_producto_has_caracteristica_producto1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `lemonclub`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_has_caracteristica_caracteristica1`
    FOREIGN KEY (`id_caracteristica`)
    REFERENCES `lemonclub`.`caracteristica` (`id_caracteristica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_producto_has_caracteristica_caracteristica1_idx` ON `lemonclub`.`producto_caracteristica` (`id_caracteristica` ASC);

CREATE INDEX `fk_producto_has_caracteristica_producto1_idx` ON `lemonclub`.`producto_caracteristica` (`id_producto` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`producto_ingrediente_tipo_cant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto_ingrediente_tipo_cant` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto_ingrediente_tipo_cant` (
  `id_producto` INT NOT NULL,
  `id_producto_ingrediente_tipo` INT NOT NULL,
  `cantidad_minima` INT NOT NULL,
  `cantidad_máxima` INT NOT NULL,
  PRIMARY KEY (`id_producto`, `id_producto_ingrediente_tipo`),
  CONSTRAINT `fk_producto_has_producto_ingrediente_tipo_producto1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `lemonclub`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_has_producto_ingrediente_tipo_producto_ingredient1`
    FOREIGN KEY (`id_producto_ingrediente_tipo`)
    REFERENCES `lemonclub`.`producto_ingrediente_tipo` (`id_producto_ingrediente_tipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_producto_has_producto_ingrediente_tipo_producto_ingredie_idx` ON `lemonclub`.`producto_ingrediente_tipo_cant` (`id_producto_ingrediente_tipo` ASC);

CREATE INDEX `fk_producto_has_producto_ingrediente_tipo_producto1_idx` ON `lemonclub`.`producto_ingrediente_tipo_cant` (`id_producto` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`producto_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto_estado` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto_estado` (
  `id_producto_estado` INT NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_producto_estado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`ingrediente_estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`ingrediente_estado` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`ingrediente_estado` (
  `id_ingrediente_estado` INT NOT NULL,
  `descricpcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_ingrediente_estado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`ingrediente_estado_sucursal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`ingrediente_estado_sucursal` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`ingrediente_estado_sucursal` (
  `id_ingrediente` INT NOT NULL,
  `id_sucursal` INT NOT NULL,
  `id_ingrediente_estado` INT NOT NULL,
  PRIMARY KEY (`id_ingrediente`, `id_sucursal`, `id_ingrediente_estado`),
  CONSTRAINT `fk_ingrediente_estado_sucursal_ingrediente1`
    FOREIGN KEY (`id_ingrediente`)
    REFERENCES `lemonclub`.`ingrediente` (`id_ingrediente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingrediente_estado_sucursal_sucursal1`
    FOREIGN KEY (`id_sucursal`)
    REFERENCES `lemonclub`.`sucursal` (`id_sucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingrediente_estado_sucursal_ingrediente_estado1`
    FOREIGN KEY (`id_ingrediente_estado`)
    REFERENCES `lemonclub`.`ingrediente_estado` (`id_ingrediente_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_ingrediente_estado_sucursal_sucursal1_idx` ON `lemonclub`.`ingrediente_estado_sucursal` (`id_sucursal` ASC);

CREATE INDEX `fk_ingrediente_estado_sucursal_ingrediente_estado1_idx` ON `lemonclub`.`ingrediente_estado_sucursal` (`id_ingrediente_estado` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`producto_estado_sucursal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`producto_estado_sucursal` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`producto_estado_sucursal` (
  `id_producto` INT NOT NULL,
  `id_sucursal` INT NOT NULL,
  `id_producto_estado` INT NOT NULL,
  PRIMARY KEY (`id_producto`, `id_sucursal`, `id_producto_estado`),
  CONSTRAINT `fk_producto_estado_sucursal_producto1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `lemonclub`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_estado_sucursal_sucursal1`
    FOREIGN KEY (`id_sucursal`)
    REFERENCES `lemonclub`.`sucursal` (`id_sucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_estado_sucursal_producto_estado1`
    FOREIGN KEY (`id_producto_estado`)
    REFERENCES `lemonclub`.`producto_estado` (`id_producto_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_producto_estado_sucursal_sucursal1_idx` ON `lemonclub`.`producto_estado_sucursal` (`id_sucursal` ASC);

CREATE INDEX `fk_producto_estado_sucursal_producto_estado1_idx` ON `lemonclub`.`producto_estado_sucursal` (`id_producto_estado` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`pedido_producto_ingrediente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`pedido_producto_ingrediente` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`pedido_producto_ingrediente` (
  `id_pedido` INT NOT NULL,
  `id_producto` INT NOT NULL,
  `id_ingrediente` INT NOT NULL,
  PRIMARY KEY (`id_pedido`, `id_producto`, `id_ingrediente`),
  CONSTRAINT `fk_pedido_producto_ingrediente_pedido_producto1`
    FOREIGN KEY (`id_pedido` , `id_producto`)
    REFERENCES `lemonclub`.`pedido_producto` (`id_pedido` , `id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_producto_ingrediente_ingrediente1`
    FOREIGN KEY (`id_ingrediente`)
    REFERENCES `lemonclub`.`ingrediente` (`id_ingrediente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_pedido_producto_ingrediente_ingrediente1_idx` ON `lemonclub`.`pedido_producto_ingrediente` (`id_ingrediente` ASC);


-- -----------------------------------------------------
-- Table `lemonclub`.`pedido_delivery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`pedido_delivery` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`pedido_delivery` (
  `id_pedido` INT NOT NULL,
  `dirección` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(45) NULL,
  `nota` VARCHAR(1000) NULL,
  PRIMARY KEY (`id_pedido`),
  CONSTRAINT `fk_pedido_delivery_pedido1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `lemonclub`.`pedido` (`id_pedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`pedido_email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`pedido_email` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`pedido_email` (
  `id_pedido` INT NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  CONSTRAINT `fk_pedido_email_pedido1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `lemonclub`.`pedido` (`id_pedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`usuario` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`usuario` (
  `id_usuario` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lemonclub`.`pedido_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lemonclub`.`pedido_usuario` ;

CREATE TABLE IF NOT EXISTS `lemonclub`.`pedido_usuario` (
  `id_pedido` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_pedido`, `id_usuario`),
  CONSTRAINT `fk_pedido_usuario_pedido1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `lemonclub`.`pedido` (`id_pedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_usuario_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `lemonclub`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_pedido_usuario_usuario1_idx` ON `lemonclub`.`pedido_usuario` (`id_usuario` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

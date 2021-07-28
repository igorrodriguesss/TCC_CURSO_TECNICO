/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : tcc

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 27/07/2020 23:10:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cad_profissional
-- ----------------------------
DROP TABLE IF EXISTS `cad_profissional`;
CREATE TABLE `cad_profissional`  (
  `idProf` int(11) NOT NULL AUTO_INCREMENT,
  `nomeProf` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rgProf` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cpfProf` varchar(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ruaProf` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `numProf` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `compProf` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bairroProf` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cidadeProf` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ufProf` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cepProf` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usuario` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `senha` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `emailProf` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `estado_civilProf` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sexoProf` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `senha2` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `data_nascProf` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `telefoneProf` varchar(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `celularProf` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `celular2Prof` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ativo` int(1) NULL DEFAULT NULL,
  `data_mensalidade` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `mensalidade` int(1) NULL DEFAULT NULL,
  `data_expira_mensalidade` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idProf`) USING BTREE,
  UNIQUE INDEX `rgProf`(`rgProf`) USING BTREE,
  UNIQUE INDEX `cpfProf`(`cpfProf`) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario`) USING BTREE,
  UNIQUE INDEX `celularProf`(`celularProf`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for contato
-- ----------------------------
DROP TABLE IF EXISTS `contato`;
CREATE TABLE `contato`  (
  `idContato` int(11) NOT NULL AUTO_INCREMENT,
  `tipoContato` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descricaoContato` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nomeContato` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `emailContato` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `celularContato` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `statusContato` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dataContato` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idContato`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for servicos
-- ----------------------------
DROP TABLE IF EXISTS `servicos`;
CREATE TABLE `servicos`  (
  `idservico` int(11) NOT NULL AUTO_INCREMENT,
  `idProf` int(11) NULL DEFAULT NULL,
  `tipoServico` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descServico` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idservico`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for solicitacoes
-- ----------------------------
DROP TABLE IF EXISTS `solicitacoes`;
CREATE TABLE `solicitacoes`  (
  `idSolicitacao` int(11) NOT NULL AUTO_INCREMENT,
  `idProf` int(11) NOT NULL,
  `nomeSolicitante` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `celularSolicitante` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `emailSolicitante` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `descSolicitante` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idSolicitacao`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tiposervico
-- ----------------------------
DROP TABLE IF EXISTS `tiposervico`;
CREATE TABLE `tiposervico`  (
  `servico` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `senha` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ativo` int(1) NOT NULL,
  `nAcesso` int(1) NOT NULL,
  PRIMARY KEY (`idUsuario`) USING BTREE,
  UNIQUE INDEX `usuario`(`usuario`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

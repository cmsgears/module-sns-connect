/* ============================= CMSGears SNS Login ============================================== */

--
-- Table structure for table `cmg_sns_profile`
--

DROP TABLE IF EXISTS `cmg_sns_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_sns_profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `snsId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` mediumtext COLLATE utf8_unicode_ci,
  `createdAt` datetime NOT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sns_profile_1` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `cmg_sns_profile`
--

ALTER TABLE `cmg_sns_profile`
	ADD CONSTRAINT `fk_sns_profile_1` FOREIGN KEY (`userId`) REFERENCES `cmg_core_user` (`id`);

SET FOREIGN_KEY_CHECKS=1;
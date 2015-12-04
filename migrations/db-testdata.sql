--
-- Dumping data for table `cmg_core_form`
--

INSERT INTO `cmg_core_form` (`siteId`,`templateId`,`createdBy`,`modifiedBy`,`name`,`slug`,`description`,`successMessage`,`captcha`,`visibility`,`active`,`userMail`,`adminMail`,`options`,`createdAt`,`modifiedAt`) VALUES
	(1,NULL,1,1,'Config Facebook','config-facebook','Facebook configuration form.','All configurations saved successfully.',0,10,1,0,0,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,NULL,1,1,'Config Google','config-google','Google configuration form.','All configurations saved successfully.',0,10,1,0,0,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,NULL,1,1,'Config Twitter','config-twitter','Twitter site configuration form.','All configurations saved successfully.',0,10,1,0,0,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_core_form_field`
--

INSERT INTO `cmg_core_form_field` (`formId`,`name`,`label`,`type`,`compress`,`validators`,`options`,`data`,`order`) VALUES 
	(5,'active','Active',20,0,'required','{\"title\":\"Check whether Facebook Login is active.\"}',NULL,0),
	(5,'app_id','Application Id',0,0,'required','{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}',NULL,0),
	(5,'app_secret','Application Secret',5,0,'required','{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}',NULL,0),
	(5,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0),
	(6,'active','Active',20,0,'required','{\"title\":\"Check whether Google Login is active.\"}',NULL,0),
	(6,'app_id','Application Id',0,0,'required','{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}',NULL,0),
	(6,'app_secret','Application Secret',5,0,'required','{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}',NULL,0),
	(6,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0),
	(7,'active','Active',20,0,'required','{\"title\":\"Check whether Google Login is active.\"}',NULL,0),
	(7,'api_key','API Id',0,0,'required','{\"title\":\"API Key.\",\"placeholder\":\"API Key\"}',NULL,0),
	(7,'api_secret','API Secret',5,0,'required','{\"title\":\"API Secret.\",\"placeholder\":\"API Secret\"}',NULL,0),
	(7,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0);

--
-- Dumping data for table `cmg_core_model_meta`
--

INSERT INTO `cmg_core_model_meta` (`parentId`,`parentType`,`name`,`value`,`type`) VALUES
	(1,'site','active','1','facebook'),
	(1,'site','app_id','','facebook'),
	(1,'site','app_secret','','facebook'),
	(1,'site','redirect_uri','/sns/facebook/authorise','facebook'),
	(1,'site','active','1','google'),
	(1,'site','app_id','','google'),
	(1,'site','app_secret','','google'),
	(1,'site','redirect_uri','/sns/google/authorise','google'),
	(1,'site','active','1','twitter'),
	(1,'site','api_key','','twitter'),
	(1,'site','api_secret','','twitter'),
	(1,'site','redirect_uri','/sns/twitter/authorise','twitter');
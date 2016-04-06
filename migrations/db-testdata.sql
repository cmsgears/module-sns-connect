--
-- Main Site
--

SELECT @site := `id` FROM cmg_core_site WHERE slug = 'main';

--
-- Facebook Config Form
--

INSERT INTO `cmg_core_form` (`siteId`,`templateId`,`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`successMessage`,`captcha`,`visibility`,`active`,`userMail`,`adminMail`,`createdAt`,`modifiedAt`,`htmlOptions`,`data`) VALUES
	(@site,NULL,1,1,'Config Facebook','config-facebook','system','Facebook configuration form.','All configurations saved successfully.',0,10,1,0,0,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL,NULL);

SELECT @form := `id` FROM cmg_core_form WHERE slug = 'config-facebook';

INSERT INTO `cmg_core_form_field` (`formId`,`name`,`label`,`type`,`compress`,`validators`,`htmlOptions`,`data`,`order`) VALUES 
	(@form,'active','Active',40,0,'required','{\"title\":\"Check whether Facebook Login is active.\"}',NULL,0),
	(@form,'app_id','Application Id',0,0,'required','{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}',NULL,0),
	(@form,'app_secret','Application Secret',10,0,'required','{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}',NULL,0),
	(@form,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0);

--
-- Google Config Form
--

INSERT INTO `cmg_core_form` (`siteId`,`templateId`,`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`successMessage`,`captcha`,`visibility`,`active`,`userMail`,`adminMail`,`createdAt`,`modifiedAt`,`htmlOptions`,`data`) VALUES
	(@site,NULL,1,1,'Config Google','config-google','system','Google configuration form.','All configurations saved successfully.',0,10,1,0,0,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL,NULL);

SELECT @form := `id` FROM cmg_core_form WHERE slug = 'config-google';

INSERT INTO `cmg_core_form_field` (`formId`,`name`,`label`,`type`,`compress`,`validators`,`htmlOptions`,`data`,`order`) VALUES 
	(@form,'active','Active',40,0,'required','{\"title\":\"Check whether Google Login is active.\"}',NULL,0),
	(@form,'app_id','Application Id',0,0,'required','{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}',NULL,0),
	(@form,'app_secret','Application Secret',10,0,'required','{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}',NULL,0),
	(@form,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0);

--
-- Twitter Config Form
--

INSERT INTO `cmg_core_form` (`siteId`,`templateId`,`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`successMessage`,`captcha`,`visibility`,`active`,`userMail`,`adminMail`,`createdAt`,`modifiedAt`,`htmlOptions`,`data`) VALUES
	(@site,NULL,1,1,'Config Twitter','config-twitter','system','Twitter configuration form.','All configurations saved successfully.',0,10,1,0,0,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL,NULL);

SELECT @form := `id` FROM cmg_core_form WHERE slug = 'config-twitter';

INSERT INTO `cmg_core_form_field` (`formId`,`name`,`label`,`type`,`compress`,`validators`,`htmlOptions`,`data`,`order`) VALUES 
	(@form,'active','Active',40,0,'required','{\"title\":\"Check whether Google Login is active.\"}',NULL,0),
	(@form,'api_key','API Id',0,0,'required','{\"title\":\"API Key.\",\"placeholder\":\"API Key\"}',NULL,0),
	(@form,'api_secret','API Secret',10,0,'required','{\"title\":\"API Secret.\",\"placeholder\":\"API Secret\"}',NULL,0),
	(@form,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0);

--
-- Dumping data for table `cmg_core_model_attribute`
--

INSERT INTO `cmg_core_model_attribute` (`parentId`,`parentType`,`name`,`label`,`type`,`valueType`,`value`) VALUES
	(@site,'site','active','Active','facebook','flag','1'),
	(@site,'site','app_id','App Id','facebook','text',''),
	(@site,'site','app_secret','App Secret','facebook','text',''),
	(@site,'site','redirect_uri','Redirect URI','facebook','text','/sns/facebook/authorise'),
	(@site,'site','active','Actrive','google','flag','1'),
	(@site,'site','app_id','App Id','google','text',''),
	(@site,'site','app_secret','App Secret','google','text',''),
	(@site,'site','redirect_uri','Redirect URI','google','text','/sns/google/authorise'),
	(@site,'site','active','Active','twitter','flag','1'),
	(@site,'site','api_key','API Key','twitter','text',''),
	(@site,'site','api_secret','API Secret','twitter','text',''),
	(@site,'site','redirect_uri','Redirect URI','twitter','text','/sns/twitter/authorise');
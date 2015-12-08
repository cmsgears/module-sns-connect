--
-- Main Site
--

SELECT @site := `id` FROM cmg_core_site WHERE slug = 'main';

--
-- Facebook Config Form
--

INSERT INTO `cmg_core_form` (`siteId`,`templateId`,`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`successMessage`,`captcha`,`visibility`,`active`,`userMail`,`adminMail`,`options`,`createdAt`,`modifiedAt`) VALUES
	(@site,NULL,1,1,'Config Facebook','config-facebook','system','Facebook configuration form.','All configurations saved successfully.',0,10,1,0,0,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @form := `id` FROM cmg_core_form WHERE slug = 'config-facebook';

INSERT INTO `cmg_core_form_field` (`formId`,`name`,`label`,`type`,`compress`,`validators`,`options`,`data`,`order`) VALUES 
	(@form,'active','Active',20,0,'required','{\"title\":\"Check whether Facebook Login is active.\"}',NULL,0),
	(@form,'app_id','Application Id',0,0,'required','{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}',NULL,0),
	(@form,'app_secret','Application Secret',5,0,'required','{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}',NULL,0),
	(@form,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0);

--
-- Google Config Form
--

INSERT INTO `cmg_core_form` (`siteId`,`templateId`,`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`successMessage`,`captcha`,`visibility`,`active`,`userMail`,`adminMail`,`options`,`createdAt`,`modifiedAt`) VALUES
	(@site,NULL,1,1,'Config Google','config-google','system','Google configuration form.','All configurations saved successfully.',0,10,1,0,0,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @form := `id` FROM cmg_core_form WHERE slug = 'config-google';

INSERT INTO `cmg_core_form_field` (`formId`,`name`,`label`,`type`,`compress`,`validators`,`options`,`data`,`order`) VALUES 
	(@form,'active','Active',20,0,'required','{\"title\":\"Check whether Google Login is active.\"}',NULL,0),
	(@form,'app_id','Application Id',0,0,'required','{\"title\":\"Application Id.\",\"placeholder\":\"Application Id\"}',NULL,0),
	(@form,'app_secret','Application Secret',5,0,'required','{\"title\":\"Application Secret.\",\"placeholder\":\"Application Secret\"}',NULL,0),
	(@form,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0);

--
-- Twitter Config Form
--

INSERT INTO `cmg_core_form` (`siteId`,`templateId`,`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`successMessage`,`captcha`,`visibility`,`active`,`userMail`,`adminMail`,`options`,`createdAt`,`modifiedAt`) VALUES
	(@site,NULL,1,1,'Config Twitter','config-twitter','system','Twitter site configuration form.','All configurations saved successfully.',0,10,1,0,0,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @form := `id` FROM cmg_core_form WHERE slug = 'config-twitter';

INSERT INTO `cmg_core_form_field` (`formId`,`name`,`label`,`type`,`compress`,`validators`,`options`,`data`,`order`) VALUES 
	(@form,'active','Active',20,0,'required','{\"title\":\"Check whether Google Login is active.\"}',NULL,0),
	(@form,'api_key','API Id',0,0,'required','{\"title\":\"API Key.\",\"placeholder\":\"API Key\"}',NULL,0),
	(@form,'api_secret','API Secret',5,0,'required','{\"title\":\"API Secret.\",\"placeholder\":\"API Secret\"}',NULL,0),
	(@form,'redirect_uri','Redirect URI',0,0,'required','{\"title\":\"Redirect URI.\",\"placeholder\":\"Redirect URI\"}',NULL,0);

--
-- Dumping data for table `cmg_core_model_attribute`
--

INSERT INTO `cmg_core_model_attribute` (`parentId`,`parentType`,`name`,`value`,`type`) VALUES
	(@site,'site','active','1','facebook'),
	(@site,'site','app_id','','facebook'),
	(@site,'site','app_secret','','facebook'),
	(@site,'site','redirect_uri','/sns/facebook/authorise','facebook'),
	(@site,'site','active','1','google'),
	(@site,'site','app_id','','google'),
	(@site,'site','app_secret','','google'),
	(@site,'site','redirect_uri','/sns/google/authorise','google'),
	(@site,'site','active','1','twitter'),
	(@site,'site','api_key','','twitter'),
	(@site,'site','api_secret','','twitter'),
	(@site,'site','redirect_uri','/sns/twitter/authorise','twitter');
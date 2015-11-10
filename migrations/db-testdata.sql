--
-- Dumping data for table `cmg_core_model_meta`
--

INSERT INTO `cmg_core_model_meta` (`parentId`,`parentType`,`name`,`value`,`type`,`fieldType`,`fieldMeta`) VALUES
	(1,'site','active','1','facebook','text',null),
	(1,'site','app id','','facebook','text',null),
	(1,'site','app secret','','facebook','password',null),
	(1,'site','redirect uri','/sns/facebook/authorise','facebook','text',null),
	(1,'site','active','1','gplus','text',null),
	(1,'site','app id','','gplus','text',null),
	(1,'site','app secret','','gplus','password',null),
	(1,'site','redirect uri','/sns/facebook/authorise','gplus','text',null),
	(1,'site','active','1','twitter','text',null),
	(1,'site','api key','','twitter','text',null),
	(1,'site','api secret','','twitter','password',null),
	(1,'site','redirect uri','/sns/twitter/authorise','twitter','text',null);
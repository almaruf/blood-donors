ezy-restaurant
==============

1. application.ini example

[production]
phpSettings.display_startup_errors = 0
phpSettings.display_errors = 0

bootstrap.path = APPLICATION_PATH "/Bootstrap.php"
bootstrap.class = "Bootstrap"
resources.frontController.controllerDirectory = APPLICATION_PATH "/controllers"
;resources.frontController.defaultControllerName = "Admin"
resources.db.adapter = PDO_MYSQL
resources.db.params.host = 'localhost
resources.db.params.username = username
resources.db.params.password = password
resources.db.params.dbname =  dbname
resources.layout.layoutpath = APPLICATION_PATH "/layouts"
resources.view[] =
resources.view.helperPath.Zend_View_Helper = APPLICATION_PATH "/views/helpers/"
resources.view.helperPath.Zend_View_Template = APPLICATION_PATH "/views/template/"


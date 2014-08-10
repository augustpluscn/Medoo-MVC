Medoo-MVC
=========

# Medoo-MVC 简介

Medoo-MVC是一个基于Medoo的简单的mvc框架，如果之前使用过Medoo，只需几分钟学习即可开始开发，如果没接触过Medoo，十多分钟的学习时间也足够了。

# Medoo-MVC快速开始

##1.config

数据库连接配置文件单独存放在"/config/db.config.php"，默认使用mysql数据库，更改username，password，dbname后可开始其他操作。

## 2.Controller

通过Controller和Controller中的方法来实现功能，Controller都继承自medoo类，这样可以直接调用medoo的方法。

## 3.View

在Controller的方法中给变量赋值，然后通过display的参数传入模板显示。

## 4.Model

如果使用model，建议继承medoo类，这样就可以调用medoo的数据操作方法，添加model后在同名的Controller中可以直接实例化model类。

## 5.全局函数

需要随处调用的自己添加的函数可写到"/lib/function/app.php"。

## 6.扩展类

自己添加的扩展类放到"/lib/class/"，之后就可在程序中实例化使用该扩展类。

## 详细介绍

参考：http://www.xuhaixiao.com/medoo-mvc/

## Medoo-MVC实例

基于Medoo-MVC开发的开源项目 shop72hour ：http://www.xuhaixiao.com/shop72hour/


# Medoo-MVC新增功能

#### 1.Url Rewrite (2014-08-05)
(1)修改配置文件“/config/app.config.php”中的“APP_PATH”和“URL_PATHINFO”配置项  
(2)添加服务器Rewrite规则  
Apache：

    RewriteEngine on  
    RewriteCond %{REQUEST_FILENAME} !-d  
    RewriteCond %{REQUEST_FILENAME} !-f  
    RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]  

Nginx:

    location / {  
        root /rootPath/;  
        index index.php index.html index.htm;  
        if (!-e $request_filename) {  
        rewrite ^/(.*)$ /index.php?s=$1 last;  
        }  
    }  
较详细的说明可参见：http://www.xuhaixiao.com/urlrewrite/
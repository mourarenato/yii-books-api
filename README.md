<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h2 align="center">Yii 2.0 </h2>
    <br>
</p>

Project Information
-------------------
This project is an API to create clients and books made with Yii2


Directory Structure
-------------------

      assets/             contains assets definition
      config/             contains application configurations
      migrations/         contains migrations
      
      src/
         controllers/        contains controller classes
         components/         contains controller classes
         commands/           contains console commands (controllers)
         models/             contains model classes
         repositories/       contains repositories classes
         services/           contains services classes

      runtime/            contains files generated during runtime
      tests/              contains unit tests
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources


Installation
------------

### Getting started with docker

1. Run `docker compose up -d`
2. Make sure all containers is up and working
3. Make sure you have the databases created in your postgres database (production and test)
5Run `php yii migrate` in docker container

You can then access the application through the following URL:

    http://10.0.0.22:80


Testing
-------

Tests can be executed by running

```
vendor/bin/phpunit ./tests
```
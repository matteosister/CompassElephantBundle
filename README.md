# CompassElephantBundle ![Travis build status](https://secure.travis-ci.org/matteosister/CompassElephantBundle.png)#

A Bundle to use the [compass-elephant](https://github.com/matteosister/CompassElephant) library in a Symfony2 project

Installation
------------

Remember that you need the CompassElephant library for this bundle to work

**deps file**

Add the bundle and the CompassElephant library to the deps file inside the root of your symfony porject

```
[compass-elephant]
    git=https://matteosister@github.com/matteosister/CompassElephant.git

[CompassElephantBundle]
    git=https://matteosister@github.com/matteosister/CompassElephantBundle.git
    target=/bundles/Cypress/CompassElephantBundle
```

Autoload

*app/autoload.php*

``` php
<?php
$loader->registerNamespaces(array(
    // ... other namespaces ...
    'Cypress'          => __DIR__.'/../vendor/bundles',
    'CompassElephant'  => __DIR__.'/../vendor/compass-elephant/src'
));
```

Register the bundle in the **AppKernel.php** file inside the dev section

*app/AppKernel.php*

``` php
<?php
if (in_array($this->getEnvironment(), array('dev', 'test'))) {
    // ...other bundles ...
    $bundles[] = new Cypress\CompassElephantBundle\CypressCompassElephantBundle();
}
```

Configuration
-------------

**Add the configuration in your config file (for the dev environment)**

*app/config_dev.yml*

```
cypress_compass_elephant:
    compass_projects:
        my-compass-project:
            path: %kernel.root_dir%/../src/Cypress/DemoBundle/Resources/public/compass
```

*my-compass-project* is a random name for this example. Pick the name you want

*path* should be an existing directory. By default, if the directory is empty, CompassElephant try to init a compass project. Remember to set the right permission!

*Important*

Remember that the apache user needs write access to the "sass" folder, the "stylesheet" folder and the config.rb file. If you use compass defaults you will have everything inside the same project folder. You can give permission to all files inside. But you can as well change the position of the stylesheets folder to be outside the project. CompassElephant parses the config file and uses it.

**Add the stylesheets to your templates**

*assetic example*

```
{% stylesheets filter="yui_css"
    "@CypressDemoBundle/Resources/public/compass/stylesheets/screen.css" %}
    <link href="{{ asset_url }}" type="text/css" rel="stylesheet" />
{% endstylesheets %}
```

*standard example*

```
<link href="{{ asset('bundles/cypressdemo/compass/stylesheets/screen.css') }}" type="text/css" rel="stylesheet" />
```

Enjoy!

Complete configuration reference
--------------------------------

```
cypress_compass_elephant:
    compass_binary_path: "/usr/local/bin/compass"
    compass_projects:
        blog:
            path: %kernel.root_dir%/../src/Cypress/BlogBundle/Resources/public/compass
            staleness_checker: finder # or native
            config_file: config.rb
            auto_init: true
```

* *compass_binary_path* is useful to force a binary that is not the default one that "which compass" gets.
* *compass_projects* is a collection of all the compass projects in your symfony project (maybe one for application)
* *staleness_checker* define what strategy the bundle use to define if a project is "clean" or needs recompile. "finder" is the default one, and you should use it. Read the [CompassElephant readme file](https://github.com/matteosister/CompassElephant) for more on this
* *config_file* is the name of te config file for compass. Defaults to config.rb, the standard one
* *auto_init* if set to false disable the init feature on an empty folder. Defaults to true

How it works
------------

This bundle register an event listener that, on every request, check if the projects defined in the config_dev.yml files are in "clean" state or needs recompile.

If the project do not need to be recompiled, it adds a really small overhead to symfony. At least with the finder staleness_checker option, just the time to check a bunch of files.

If you use native implementation it's really slow. So use it only if for some reason you can't use the finder component

Read the [CompassElephant readme](https://github.com/matteosister/CompassElephant) for other useful informations
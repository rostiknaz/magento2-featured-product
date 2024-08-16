# Rnazy_FeaturedProduct module

Display a featured product banner on the homepage.

## Installation (composer)

* Install __Composer__ - [Composer Download Instructions](https://getcomposer.org/doc/00-intro.md) (if not installed)

* Registering the module git repository

  ```sh
  $ composer config repositories.rostiknaz-magento2-custom-catalog git git@github.com:rostiknaz/magento2-custom-catalog.git
  ```
  Composer will register a new repository to composer.json (under “repositories” node). Updated composer.json looks like:

  ```
  {
    "repositories": {
      "rostiknaz-magento2-featured-product": {
        "type": "git",
        "url": "git@github.com:rostiknaz/magento2-featured-product.git"
      }
    }
  }
  ```  

* Registering the module package itself

  ```
  $ composer require rostiknaz/magento2-custom-catalog:1.0.0
  ```
  This will add a new dependent package under node “require” and run installation process:

  ```
  {
    "require": {
      "rostiknaz/magento2-custom-catalog": "1.0.0"
    }
  }
  ```
* Enable module

    ```
    $ php bin/magento setup:upgrade
    ```  

## Installation (manual)

* Download the Module archive from github repo, unpack it and upload its contents to a new folder <root>/app/code/Rnazy/FeaturedProduct/ of your Magento 2 installation
* Enable module

  ```
  $ php bin/magento setup:upgrade
  ```

## Usage

* Go to Stores -> Configurations -> Rnazy -> Featured Products and insert some existing salable product SKU.
* Clear config and FPC caches
* Go to Home Page and see a Featured Product banner
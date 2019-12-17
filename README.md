Weather module for ANAX framework
=========================

Install with composer
``composer require lyco/weather-module``

##### Require in json
Add following to your composer.json under require:
```
"lyco/weather-module": "^2.0.0"
```

#### API-Keys
Change "xxxxx" in "config/api.php" to your personalized api keys.

#### Move into folders
Move following files from module to your framework

```
rsync -av vendor/lyco/weather/view ./
rsync -av vendor/lyco/weather/config ./
```

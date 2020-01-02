[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Lyco18/weather-module/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Lyco18/weather-module/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/Lyco18/weather-module/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Lyco18/weather-module/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/Lyco18/weather-module/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Lyco18/weather-module/build-status/master) [![Code Intelligence Status](https://scrutinizer-ci.com/g/Lyco18/weather-module/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

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
rsync -av vendor/lyco/weather-module/view ./
rsync -av vendor/lyco/weather-module/config ./
```

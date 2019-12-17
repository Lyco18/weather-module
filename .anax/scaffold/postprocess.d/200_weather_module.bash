#!/usr/bin/env bash
#
# lyco/weather
#

# Copy default config
# Copy the configuration files
rsync -av vendor/lyco/weather/config/ config/

# Copy the view files
rsync -av vendor/lyco/weather/view/ view/

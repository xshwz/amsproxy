#!/bin/bash

source config.sh
source ${1}.sh
curl -i -d "$data" $url

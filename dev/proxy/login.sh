#!/bin/bash

source config.sh

curl "${host}_data/Index_LOGIN.aspx"
    -d "Sel_Type=STU&UserID=${uid}&PassWord=${oldpwd}" \
    -c asp.cookie \
    -o login.html

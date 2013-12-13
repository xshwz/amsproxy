#!/bin/bash

source config.sh
curl -c asp.cookie -d "Sel_Type=STU&UserID=${uid}&PassWord=${oldpwd}" "${host}_data/Index_LOGIN.aspx" -o login.html

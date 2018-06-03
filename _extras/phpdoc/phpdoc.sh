#!/bin/bash

cd /home/gorka/public_html/crudder/_docs/

# WITH PRIVATE METHODS

# generate phpdocs

phpdoc -pp -d ../application/controllers            -t ./controllers
phpdoc -pp -f ../application/core/Crudderconfig.php -t ./core

# fix formattings errors

FILE=controllers/Crudder/Crudder.html
echo fixing phpdocs...
echo fix 01...
mv $FILE ${FILE}.tmp1
cat ${FILE}.tmp1 | sed 's/<ol><li>/1. /g' >${FILE}.tmp2
echo fix 02...
cat ${FILE}.tmp2 | sed 's/<\/li><\/ol>/<p>/g' >$FILE
rm ${FILE}.tmp*
echo fixes done.

# rename directories

mv controllers controllers_with_privates
mv core core_with_privates

# WITHOUT PRIVATE METHODS

# generate phpdocs

phpdoc -d ../application/controllers            -t ./controllers
phpdoc -f ../application/core/Crudderconfig.php -t ./core

# fix formattings errors

FILE=controllers/Crudder/Crudder.html
echo fixing phpdocs...
echo fix 01...
mv $FILE ${FILE}.tmp1
cat ${FILE}.tmp1 | sed 's/<ol><li>/1. /g' >${FILE}.tmp2
echo fix 02...
cat ${FILE}.tmp2 | sed 's/<\/li><\/ol>/<p>/g' >$FILE
rm ${FILE}.tmp*
echo fixes done.

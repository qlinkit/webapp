#/bin/bash
cd /usr/share/nginx/html/qlink-alpha
DATE=`date +%Y-%m-%d`
ANT_DATE=$(date +%Y-%m-%d -d "$DATE - 3 day")
srm -r ../app/encfiles/one/$ANT_DATE
srm -r ../app/encfiles/two/$ANT_DATE
ANT_DATE=$(date +%Y-%m-%d -d "$DATE - 4 day")
srm -r ../app/encfiles/one/$ANT_DATE
srm -r ../app/encfiles/two/$ANT_DATE
ANT_DATE=$(date +%Y-%m-%d -d "$DATE - 5 day")
srm -r ../app/encfiles/one/$ANT_DATE
srm -r ../app/encfiles/two/$ANT_DATE
ANT_DATE=$(date +%Y-%m-%d -d "$DATE - 6 day")
srm -r ../app/encfiles/one/$ANT_DATE
srm -r ../app/encfiles/two/$ANT_DATE

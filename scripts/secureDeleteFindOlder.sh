#/bin/bash
cd /usr/share/nginx/html/qlink-alpha
DATE=`date "+%Y-%m-%d %H:%M:%S"`
TO_DATE=$(date "+%Y-%m-%d %H:%M:%S" -d "$DATE 1 days ago")
FROM_DATE=$(date "+%Y-%m-%d %H:%M:%S" -d "$DATE 3 days ago")
find ./app/encfiles/ -type f -newermt "$FROM_DATE" ! -newermt "$TO_DATE" -exec srm -r {} \;

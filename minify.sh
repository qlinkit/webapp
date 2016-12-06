#/bin/bash
java -jar libs/yuicompressor-2.4.8.jar public/css/global.css -o public/css/global.min.css
java -jar libs/yuicompressor-2.4.8.jar public/js/application.js -o public/js/application.min.js
java -jar libs/yuicompressor-2.4.8.jar public/js/bootstrap.file-input.js -o public/js/bootstrap.file-input.min.js
java -jar libs/yuicompressor-2.4.8.jar public/js/xss.js	-o public/js/xss.min.js
java -jar libs/yuicompressor-2.4.8.jar public/js/lzw.js -o public/js/lzw.min.js
java -jar libs/yuicompressor-2.4.8.jar public/js/jquery.blockUI.js -o public/js/jquery.blockUI.min.js

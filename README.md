# pico_xml_sitemap
This is [Pico](http://picocms.org/) plugin to generate sitemap.xml.

## How To Use.
* Place the pico_xml_sitemap.php into your plugins directory.
* You edit .htaccess in Pico root directory (see below).
* You can see sitemap XML when access http://[HOST]/[Pico-root-dir]/sitemap.xml

## Example of .htaccess
```apache
<IfModule mod_rewrite.c>
RewriteEngine On

RewriteRule sitemap\.xml \?sitemap  ## add this line ##

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteRule . index.php [L]
</IfModule>

# Prevent file browsing
Options -Indexes
 ```
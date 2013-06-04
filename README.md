# TinyMCE

Plugin for integrating [TinyMCE v4](http://tinymce.com/) into [Croogo](http://croogo.org).

Requires Croogo v1.5 or higher.  

Also, if you install this and my [elFinder plugin](https://github.com/phpMagpie/ElFinder) it will 
automatically set TinyMCE's image/file browser to use elFinder.

## Installation

1. Clone repository to /app/Plugin/Tinymce, and activate the plugin from your admin panel.
2. Deactivate Ckeditor plugin
3. Create a symlink in /app/webroot called Tinymce to ../Plugin/Tinymce/webroot

The third step bypasses CakePHP's plugin routing when accessing TinyMCE plugins.

On my Redhat Linux server I run the following as root:

1. cd /app/webroot
2. ln -s ../Plugin/Tinymce/webroot/ Tinymce
3. chown -h %youruser%:%yourgroup% Tinymce

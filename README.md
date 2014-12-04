# TinyMCE

Plugin for integrating [TinyMCE v4](http://tinymce.com/) into [Croogo](http://croogo.org). Requires Croogo v1.5 or higher.  

Packaged with TinyMCE version 4.0b2.  

I have used this with Croogo versions 1.5.x, 1.6.x, 2.0.x, 2.1.x

Note: My [elFinder](https://github.com/phpMagpie/ElFinder) and [MoxieManager](https://github.com/phpMagpie/MoxieManager) plugins 
automatically reconfigure TinyMCE's image/file browser to use them rather than the core FileManager::attachments.

## Installation

1. Clone repository to /app/Plugin/Tinymce, and activate the plugin from your admin panel.
2. Deactivate Ckeditor plugin
3. Create a symlink in /app/webroot called Tinymce to ../Plugin/Tinymce/webroot

The third step bypasses CakePHP's plugin routing when accessing TinyMCE plugins.

On my Redhat Linux server I run the following as root:

1. cd /app/webroot
2. ln -s ../Plugin/Tinymce/webroot/ Tinymce
3. chown -h %youruser%:%yourgroup% Tinymce

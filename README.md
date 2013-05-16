# TinyMCE

Plugin for integrating [TinyMCE](http://tinymce.com/) into [Croogo](http://croogo.org).

Requires Croogo v1.5 or higher

## Installation

1. Clone repository to /app/Plugin/Tinymce, and activate the plugin from your admin panel.
2. Create a symlink in /app/webroot called Tinymce to ../Plugin/Tinymce/webroot

The second step bypasses CakePHP's plugin routing when accessing TinyMCE plugins.

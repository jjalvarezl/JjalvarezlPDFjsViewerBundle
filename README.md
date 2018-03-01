JjalvarezlPDFjsViewerBundle
===========================

[![Build Status](https://travis-ci.org/jjalvarezl/JjalvarezlPDFjsViewerBundle.svg?branch=sf3)](https://travis-ci.org/jjalvarezl/JjalvarezlPDFjsViewerBundle) [![Total Downloads](https://poser.pugx.org/jjalvarezl/pdfjs-viewer-bundle/downloads)](https://packagist.org/packages/jjalvarezl/pdfjs-viewer-bundle) [![Latest Stable Version](https://poser.pugx.org/jjalvarezl/pdfjs-viewer-bundle/version)](https://packagist.org/packages/jjalvarezl/pdfjs-viewer-bundle) [![Latest Unstable Version](https://poser.pugx.org/jjalvarezl/pdfjs-viewer-bundle/v/unstable)](https://packagist.org/packages/jjalvarezl/pdfjs-viewer-bundle) [![License](https://poser.pugx.org/jjalvarezl/pdfjs-viewer-bundle/license)](https://packagist.org/packages/jjalvarezl/pdfjs-viewer-bundle)

This bundle provides a simple integration of the "[PDF.JS library](https://github.com/mozilla/pdf.js)" from mozilla into Symfony 3 with different custom parameters.

Following features are supported:
* Access to pdf outside from web directory.
* Customizable pdf viewer options.
* PDF.js incorporated until 23/03/2017.

Available at:
* [Packagist](https://packagist.org/packages/jjalvarezl/pdfjs-viewer-bundle#dev-sf3)
* [GitHub](https://github.com/jjalvarezl/JjalvarezlPDFjsViewerBundle/tree/sf3)

Why use this?:

* This bundle renders a pdf with on server side. For this reazon you can have an alternative solution to the default browser viewer that can variate the way that a pdf can be loaded on each browser type.
* This bundle can access files in every part of the server.
* This bundle can delete the pdf after rendering it.

Installation
============

### 1) Download JjalvarezlPDFjsViewerBundle

Its necessary to provide the bundle's name in order to download it:

``` bash
$ php composer.phar require jjalvarezl/pdfjs-viewer-bundle dev-sf3
```

### 2) Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new jjalvarezl\PDFjsViewerBundle\jjalvarezlPDFjsViewerBundle(),
    );
}
```
### 3) Install assets

Don't forget to install assets, is the only way that this bundle works:

```
$ php bin/console assets:install --symlink --relative
```

## Concepts before usage:

First at all, its necessary to establish some taxonomy an initial concepts in order to understand how it works:

* **Webroot**: is the web folder of Symfony
* "[PDF.js](https://github.com/mozilla/pdf.js)" works only in webroot folders in all kind of projects.
* This bundle enables to "[PDF.js](https://github.com/mozilla/pdf.js)" to show pdf files in any place that you need to obtain them.
* It makes a temporal copy with the absolute path of the pdf file in a custom temporal dir inside webroot (defined by the developer). So make sure about the right permissions (files + owner).
* Once "[PDF.js](https://github.com/mozilla/pdf.js)" loads the pdf file, this bundle can immediately delete it from webroot in order to avoid issues such as disk space overflow.
* This bundle also can show or hide visual "[PDF.js](https://github.com/mozilla/pdf.js)" components.

All those features can be performed with parameters which have only true / false values as follows:

## Usage

You can choose from different ways to use this bundle:

**Fast testing**

You can verify functionality in multiple browsers, you can enable the default "[PDF.js viewer](https://mozilla.github.io/pdf.js/web/viewer.html)" with same loaded pdf in your function controller that returns a response:

```php
return $this->get('jjalvarezl_pdfjs_viewer.viewer_controller')->renderTestViewer();
```

**Default viewer**

This shows same pdf viewer as the **fast testing** but its necessary to configure some extra parameters:

```php
$parameters = array(
        //Tell to the bundle that the pdf is outside the webroot
        'isPdfOutsideWebroot' => true,

        //Tell to the bundle where is the pdf. (absolute path for outside temporal folder pdf, just the <name>.pdf for inside temporal folder)
        'pdf' => '/home/jjalvarezl/Descargas/123.pdf',

        //Tell to the bundle that its necessary to delete pdf after render.
        'deletePdfInTmpAfterRenderized' => false,
    );

return $this->get('jjalvarezl_pdfjs_viewer.viewer_controller')->renderDefaultViewer($parameters);
```

**Custom viewer**

Also, you can customize which elements from viewer you want to display by editing the parameters:

```php
$parameters = array(
        //Same parameters as defalt viewer.

        //pdf.js viewer options
        'showToolBar' => true,
        'showLeftToolbarButton' => true,
        'showSearchInDocumentButton' => true,
        'showPreviousPageButton' => true,
        'showPreviousPageButton' => true,
        'showFindPageInputText' => true,
        'showNumberOfPagesLabel' => true,
        'showZoomInButton'=> false,
        'showZoomOutButton'=> false,
        'showScaleSelectComboBox'=> false,
        'showPresentationModeButton'=> true,
        'showOpenFileButton'=> true,
        'showPrintButton'=> true,
        'showDownloadButton'=> true,
        'showViewBookmarkButton'=> true,
        'showToolsButton'=> true,
    );

return $this->get('jjalvarezl_pdfjs_viewer.viewer_controller')->renderCustomViewer($parameters);
```

Here you can play with this parameters as you wish for customize the pdf viewer.

Support
=======

* Email: jhon.jairo.alvarez.londono@gmail.com

Please email me if you see something wrong or abnormal.

You can always be a contributor or you can [add an issue here](https://github.com/jjalvarezl/JjalvarezlPDFjsViewerBundle/issues)

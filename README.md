ayana-reader
============

Free manga reader depeloved for scanlation group. If you familiar with MangaStream you should know what this software for. I personaly don't own OMV v1.4. I found it on the internet, but it not include the license. **ayana-reader** will be fork from original OMV v1.4.

## Online Manga Viewer v1.4 (2008-10-13)


History
-------
**v1.4** (2008-10-13)
  * Added keyboard navigation feature.
  * Reduced page rendering time.
**v1.3** (2008-03-28)
  * dded chapter's title support.
**v1.2.1** (2008-02-04)
  * Added ability to automatically jump to the next chapter on the last page of the current chapter.
**v1.2** (2008-01-27)
  * Changed URL format.
  * Fixed border layout (it was not displayed in high resolutions).
**v1.1** (2008-01-07)
  * Improved CSS stylesheet.
  * Optimized the way of retreiving the list of uploaded mangas.
  * Fixed invalid XHTML code.
  * Cleaned up some PHP functions.
**v1.0** (2007-12-27)
  * Everything is new in this first version :)


### Requirements
  * PHP version 4 or higher.
  * Apache Mod_Rewrite enabled.


### Installation
1. Unzip the package into a new directory.
2. Edit the file `config.inc.php` and specify your configuration settings.
3. Edit the file `index.php` and paste your advertiser's HTML code between
  `<!-- Begin Advertisement -->` and `<!-- End Advertisement -->` HTML tags.


### Usage
1. Add a manga by creating a new folder into `mangas` directory
   and rename it according to this format: `Manga title`.
2. Add a chapter by creating a new folder into manga's according directory
   and rename it according to this format: `Chapter number - Chapter title`.
3. Finally, add images to the newly created chapter folder. Images will be
   automatically sorted by alphabetical order.

### Note:
  * Do not use `_` character in folder's name.
  * Chapter number must be unique for each manga (accepted characters are: 0-9, A-Z).
  * Chapters can be sorted by ascending or descending order of their numbers (from 0 to 9 then from A to Z).

```Examples:
Chapter 266 of School Rumble must be uploaded at "mangas/School Rumble/266 - Mad Max/".
Bonus Chapter of School Rumble must be uploaded at "mangas/School Rumble/Bonus - Hario Loves Tenma/".
```

### Features
  * Easy to use.
  * Custom image file formats support.
  * Image auto-resizing support.
  * Hot-linking and bandwidth theft protection of uploaded images and folders.
  * Tested with Internet Explorer 6+, Firefox 1.5+ and Opera 8+ (should be compatible with all recent navigators).
  * Search Engine Optimized.
	  * Automatic generation of meta keywords, page title and description.
	  * Friendly looking URLs.
	  * Valid XHTML 1.1 / CSS code.
  * Advertising support.

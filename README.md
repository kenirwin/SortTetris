# Citation Tetris

**Citation Tetris** is a game to help library workers and others practice quickly identifying the kind of citation they are looking at. Options include "article", "book chapter", and "book". 

This tool can be readily adapted for other identification/sorting practice as well. See alternate demo below.

## Demo

Demo available online at:
http://www6.wittenberg.edu/lib/ken/demo/CitationTetris

Alternate demo: sorting animals by Linnean Class:
http://www6.wittenberg.edu/lib/ken/demo/CitationTetris?settings=animal

## Configuration

The settings file defines the default configuration for an installation. By default, the program looks for a `settings.php` file, and fails back to `settings_bib.php`. (Note: the program does not install with a `settings.php` file -- that is reserved for local use. When freshly installed, the program defauts to using `settings_bib.php`.) Additional settings can be supported by the same installation by creating additional settings files; additional settings files must be named `settings_xxx.php` where `xxx` is replaced with an apprpriate string. (e.g. settings_animal). As shown in the alternate demo link above, the `settings_animal.php` file describes the configuration for a game playable at the URL `CitationTetris?settings=animal`.

The two most important variables in the settings files are `$buttons` and `$data_file`: 
* `$buttons` array, which defines the allowable answers (e.g. "books","chapters","articles" or "mammals", "fish", "birds")
* `$data_file` points to a json file such as bibliography.json or animals.json

### Generating JSON files

The `raw-data/` folder contains a tool for generating appropriate data files. The `convert.php` (in its default setup) takes three files of one-entry-per-line lists in files called `books`, `book chapters`, and `articles`, and generates a single JSON file with item types `book`, `book chapter` and `article`. Save the output from this operation to generate new JSON data files. 

## Credits
Written by Ken Irwin, Wittenberg University
"Atari" font created by Genshichi Yasui with a freeware license: http://www.fontspace.com/genshichi-yasui/atari-font

Structure based in part on Tetris with jQuery by Franck Marcia (MIT License):
http://fmarcia.info/jquery/tetris/tetris.html

## License

Licensed under the Creative Commons Attribution-ShareAlike 4.0 International license.                                                                         
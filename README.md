# Citation Tetris

**Citation Tetris** is a game to help library workers and others practice quickly identifying the kind of citation they are looking at. Options include "article", "book chapter", and "book". 

This tool can be readily adapted for other identification/sorting practice for both text and images as well. See alternate demos below.

## Demo

Demo available online at:
http://www6.wittenberg.edu/lib/ken/demo/CitationTetris

Alternate demo #1: sorting animals by Linnean Class:
http://www6.wittenberg.edu/lib/ken/demo/CitationTetris?settings=animal

Alternate demo #2: photo-based animal sorting 
http://www6.wittenberg.edu/lib/ken/demo/CitationTetris?settings=pix

## Installation

The basic functionality of Citation Tetris should work "out of the box" upon moving the files to a suitable server. The leaderboard functions, however, require access to MySQL. To set up the leaderboard:
1. create a database or using an existing MySQL database
2. copy the file `mysql_connect_example.php` to `mysql_connect.php`
3. modify the variables in `mysql_connect.php` to connect to the database
4. use the `leaderboard.sql` file to create the table in your mysql database (you can do this by copying and pasting the sql file)

## Configuration

The settings file defines the default configuration for an installation. By default, the program looks for a `settings.php` file, and fails back to `settings_bib.php`. (Note: the program does not install with a `settings.php` file -- that is reserved for local use. When freshly installed, the program defauts to using `settings_bib.php`.) Additional settings can be supported by the same installation by creating additional settings files; additional settings files must be named `settings_xxx.php` where `xxx` is replaced with an apprpriate string. (e.g. settings_animal). As shown in the alternate demo link above, the `settings_animal.php` file describes the configuration for a game playable at the URL `CitationTetris?settings=animal`.

The two most important variables in the settings files are `$buttons` and `$data_file`: 
* `$buttons` array, which defines the allowable answers (e.g. "book","chapter","article" or "mammal", "fish", "bird")
* `$data_file` points to a json file such as bibliography.json or animals.json

### Generating JSON files

The `raw-data/` folder contains a tool for generating appropriate data files. The `convert.php` (in its default setup) takes three files of one-entry-per-line lists in files called `books`, `book chapters`, and `articles`, and generates a single JSON file with item types `book`, `book chapter` and `article`. Save the output from this operation to generate new JSON data files. 

## Credits
Written by Ken Irwin, Wittenberg University
"Atari" font created by Genshichi Yasui with a freeware license: http://www.fontspace.com/genshichi-yasui/atari-font

Structure based in part on Tetris with jQuery by Franck Marcia (MIT License):
http://fmarcia.info/jquery/tetris/tetris.html

Animal photos used under the Creative Commons CC0 from https://pixabay.com

## License

Licensed under the GNU Affero General Public License.
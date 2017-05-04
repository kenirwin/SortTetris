# Sort Tetris

**Sort Tetris** is an educational falling-blocks style game designed to provide practice sorting things into categories. It can be adapted to sort any short textual or small visual items into 2-5 categories. Examples include:

* U.S. Presidents: Democrat, Republican
* Instruments: Brass, Percussion, Strings, Woodwind
* Animals: Amphibian, Bird, Fish, Mammal, Reptile
* Bibliographic Entries: Article, Book, Book Chapter

The system allows users from different groups (classrooms, workplaces, etc.) to sign in under the name of their group, and for the teacher or supervisor to observe their progress in a Supervisor dashboard. 

## Demo

Demo and public game play available online at:
http://www.sort-tetris.com/play/

## Installation

The basic functionality of Sort Tetris should work "out of the box" upon moving the files to a suitable server. The leaderboard and supervisor functions, however, require access to MySQL. To set up the leaderboard:
1. create a database and authorized user or use an existing MySQL database
   * Database user permissions: ALTER, CREATE, DELETE, INSERT, SELECT, UPDATE
2. copy the file `global_settings_example.php` to `global_settings.php`
3. modify the variables in `global_settings.php` to connect to the database
4. copy the file `supervisor/classes/Config_Sample.class.php` to `supervisor/classes/Config.class.php`
5. modify the variables in `Config.class.php`; there will be some overlap with step 3.
   * Future versions will combine the `global_settings.php` and `Config.class.php` files, but not yet.
6. Create the database tables by one of two methods:
   * Automated: Use a web browser to go to 'install/index.php' 
   * OR Manual: Use the `tables.sql` file to create the table in your mysql database

### Optional additional installation instructions

1. Allow supervisors to register by altering several settings in `global_settings.php`:
 * $allow_supervisor_registration - when set to true, supervisors may register
 * $display_supervisor_reg_links - when true, links appear to the registration form. (If false, but registration is allowed, registering supervisors would have to know how to find the registration link directly.)
 * $display_institution_select - when true, the institutional login link will appear on the game page. If false, an institutional player would have to have a direct link to their an institution URL in order to play as a logged-in user. 

2. Allow access to administrative functions using the $allow_admin variable. When true, the ./supervisor URL will function.

3. Turn on the sound! If you server supports playing mp3 audio, set `$audioOK = true` in `global_settings.php`. By default it is set to false because servers without support for this feature may hang significantly if the setting is turned on.

4. Use Google Analytics. You may add a Google Analytics ID to the $google_analytics_id variable in `global_settings.php` to track use of the program in Google Analytics.

[not currently enabled]: 5. Protect your site using Captcha. To limit bogus activity on the Supervisor functions, it is strongly recommended that you use Google's ReCaptcha service. Obtain a ReCaptcha API key pair at: https://developers.google.com/recaptcha/docs/start . Once you have done so, add them to the global_settings.php file and set `$using_captcha` to true.

## Game Configuration

The `settings/settings_*` files define the configuration for the games. By default, the program displays a list of public games configurations, including all of those included with the initial download. Game configurations can be made public or private in individual `settings_` files. 

Additional settings can be supported by the same installation by creating additional settings files; additional settings files must be named `settings_xxx.php` where `xxx` is replaced with an appropriate string. (e.g. settings_animal). As shown in the alternate demo link above, the `settings_animal.php` file describes the configuration for a game playable at the URL `SortTetris?settings=animal`.

The two most important variables in the settings files are `$buttons` and `$data_file`: 
* `$buttons` array, which defines the allowable answers (e.g. "book","chapter","article" or "mammal", "fish", "bird")
* `$data_file` points to a json file such as bibliography.json or animals.json

## Creating New Content

### Generating JSON files

The `prep_files.php` file is a command-line tool for generating JSON-formatted data suitable for use with the program. Plain text files of categorized data go in the `raw-data/` folder. It contains a subfolder for each knowledge area (bibliography, animals, presidents) and each subfolder contains a plain text file with a list of examples (one item per line). So the "animals" folder contains files for "mammal", "fish", and "bird". (Note that these files are named as singular nouns - these filenames will correspond to the item type displayed during the game.)

Run `prep_files.php` on the command line, giving the knowledge area corresponding to the folder name as an argument, e.g.:

`php prep_files.php animals`

This will generate a correctly-formatted JSON file `animals.json` in the `data-files` directory. When establishing a new JSON file, you will also need to create a new corresponging `settings_FILENAME.php` file in the `settings/` folder in order to play a game with that data file.  

### Infopages

The `infopages/` directory contains infomrational or instructional materials to support learning. Links to relevant infopages are defined in the settings for each game. Users are encouraged to develop helpful infopages for any game they create. 

The `generate_infopage.php` script creates very simple infopages most suitable for known-item lists, such as presidents or instruments. The script lists all of the answers by category and links to the relevant Wikipedia page. Note: this is not a "smart" feature -- it speeds up the process of creating such a page, but may link to the "wrong" Wikipedia page (e.g. the "triagle" wikipedia page is about the shape, not about the musical instrument.) It is strongly suggested that you test and edit any infopages generated automatically. 

The `generate_infopage.php` script does not, by default, write a new file (to protect edited infopages from being accidentally overwritten.) To use the script to create a file, use the `>` directive to write a new file, e.g.

`php generate_infopage.php presidents > infopages/presidents_test.html`

To sort items alphabetically within their type, use the --sort flag:

`php generate_infopage.php --sort animals > infopages/animals.html`

Note: you might not want to sort items like presidents because they may have another valid ordering, such as chronological.

## Credits
Written by Ken Irwin, Wittenberg University

"Atari" font created by Genshichi Yasui with a freeware license: http://www.fontspace.com/genshichi-yasui/atari-font 

"Press Start 2P" font by Cody "CodeMan38" Boisclair, used under the Open Font License: https://fonts.google.com/specimen/Press+Start+2P?query=press&selection.family=Press+Start+2P

Structure based in part on Tetris with jQuery by Franck Marcia (MIT License):
http://fmarcia.info/jquery/tetris/tetris.html

Supervisor & Admin functionality substantially based on code from Dave Hollingworth's excellent Udemy course materials for [Login and Registration from Scratch with PHP and MySQL](https://www.udemy.com/authentication-from-scratch-with-php-and-mysql/learn/v4/overview)

Animal photos used under the Creative Commons CC0 from https://pixabay.com, or under public domain from Wikimedia Commons.

`scores.php` makes use of the DynaTable jQuery plugin by Alfa Jango: https://www.dynatable.com

## License

Licensed under the GNU Affero General Public License.
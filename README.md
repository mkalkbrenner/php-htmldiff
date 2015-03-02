php-htmldiff-advanced
=======
*A library for comparing two HTML files/snippets and highlighting the differences using simple HTML.*

This HTML Diff implementation leverages https://github.com/rashid2538/php-htmldiff - a PHP port of the ruby implementation found at https://github.com/myobie/htmldiff.

It extends php-htmldiff in a backward compatible way that
- allows to run multiple diffs using the same instance of the class, which eases the integration as a service of dependency injection containers
- dicovers removals or additions of complete HTML sections

License
-------
php-htmldiff-advanced is available under [GNU General Public License, version 2] (http://www.gnu.org/licenses/gpl-2.0.html).

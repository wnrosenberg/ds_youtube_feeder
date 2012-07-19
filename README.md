DS Youtube Feeder
=================

Output a Youtube Feed from your Wordpress templates.

- - -

Options:
--------

Options can be found in the Wordpress admin under the menu item "DS Youtube Feeder" under the "Settings" section.

*Youtube Username*: Edit the username here that the plugin will pull videos from.

- - -

Usage:
------

To output all the videos in the feed, use:

    <ul><?php ds_youtube_feeder(); ?></ul>

To output a limited number of results (2 for example), use:

    <ul><?php ds_youtube_feeder(2); ?></ul>

- - -

TODO:
-----

* Allow for custom markup to be returned from this function instead of the default markup (specific to the project it was created for).

* Bundle pagination script (used on project plugin was created for) cuz it's awesome.


- - -

Changelog:
----------

1.1 - Bugs fixed.

1.0 - Initial Release!
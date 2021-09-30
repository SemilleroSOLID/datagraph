<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Local library functions for the datagraph report.
 *
 * @package   report_datagraph
 * @copyright 2013 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

define('DATAGRAPH_MODE_DISPLAY', 'display');
define('DATAGRAPH_MODE_PRINT', 'print');



/**
 * Retrieves the size options and formats them for use in a drop-down
 * selector.
 *
 * @return array The user image size options
 */
function report_datagraph_get_options_size() {
    $sizes = array();

    foreach (array('smalls', 'mediums', 'larges') as $size) {
        $pixels = (int) get_config('report_datagraph', "size_$size");
        $label  = get_string("size:$size", 'report_datagraph');

        if ($pixels > 0) {
            $sizes[$pixels] = $label;
        }
    }

    return $sizes;
}

/**
 * Creates the action buttons (learning mode and groups) used on the report page.
 *
 * @param int $id The course id
 * @param moodle_url $url The current page URL
 * @param array $params Current parameters values as an associative array (group, role, size, mode)
 * @return string The generated HTML
 */
function report_datagraph_output_action_buttons($id, $url, $params) {
    global $OUTPUT;

    $options = array();
    $options['mode']   = array(
        DATAGRAPH_MODE_DISPLAY => get_string('webmode', 'report_datagraph'),
        DATAGRAPH_MODE_PRINT => get_string('printmode', 'report_datagraph'));
    $options['size']  = report_datagraph_get_options_size($id);

    // If there's only one size, don't bother displaying the select.
    if (count($options['size']) <= 1) {
        $options['size'] = array();
    }

    $selects = array();
    foreach ($params as $key => $val) {
        if (array_key_exists($key, $options) && !empty($options[$key])) {
            $myurl      = clone $url;
            $myparams   = $params;

            unset($myparams[$key]);
            $myurl->params($myparams);

            $myselect        = new single_select($myurl, $key, $options[$key], $val, null);
            $myselect->label = get_string_manager()->string_exists("param:$key", 'report_datagraph')
                             ? get_string("param:$key", 'report_datagraph')
                             : get_string($key);

            $selects[$key] = $myselect;
        }
    }

    $html = html_writer::start_tag('div');
    foreach ($selects as $select) {
        $html .= $OUTPUT->render($select);
    }
    $html .= html_writer::end_tag('div');
    return $html;
}



/**
 * Resolves which size display when no query param has been passed.
 *
 * @return string The generated HTML
 */
function report_datagraph_resolve_auto_size() {
    $defaultselector = get_config('report_datagraph', 'size_default');
    $defaultsize = get_config('report_datagraph', 'size_' . $defaultselector);

    if ($defaultsize != 0) {
        // If the default size config is valid, return that.
        return (int) $defaultsize;
    } else {
        // Otherwise, check the other size options and return the first non-zero one.
        foreach (array('smalls', 'mediums', 'larges') as $selector) {
            $size = get_config('report_datagraph', 'size_' . $selector);
            if ($size != 0) {
                return $size;
            }
        }
        // And finally, if none of that worked, hard default to 100.
        return 100;
    }
}


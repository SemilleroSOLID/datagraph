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
 * Display a datagraph of students
 *
 * @package   report_datagraph
 * @copyright 2013 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');

$id       = required_param('id', PARAM_INT);
$mode     = optional_param('mode', DATAGRAPH_MODE_DISPLAY, PARAM_TEXT);
$autosize = report_datagraph_resolve_auto_size();
$size     = optional_param('size', $autosize, PARAM_INT);



// Setup page.
$PAGE->set_url('/report/datagraph/index.php', array('id' => $id));
if ($mode === DATAGRAPH_MODE_PRINT) {
    $PAGE->set_pagelayout('print');
} else {
    $PAGE->set_pagelayout('report');
}
$returnurl = new moodle_url('/course/view.php', array('id' => $id));

$data = array();
$fields = explode("\n", get_config('report_datagraph', 'fields'));
foreach ($userlist as $user) {
    // If user is suspended, skip them.
    if (in_array($user->id, $suspended)) {
        continue;
    }

    // Get user picture and profile data.
    $item = $OUTPUT->user_picture($user, array('size' => $size, 'courseid' => $course->id));
    profile_load_data($user);

    // Loop through configured display fields and add them.
    foreach ($fields as $field) {
        $value = report_datagraph_process_field($field, $user);
        $item .= !empty($value) ? html_writer::tag('span', $value) : '';
    }

    $data[] = $item;
}

// Finish setting up page.
$PAGE->set_title($course->shortname .': '. get_config('report_datagraph' , 'displayname'));
$PAGE->set_heading($course->fullname);
$PAGE->requires->js_call_amd('report_datagraph/datagraph', 'init');

// Display the datagraph to the user.
echo $OUTPUT->header();
echo html_writer::tag('button', get_string('learningmodeoff', 'report_datagraph'), array('id' => 'report-datagraph-toggle'));

$currentparams = array(
    
    'size'  => $size,
   
);
echo report_datagraph_output_action_buttons($id, $PAGE->url, $currentparams);

echo html_writer::alist($data, array('class' => 'report-datagraph'));
echo $OUTPUT->footer();

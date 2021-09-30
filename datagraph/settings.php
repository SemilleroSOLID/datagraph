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
 * Library functions for the datagraph report.
 *
 * @package   report_datagraph
 * @copyright 2019 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $settings->add(
        new admin_setting_heading('general', get_string('settings:headings:general', 'report_datagraph'), '')
    );

   /* $settings->add(
        new admin_setting_configtextarea('report_datagraph/fields',
            get_string('settings:fields', 'report_datagraph'),
            get_string('settings:fields:description', 'report_datagraph'),
            get_string('settings:fields:default', 'report_datagraph')
        )
    );

    $settings->add(
        new admin_setting_configtext('report_datagraph/displayname',
            get_string('settings:displayname', 'report_datagraph'),
            get_string('settings:displayname:description', 'report_datagraph'),
            get_string('settings:displayname:default', 'report_datagraph')
        )
    );

    $settings->add(
        new admin_setting_heading('flatnav', get_string('settings:headings:flatnav', 'report_datagraph'), '')
    );

    $settings->add(
        new admin_setting_configcheckbox('report_datagraph/flatnav',
            get_string('settings:flatnav', 'report_datagraph'),
            get_string('settings:flatnav:description', 'report_datagraph'),
            0
        )
    );

    $settings->add(
        new admin_setting_configtextarea('report_datagraph/flatnav_position',
            get_string('settings:flatnav_position', 'report_datagraph'),
            get_string('settings:flatnav_position:description', 'report_datagraph'),
            get_string('settings:flatnav_position:default', 'report_datagraph')
        )
    );  */

    $options = array(
        'smalls'  => get_string('size:smalls', 'report_datagraph'),
        'mediums' => get_string('size:mediums', 'report_datagraph'),
        'larges'  => get_string('size:larges', 'report_datagraph'),
    );

    $settings->add(
        new admin_setting_heading('size', get_string('settings:headings:size', 'report_datagraph'), '')
    );

    $settings->add(
        new admin_setting_configselect('report_datagraph/size_default',
            get_string('settings:size_default', 'report_datagraph'),
            get_string('settings:size_default:description', 'report_datagraph'),
            'smalls',
            $options
        )
    );
    $settings->add(
        new admin_setting_configtext('report_datagraph/size_smalls',
            get_string('settings:size_smalls', 'report_datagraph'),
            get_string('settings:size_smalls:description', 'report_datagraph'),
            100,
            PARAM_INT
        )
    );

    $settings->add(
        new admin_setting_configtext('report_datagraph/size_mediums',
            get_string('settings:size_mediums', 'report_datagraph'),
            get_string('settings:size_mediums:description', 'report_datagraph'),
            200,
            PARAM_INT
        )
    );

    $settings->add(
        new admin_setting_configtext('report_datagraph/size_larges',
            get_string('settings:size_larges', 'report_datagraph'),
            get_string('settings:size_larges:description', 'report_datagraph'),
            300,
            PARAM_INT
        )
    );
}

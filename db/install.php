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
 * @package   local_noactivitiesnotemptyactualcourses
 * @copyright 2018 Luca Bösch <luca.boesch@bfh.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function xmldb_local_noactivitiesnotemptyactualcourses_install() {
    global $DB;

    \core\session\manager::set_user(get_admin());

    $usedtargets = $DB->get_fieldset_select('analytics_models', 'DISTINCT target', '');

    // Instantiate indicators.
    $indicator1 = \core_analytics\manager::get_indicator('\local_noactivitiesnotemptyactualcourses\analytics\indicator\now_active');
    $indicator2 = \core_analytics\manager::get_indicator('\local_noactivitiesnotemptyactualcourses\analytics\indicator\teacher_and_student_present');
    $indicator3 = \core_analytics\manager::get_indicator('\local_noactivitiesnotemptyactualcourses\analytics\indicator\just_files_resources_and_a_forum');
    $indicators = array($indicator1->get_id() => $indicator1, $indicator2->get_id() => $indicator2, $indicator3->get_id() => $indicator3);

    if (!in_array('\local_noactivitiesnotemptyactualcourses\analytics\target\for_your_files_only', $usedtargets)) {
        // Instantiate the target.
        $target = \core_analytics\manager::get_target('\local_noactivitiesnotemptyactualcourses\analytics\target\for_your_files_only');
        // Create the model.
        $model = \core_analytics\model::create($target, $indicators, '\core\analytics\time_splitting\no_splitting');
        $model->enable();
    }

}

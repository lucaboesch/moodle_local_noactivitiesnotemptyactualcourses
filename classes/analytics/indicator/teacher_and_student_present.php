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
 * Teacher and student present.
 *
 * @package   local_noactivitiesnotemptyactualcourses
 * @copyright 2018 Luca Bösch <luca.boesch@bfh.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_noactivitiesnotemptyactualcourses\analytics\indicator;

defined('MOODLE_INTERNAL') || die();

/**
 * Teacher and student present.
 *
 * @package   local_noactivitiesnotemptyactualcourses
 * @copyright 2018 Luca Bösch <luca.boesch@bfh.ch>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class teacher_and_student_present extends \core_analytics\local\indicator\binary {

    /**
     * File resource ids.
     *
     * @var array|null
     */
    protected $fileresourceid = null;

    /**
     * Returns the name.
     *
     * If there is a corresponding '_help' string this will be shown as well.
     *
     * @return \lang_string
     */
    public static function get_name() : \lang_string {
        return new \lang_string('indicator:teacherandstudentpresent', 'local_noactivitiesnotemptyactualcourses');
    }

    /**
     * required_sample_data
     *
     * @return string[]
     */
    public static function required_sample_data() {
        // We require course because, although calculate_sample only reads context, we need the context to be course
        // or below.
        return array('context', 'course');
    }

    /**
     * Reversed because the indicator is in 'negative' and the max returned value means teacher present.
     *
     * @param float $value
     * @param string $subtype
     * @return string
     */
    public function get_display_value($value, $subtype = false) {

        // No subtypes for binary values by default.
        if ($value == -1) {
            return get_string('yes');
        } else if ($value == 1) {
            return get_string('no');
        }
    }

    /**
     * calculate_sample
     *
     * @param int $sampleid
     * @param string $sampleorigin
     * @param int|false $notusedstarttime
     * @param int|false $notusedendtime
     * @return float
     */
    public function calculate_sample($sampleid, $sampleorigin, $notusedstarttime = false, $notusedendtime = false) {

        $forum = false;

        foreach (get_course_mods($sampleid) as $cm) {
            if ($cm->modname = 'forum') {
                if ($forum) {
                    return self::get_max_value();
                } else {
                    $forum = true;
                }
                continue;
            }
            if ($cm->modname != 'resource') {
                return self::get_max_value();
            }
        }

        return self::get_min_value();
    }
}
<?php
/**
 * @package		JINC
 * @subpackage          Statistics
 * @copyright           Copyright (C) 2010 - Lhacky
 * @license		GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 *   This file is part of JINC.
 *
 *   JINC is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   JINC is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with JINC.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Requiring PHP libraries and defining constants
 */
require_once 'statistic.php';
require_once 'subsstatistic.php';
require_once 'unsubsstatistic.php';
require_once 'numsstatistic.php';
require_once 'sentstatistic.php';
require_once 'timeline.php';
require_once 'dailytimeline.php';
require_once 'hourlytimeline.php';
require_once 'monthlytimeline.php';
require_once 'weeklytimeline.php';

define('STATISTICFACTORY_STAT_HOURLY', 1);
define('STATISTICFACTORY_STAT_DAILY', 0);
define('STATISTICFACTORY_STAT_WEEKLY', 2);
define('STATISTICFACTORY_STAT_MONTHLY', 3);

define('STATISTICFACTORY_SUBS_TYPE', 0);
define('STATISTICFACTORY_UNSUBS_TYPE', 1);
define('STATISTICFACTORY_NUMSUBS_TYPE', 2);
define('STATISTICFACTORY_SENT_TYPE', 3);

/**
 * StatisticFactory class, providing methods to obtains statistical objects.
 *
 * @package		JINC
 * @subpackage          Statistics
 * @since		0.6
 */
class StatisticFactory {
    /**
     * Method to get statistics on a newsletter.
     *
     * @param int $type Statistic type. See STATISTICFACTORY_*_TYPE constants
     * @param int $frequency Statistic frequency. See STATISTICFACTORY_STAT_* constants
     * @param timestamp $start_time Statistic start time
     * @param timestamp $end_time Statistic end time
     * @param int $news_id Newsletter identifier
     * @return NewsletterStatistic
     */
    function getStatistic($type, $frequency, $start_time, $end_time, $news_id) {
        switch ($frequency) {
            case STATISTICFACTORY_STAT_HOURLY:
                $timeline = new HourlyTimeLine($start_time, $end_time);
                break;

            case STATISTICFACTORY_STAT_DAILY:
                $timeline = new DailyTimeLine($start_time, $end_time);
                break;

            case STATISTICFACTORY_STAT_WEEKLY:
                $timeline = new WeeklyTimeLine($start_time, $end_time);
                break;

            case STATISTICFACTORY_STAT_MONTHLY:
                $timeline = new MonthlyTimeLine($start_time, $end_time);
                break;

            default:
                $timeline = new DailyTimeLine($start_time, $end_time);
                break;
        }
        $timeline->calculate();

        switch ($type) {
            case STATISTICFACTORY_UNSUBS_TYPE:
                $stat = new UnsubsStatistic($timeline);
                break;

            case STATISTICFACTORY_NUMSUBS_TYPE:
                $stat = new NumsStatistic($timeline);
                break;

            case STATISTICFACTORY_SENT_TYPE:
                $stat = new SentStatistic($timeline);
                break;

            default:
                $stat = new SubsStatistic($timeline);
                break;
        };
        $stat->setNewsId($news_id);
        return $stat;
    }

    /**
     * Methods to get active statistic type list.
     * @return array
     */
    function getTypeList() {
        $typelist = array();
        // $typelist[0] = array('stat_type' => STATISTICFACTORY_NUMSUBS_TYPE, 'stat_descr' => JText::_('OPTION_NUMSUBS_TYPE'));
        $typelist[1] = array('stat_type' => STATISTICFACTORY_SUBS_TYPE, 'stat_descr' => JText::_('COM_JINC_SUBS_TYPE'));
        $typelist[2] = array('stat_type' => STATISTICFACTORY_UNSUBS_TYPE, 'stat_descr' => JText::_('COM_JINC_UNSUBS_TYPE'));
        $typelist[3] = array('stat_type' => STATISTICFACTORY_SENT_TYPE, 'stat_descr' => JText::_('COM_JINC_SENT_TYPE'));
        return $typelist;
    }

    /**
     * Methods to get active time type list.
     * @return array
     */

    function getTimeList() {
        $timelist = array();
        $timelist[0] = array('time_type' => STATISTICFACTORY_STAT_HOURLY, 'time_descr' => JText::_('COM_JINC_STAT_HOURLY'));
        $timelist[1] = array('time_type' => STATISTICFACTORY_STAT_DAILY, 'time_descr' => JText::_('COM_JINC_STAT_DAILY'));
        // $timelist[2] = array('time_type' => STATISTICFACTORY_STAT_WEEKLY, 'time_descr' => JText::_('_STAT_WEEKLY'));
        // $timelist[3] = array('time_type' => STATISTICFACTORY_STAT_MONTHLY, 'time_descr' => JText::_('COM_JINC_STAT_MONTHLY'));
        return $timelist;
    }
}
?>
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

/**
 * NewsletterStatistic class, defining a generic newletter statistic.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class NewsletterStatistic extends Statistic {
    /**
     * Newsletter identifier
     *
     * @var int
     */
    var $_news_id;

    /**
     * NewsletterStatistic constructor
     *
     * @param TimeLine $timeline Statistic time line
     */
    function NewsletterStatistic($timeline) {
        parent::Statistic($timeline);
        $this->setNewsId(0);
    }

    /**
     * Newsletter identifier getter.
     *
     * @return integer
     */
    function getNewsId() {
        return $this->_news_id;
    }

    /**
     * Newsletter identifier getter.
     * @param integer $news_id
     */
    function setNewsId($news_id) {
        $this->_news_id = (int) $news_id;
    }
}
?>
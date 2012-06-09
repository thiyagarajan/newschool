<?php
/**
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
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class JINCViewStats extends JView {

    protected $news_id;
    protected $stat_type;
    protected $time_type;
    protected $start_time;
    protected $end_time;
    protected $values = array();
    protected $legend = array();

    function display($tpl = null) {
        jincimport('statistics.statisticfactory');
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
        JToolBarHelper::title( JText::_('COM_JINC_STATISTICS'), 'jinc' );
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(69);

        $session =& JFactory::getSession();
        $config =& JFactory::getConfig();
        $tzoffset = $config->getValue('config.offset');

        $this->news_id = JRequest::getInt('id', 0);
        $this->stat_type = JRequest::getInt('stat_type', STATISTICFACTORY_SUBS_TYPE);
        $this->time_type = JRequest::getInt('time_type', STATISTICFACTORY_STAT_DAILY);

        $start_date = JRequest::getFloat('start_date', time());
        $end_date = JRequest::getFloat('end_date', time());
        $sdate =& JFactory::getDate($start_date, $tzoffset);
        $edate =& JFactory::getDate($end_date, $tzoffset);
        $this->start_time = $sdate;
        $this->end_time = $edate;

        $this->values = $session->get('stats.values');
        $this->legend = $session->get('stats.legend');

        parent::display($tpl);
    }
}
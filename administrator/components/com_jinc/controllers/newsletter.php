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

jimport('joomla.application.component.controllerform');

class JINCControllerNewsletter extends JControllerForm {

    function __construct() {
        parent::__construct();
    }

    function statsRender() {
        jincimport('graphics.builtinrenderer');
        $session = JFactory::getSession();
        $values = $session->get('stats.values');
        $legend = $session->get('stats.legend');
        $renderer = new BuiltInRenderer($values, $legend);
        $renderer->render();
    }

    function stats() {
        jincimport('statistics.statisticfactory');
        jincimport('core.newsletterfactory');

        $session = & JFactory::getSession();
        $config = & JFactory::getConfig();
        $tzoffset = $config->getValue('config.offset');

        $id = JRequest::getInt('id', 0);
        $stat_type = JRequest::getInt('stat_type', 0);
        $time_type = JRequest::getInt('time_type', 0);
        $start_date = JRequest::getString('start_date');
        $end_date = JRequest::getString('end_date');
        $sdate = & JFactory::getDate($start_date, $tzoffset);
        $edate = & JFactory::getDate($end_date, $tzoffset);

        $stat = StatisticFactory::getStatistic($stat_type, $time_type, $sdate->toUNIX(), $edate->toUNIX(), $id);
        $values = $stat->getValues();
        $legend = $stat->getTimeValues();
        $session->set('stats.values', $values);
        $session->set('stats.legend', $legend);

        $timeline = $stat->getTimeLine();
        JRequest::setVar('start_date', $timeline->getStartTime());
        JRequest::setVar('end_date', $timeline->getEndTime());
        $stattypes = StatisticFactory::getTypeList();
        $timetypes = StatisticFactory::getTimeList();
        $time_format = $timeline->getJFormat();

        JRequest::setVar('view', 'stats');
        $view = & $this->getView('stats', 'html');

        $ninstance = NewsletterFactory::getInstance();
        if ($newsletters = $ninstance->loadNames()) {
            $empty_filter = array("id" => "0", "name" => JText::_('COM_JINC_SELECT_NEWSLETTER'));
            array_unshift($newsletters, $empty_filter);
        } else {
            $newsletters = array(array("id" => "0", "name" => JText::_('COM_JINC_SELECT_NEWSLETTER')));
        }

        $view->assignRef('time_format', $time_format);
        $view->assignRef('stattypes', $stattypes);
        $view->assignRef('timetypes', $timetypes);
        $view->assignRef('newsletters', $newsletters);
        parent::display();
    }

    function import() {
        JRequest::setVar('view', 'newsletter');
        $id = JRequest::getInt('id', 0);
        $csvfile = JRequest::getVar('csvfile', array(), 'FILES');
        $view = & $this->getView('newsletter', 'html');
        if (isset($csvfile['tmp_name']) && $csvfile['tmp_name'] != '' && !is_null($csvfile['tmp_name'])) {
            $mime = $csvfile['type'];
            if (true || $mime == 'application/x-csv' || $mime == 'text/csv' ||
                    $mime == 'application/csv' || $mime == 'application/excel' ||
                    $mime == 'application/vnd.ms-excel' || $mime == 'application/vnd.msexcel') {
                $model = $this->getModel('newsletter');
                if ($result = $model->import($id, $csvfile['tmp_name'])) {
                    $view->setLayout('import');
                    $view->assignRef('result', $result);
                    parent::display();
                } else {
                    $msg = JText::_('COM_JINC_ERR004');
                    $link = 'index.php?option=com_jinc&view=newsletter&layout=uploadcsv&id=' . $id;
                    $this->setRedirect($link, $msg);
                }
            } else {
                $msg = JText::_('COM_JINC_ERR014') . ' ' . $csvfile['type'];
                $link = 'index.php?option=com_jinc&view=newsletter&layout=uploadcsv&id=' . $id;
                $this->setRedirect($link, $msg);
            }
        } else {
            $msg = JText::_('COM_JINC_ERR004');
            $link = 'index.php?option=com_jinc&view=newsletter&layout=uploadcsv&id=' . $id;
            $this->setRedirect($link, $msg);
        }
    }

    function listAttributes() {
        JRequest::setVar('view', 'attributes');
        JRequest::setVar('hidemainmenu', 1);
        parent::display();
    }
}

?>

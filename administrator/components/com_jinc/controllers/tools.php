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

class JINCControllerTools extends JINCController {

    function __construct() {
        parent::__construct();
    }

    function loadSampleData() {
        $model = $this->getModel('tools');
        if (!$model->loadSampleData()) {
            $msg = JText::_('COM_JINC_ERR033') . ": " . $model->getError();
        } else {
            $msg = JText::_('COM_JINC_INF007');
        }
        $this->setRedirect('index.php?option=com_jinc&view=newsletters', $msg);
    }

    function loadSampleStatisticalData() {
        $model = $this->getModel('tools');
        if (!$model->loadSampleStatisticalData()) {
            $msg = JText::_('COM_JINC_ERR033') . ": " . $model->getError();
        } else {
            $msg = JText::_('COM_JINC_INF007');
        }
        $this->setRedirect('index.php?option=com_jinc&view=newsletters', $msg);
    }

}

?>

<?php

/**
 * @package		JINC
 * @subpackage          Utility
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
require_once 'logger.php';

define('PARAMETERPROVIDER_MAIL_TIME_INTERVAL', 500);
define('PARAMETERPROVIDER_MAIL_X_STEP', 1);
define('PARAMETERPROVIDER_MAIL_MAX_BCC', 50);
define('PARAMETERPROVIDER_SEND_MAILS', true);
define('PARAMETERPROVIDER_LOG_LEVEL', LOGGER_INFO);
define('PARAMETERPROVIDER_AJAX_LOG_LEVEL', 0);
define('PARAMETERPROVIDER_HINTS', 1);
define('PARAMETERPROVIDER_NUM_MSG', 5);
define('PARAMETERPROVIDER_STOP_ON_FAILURE', true);
define('PARAMETERPROVIDER_CHART_SYSTEM', 0);

/**
 * ParameterProvider class, providing methods to get application parameters.
 *
 * @package		JINC
 * @subpackage          Utility
 * @since		0.6
 */
class ParameterProvider {

    /**
     * Method to get a generic parameter value.
     *
     * @param String $name Parameter name
     * @param String $default Default parameter value
     * @return String Parameter value
     */
    function getParam($name, $default) {
        jimport('joomla.application.component.model');

        $params = JComponentHelper::getParams('com_jinc');
        $param = $params->get($name, $default);
        return $param;
    }

    /**
     * Method to get max mail interval time parameter value.
     *
     * @return integer
     */
    function getMailTimeInterval() {
        $ret = (int) ParameterProvider::getParam('mail_time_interval', PARAMETERPROVIDER_MAIL_TIME_INTERVAL);
        $interval = ($ret < 0) ? PARAMETERPROVIDER_MAIL_TIME_INTERVAL : $ret;
        return $interval * 1000;
    }

    /**
     * Method to get max number of mails per AJAX step value.
     *
     * @return integer
     */
    function getMaxXStep() {
        $ret = (int) ParameterProvider::getParam('mail_x_step', PARAMETERPROVIDER_MAIL_X_STEP);
        return ($ret < 0) ? PARAMETERPROVIDER_MAIL_X_STEP : $ret;
    }

    /**
     * Method to get max number of recipients in BCC for a single mail.
     * @return integer
     */
    function getMailMaxBcc() {

        $ret = (int) ParameterProvider::getParam('mail_max_bcc', PARAMETERPROVIDER_MAIL_MAX_BCC);
        return ($ret < 0) ? PARAMETERPROVIDER_MAIL_MAX_BCC : $ret;
    }

    /**
     * Method to understand if the application must simply simulate mail dispatch.
     *
     * @return boolean
     */
    function getSendMail() {
        $ret = (int) ParameterProvider::getParam('send_mail', PARAMETERPROVIDER_SEND_MAILS);
        return ($ret == 1) ? PARAMETERPROVIDER_SEND_MAILS : $ret;
    }

    /**
     * Method to get the application log level.
     *
     * @return integer
     */
    function getLogLevel() {
        $ret = (int) ParameterProvider::getParam('log_level', PARAMETERPROVIDER_LOG_LEVEL);
        return ($ret < 0) ? PARAMETERPROVIDER_LOG_LEVEL : $ret;
    }

    /**
     * Method to get the application log level.
     *
     * @return integer
     */
    function getChartSystem() {
        $ret = (int) ParameterProvider::getParam('chart_system', PARAMETERPROVIDER_CHART_SYSTEM);
        return ($ret < 0) ? PARAMETERPROVIDER_CHART_SYSTEM : $ret;
    }

    /**
     * Method to get the application ajax log level.
     * @return integer
     */
    function getAJAXLogLevel() {
        $ret = (int) ParameterProvider::getParam('debug_ajax', PARAMETERPROVIDER_AJAX_LOG_LEVEL);
        return ($ret == 1);
    }

    /**
     * Method to understand if hints must be showed.
     *
     * @return boolean
     */
    function getHints() {
        return ((int) ParameterProvider::getParam('hints', PARAMETERPROVIDER_HINTS));
    }

    /**
     * Method to get max number of messages to show in frontend.
     *
     * @return integer
     */
    function getDefaultNumMessages() {
        return ((int) ParameterProvider::getParam('num_msg', PARAMETERPROVIDER_NUM_MSG));
    }

    /**
     * Method to understand if a sending process must be stopped
     * in case of mail system failure.
     *
     * @return boolean
     */
    function getStopOnFail() {
        $ret = (int) ParameterProvider::getParam('stop_on_failure', PARAMETERPROVIDER_STOP_ON_FAILURE);
        return ($ret == 1) ? PARAMETERPROVIDER_STOP_ON_FAILURE : $ret;
    }

}

?>
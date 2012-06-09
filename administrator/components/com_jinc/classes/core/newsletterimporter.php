<?php

/**
 * @version		$Id: newsletterimporter.php 25-gen-2010 12.50.07 lhacky $
 * @package		JINC
 * @subpackage          Core
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
require_once 'newsletter.php';

/**
 * NewsletterImporter class, providing methods to import newsletter subscribers
 * from CSV or other format files.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class NewsletterImporter {

    /**
     * Max line length to read from a file
     *
     * @var	Max line length to read from a file
     * @access	public
     * @since	0.6
     */
    var $_LINE_MAX_LENGTH;

    function NewsletterImporter() {
        $this->_LINE_MAX_LENGTH = 10000;
    }

    function &getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new NewsletterImporter();
        }
        return $instance;
    }

    /**
     * The newsletter importer. It imports newsletter subscribers from a CSV file.
     *
     * @access	public
     * @param	integer $newsletter a newsletter object.
     * @param	string  $csvfile_name the CSV file name.
     * @return  array containing import results.
     * @since	0.6
     * @see     Newsletter
     */
    function ImportFromCSV($newsletter, $csvfile_name) {
        jincimport('utility.jincjoomlahelper');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        if (!($handle = @fopen($csvfile_name, "r"))) {
            $logger->finer('NewsletterImporter: unable to open ' . $csvfile_name);
            return false;
        }
        $result = array();
        while (($data = fgetcsv($handle, $this->_LINE_MAX_LENGTH, ",")) !== FALSE) {
            $logger->finer('NewsletterImporter: importing ' . implode(', ', $data));
            $info = $newsletter->getSubscriptionInfo();
            $subscriber_info = array();
            $attributes = array();
            for ($i = 0; $i < count($info); $i++) {
                $prefix = substr($info[$i], 0, 5);
                if ($prefix == 'attr_') {
                    $suffix = substr($info[$i], 5);
                    $attributes[$suffix] = isset($data[$i])?$data[$i]:'';
                } else {
                    $subscriber_info[$info[$i]] = $data[$i];
                }
            }

            $sub_result = array();
            $sub_result['data'] = implode(', ', $subscriber_info);

            switch ($newsletter->getType()) {
                case NEWSLETTER_PUBLIC_NEWS:
                    $subscriber_info['noptin'] = true;
                    break;

                case NEWSLETTER_PRIVATE_NEWS: {
                        $user_id = $subscriber_info['user_id'];
                        $user_info = JINCJoomlaHelper::getUserInfo($user_id);
                        if (empty($user_info)) {
                            $user_info = JINCJoomlaHelper::getUserInfoByUsername($user_id);
                            if (empty($user_info)) {
                                $user_info = JINCJoomlaHelper::getUserInfoByUsermail($user_id);
                                if (!empty($user_info))
                                    $subscriber_info['user_id'] = $user_info['id'];
                            } else {
                                $subscriber_info['user_id'] = $user_info['id'];
                            }
                        }
                        break;
                    }

                default:
                    break;
            }
            
            if ($newsletter->subscribe($subscriber_info, $attributes)) {
                $sub_result['result'] = 'OK';
            } else {
                $sub_result['result'] = $newsletter->getError();
            }
            array_push($result, $sub_result);
        }
        fclose($handle);
        return $result;
    }

}
?>

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
jimport('joomla.application.component.modellist');

class JINCModelMessages extends JModelList {

    protected $option = 'com_jinc';

    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'm.subject', 'm.bulkmail', 'n.name', 'datasent', 'm.id'
            );
        }

        parent::__construct($config);
    }

    protected function populateState() {
        $app = JFactory::getApplication('administrator');

        $newsletterId = $app->getUserStateFromRequest($this->context . '.filter.news_id', 'filter_news_id', '');
        $this->setState('filter.news_id', $newsletterId);

        $filterSearch = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search', '');
        $this->setState('filter.search', $filterSearch);

        parent::populateState('m.subject', 'asc');
    }

    protected function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query_cols = 'm.id, m.subject, m.bulkmail, ' .
                'UNIX_TIMESTAMP(m.datasent) AS datasent, ' .
                'm.news_id, n.name, m.attachment, ' .
                'IF(ISNULL(MIN(p.status)), 0, MIN(p.status)) AS status, ' .
                'IF(ISNULL(MAX(p.status)), 0, MAX(p.status)) AS max_status ';

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select',
                        $query_cols
                )
        );
        $query->from('`#__jinc_message` m');
        $query->join('LEFT', '`#__jinc_newsletter` n ON m.news_id = n.id');
        $query->join('LEFT', '`#__jinc_process` p ON m.id = p.msg_id');
        $query->group('m.id');

        // Filter by category.
        $newsletterId = $this->getState('filter.news_id');
        if (is_numeric($newsletterId)) {
            $query->where('m.news_id = ' . (int) $newsletterId);
        }

        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%' . $db->getEscaped($search, true) . '%');
            $query->where('m.subject LIKE ' . $search);
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        $query->order($db->getEscaped($orderCol . ' ' . $orderDirn));
        return $query;
    }

}

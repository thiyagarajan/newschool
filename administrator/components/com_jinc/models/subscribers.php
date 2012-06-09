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

class JINCModelSubscribers extends JModelList {

    protected $option = 'com_jinc';

    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                's.id', 'subs_email', 'n.name'
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

        parent::populateState('subs_email', 'asc');
    }

    protected function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query_cols = 's.id, concat(COALESCE(s.email, \'\'), COALESCE(u.email, \'\')) as subs_email, user_id, news_id, random, n.name, s.datasub ';
        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select',
                        $query_cols
                )
        );
        $query->from('`#__jinc_subscriber` s');
        $query->join('LEFT', '`#__jinc_newsletter` n ON s.news_id = n.id');
        $query->join('LEFT', '`#__users` u ON s.user_id = u.id');
        $query->group('s.id');

        // Filter by category.
        $newsletterId = $this->getState('filter.news_id');
        if (is_numeric($newsletterId)) {
            $query->where('s.news_id = ' . (int) $newsletterId);
        }

        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%' . $db->getEscaped($search, true) . '%');
            $query->where('u.email LIKE ' . $search . ' OR s.email LIKE ' . $search);
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        $query->order($db->getEscaped($orderCol . ' ' . $orderDirn));
        return $query;
    }

}

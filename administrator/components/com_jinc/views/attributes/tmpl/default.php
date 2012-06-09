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
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('ATTRIBUTE_MANAGER', 'ATTRIBUTE_MANAGER_TITLE');

$ajax_log_level = isset($this->ajax_log_level) ? ($this->ajax_log_level == true) : false;
$debug_ajax = ($ajax_log_level) ? 'true' : 'false';
JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
JHTML::script('administrator/components/com_jinc/assets/js/phplivex.js');
jincimport('utility.PHPLiveX');
?>

<link rel="stylesheet" type="text/css" href="templates/khepri/css/rounded.css" />
<script type="text/javascript">
    function setError(errcode, errmsg) {
    if (typeof(errcode) != "undefined") {
    alert(errmsg);
    }
    }

    function attributeCreate() {
    var attr_name_input = document.getElementById("jform_name");
    var attr_description_input = document.getElementById("jform_description");
    var attr_type_input = document.getElementById("jform_type");
    var attr_name_i18n_input = document.getElementById("jform_name_i18n");

    var attr_name = attr_name_input.value;
    if (attr_name.length == 0) {
    alert("<?php echo JText::_('COM_JINC_ERR044'); ?>");
    return
    }
    var attr_description = attr_description_input.value;
    var attr_type = attr_type_input.selectedIndex;
    var attr_name_i18n = attr_name_i18n_input.value;

    var nowdate = new Date();
    var rand_num = Math.ceil(Math.random() * 10000);
    var cache_id = nowdate.getTime() + "_" + rand_num;
    var plx = new PHPLiveX();
    return plx.ExternalRequest({
    'content_type': 'json',
    'preloader': 'pr',
    'url': 'index.php?option=com_jinc&task=newsletterJSON.createAttribute&format=json',
    'onFinish': function(response){
    var status = response.status;
    if (status >= 0) {
    attr_name_input.value = '';
    attr_description_input.value = '';
    attr_type_input.selectedIndex = 0;
    attr_name_i18n_input.value = '';
    location.reload();
    } else {
    setError(response.errcode, response.errmsg);
    }
    },
    'params':{'cache_id': cache_id, 'attr_name': attr_name, 'attr_type': attr_type, 'attr_description': attr_description, 'attr_name_i18n': attr_name_i18n}
    });
    }

    function attributeRemove(attr_name, row_id) {
    var nowdate = new Date();
    var rand_num = Math.ceil(Math.random() * 10000);
    var cache_id = nowdate.getTime() + "_" + rand_num;
    var plx = new PHPLiveX();
    return plx.ExternalRequest({
    'content_type': 'json',
    'preloader': 'pr',
    'url': 'index.php?option=com_jinc&task=newsletterJSON.removeAttribute&format=json',
    'onFinish': function(response){
    var status            = response.status;
    if (status >= 0) {
    location.reload();
    } else {
    setError(response.errcode, response.errmsg);
    }
    },
    'params':{'cache_id': cache_id, 'attr_name': attr_name}
    });
    }

    function attrName_OnChange() {
    var attr_name_input = document.getElementById("jform_name");
    var attr_name = attr_name_input.value;
    var attr_name_tagi18n_div = document.getElementById("attr_name_tagi18n");
    var attr_name_tagi18n_string = "COM_JINC_TAG_ATTR_" + attr_name;
    attr_name_tagi18n_div.innerHTML = attr_name_tagi18n_string.toUpperCase();
    }
</script>

<div id="element-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <form action="index.php" method="post" name="adminForm">
            <table cellspacing="5px" align="center" width="100%">
                <tr>
                    <td width="15%">
                        <strong>
                            <?php echo $this->form->getLabel('name'); ?>
                        </strong>
                    </td>
                    <td width="35%">
                        <?php echo $this->form->getInput('name'); ?>
                        </td>
                        <td width="15%">
                            <strong>
                            <?php
                            echo JHTML::tooltip(JText::_('COM_JINC_ATTR_NAME_TAGI18N_DESC'), JText::_('COM_JINC_ATTR_NAME_TAGI18N_DESC'),
                                    '', JText::_('COM_JINC_ATTR_NAME_TAGI18N'));
                            ?>
                        </strong>
                    </td>
                    <td width="35%">
                        <div id="attr_name_tagi18n">COM_JINC_TAG_ATTR_</div>
                    </td>
                </tr>
                <tr>
                    <td width="15%">
                        <strong>
                            <?php echo $this->form->getLabel('name_i18n'); ?>
                        </strong>
                    </td>
                    <td>
                        <?php echo $this->form->getInput('name_i18n'); ?>
                        </td>
                        <td width="15%">
                            <strong>
                            <?php echo $this->form->getLabel('type'); ?>
                        </strong>
                    </td>
                    <td width="20%">
                        <?php echo $this->form->getInput('type'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">
                        <?php echo $this->form->getLabel('description'); ?>
                        </td>
                        <td colspan="3">
                        <?php echo $this->form->getInput('description'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" valign="middle" align="center">
                            <input type="button" onclick="javascript:attributeCreate();" value="<?php echo JText::_('COM_JINC_BTN_CREATE_ATTRIBUTE'); ?>">
                            <span id="pr" style="visibility:hidden;vertical-align:middle">
                                <img alt="Loading ..." width="16px" height="16px" src="components/com_jinc/assets/images/icons/jinc-ajax-loader.gif">
                            </span>
                        </td>
                    </tr>
                </table>

            </form>
        </div>

        <div class="b">
            <div class="b">
                <div class="b"></div>
            </div>
        </div>
    </div>
    <br>
    <div id="element-box">
        <div class="t">
            <div class="t">
                <div class="t"></div>
            </div>
        </div>
        <div class="m">
            <div id="editcell">
                <table class="adminlist" id="attrTable">
                    <thead>
                        <tr>
                            <th width="2%">

                            </th>
                            <th width="30%">
                            <?php echo JText::_('COM_JINC_ATTR_NAME'); ?>
                        </th>
                        <th width="58%">
                            <?php echo JText::_('COM_JINC_ATTR_DESCRIPTION'); ?>
                        </th>
                        <th width="10%">
                            <?php echo JText::_('COM_JINC_ATTR_TYPE'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if (isset($this->items)) {
                                $k = 0;
                                $options = array("height" => 16, "width" => 16, "title" => JText::_('COM_JINC_ATTRIBUTE_DELETE'));
                                $base_url = JURI::base() . 'components/com_jinc/assets/images/icons/';
                                $delete_img = JHTML::image($base_url . 'delete_f2.png', JText::_('COM_JINC_ATTRIBUTE_DELETE'), $options);
                                for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                                    $row = & $this->items[$i];
                    ?>
                                    <tr class="<?php echo "row$k"; ?>">
                                        <td>
                            <?php
                                    $options['onClick'] = 'attributeRemove(\'' . $row->name . '\', ' . $i . ');';
                                    $delete_img = JHTML::image($base_url . 'delete_f2.png', JText::_('COM_JINC_ATTRIBUTE_DELETE'), $options);
                                    echo $delete_img;
                            ?>
                                </td>
                                <td>
                            <?php
                                    echo JHTML::tooltip(JText::_($row->name_i18n), JText::_('TAGS_ATTR_' . strtoupper($row->name)),
                                            '', $row->name);
                            ?>
                                </td>
                                <td>
                            <?php echo $row->description; ?>
                                </td>
                                <td>
                            <?php echo JText::_('COM_JINC_ATTRIBUTE_TYPE_' . $row->type); ?>
                                </td>
                            </tr>
                    <?php
                                    $k = 1 - $k;
                                }
                            }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="b">
        <div class="b">
            <div class="b"></div>
        </div>
    </div>
</div>

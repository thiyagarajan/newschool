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
 * JINCHTMLHelper class, providing functions to create common blocks of HTML documents.
 *
 * @package		JINC
 * @subpackage          Utility
 * @since		0.6
 */
class JINCHTMLHelper {
    function quickIconButton( $link, $image, $text, $attribs = "" ) {
        $button = '<div style="float:left;">';
        $button .=	'<div class="icon">'
            .'<a href="'.$link.'" ' . $attribs . '>'
            .JHTML::_('image.site',  $image, '/components/com_jinc/assets/images/icons/', NULL, NULL, $text )
            .'<span>'.$text.'</span></a>'
            .'</div>';
        $button .= '</div>';

        return $button;
    }

    function hint($hint_name, $hint_title, $hint_header = '', $hint_footer = '', $force = false) {
        jincimport('utility.parameterprovider');
        $hinton = ParameterProvider::getHints();        
        if ( !$hinton && !$force) return;
        echo '<div width="80%">';
        echo '<center><fieldset class="menubackgr" style="padding: 10px; text-align: left">';
        echo '<legend><img src="components/com_jinc/assets/images/icons/checkin.png" border="0" align="absmiddle" alt="Hint" width="24px" height="24px" hspace="6">';
        echo '<strong>&nbsp;&nbsp;' . JText::_('COM_JINC_HINT_' . $hint_title) . ' </strong></legend>';
        echo $hint_header;
        echo JText::_('COM_JINC_HINT_' . $hint_name);
        echo $hint_footer;
        echo '</fieldset></center></div>';
    }

    function legend($legend_array, $img_base = 'components/com_jinc/assets/images/') {
        echo '<table cellspacing="0" cellpadding="4" align="center">';
        echo '<tr align="center">';
        for ($i = 0 ; $i < count($legend_array) ; $i++) {
            $element = $legend_array[$i];
            $text = JText::_($element['text']);
            $icon = $element['icon'];
            $alternate = isset($element['alt'])? $element['alt'] : $text;
            $img_url = JURI::base() . $img_base . $icon;
            $img_options = array( "height" => 16, "width" => 16);
            $img = JHTML::image($img_url, $alternate, $img_options);
            echo '<td>' . $img . '&nbsp;&nbsp;';
            echo $text . '&nbsp;&nbsp;&nbsp;&nbsp;</td>';
        }
        echo '</tr></table>';
    }

    function showError($error_code) {
        echo $error_code . ' - ' . JText::_('ERROR_' . $error_code) . '<br>';
    }

    function showTags($tags_array, $include_prefix = array(), $print_js_id = true) {
        $result = '';
        if (! empty ($tags_array))
            $result .= addslashes(JText::_('TAGS_INTRO')) . '<br>';
        if ($print_js_id)
            $result .= '<div id="TAGS">';
        foreach ($tags_array as $tag) {
            $tag_exploded = explode('_', $tag);
            if (count($tag_exploded) == 1 || in_array($tag_exploded[0], $include_prefix) ) {
                $tag_lang = 'TAGS_' . $tag;
                $result .= '<strong>[' . $tag . ']</strong>';
                $result .= ' - ' . addslashes(JText::_($tag_lang)) . '<br>';
            }
        }
        if ($print_js_id)
            $result .= '</div>';

        return $result;
    }

    function statChart() {
        jincimport('utility.parameterprovider');
        jincimport('graphics.chartrenderer');
        $chart_system = ParameterProvider::getChartSystem();
        if ($chart_system == STATSRENDERER_BUILTIN) {
            echo '<img align="center" src="index.php?option=com_jinc&task=newsletter.statsRender&format=json" alt="Chart">';
        } else {
            jincimport('graphics.openflashrenderer');
            $session = JFactory::getSession();
            $values = $session->get('stats.values');
            $legend = $session->get('stats.legend');

            $renderer = new OpenFlashRenderer($values, $legend);
            $chart = $renderer->render();
            ?>
<br>
<script type="text/javascript" src="components/com_jinc/assets/js/json2.js"></script>
<script type="text/javascript" src="components/com_jinc/assets/js/swfobject.js"></script>
<script type="text/javascript">
    swfobject.embedSWF("components/com_jinc/assets/flash/open-flash-chart.swf", "my_chart", "750", "250", "9.0.0");
</script>
<script type="text/javascript">

    function ofc_ready() {
    }

    function open_flash_chart_data() {
        return JSON.stringify(data);
    }

    function findSWF(movieName) {
        if (navigator.appName.indexOf("Microsoft")!= -1) {
            return window[movieName];
        } else {
            return document[movieName];
        }
    }

    var data = <?php echo $chart->toPrettyString(); ?>;

</script>
<div id="my_chart"></div>
        <?php
        }
    }
}
?>

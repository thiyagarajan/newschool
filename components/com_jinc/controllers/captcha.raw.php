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

class NewslettersControllerCaptcha extends NewslettersController {
    public function showCaptcha () {
        include JPATH_COMPONENT . DS . 'securimage' . DS . 'securimage.php';

        $img = new securimage();

        $mod_jinc = JRequest::getString('mod_jinc', 'false');
        $mod_jinc = trim($mod_jinc);
        
        if ($mod_jinc == 'true') {
            $img->image_width = 125;
            $img->image_height = 30;
            $img->code_length = rand(4,4);
            $img->setSessionPrefix('mod_jinc');
        } else {
            $img->image_width = 250;
            $img->image_height = 40;
            $img->code_length = rand(5,6);
        }
        
        $img->perturbation = 0.7;
        $img->image_bg_color = new Securimage_Color("#ffffff");
        $img->use_transparent_text = true;
        $img->text_transparency_percentage = 45; // 100 = completely transparent
        $img->num_lines = 2;
        $img->image_signature = '';
        $img->text_color = new Securimage_Color("#333366");
        $img->line_color = new Securimage_Color("#FFFFCC");

        $img->show(''); // alternate use:  $img->show('/path/to/background_image.jpg');
    }
}
?>
/*  
 * JCE Editor                 2.1.3
 * @package                 JCE
 * @url                     http://www.joomlacontenteditor.net
 * @copyright               Copyright (C) 2006 - 2012 Ryan Demmer. All rights reserved
 * @license                 GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * @date                    19 May 2012
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * NOTE : Javascript files have been compressed for speed and can be uncompressed using http://jsbeautifier.org/
 */
(function(){var each=tinymce.each,extend=tinymce.extend,JSON=tinymce.util.JSON;var Node=tinymce.html.Node;tinymce.create('tinymce.plugins.AnchorPlugin',{init:function(ed,url){this.editor=ed;this.url=url;var self=this;function isAnchor(n){return n&&((n.nodeName=='IMG'&&/mceItemAnchor/.test(n.className))||(n.nodeName=='A'&&!n.href&&(n.name||n.id)));}
ed.addCommand('mceInsertAnchor',function(){var se=ed.selection,n=se.getNode();ed.windowManager.open({url:ed.getParam('site_url')+'index.php?option=com_jce&view=editor&layout=plugin&plugin=anchor',width:320+parseInt(ed.getLang('advanced.anchor_delta_width',0)),height:100+parseInt(ed.getLang('advanced.anchor_delta_height',0)),inline:true,popup_css:false},{plugin_url:this.url});});ed.addButton('anchor',{title:'advanced.anchor_desc',cmd:'mceInsertAnchor'});ed.onNodeChange.add(function(ed,cm,n,co){cm.setActive('anchor',isAnchor(n));});ed.onInit.add(function(){if(ed.theme&&ed.theme.onResolveName){ed.theme.onResolveName.add(function(theme,o){var n=o.node,v;if(o.name==='img'&&/mceItemAnchor/.test(n.className)){var data=JSON.parse(ed.dom.getAttrib(n,'data-mce-json'));v=data.name||data.id;}
if(o.name==='a'&&!n.href&&(n.name||n.id)){v=n.name||n.id;}
if(v){o.name='a#'+v;}});}
if(!ed.settings.compress.css)
ed.dom.loadCSS(url+"/css/content.css");});ed.onPreInit.add(function(){if(tinymce.isWebKit){ed.parser.addNodeFilter('a',function(nodes){for(var i=0,len=nodes.length;i<len;i++){var node=nodes[i];if(!node.attr('href')&&(node.attr('name')||node.attr('id'))){self._createAnchorImage(node);}}});ed.serializer.addNodeFilter('img',function(nodes,name,args){for(var i=0,len=nodes.length;i<len;i++){var node=nodes[i];if(/mceItemAnchor/.test(node.attr('class')||'')){self._restoreAnchor(node,args);}}});}});},_restoreAnchor:function(n){var self=this,ed=this.editor,p,v,node,text;if(!n.parent)
return;p=JSON.parse(n.attr('data-mce-json'))||{};node=new Node('a',1);if(p.html){var value=new Node('#text',3);value.raw=true;value.value=p.html;node.append(value);delete p.html;}
each(p,function(v,k){node.attr(k,v);});n.replace(node);},_getInnerHTML:function(node){return new tinymce.html.Serializer({inner:true,validate:false}).serialize(node);},_createAnchorImage:function(n){var self=this,ed=this.editor,dom=ed.dom,v,k,p={};if(!n.parent)
return;each(n.attributes,function(at){if(at.name=='class'){return;}
p[at.name]=at.value;});if(n.firstChild){p.html=this._getInnerHTML(n);}
var classes=[];if(n.attr('class')){classes=n.attr('class').split(' ');}
if(classes.indexOf('mceItemAnchor')==-1){classes.push('mceItemAnchor');}
var img=new Node('img',1);img.attr({src:this.url+'/img/anchor.gif','class':classes.join(' '),'data-mce-json':JSON.serialize(p)});n.replace(img);},getInfo:function(){return{longname:'Anchor',author:'Ryan Demmer',authorurl:'http://www.joomlacontenteditor.net',infourl:'http://www.joomlacontenteditor.net',version:'2.1.3'};}});tinymce.PluginManager.add('anchor',tinymce.plugins.AnchorPlugin);})();
    /***************************/  
    //@Author: Adrian "yEnS" Mato Gondelle &amp;amp;amp; Ivan Guardado Castro  
    //@website: www.yensdesign.com  
    //@email: yensamg@gmail.com  
    //@license: Feel free to use it, but keep this credits please!  
    /***************************/  
      
    jQuery(document).ready(function(){  
        jQuery(".menutabs > li").click(function(e){  
            switch(e.target.id){  
                case "news":  
                    //change status &amp;amp;amp; style menu  
                    jQuery("#news").addClass("active");  
                    jQuery("#tutorials").removeClass("active");  
                    jQuery("#links").removeClass("active");  
                    //display selected division, hide others  
                    jQuery("div.news").fadeIn();  
                    jQuery("div.tutorials").css("display", "none");  
                    jQuery("div.links").css("display", "none");  
                break;  
                case "tutorials":  
                    //change status &amp;amp;amp; style menu  
                    jQuery("#news").removeClass("active");  
                    jQuery("#tutorials").addClass("active");  
                    jQuery("#links").removeClass("active");  
                    //display selected division, hide others  
                    jQuery("div.tutorials").fadeIn();  
                    jQuery("div.news").css("display", "none");  
                    jQuery("div.links").css("display", "none");  
                break;  
                case "links":  
                    //change status &amp;amp;amp; style menu  
                    jQuery("#news").removeClass("active");  
                    jQuery("#tutorials").removeClass("active");  
                    jQuery("#links").addClass("active");  
                    //display selected division, hide others  
                    jQuery("div.links").fadeIn();  
                    jQuery("div.news").css("display", "none");  
                    jQuery("div.tutorials").css("display", "none");  
                break;  
            }  
            //alert(e.target.id);  
            return false;  
        });  
    });  
function isEmpty(str) {
    if (str.replace(/\s/g,"") == ""){
        return true;
    }
    return false;
}

function isInteger(str) {
    if (isEmpty(str)) return false;
    n = parseInt(str);
    n += '';
    return (str == n);
}

function isMail(str) {
    if (isEmpty(str)) return false;
    var at = "@";
    var dot = ".";
    var lat = str.indexOf(at);
    var lstr = str.length;
    var ldot = str.indexOf(dot);
    if (str.indexOf(at)==-1) 
        return false;
    if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr)
        return false;
    if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr)
        return false;
    if (str.indexOf(at,(lat+1))!=-1)
        return false;
    if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot)
        return false;
    if (str.indexOf(dot,(lat+2))==-1)
        return false;
    if (str.indexOf(" ")!=-1)
        return false;
    return true;
}

function isDate(str) {
    // Up to now no check for date attribute type, because date format depends on site language
    return true;
}

function mod_validate_required(field, alerttxt) {
    if (isEmpty(field.value)) {
        alert( alerttxt );
        field.focus();
        return false;
    }
    return true;
}

function mod_validate_mail(field, alerttxt) {
    if (!isMail(field.value)) {
        alert( alerttxt );
        field.focus();
        return false;
    }
    return true;
}

function mod_validate_integer(field, alerttxt) {
    if (!isEmpty(field.value) && !isInteger(field.value)) {
        alert( alerttxt );
        field.focus();
        return false;
    }
    return true;
}

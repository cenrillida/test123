/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2014 Coppermine Dev Team
  v1.0 originally written by Gregory DEMAR

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 3
  as published by the Free Software Foundation.

  ********************************************
  Coppermine version: 1.5.28
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/js/db_ecard.js $
  $Revision: 8683 $
**********************************************/

function check(state){
    jQuery.each($("input[name='eid[]']"), function(){
        $(this).attr('checked', state);
    });
}

function agreesubmit(){
    $("input[type='submit'][name='delete']").attr('disabled', ($('#agreecheck').attr('checked')) ? false : true);
}

function defaultagree(){
    if ($('#agreecheck').attr('checked'))
        return true;
    else{
        alert(js_vars.ecards_delete_confirm);
        return false;
    }
}
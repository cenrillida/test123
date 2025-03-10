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
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/js/reviewcom.js $
  $Revision: 8683 $
**********************************************/

function textCounter(field, maxlimit) {
        if (field.value.length > maxlimit) // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
}

function approveCommentEnable(id) {
    if (document.getElementById('approved'+id+'yes').checked == true) {
        document.getElementById('status_approved_yes'+id).value = id;
        document.getElementById('status_approved_no'+id).value = '';
    }
    if (document.getElementById('approved'+id+'no').checked == true) {
        document.getElementById('status_approved_yes'+id).value = '';
        document.getElementById('status_approved_no'+id).value = id;
    }
}
/**
 * SocietoPluginBundle
 * Copyright (C) 2011 Kousuke Ebihara
 *
 * This program is under the EPL/GPL/LGPL triple license.
 * Please see the Resources/meta/LICENSE file that was distributed with this file.
 */

function buildsite_menu()
{
    $("#site_menu ul").addClass("toggle").hide();
    $("#site_menu").prepend('<ul><li class="togglebutton"><a href="#" onclick="togglesite_menu()">Click Here to Toggle Menu</a></li></ul>');

    $("#site_menu li").css("line-height", "36px");
}

function togglesite_menu()
{
    $("#site_menu ul.toggle").toggle();
}

$(document).ready(function() {
    buildsite_menu();
});

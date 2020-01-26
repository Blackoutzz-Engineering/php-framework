﻿$(function () {
    $.contextMenu({
        selector: '.file',
        callback: function (key, options) {
            var m = "clicked: " + key;
            window.console && console.log(m) || alert(m);
        },
        items: {
            "edit": { name: "Edit", icon: "edit" },
            "cut": { name: "Cut", icon: "cut" },
            "copy": { name: "Copy", icon: "copy" },
            "paste": { name: "Paste", icon: "paste" },
            "delete": { name: "Delete", icon: "delete" },
            "sep1": "---------",
            "quit": {
                name: "Quit", icon: function () {
                    return 'context-menu-icon context-menu-icon-quit';
                }
            }
        }
    });

    $('.context-menu-one').on('click', function (e) {
        console.log('clicked', this);
    })
});
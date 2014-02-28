'use strict';

var kbaseContextMenu;

kbaseContextMenu = Class.create(Zikula.UI.ContextMenu, {
    selectMenuItem: function ($super, event, item, item_container) {
        // open in new tab / window when right-clicked
        if (event.isRightClick()) {
            item.callback(this.clicked, true);
            event.stop(); // close the menu
            return;
        }
        // open in current window when left-clicked
        return $super(event, item, item_container);
    }
});

/**
 * Initialises the context menu for item actions.
 */
function kbaseInitItemActions(objectType, func, containerId)
{
    var triggerId, contextMenu, icon;

    triggerId = containerId + 'Trigger';

    // attach context menu
    contextMenu = new kbaseContextMenu(triggerId, { leftClick: true, animation: false });

    // process normal links
    $$('#' + containerId + ' a').each(function (elem) {
        // save css class before hiding (#428)
        var elemClass = elem.readAttribute('class');
        // hide it
        elem.addClassName('hide');
        // determine the link text
        var linkText = '';
        if (func === 'display') {
            linkText = elem.innerHTML;
        } else if (func === 'view') {
            linkText = elem.readAttribute('data-linktext');
        }

        // determine the icon
        icon = '';
        if (elem.hasClassName('fa')) {
            icon = '<span class="' + elemClass + '"></span>';
        }

        contextMenu.addItem({
            label: icon + linkText,
            callback: function (selectedMenuItem, isRightClick) {
                var url;

                url = elem.readAttribute('href');
                if (isRightClick) {
                    window.open(url);
                } else {
                    window.location = url;
                }
            }
        });
    });
    $(triggerId).removeClassName('hide');
}

function kbaseCapitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/**
 * Submits a quick navigation form.
 */
function kbaseSubmitQuickNavForm(objectType)
{
    $('guiteknowledgebasemodule' + kbaseCapitaliseFirstLetter(objectType) + 'QuickNavForm').submit();
}

/**
 * Initialise the quick navigation panel in list views.
 */
function kbaseInitQuickNavigation(objectType, controller)
{
    if ($('guiteknowledgebasemodule' + kbaseCapitaliseFirstLetter(objectType) + 'QuickNavForm') == undefined) {
        return;
    }

    if ($('catid') != undefined) {
        $('catid').observe('change', function () { kbaseSubmitQuickNavForm(objectType); });
    }
    if ($('sortby') != undefined) {
        $('sortby').observe('change', function () { kbaseSubmitQuickNavForm(objectType); });
    }
    if ($('sortdir') != undefined) {
        $('sortdir').observe('change', function () { kbaseSubmitQuickNavForm(objectType); });
    }
    if ($('num') != undefined) {
        $('num').observe('change', function () { kbaseSubmitQuickNavForm(objectType); });
    }

    switch (objectType) {
    case 'ticket':
        if ($('workflowState') != undefined) {
            $('workflowState').observe('change', function () { kbaseSubmitQuickNavForm(objectType); });
        }
        break;
    default:
        break;
    }
}

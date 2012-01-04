
function onKbTicketDisplay()
{
    $('kbhotornot').show();
    reqRunning = false;
    $('linklikeit').observe('click', function(event) {
        Event.stop(event);
        if (reqRunning === false) {
            reqRunning = true;
            var myAjax = new Ajax.Request(Zikula.Config.baseURL + 'ajax.php', {
                method: 'post',
                parameters: 'module=KnowledgeBase&func=like' + '&id=' + kbTid,
                onComplete: function(req) {
                    if (req.status != 200) {
                        alert(req.responseText);
                        reqRunning = false;
                        return;
                    }

                    var numLikes = parseInt($('amountlikes').innerHTML);
                    $('amountlikes').innerHTML = ++numLikes;
                    reqRunning = false;
                }
            });
        }
    });
    $('linkdislikeit').observe('click', function(event) {
        Event.stop(event);
        if (reqRunning === false) {
            reqRunning = true;
            var myAjax = new Ajax.Request(Zikula.Config.baseURL + 'ajax.php', {
                method: 'post',
                parameters: 'module=KnowledgeBase&func=dislike' + '&id=' + kbTid,
                onComplete: function(req) {
                    if (req.status != 200) {
                        alert(req.responseText);
                        reqRunning = false;
                        return;
                    }

                    var numDislikes = parseInt($('amountdislikes').innerHTML);
                    $('amountdislikes').innerHTML = ++numDislikes;
                    reqRunning = false;
                }
            });
        }
    });
}


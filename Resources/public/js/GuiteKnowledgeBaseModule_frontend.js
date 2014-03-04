
function onKbTicketDisplay()
{
    var reqRunning;

    $('kbhotornot').show();
    reqRunning = false;

    $('linklikeit').observe('click', function(event) {
        event.preventDefault();
        if (reqRunning === false) {
            reqRunning = true;
            var myAjax = new Ajax.Request(Zikula.Config.baseURL + 'index.php', {
                method: 'post',
                parameters: 'module=KnowledgeBase&type=ajax&func=like' + '&id=' + kbTid,
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
        event.preventDefault();
        if (reqRunning === false) {
            reqRunning = true;
            var myAjax = new Ajax.Request(Zikula.Config.baseURL + 'index.php', {
                method: 'post',
                parameters: 'module=KnowledgeBase&type=ajax&func=dislike' + '&id=' + kbTid,
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


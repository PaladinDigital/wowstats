/* Character Claiming */
function lockFight(id)
{
    var url = window.Laravel.base_url + '/fight/' + id + '/lock';
    var data = {
        "_token": window.Laravel.csrfToken
    }
    $.post(url, data)
        .done(function() {
            window.location.reload();
        })
}

function unlockFight(id) {
    var url = window.Laravel.base_url + '/fight/' + id + '/unlock';
    var data = {
        "_token": window.Laravel.csrfToken
    }
    $.post(url, data)
        .done(function() {
            window.location.reload();
        })
}
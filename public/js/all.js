/* Character Claiming */
function claimCharacter(id)
{
    var url = window.Laravel.base_url + '/character/claim';
    var data = {
        character_id: id,
        "_token": window.Laravel.csrfToken
    }
    $.post(url, data)
        .done(function() {
            window.location.reload();
        })
}

function unclaimCharacter(id) {
    var url = window.Laravel.base_url + '/character/unclaim';
    var data = {
        character_id: id,
        "_token": window.Laravel.csrfToken
    }
    $.post(url, data)
        .done(function() {
            window.location.reload();
        })
}
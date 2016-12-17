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

/* Character Deletion (Admin) */
function deleteCharacter(id) {
    var confirmDelete = confirm('Are you sure you wish to delete this character?');

    var url = window.Laravel.base_url + '/character/' + id;
    var data = {
        character_id: id,
        "_token": window.Laravel.csrfToken,
        "_method": "delete"
    }

    if (confirmDelete) {
        $.post(url, data)
            .done(function() {
                window.location.reload();
            })
    }
}
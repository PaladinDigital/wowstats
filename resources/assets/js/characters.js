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
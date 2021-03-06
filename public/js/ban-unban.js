function ban(user_id) {
    let button = document.getElementById("ban-button");

    if (button != null)
        sendAjaxRequest("PATCH", "/api/admin/user/" + user_id + "/" + encodeURI(button.innerHTML.trim().toLowerCase()), "",
            (request) => {
                if (request.status == 200) {
                    toast("Successfully " + encodeURI(button.innerHTML.trim()) + "ed user", "s");
                    if (button.innerHTML.trim() === "Ban") {
                        button.innerHTML = "Unban";
                    } else {
                        button.innerHTML = "Ban";
                    }
                } else {
                    toast("Error " + encodeURI(button.innerHTML.trim()) + "ing user", "s");
                }
            }
        )
}

function unban(id) {
    sendAjaxRequest("PATCH", "/api/admin/user/" + id + "/unban", "",
        (request) => {
            if (request.status == 200) {
                toast("Successfully re-integrated user", "s");
                document.getElementById("banned_" + id).remove()
                if (typeof inDashboard !== 'undefined') {
                    decrementCount();
                }
            } else {
                toast("Error re-integrating user", "d");
            }
        })
}
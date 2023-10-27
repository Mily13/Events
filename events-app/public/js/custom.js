$(document).ready(function() {
    $('.join-button').click(function() {
        let event = $(this).data('event');
        let user = $(this).data('user');
        let joinRoute = $(this).data('join-route');
        $.ajax({
            type: 'POST',
            url: joinRoute,
            data: { event: event, user: user },
            success: function(result) {
                if (result.redirect) {
                    window.location.href = result.redirect;
                } else if (result.joined) {
                    alert('You are already joined!');
                } else {
                    alert('You joined successfully!');
                }
            },
        });
    });
});


window.addEventListener("DOMContentLoaded", function() {
    const checkbox = document.getElementById("flexCheckDefault");
    const select = document.getElementById("select2");
    checkbox.addEventListener("change", function() {
        if (this.checked) {
            select.removeAttribute("disabled");
        } else {
            select.setAttribute("disabled", "disabled");
        }
    });
});


$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});



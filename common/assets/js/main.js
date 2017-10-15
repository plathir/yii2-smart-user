$(function () {
    if ($('#user_tabs').length) {
        // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // save the latest tab; use cookies if you like 'em better:
            localStorage.setItem('lastTab', $(this).attr('href'));
        });

        // go to the latest tab, if it exists:
        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');
        }
    }
});
//
//
//$(function () {
//    $('#modalButtonAccount').click(function () {
//        $('#modalAccount').modal('show')
//                .find('#modalContentAccount')
//                .load($(this).attr('value'));
//
//    });
//});
//
//
//$(function () {
//    $('#modalButtonChangePass').click(function () {
//        $('#modalChangePass').modal('show')
//                .find('#modalContentChangePass')
//                .load($(this).attr('value'));
//
//    });
//});
//
//$(function () {
//    $('#modalButtonProfile').click(function () {
//        $('#modalProfile').modal('show')
//                .find('#modalContentProfile')
//                .load($(this).attr('value'));
//
//    });
//});


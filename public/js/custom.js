$(document).ready(function () {

    /************** spiner code ****************************/
    var stopSpiner = "{{ $spiner}}";
    var spinner = $('#loader');

    $('#next').click(function (event) {
        spinner.show();
    });

    /**
    hide spiner
    */
    if (stopSpiner) {
    spinner.hide();
    }
    /************** end spiner code ****************************/

});
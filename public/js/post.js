$(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    
    $("#postForm").submit(function(event){
        event.preventDefault();
        
        // manage optional info check box array
        var myCheckboxes = $('input[name="optional_info[]"]:checked').map(function(){
            return $(this).val();
          }).get();
        
        // Manage Form Data
        var result = [];
        $.each($('form').serializeArray(), function() {
            result[this.name] = this.value;
        });
        result['optional_info'] = myCheckboxes;

        console.log( result);
        
    });

    /**
     * Manage radio button
     */
     $('input[type=radio]').on('change', function() {
        switch ($(this).val()) {
          case 'me':
            $("#otherSsurfer").hide();
            $("#other_surfer").val("");
            break;
          case 'other':
            $("#otherSsurfer").show();
            $("#other_surfer").val("");
            break;
        case 'unknown':
            $("#otherSsurfer").hide();
            $("#other_surfer").val("");
            break;
        default:
            $("#otherSsurfer").hide();
            $("#other_surfer").val("");
        }
      });

       
});
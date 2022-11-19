$(window).load(function() {
    $(".se-pre-con").fadeOut("slow");;
});

function showPassword() {
    var x1 = document.getElementById("passInputOld");
    var x2 = document.getElementById("passInputNew");
    var x3 = document.getElementById("passInputNew2");
    if (x1.type === "password" || x2.type === "password" || x3.type === "password") {
        x1.type = "text";
        x2.type = "text";
        x3.type = "text";
    } else {
        x1.type = "password";
        x2.type = "password";
        x3.type = "password";
    }

}

function showPasswordAdmin() {
    var x = document.getElementById("passAdminOne");
    var y = document.getElementById("passAdminTwo");
    if (x.type === "password" || y.type === "password") {
        x.type = "text";
        y.type = "text";

    } else {
        x.type = "password";
        y.type = "password";
    }





}

$(document).ready(function() {
    $('#search').keyup(function() {
        search_table($(this).val());
    });

    function search_table(value) {
        $('#record_table tr').each(function() {
            var found = 'false';
            $(this).each(function() {
                if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                    found = 'true';
                }
            });
            if (found == 'true') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
});



$("#seeGenderOptions").change(function() {
    if ($(this).val() == "Kobieta") {
        $('#famaleOptions').show();
        $('#recordBreast').attr('required', '');
        $('#recordBreast').attr('data-error', 'This field is required.');
        $('#recordFamaleWaist').attr('required', '');
        $('#recordFamaleWaist').attr('data-error', 'This field is required.');
        $('#recordHips').attr('required', '');
        $('#recordHips').attr('data-error', 'This field is required.');
    } else {
        $('#famaleOptions').hide();
        $('#recordBreast').removeAttr('required');
        $('#recordBreast').removeAttr('data-error');
        $('#otherFirecordFamaleWaisteld2').removeAttr('required');
        $('#otherFirecordFamaleWaisteld2').removeAttr('data-error');
        $('#recordHips').removeAttr('required');
        $('#recordHips').removeAttr('data-error');
    }
});
$("#seeGenderOptions").trigger("change");

$("#seeGenderOptions").change(function() {
    if ($(this).val() == "Mężczyzna") {
        $('#maleOptions').show();
        $('#recordChest').attr('required', '');
        $('#recordChest').attr('data-error', 'This field is required.');
        $('#recordMaleWaist').attr('required', '');
        $('#recordMaleWaist').attr('data-error', 'This field is required.');
    } else {
        $('#maleOptions').hide();
        $('#recordChest').removeAttr('required');
        $('#recordChest').removeAttr('data-error');
        $('#recordMaleWaist').removeAttr('required');
        $('#recordMaleWaist').removeAttr('data-error');
    }
});
$("#seeGenderOptions").trigger("change");
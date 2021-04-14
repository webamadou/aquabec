//Building functions to format the phone number fields
const isNumericInput = (event) => {
    const key = event.keyCode;
    return ((key >= 48 && key <= 57) || // Allow number line
        (key >= 96 && key <= 105) // Allow number pad
    );
};

const isModifierKey = (event) => {
    const key = event.keyCode;
    return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
        (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
        (key > 36 && key < 41) || // Allow left, up, right, down
        (
            // Allow Ctrl/Command + A,C,V,X,Z
            (event.ctrlKey === true || event.metaKey === true) &&
            (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
        )
};

const enforceFormat = (event) => {
    // Input must be of a valid number format or a modifier key, and not longer than ten digits
    if (!isNumericInput(event) && !isModifierKey(event)) {
        event.preventDefault();
    }
};

const formatToPhone = (event) => {
    if (isModifierKey(event)) { return; }

    // I am lazy and don't like to type things more than once
    const target = event.target;
    const input = target.value.replace(/\D/g, '').substring(0, 20); // First ten digits of input only
    const areaCode = input.substring(0, 3);
    const middle = input.substring(3, 6);
    const last = input.substring(6, 10);

    if (input.length > 6) { target.value = `(${areaCode}) ${middle} - ${last}`; }
    else if (input.length > 3) { target.value = `(${areaCode}) ${middle}`; }
    else if (input.length > 0) { target.value = `(${areaCode}`; }
};

const phone_numbers = document.querySelectorAll(".phone_number").forEach(function (item) {
    item.addEventListener('focus', formatToPhone);
    item.addEventListener('keydown', enforceFormat);
    item.addEventListener('keyup', formatToPhone);
});
//End building function to format the phone number fields
// Select the city list based on user's region selection


//I get this code from the layou.back.user file but I barely understand what it is for
/* $(function () {
    $('.textarea').summernote({
        height: 250,
        lang: 'fr',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'style']],
            ['table', ['table']],
            ['insert', ['link', 'hr']],
            ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
        ]
    });

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'DD/MM/YYYY hh:mm A'
        }
    });
}); */

$(document).ready(function () {
    //bsCustomFileInput.init();

    //processing upload of image
    $(document).on("click", ".browse", function() {
     let file = $(this)
        .parent()
        .parent()
        .parent()
        .find("#images");
      file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
        let fileName = e.target.files[0].name;
        $("#file").val(fileName);

        let reader = new FileReader();
        reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });
});
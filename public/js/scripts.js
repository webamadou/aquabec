const SITE_URL = document.querySelector("body").getAttribute("siteurl");
moment.locale('fr');

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

//Filter announcements based on different criteria
const filter_elements = () => {
    //Get form fields values
    const region_filter = document.getElementById("region_id").value;
    const city_filter = document.getElementById("city_id").value;
    const categ_filter = document.getElementById("categ_id").value;
    const postalcode_filter = document.getElementById("postal_code_id").value;
    const price_filter = document.getElementById("price_id").value;
    //const dates_filter  = document.getElementById("dates_id").value;
    const user_filter = document.getElementById("user_id").value;
    $.ajax({
        url: `${SITE_URL}/filter/announcements`,
        type: "get",
        data: {
            "type": "announcements",
            "region_id": region_filter,
            "city_id": city_filter,
            "category_id": categ_filter,
            "postal_code": postalcode_filter,
            "price": price_filter,
            "user": user_filter,
        },
        beforeSend: function () {
            $("#filter-loading").show()
        }
    }).done(function (data) {
        //first we get the template and the wrapper where to append the elements
        const component_wrapper = document.getElementById('list-component-wrapper');

        component_wrapper.innerHTML = '';
        console.log(data.length);
        if (data.length > 0) {
            for (let item = 0; item < data.length; item++) {
                //*first we create a mozaique element
                const mozaique_element = document.createElement('div');
                mozaique_element.className = "mozaique-item visible col-sm-6 col-md-4";
                mozaique_element.innerHTML = `<div class="card shadow-sm p-0">
                                                <a id="item_img" href="${SITE_URL}/annonce/${data[item].slug}"><img class="img-fluid" src="/voir/images/${data[item].images}" alt="${data[item].title}"></a>
                                                <div class="card-body p-0">
                                                    <p class="card-text" id="item_title">
                                                        <a href="${SITE_URL}/annonce/${data[item].slug}">${data[item].title}</a>
                                                    </p>
                                                    <div class="d-block" style="background: #dcdcdc; padding: 0;">
                                                        <div type="button" class="px-1" id="item_price">${data[item].price}</div>
                                                        <div type="button" class="px-1" id="item_category">Catégorie : ${data[item].categ_name}</div>
                                                        <div type="button" class="px-1" id="item_author">Par : ${data[item].owner}</div>
                                                    </div>
                                                </div>
                                            </div>`;

                component_wrapper.appendChild(mozaique_element);
            }//End for loop
        } else {
            component_wrapper.innerHTML = `<h2 class="water-mark text-center"><i class="fa fa-alert"></i> Aucune correspondance!</h2>`
        }
        $('#filter-loading').hide(); //hide loading animation once data is received
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        console.log('No response from server');
    })
}

const maximum_in_array = (value) => {
    if (toString.call(value) !== "[object Array]")
        return false;
    return Math.max.apply(null, value);
}

//Filter events based on different criteria
const filter_events = () => {
    //Get form fields values
    const region_filter = document.getElementById("region_id").value;
    const city_filter = document.getElementById("city_id").value;
    const categ_filter = document.getElementById("categ_id").value;
    const postalcode_filter = document.getElementById("postal_code_id").value;
    const dates_filter = document.getElementById("dates_id").value;
    const user_filter = document.getElementById("user_id").value;

    $.ajax({
        url: `${SITE_URL}/filter/events`,
        type: "get",
        data: {
            "type": "events",
            "region_id": region_filter,
            "city_id": city_filter,
            "category_id": categ_filter,
            "postal_code": postalcode_filter,
            "dates": dates_filter,
            "user": user_filter,
        },
        beforeSend: function () {
            $("#filter-loading").show()
        }
    }).done(function (data) {
        //first we get the template and the wrapper where to append the elements
        const component_wrapper = document.getElementById('list-component-wrapper');

        component_wrapper.innerHTML = '';
        console.log(data.length);
        if (data.length > 0) {
            for (let item = 0; item < data.length; item++) {
                //*first we create a mozaique element
                const mozaique_element = document.createElement('div');
                mozaique_element.className = "mozaique-item visible col-sm-6 col-md-4";
                //const dates = data[item].dates != null ? maximum_in_array(data[item].dates.split(";")) : '';

                const dates_array = data[item].dates != null ? data[item].dates.split(";") : '';
                const date = moment(dates_array[0]).format("DD/MM/YYYY");
                mozaique_element.innerHTML = `<div class="card shadow-sm p-0">
                                                <a id="item_img" href="${SITE_URL}/evenement/${data[item].slug}"><img class="img-fluid" src="/voir/images/${data[item].images}" alt="${data[item].title}"></a>
                                                <div class="card-body p-0">
                                                    <p class="card-text" id="item_title">
                                                        <a href="${SITE_URL}/evenement/${data[item].slug}">${data[item].title}</a>
                                                    </p>
                                                    <div class="d-block" style="background: #dcdcdc; padding: 0;">
                                                        <div type="button" class="px-1" id="item_price">${date}</div>
                                                        <div type="button" class="px-1" id="item_category">Catégorie : ${data[item].categ_name}</div>
                                                        <div type="button" class="px-1" id="item_author">Par : ${data[item].owner}</div>
                                                    </div>
                                                </div>
                                            </div>`;

                component_wrapper.appendChild(mozaique_element);
            }//End for loop
        } else {
            component_wrapper.innerHTML = `<h2 class="water-mark text-center"><i class="fa fa-alert"></i> Aucune correspondance!</h2>`
        }
        $('#filter-loading').hide(); //hide loading animation once data is received
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        console.log('No response from server');
    })
}

$(document).on('ready', function () {
    /** trigger filters on public pages */
    const mozaique_item = document.querySelectorAll('.mozaique-item');
    //Autocomplete user in front
    const autocomplete_field = document.querySelector('input[name="autocomplete_user"]');
    const autocompletes = document.getElementById("autocompletes");
    const user_id_field = document.getElementById("user_id");
    //Trigger the announcements filter method when one of this element is updated 
    $('body').on('change', '#filter_form_announcement #region_id,#filter_form_announcement #city_id,#filter_form_announcement #user_id', filter_elements);
    $('#filter_form_announcement #postal_code_id,#filter_form_announcement #price_id').on('keyup', filter_elements);
    //When the button to erase filters is clicked
    $('#delete-filters').on('click', function (e) {
        e.preventDefault();
        $('#filter_form_announcement')[0].reset();
        $("filter_form_announcement #user_id").val("");
        filter_elements();
    });
    //Trigger the events filter method when one of this element is updated 
    $('body').on('change', '#filter_form_events #region_id,#filter_form_events #city_id,#filter_form_events #user_id,#filter_form_events #categ_id,#filter_form_events #dates_id', filter_events);
    $('#filter_form_events #postal_code_id,#filter_form_events #dates').on('keyup', filter_events);
    //When the button to erase filters is clicked
    $('#delete-events-filters').on('click', function (e) {
        e.preventDefault();
        $('#filter_form_events')[0].reset();
        $("#filter_form_events #user_id").val("");
        filter_events();
    });

    if (autocomplete_field !== null) {
        autocomplete_field.addEventListener('keyup', function (e) {
            $.ajax({
                url: `${SITE_URL}/autocomplete-user`,
                type: "get",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "autocomplete_user": autocomplete_field.value,
                },
                beforeSend: function () {
                    console.log('loading users');
                }
            }).done(function (data) {
                console.log(data);
                let list = '';
                for (let item in data) {
                    const user = data[item];
                    list += `<li data-user="${user.username}" class="select-user">${user.username}</li>`;
                }
                autocompletes.innerHTML = `<div class="close-autocomplete">x</div> ${list}`;
                autocompletes.style.display = "block";

            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('No response from server');
            });
        });
        //When click to close the autocomplete
        /* document.querySelector(".close-autocomplete")[0] */
        /* autocomplete_field.addEventListener('focusout', function(e){
            autocompletes.style.display = "none";
        }); */
        const close_autocomplete = document.querySelector(".close-autocomplete");
        $('body').on('click', '.close-autocomplete', function (e) {
            autocompletes.style.display = "none";
        });

        //when clicking on one of the result on the autocompletion
        $('body').on('click', '.select-user', function (e) {
            const username = $(this).data("user");
            autocomplete_field.value = username;

            if (user_id_field != null) {
                user_id_field.value = username;
                if (document.getElementById('filter_form_announcement') != null)
                    filter_elements();//we execute filter announcements function in case we need to filter
                if (document.getElementById('filter_form_events') != null)
                    filter_events();//we execute filter events function in case we need to filter
            }
            autocompletes.style.display = "none";
        });
    }

    //processing upload of image
    $(document).on("click", ".browse", function () {
        let file = $(this)
            .parent()
            .parent()
            .parent()
            .find("#images");
        file.trigger("click");
    });
    $('input[type="file"]').on('change', function (e) {
        let fileName = e.target.files[0].name;
        $("#file").val(fileName);

        let reader = new FileReader();
        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });


    //*** Select the cities of the selected region *** 
    const regions = document.getElementById("region_id");
    if (regions != null) {
    }//End if region !null
});
<!-- BEGIN: Dark Mode Switcher-->
<!-- <div data-url="#" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
    <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
    <div class="dark-mode-switcher__toggle border"></div>
</div> -->
<!-- END: Dark Mode Switcher-->
<!-- BEGIN: JS Assets-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=[" your-google-map-api "]&libraries=places"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="dist/js/app.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons/2.2.2/js/buttons.html5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons/2.2.2/js/buttons.print.js"></script>
<!-- Dropdwn Dynamic -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="dist/js/toast/toastr.js"></script>
<script type="text/javascript" src="dist/js/summernote-bs4.js"></script>

<script>
    // custom toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "2000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $(document).on('focus', '.select2.select2-container', function(e) {
        if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
            $(this).siblings('select').select2('open');
        }
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    const addNewData = (data) => {
        if (data == 'add-country') {
            window.location.href = 'add-country';
        } else if (data == 'add-level') {
            window.location.href = 'add-level';
        } else if (data == 'add-document') {
            window.location.href = 'add-document';
        } else if(data == 'add-country-document'){
            window.location.href = 'add-country-document';
        } else  if(data == 'add-gea-currency'){
            window.location.href = 'add-gea-currency';
        } else  if(data == 'add-gea-product'){
            window.location.href = 'add-gea-product';
        } else  if(data == 'add-new-page'){
            window.location.href = 'add-new-page';
        }
    }
    // Regex validations
    let nameRegx = /^[a-zA-Z0-9 ]*$/,
        mobileRegx = /^\d+$/,
        usernameRegx = /^[A-Za-z0-9-_\.]+$/,
        docRegx = /^[A-Za-z0-9-]+$/,
        emailRegx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/,
        country_name_regx = /^[A-Za-z0-9-_\.()', ]+$/,
        country_code_regx = /^[a-zA-Z]{2}$/,
        country_currency_regx = /^[a-zA-Z]{1,3}$/;
    $(function(){
        $("#load_container").addClass("hidden");
        $("#main_container").removeClass("hidden");
    });
</script>
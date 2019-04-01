
var DatatableAdvanced = function () {
    var TableDatatablesAjax = function () {
        var handleRecords = function () {
            if (!$().DataTable) {
                console.warn('Warning - datatables.min.js is not loaded.');
                return;
            }

            dataTable = $('.datatable-highlight').DataTable({
                "processing": true,
                "serverSide": true,
                autoWidth: false,
                searching: false,
                "order": [],
                columnDefs: [{
                    orderable: false,
                    width: 100,
                    targets: [0, 5]
                }],
                dom: '<"datatable-header"><"datatable-scroll"t><"datatable-footer"ip fl>',
                "pageLength": 10,
                language: {
                    lengthMenu: '<span>Show: </span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'}
                },
                "ajax": {
                    "url": "/speakers/get-list",
                    "type":"POST",
                    "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    "data": function (data) {
                        $(".form-filter").each(function (e) {
                            data[$(this).attr('name')] = this.value;
                        });
                        $(".form-filter-dropdown").each(function (e) {
                            data[$(this).attr('id')] = this.value;
                        });
                        return data;
                    },
                    beforeSend: function (jqXHR, settings) {
                        $('.custom-loader').css('display', 'block');
                    }
                },
                "drawCallback": function (settings) {
                    $('.custom-loader').css('display', 'none');
                },
            });
            dataTable.on('keyup', '.form-filter', function (e) {
                e.preventDefault();
                if (e.keyCode === 13) {
                    dataTable.draw()
                }
            });
            dataTable.on('change', '.select-search', function (e) {
                e.preventDefault();
                dataTable.draw()
            });
            $('.filter-cancel').on('click', function (e) {
                e.preventDefault();
                $(".form-filter").each(function (e) {
                    this.value = "";
                });
                $(".select-search").each(function (e) {
                    this.value = "";
                });
                $('.select2').select2();
                dataTable.draw();
            });
            $('.filter-submit').on('click', function (e) {
                e.preventDefault();
                dataTable.draw();
            });
        };
        return {
            //main function to initiate the module
            init: function () {
                //initPickers();
                handleRecords();

            }
        };
    }();

    return {
        //main function to initiate the module
        init: function () {
            TableDatatablesAjax.init();
        },

    };

}();

// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function () {
    DatatableAdvanced.init();
    $('.select2').select2();
});

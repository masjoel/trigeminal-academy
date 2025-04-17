<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-template="vertical-menu-template-no-customizer-starter" data-style="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <link rel="shortcut icon"
        href="{{ preg_match('/desa/i', klien('image_icon')) ? Storage::url(klien('image_icon')) : asset(klien('image_icon')) }}"
        type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('v3/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('v3/fonts/fontawesome.css') }}" />

    @stack('style')
    <script src="{{ asset('v3/js/helpers.js') }}"></script>
    <script src="{{ asset('v3/assets/js/config.js') }}"></script>
    <style>
        .table th {
            text-transform: none !important;
        }
        input[readonly] {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ccc;
        }
        .note-editor.note-frame.fullscreen,
        .note-editor.note-airframe.fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100vh !important;
            z-index: 9990 !important;
        }

        .note-editor.note-frame.fullscreen .note-editable,
        .note-editor.note-airframe.fullscreen .note-editable {
            height: calc(100vh - 50px) !important;
            background-color: #f5f5f5 !important; /* Ganti dengan warna yang diinginkan */
            color: #161414 !important; /* Warna teks agar kontras */
        }
        .note-modal.open {
            top: 60px !important;
            z-index: 9991 !important;
        }
        .note-modal-footer {
            height: 60px !important;
        }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('layouts.components.sidebar')

            <div class="layout-page">

                @include('layouts.components.menu')

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('main')
                    </div>

                    @include('layouts.components.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    <script src="{{ asset('v3/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('v3/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('v3/js/bootstrap.js') }}"></script>
    <script src="{{ asset('v3/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('v3/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('v3/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('v3/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('v3/js/menu.js') }}"></script>
    <script src="{{ asset('library/sweetalert2/sweetalert2.min.js') }}"></script>


    <script type="text/javascript">
        // let BASE_URL = "{{ url('/') }}";
        let BASE_URL = "https://{{ $_SERVER['HTTP_HOST'] }}";

        function resetAllInputOnForm(formId) {
            $(formId).find('input, textarea').val('');
            $(formId).find('x').each(function() {});
        }

        function showAlertOnSubmit(params, modal, table, reload, reloadBlank) {
            if (params.status == 'success') {
                setTimeout(function() {
                    Swal.fire({
                        title: "Sukses",
                        text: params.message,
                        icon: "success"
                    }).then((result) => {
                        if (modal) {
                            $(modal).modal('hide');
                        }
                        if (table) {
                            $(table).DataTable().ajax.reload(null, false);
                        }
                        if (reload) {
                            window.location.replace(reload);
                        }
                        if (reloadBlank) {
                            window.open(reloadBlank, '_blank');
                        }
                    });
                }, 200);
            } else {
                showFailedAlert(params.message);
            }
            setTimeout(function() {
                Swal.close()
            }, 1000);
        }

        function showFailedAlert(msg) {
            Swal.fire({
                title: "Failed",
                text: msg,
                showConfirmButton: true,
                confirmButtonColor: '#0760ef',
                icon: "error"
            });
        }

        function showWarningAlert(msg) {
            Swal.fire({
                title: "Perhatian",
                html: msg,
                showConfirmButton: true,
                confirmButtonColor: '#ff9909',
                icon: "warning"
            });
        }

        function showDeletePopup(url, token, modal, table, reload) {
            Swal.fire({
                title: 'Are You Sure?',
                text: "Are You Sure Delete This Data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: url,
                            "headers": {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE"
                        })
                        .done(function(data) {
                            if (data.status == 'success') {
                                Swal.fire("Deleted!", "Data has succesfully deleted!", "success");
                                setTimeout(function() {
                                    Swal.close()
                                }, 1000);
                                if (modal) {
                                    $(modal).modal('hide');
                                }
                                if (table) {
                                    $(table).DataTable().ajax.reload(null, false);
                                }
                                if (reload) {
                                    window.location.replace(reload);
                                }
                            } else {
                                Swal.fire("Error!", data.message, "error");
                            }
                        })
                        .fail(function(data) {
                            Swal.fire("Oops", "We couldn't connect to the server!", "error");
                        });
                }
            })
        }

        function showDeleteModal(url, token, modal, table, reload) {
            Swal.fire({
                title: 'Are You Sure?',
                text: "Are You Sure Delete This Data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: url,
                            "headers": {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE"
                        })
                        .done(function(data) {
                            if (data.status == 'success') {
                                Swal.fire("Deleted!", "Data has succesfully deleted!", "success");
                                setTimeout(function() {
                                    Swal.close()
                                }, 1000);
                                if (modal) {
                                    $(modal).modal('hide');
                                    $(table).DataTable().ajax.reload(null, false);
                                }
                                if (table) {
                                    $(table).DataTable().ajax.reload(null, false);
                                }
                                if (reload) {
                                    window.location.replace(reload);
                                }
                            } else {
                                Swal.fire("Error!", data, "error");
                            }
                        })
                        .fail(function(data) {
                            Swal.fire("Oops", "We couldn't connect to the server!", "error");
                        });
                }
            })
        }

        function showLoading(title, message) {
            Swal.fire({
                title: title,
                html: message,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function alertSuccess(title, message) {
            Swal.fire({
                title: title,
                html: message,
                didOpen: () => {
                    Swal.alertSuccess();
                }
            });
            setTimeout(function() {
                Swal.close()
            }, 1000);
        }
    </script>

    <script src="{{ asset('v3/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>

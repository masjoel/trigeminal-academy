<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <!-- General CSS Files -->
    <link rel="shortcut icon"
        href="{{ preg_match('/profile/i', klien('image_icon')) ? Storage::url(klien('image_icon')) : asset(klien('image_icon')) }}"
        type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/webdesa/css/fontawesome-all.min.css') }}">

    @stack('style')

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <style>
        .main-sidebar .sidebar-menu li a i {
            margin-right: 5px !important;
        }

        .main-sidebar .sidebar-menu li ul.dropdown-menu li a {
            height: 30px !important;
            padding-left: 35px !important;
        }

        .main-sidebar .sidebar-menu li ul.dropdown-menu li.active>a {
            font-weight: 400 !important;
        }

        .long-t-menu {
            line-height: 18px !important;
        }

        .long-t-margin {
            padding-bottom: 16px !important;
        }
        .btn-primary.disabled,
        .btn-primary:disabled {
            background-color: #474a49 !important;
            border-color: #474a49 !important;
        }
    </style>
    <script>
        window.dataLayer = window.dataLayer || [];
    </script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.header')

            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Content -->
            @yield('main')

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('library/sweetalert2/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        let BASE_URL = "{{ url('/') }}";
        // let BASE_URL = "https://{{ $_SERVER['HTTP_HOST'] }}";

        function resetAllInputOnForm(formId) {
            $(formId).find('input, textarea').val('');
            $(formId).find('select').each(function() {
                // $(this).select2('destroy').val("").select2({
                //     width: '100%'
                // });
            });
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

    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>

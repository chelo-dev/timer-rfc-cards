<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="..." name="description" />
    <meta content="Angel Paredes Torres" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app-modern.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-modern-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />

</head>

<body class="authentication-bg">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            @yield('container')
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2024 © KHS - kharma-s.com
    </footer>

    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script type="text/javascript">
        'use strict'

        function removeSpaces(input) {
            input.value = input.value.replace(/\s/g, '');
        }

        function checkSubmit() {
            document.getElementById("btn-free").innerHTML = '<i class="mdi mdi-spin mdi-loading mr-1"></i> Loading...';
            document.getElementById("btn-free").disabled = true;

            return true;
        }

        document.addEventListener('DOMContentLoaded', function () {
            var revealPasswordButton = document.querySelector('.reveal-password');
            var passwordInput = document.querySelector('#password');
            var eyeOffIcon = 'mdi mdi-eye-off-outline';
            var eyeIcon = 'mdi mdi-eye-outline';

            revealPasswordButton.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    revealPasswordButton.innerHTML = '<i class="' + eyeOffIcon + '" aria-hidden="true"></i>';
                } else {
                    passwordInput.type = 'password';
                    revealPasswordButton.innerHTML = '<i class="' + eyeIcon + '" aria-hidden="true"></i>';
                }
            });
        });
    </script>
</body>

</html>
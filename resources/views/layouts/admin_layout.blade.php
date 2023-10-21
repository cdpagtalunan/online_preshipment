@php
session_start();
$isLogin = false;
if (isset($_SESSION['rapidx_user_id'])) {
    $isLogin = true;
}

$isAuthorized = false;
$user_level = 0;
@endphp

@if ($isLogin)
    @if ($_SESSION['rapidx_user_level_id'] == 5)
        @if (count($_SESSION['rapidx_user_accesses']) > 0)
            @for ($index = 0; $index < count($_SESSION['rapidx_user_accesses']); $index++)
                @if ($_SESSION['rapidx_user_accesses'][$index]['module_id'] == 14)
                        @php
                            $isAuthorized = true;
                            $user_level = $_SESSION['rapidx_user_accesses'][$index]['user_level_id'];
                        @endphp
                    @break
                @endif
                
            @endfor
        @if (!$isAuthorized)
            <script type="text/javascript">
                window.location = '../RapidX/';
            </script>
        @endif
    @else
        <script type="text/javascript">
            window.location = '../RapidX/';
        </script>
    @endif
@endif
 
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Online Pre-Shipment | @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="{{ asset('/images/favicon.ico') }}">

        {{-- CSS Styles --}}
        @include('shared.css_links.css_links')
        
    </head>
        <body class="hold-transition sidebar-mini">
            <input type="hidden" id="login_id" value="<?php echo $_SESSION['rapidx_user_id']; ?>">
            <input type="hidden" id="login_name" value="<?php echo $_SESSION["rapidx_name"]; ?>">
            <div class="wrapper">
                @include('shared.pages.admin_header')
                @include('shared.pages.admin_nav')
                @yield('content_page')
                @include('shared.pages.admin_footer')
            </div>

            {{-- JS --}}
            @include('shared.js_links.js_links')
            @yield('js_content')

        </body>
    </html>

    <script>
        let loginUserId = $('#login_id').val();
        verifyUser(loginUserId);
    </script>

    @else
    <script type="text/javascript">
        alert('session expired');
        window.location = "{{ url('http://rapidx/RapidX/') }}";
    </script>
    @endauth
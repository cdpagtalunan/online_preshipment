{{-- @auth --}}
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ISS License/Billing Reminder</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('/images/favicon.ico') }}"> --}}

        @include('shared.css_links.css_links')
    </head>
        <body class="hold-transition sidebar-mini">
            <div class="container-fluid px-0">
                @include('shared.pages.header')
                {{-- @include('shared.pages.user_nav') --}}
                @yield('content_page')
                @include('shared.pages.footer')
            </div>

            {{-- JS --}}
            @include('shared.js_links.js_links')
            @yield('js_content')
            {{-- @include('shared.pages.common') --}}
        </body>
    </html>
{{-- @endauth --}}
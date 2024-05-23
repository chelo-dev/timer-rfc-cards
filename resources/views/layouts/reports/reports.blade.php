<html>

<head>
    <meta charset="utf-8">
    <title>KHARMA SOLUTIONS | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ public_path('favicon.png') }}">
    <link href="{{ public_path('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .portada {
            position: absolute;
            top: -10%;
            left: -9%;
            width: 120%;
        }

        .watermark {
            position: fixed;
            top: 50%;
            right: -40px;
            transform: translateY(-50%);
            opacity: 0.8;
            z-index: -1000;
        }

        .espacio-1 {
            height: 40% !important;
        }

        .espacio-2 {
            height: 25% !important;
        }

        .salto-pagina {
            page-break-after: always;
        }

        td {
            white-space: normal;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        .table thead th {
            color: #FFFFFF;
        }

        .table tbody td {
            color: #26798E;
        }

        .bg-dark {
            background: #FFC172 !important;
            color: #333 !important;
            font-weight: bold !important;
        }

        .bg-kharma {
            background-color: #27798e;
            color: #eee;
            font-weight: bold;
        }
    </style>
    @yield('css')
</head>

<body>
    @php
    use Carbon\Carbon;
    setlocale(LC_TIME, 'es_ES.UTF-8');
    @endphp
    <div class="portada">
        <img width="99%" src="{{ public_path('portada.webp') }}" alt="{{ __('TITULO') }}">
    </div>
    <div class="watermark">
        <img src="{{ public_path('marca_agua.png') }}" width="35px" alt="{{ __('TITULO') }}" />
    </div>
    <div class="salto-pagina"></div>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="espacio-1"></div>
        <hr>
        <p class="float-right">{{ date('d/m/Y H:i:s', strtotime(now())) }}</p>
        <p class="text-muted">Reporte generado por: {{ __('TITULO') }}</p>
        <hr>
    </div>
    <div class="salto-pagina"></div>
    <div class="contenedor"></div>
    @yield('content')
    </div>

    {{-- <div class="salto-pagina"></div> --}}

    <script type="text/php">
        if (isset($pdf)) {
                $pdf->page_script('
                    $text = sprintf(_("Página %d de %d"), $PAGE_NUM, $PAGE_COUNT);
                    $font = "Arial, Helvetica, sans-serif";
                    $size = 12;
                    $color = array(0,0,0);
                    $word_space = 0.0;
                    $char_space = 0.0;
                    $angle = 0.0;
        
                    $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
        
                    if ($PAGE_NUM >= 2) {
                        $x = ($pdf->get_width() - $textWidth) / 2;
                        $y = $pdf->get_height() - 35;
        
                        $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                    }
                ');
            }
        </script>
    @yield('js')
</body>

</html>
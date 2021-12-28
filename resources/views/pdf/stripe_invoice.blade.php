<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <title>MakeContent - Faktura</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="robots" content="all"/>
    <meta name="Description" content="makeContent - Faktura"/>
    <link rel="stylesheet" media="screen"
          href="/invoice/asset/application-e88ea6adb5b88721b2521006834da4eedfc491b93c54c6b314021fbe86b837f8.css"/>
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/ie-lt8.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <![endif]-->
    <link rel="stylesheet" media="print"
          href="/asset/print-be45fc5878732f94baf387349c08a244ff076271469e5c565559babab114c0e4.css"/>
    <!-- VENDOR JS CODE: radgost -->
    <script type="text/javascript">
        var _APP_LOCALE = 'pl';

        if (_APP_LOCALE == 'en') {
            _locale = 'us'
        } else {
            _locale = _APP_LOCALE
        }
        var _APP_DIGITS = 2;
        var _APP_DIGITS_F = {format: "#,##0.00", locale: _locale};
        var _APP_DIGITS_QTY_F = {format: "#,##0.000", locale: _locale};
        var _ACCOUNT_CURRENCY = 'PLN';

        var _TOTAL_TEXT = 'Razem';
    </script>
    <script src="/invoice/asset/application-ce901f0717b89a2a1c5e794cfc226c92338b24c9ddc602dd0f9f991c05d19038.js"></script>
    <style type="text/css" media="screen">
        body {
            padding-top: 0;
        }
        .content {
            overflow: visible;
            min-height: 318px;
        }

        .f_box {
            width: 800px;
            margin: 20px auto;
        }
        @font-face {
            font-family: DejaVu Sans;
            font-weight: bold;
            src: url(/invoice/asset/font/DejaVuSans-Bold.ttf);
        }
        @font-face {
            font-family: DejaVu Sans;
            font-weight: normal;
            src: url(/invoice/asset/font/DejaVuSans.ttf);
        }

        strong {
            font-family: "DejaVu Sans";
        }

        table th {
            font-family: "DejaVu Sans";
        }

        body {
            font-family: "DejaVu Sans"!important;
            font-size: 14px!important;
        }
        table.main_inv_table th {
            font-size: 10px!important;
        }

    </style>
</head>
<body>
    <div class="content  wide-content">
    <div class="container">
        <div class="invoice_preview invoice">
            <style type="text/css">
                @media all {
                    .invoice_outline {
                        font-family: helvetica, "lucida grande", "lucida sans unicode";
                    }

                    /*@page{size:A4 ;}*/
                    .clear {
                        clear: both;
                    }

                    p {
                        margin: 0;
                    }

                    table p {
                        margin-bottom: 0.5em;
                        line-height: 1.4em;
                    }

                    .split_three strong {
                        display: block;
                        margin-bottom: 5px;
                    }

                    .split_three br {
                        display: none
                    }

                    #custom_stamp {
                        background-position: 96% 87% !important
                    }

                    /*TABELE*/
                    table {
                        font-size: 0.6em;
                    }

                    tr {
                        page-break-inside: avoid;
                    }

                    table {
                        page-break-after: auto
                    }

                    tr {
                        page-break-inside: avoid;
                        page-break-after: auto
                    }

                    td {
                        page-break-inside: avoid;
                        page-break-after: auto
                    }

                    thead {
                        display: table-header-group
                    }


                    .nobreak {
                        page-break-inside: avoid;
                    }


                    table th,
                    table td {
                        margin: 0;
                        padding: 0;
                    }

                    th.width0,
                    td.width0 {
                        width: 1%;
                        white-space: nowrap
                    }

                    th.width1,
                    td.width1 {
                        width: 2%;
                    }

                    th.width2,
                    td.width2 {
                        width: 5%;
                    }

                    th.width3,
                    td.width3 {
                        width: 7%;
                    }

                    th.width4,
                    td.width4 {
                        width: 25%;
                    }

                    th.width3_5,
                    td.width3_5 {
                        width: 22%;
                    }


                    td.logo_inside,
                    td.logo_inside {
                        vertical-align: middle;
                        text-align: center
                    }

                    td.logo_inside img {
                        max-height: 187px;
                        max-width: 250px;

                    }

                    td:empty {
                        visibility: hidden;
                    }

                    table {
                        border-collapse: collapse;
                        empty-cells: hide;
                    }

                    html tr,
                    html td {
                        background-color: transparent;
                        empty-cells: hide
                    }

                    table {
                        margin: auto;
                        clear: both;
                        border-collapse: collapse;
                        empty-cells: hide;
                        margin: 5px auto 5px auto;
                        width: 100%;
                    }

                    table tr {
                        vertical-align: top;
                    }

                    table, table th, table td {
                        border: 0;
                        background-color: transparent;
                        text-align: left;
                        vertical-align: top;
                    }

                    table.main_inv_table th, table.main_inv_table td, table.main_inv_table caption {
                        text-align: right;
                        border-collapse: collapse;
                        border: 1px solid #d8d7d7;
                    }

                    table.main_inv_table th {
                        font-weight: bold;
                        background-color: #f1f1f1;
                        border: 1px solid #bbbbbb;
                        font-size: 10px;
                    }

                    table.main_inv_table th p, table td a {
                        text-align: left;
                    }

                    table.main_inv_table .tax_col.footer {
                        visibility: visible;
                    }

                    table th {
                        font-weight: bold;
                    }

                    table.to_right {
                        float: right;
                        width: 99%;
                    }

                    table.to_right th {
                        text-align: right;
                    }

                    table.to_right td {
                        width: 15%;
                        text-align: right;
                    }

                    .split_half td {
                        width: 50%;
                    }

                    .split_three td {
                        width: 33%;
                    }

                    table.to_pay {
                        margin: 40px auto 20px auto;
                        background: transparent;
                    }

                    table.to_pay th,
                    table.to_pay td {
                        border-top: 1px solid #ddd;
                        border-bottom: 1px solid #ddd;
                    }

                    hr {
                        margin: 10px auto;
                    }

                    .to_pay th {
                        width: 120px;
                    }

                    .to_pay td,
                    .to_pay th {
                        padding: 10px 5px;
                    }

                    table th, table td {
                        margin: 0;
                        padding: 5px;
                    }


                    #exchange_currency {
                        margin-top: 20px;
                    }

                    #exchange_currency td {
                        border-top: 1px solid #ddd;
                        padding-top: 10px !important;
                    }

                    #exchange_currency + table.clean.to_pay {
                        margin-top: 0;
                    }


                    table td.empty {
                        border: 0;
                    }

                    html body table tr:hover {
                        background-color: transparent;
                    }

                    table.main_inv_table th.text_left,
                    table.main_inv_table td.text_left,
                    th.text_left,
                    td.text_left {
                        text-align: left;
                        padding-left: 10px;
                    }

                    .number, .nowrap,
                    td b, td.row1, td.row2, td.row3 {
                        white-space: nowrap
                    }

                    th.width3 + th.width1.nowrap {
                        white-space: normal
                    }


                    .payment_button {
                        display: block;
                        float: right;
                        text-align: right;
                        height: 43px;
                        width: 190px;
                        z-index: 999;
                    }

                    .payment_button img {
                        display: block;
                        float: right;
                        text-align: right;
                        width: 190px;
                        height: 43px;
                        z-index: 999;
                    }

                    html,
                    body {
                        margin: 0;
                        padding: 0;
                    }


                    .invoice_outline[dir="rtl"],
                    .invoice_outline[dir="rtl"] table,
                    .invoice_outline[dir="rtl"] table th,
                    .invoice_outline[dir="rtl"] table td {
                        text-align: right;
                    }

                    .invoice_outline[dir="rtl"] .inv_paid > td,
                    .invoice_outline[dir="rtl"] .inv_to_pay > td {
                        text-align: right;
                    }


                    .invoice_outline[dir="rtl"] table.clean.to_right td,
                    .invoice_outline[dir="rtl"] table.clean.to_right th {
                        text-align: left;
                    }

                    .nowrap, .no_wrap {
                        white-space: nowrap !important;
                    }

                    .nowrap-lines {
                        white-space: pre;
                    }

                    #corrected_content {
                        width: 100%;
                    }

                    #corrected_content th,
                    #corrected_content td {
                        width: 50%;
                        vertical-align: top;
                        text-align: left;
                    }

                    /* EXTRA NOTES ON EXTRA PAGE */
                    #extra_page {
                        clear: both;
                        display: block;
                        text-align: left;
                        font-size: 9pt;
                    }

                }

                @page :first {
                    margin-top: 0in;
                    margin-bottom: 0.5in;
                }


                @page {
                    size: portrait;
                    margin: 0in;
                    padding: 0;
                    margin-top: 0.5in;
                    margin-bottom: 0.5in;
                }

                @media print {

                    .invoice_outline {
                        margin-top: 0.5in;
                        margin-bottom: 0in;
                        margin-left: 0.5in;
                        margin-right: 0.5in;
                    }


                    table {
                        page-break-inside: auto
                    }

                    td, tr {
                        page-break-inside: avoid;
                        page-break-after: auto
                    }

                    thead {
                        display: table-header-group
                    }

                    tfoot {
                        display: table-footer-group
                    }

                    a.btn-print {
                        color: #333333 !important;
                        background-color: #ffffff !important;
                        border: 2px solid #cccccc !important;
                        display: inline-block;
                        padding: 6px 12px !important;
                        margin-bottom: 0;
                        font-size: 14px !important;
                        font-weight: normal;
                        line-height: 1.428571429 !important;
                        text-align: center !important;
                        vertical-align: middle !important;
                        border-radius: 4px !important;
                        white-space: nowrap !important;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        -o-user-select: none;
                        user-select: none;
                        text-decoration: none;
                    }

                    .pull-right {
                        float: right;
                    }

                    #buyer a {
                        color: inherit;
                        text-decoration: none;
                    }

                }

                @media screen {

                    .invoice_preview.invoice {
                        font-size: 180%;
                        width: 8.25in;
                    }


                }

                section#description_footer {
                    border: 0;
                    padding: 0;
                    margin: 0;
                    vertical-align: bottom;
                    padding-top: 15px;
                    padding-left: 0px;
                    padding-right: 0px;
                    padding-left: 22%;
                    padding-right: 22%;
                    margin-top: 40px;
                }

                section#description_footer span {
                    margin-left: auto;
                    margin-right: auto;
                    max-width: 407px;
                    display: block;
                    overflow: hidden;
                    line-height: 11.3px !important;
                    font-family: arial, sans-serif, tahoma !important;
                    font-size: 9.85px !important;
                    letter-spacing: normal !important;
                    text-align: center;
                }

                .no-page-break {
                    page-break-before: auto;
                    page-break-inside: avoid !important;
                }

                .text_separator {
                    white-space: pre-line;
                }

                /* fix for multipage table printing issue */
                @media print {
                    table.main_inv_table {
                        border-collapse: collapse;
                    }

                    table.main_inv_table tr {
                        page-break-inside: avoid !important;
                    }

                    table.main_inv_table td {
                        page-break-inside: avoid !important;
                    }

                    table.main_inv_table thead {
                        display: table-header-group !important;
                    }


                    .hidden-print, .no-print, .noprint {
                        display: none !important;
                    }

                    .hidden {
                        display: none !important;
                    }

                    .show-print {
                        display: block !important;
                    }

                    .pull-right {
                        float: right;
                    }

                    a.btn-print {
                        color: #333333 !important;
                        background-color: #FFFFFF !important;
                        border: 1px solid #BEBEBE !important;
                        display: inline-block;
                        padding: 9px 15px 7px 15px !important;
                        margin-bottom: 0;
                        font-size: 9pt !important;
                        font-weight: normal;
                        line-height: 1em !important;
                        text-align: center !important;
                        vertical-align: middle !important;
                        border-radius: 4px !important;
                        white-space: nowrap !important;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        -o-user-select: none;
                        user-select: none;
                        text-decoration: none;
                    }

                    .content.wide-content.incomplete {
                        display: none !important;
                    }

                    #incomplete_safe_print {
                        margin-top: 100pt;
                        width: 100%;
                        text-align: center;
                        font-size: 14pt;
                        font-weight: bold;
                        line-height: 20pt;
                        display: block !important;
                    }

                    span.item_description {
                        display: block;
                    }

                    .profiler-results,
                    .profiler-popup,
                    .profiler-queries,
                    .profiler-queries-bg {
                        display: none !important;
                    }

                    .bilangual table.main_inv_table th {
                        white-space: normal !important;
                    }


                    #HW_frame_cont, li.hw_badge {
                        display: none;
                    }

                    #sx_container {
                        display: none;
                    }

                    #company_info_footer,
                    section#description_footer span {
                        height: auto;
                        max-height: 50px;
                        padding-top: 0px;
                    }

                    section#description_footer {
                        margin-top: 15px;
                    }

                }

                @media screen {
                    .hidden-screen {
                        display: none !important;
                    }

                    .show-screen {
                        display: block !important;
                    }

                    section#description_footer {
                        width: 100%;
                        margin-top: 30px;
                    }

                    section#description_footer span {
                        height: 50px !important;
                    }

                }
            </style>
            <div class="vat" style="padding: 10px"><!-- Komunikat o tym, że faktura jest anulowana -->
                <div class="invoice_outline default">
                    <table class="clean to_half" style="margin-bottom: 1px">
                        <tr>
                            <td>
                                <p class="invoice_title">
                                    <strong>
                                        Faktura numer
                                    </strong>
                                    <span>MK/{{ $invoice->id }}/{{date('Y')}}</span>
                                </p>
                                <p class="original_copy">
                                </p>
                                <br/>
                                <p>
                                    <strong>
                                        Data wystawienia:
                                    </strong>
                                    Warszawa,
                                    {{ date('Y-m-d', $order->created)}}
                                </p>
                                <p>
                                    <strong>Data sprzedaży:</strong> {{ date('Y-m-d', $order->created)}}
                                </p>
                                <p>
                                    <strong>Termin płatności:</strong>
                                    {{ date('Y-m-d', $order->created)}}
                                </p>
                                <p><strong>Płatność:</strong>
                                    PayU
                                </p>
                            </td>
                            <td class="logo_inside" rowspan="6">
                                <div id="logo">
                                    <div id="logo_place" style="display:inline-block; position:relative;">
                                        <img src="data:image/png;base64, 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" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    @php
                        $total = roundPrice((float)$trx->amount/100)
                    @endphp
                    @php
                        $fee = roundPrice((float)$trx->fee)
                    @endphp
                    @php
                        $sum = roundPrice((float)$trx->net/100)
                    @endphp
                    <table class="clean split_half" style="border-top: 1px solid lightgray; width: 100%">
                        <thead>
                        <tr>
                            <th>
                                <span class="seller">Sprzedawca</span>
                            </th>
                            <th>
                            <span class="buyer">
                                Nabywca
                            </span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <p>IT PLATINIUM SP. Z O.O</p>
                                <p>
                                    ul. Nowy Świat 33/13<br>00-029 Warszawa, Polska
                                </p>
                                <p>NIP 5252785339</p>
                                <p>REGON 382943352</p>
                                <p>KRS: 0000779092</p>
                                <p></p>
                                <p>
                                </p>
                            </td>
                            <td id="buyer">
                                <p data-client="19729185">
                                    {{ ($user->email ?? '') }}
                                </p>
                                <p>
                                    {{ $user->address }}<br>{{ $user->address_2 }}
                                </p>
                                <p>NIP {{ $user->NIP }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="main_inv_table VAT">
                        <thead>
                        <tr>
                            <th class="width0 nr_col">
                                LP
                            </th>
                            <th class="width3 text_left name_col">
                                Nazwa towaru / usługi
                            </th>

                            <th class="width1 quantity_col">
                                Ilość
                            </th>

                            <th class="width2 price_net_col">
                                Cena netto
                            </th>
                            <th class="width2 total_price_net_col">
                                Wartość netto
                            </th>
                            <th class="width1 tax_col nowrap">
                                VAT %
                            </th>
                            <th class="width2 tax_value_col">
                                Wartość VAT
                            </th>
                            <th class="width2 total_price_gross_col">
                                Wartość brutto
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="row0 nr_col">
                                1
                            </td>
                            <td class="row0 text_left name_col">
                                <span>
                                    Punkty pozwalające na zlecenie wykonania artykułów i tekstów na platformie makeContent.pl
                                </span>
                            </td>
                            <td class="row3 quantity_col">
                                1
                            </td>
                            <td class="row1 price_net_col">
                                {{ $total }}
                            </td>
                            <td class="row1 total_price_net_col">
                                {{ $total }}
                            </td>
                            <td class="row2 tax_col">
                                23
                            </td>
                            <td class="row1 tax_value_col">
                                {{ $fee }}
                            </td>
                            <td class="row1 total_price_gross_col">
                                {{ $sum }}
                            </td>
                        </tr>
                        <tr>
                            <td class="empty nr_col footer "></td>
                            <td class="empty price_net footer "></td>
                            <td class="empty mod_4_3 footer "></td>
                            <td class="including footer ">W tym</td>
                            <td class="total_price_net_col footer ">
                                {{ $total }}
                            </td>
                            <td class="tax_col footer ">
                                23
                            </td>
                            <td class="tax_value_col footer ">
                                {{ $fee }}
                            </td>
                            <td class="total_price_gross_col footer ">
                                {{ $sum }}
                            </td>
                        </tr>

                        <tr>
                            <td class="empty nr_col footer "></td>

                            <td class="empty price_net footer "></td>

                            <td class="empty mod_4_2 footer "></td>
                            <td class="total footer "><b>Razem</b></td>

                            <td class="total_price_net_col footer ">
                                <b>{{ $total }} </b>
                            </td>
                            <td class="tax_col footer "></td>
                            <td class="tax_value_col footer ">
                                <b>{{ $total }} </b>
                            </td>
                            <td class="total_price_gross_col footer ">
                                <b>{{ $sum }} </b>
                            </td>

                        </tr>


                        </tbody>
                    </table>

                    <div class="clear"></div>


                    <table class="clean to_right">
                        <tr>
                            <th>
                                Wartość netto
                            </th>
                            <td class="number">
                                {{$total}} PLN
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Wartość VAT
                            </th>
                            <td class="number">
                                {{ $fee }} PLN
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Wartość brutto

                            </th>
                            <td class="number">
                                {{ $sum }} PLN
                            </td>
                        </tr>
                    </table>

                    <div style="page-break-inside:avoid">
                        <table class="clean to_pay">
                            <tr class="inv_paid">
                                <th width="10">
                                    Kwota opłacona
                                </th>
                                <td>
                                    {{ $sum }} PLN
                                </td>
                            </tr>
                            <tr class="inv_to_pay">
                                <th width="10">
                                    Do zapłaty
                                </th>
                                <td>
                                    0,00 PLN

                                    <br/>
                                    Słownie:
                                    zero PLN zero gr
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div> <!-- invoice_preview -->

        <script type="text/javascript">
            $(function () {
                $("#sign-document-button").click(function (e) {
                    e.preventDefault();
                    signature_form();
                });
            });
        </script>
    </div>
</div>
</body>
</html>

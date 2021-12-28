<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <title>makeContent - Faktura</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="robots" content="all"/>
    <meta name="Description" content="makeContent - Faktura"/>
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/ie-lt8.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <![endif]-->
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

    <style type="text/css" media="screen">body {
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
        .invoice_preview.invoice {
            background-color: white;
            -webkit-box-shadow: 1px 3px 5px 0px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 1px 3px 5px 0px rgba(0, 0, 0, 0.75);
            box-shadow: 1px 3px 5px 0px rgba(0, 0, 0, 0.75);
            font-size: 110%;
            border: 1px solid #ddd;
            padding: 10px;
            padding-bottom: 0px;
            min-width: 700px;
            width: auto;
            overflow: visible;
            margin: auto;
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
                        margin-top: 10px;
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
            <div class=" vat"><!-- Komunikat o tym, że faktura jest anulowana -->


                <div class="invoice_outline default">

                    <!-- dir="rtl" -->


                    <table class="clean to_half">
                        <tr>
                            <td>
                                <p class="invoice_title">
                                    <strong>
                                        Faktura numer
                                    </strong>
                                    <span>MK1/02/2020</span>
                                </p>


                                <p class="original_copy">
                                </p>
                                <br/>
                                <p>
                                    <strong>
                                        Data wystawienia:
                                    </strong>
                                    Warszawa,
                                    2020-02-06
                                </p>
                                <p>
                                    <strong>Data sprzedaży:</strong> 2020-02-06
                                </p>

                                <p>
                                    <strong>Termin płatności:</strong>
                                    2020-02-06
                                </p>


                                <p><strong>Płatność:</strong>
                                    PayU
                                </p>
                            </td>
                            <td class="logo_inside" rowspan="6">
                                <div id="logo">
                                    <div id="logo_place" style="display:inline-block; position:relative;">
                                        <img src="/invoice/logo-black.png"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table class="clean split_half" style="border-top: 1px solid lightgrey">
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
                                    Yashin Alponse LTD
                                </p>
                                <p>
                                    Chełmska 21<br>00-724 Warszawa, Polska
                                </p>
                                <p>NIP 7010117055</p>
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
                            <th class="width4 text_left name_col">
                                Nazwa towaru / usługi
                            </th>

                            <th class="width1 quantity_col">
                                Ilość
                            </th>

                            <th class="width3 price_net_col">
                                Cena netto
                            </th>
                            <th class="width3 total_price_net_col">
                                Wartość netto
                            </th>
                            <th class="width1 tax_col nowrap">
                                VAT %
                            </th>
                            <th class="width3 tax_value_col">
                                Wartość VAT
                            </th>
                            <th class="width3 total_price_gross_col">
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
                                595,00
                            </td>
                            <td class="row1 total_price_net_col">
                                595,00
                            </td>
                            <td class="row2 tax_col">
                                23
                            </td>
                            <td class="row1 tax_value_col">
                                136,85
                            </td>
                            <td class="row1 total_price_gross_col">
                                731,85
                            </td>
                        </tr>


                        <tr>
                            <td class="empty nr_col footer "></td>
                            <td class="empty price_net footer "></td>
                            <td class="empty mod_4_3 footer "></td>
                            <td class="including footer ">W tym</td>
                            <td class="total_price_net_col footer ">
                                595,00
                            </td>
                            <td class="tax_col footer ">
                                23
                            </td>
                            <td class="tax_value_col footer ">
                                136,85
                            </td>
                            <td class="total_price_gross_col footer ">
                                731,85
                            </td>
                        </tr>

                        <tr>
                            <td class="empty nr_col footer "></td>

                            <td class="empty price_net footer "></td>

                            <td class="empty mod_4_2 footer "></td>
                            <td class="total footer "><b>Razem</b></td>

                            <td class="total_price_net_col footer ">
                                <b>595,00 </b>
                            </td>
                            <td class="tax_col footer "></td>
                            <td class="tax_value_col footer ">
                                <b>136,85 </b>
                            </td>
                            <td class="total_price_gross_col footer ">
                                <b>731,85 </b>
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
                                595,00 PLN
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Wartość VAT
                            </th>
                            <td class="number">
                                136,85 PLN
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Wartość brutto

                            </th>
                            <td class="number">
                                731,85 PLN
                            </td>
                        </tr>

                    </table>


                    <div class="clear"></div>


                    <div style="page-break-inside:avoid">
                        <table class="clean to_pay">


                            <tr class="inv_paid">
                                <th width="10">
                                    Kwota opłacona
                                </th>
                                <td>
                                    731,85 PLN
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

                        <div class="clear"></div>


                        <table class="clean split_three">
                            <tr>
                                <td class="buyer_person">
                                </td>
                                <td>
                                </td>

                                <td class="seller_person signature-bg">

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

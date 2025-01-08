<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Payslip</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
        

        <style>
            /* Убираем влияние шрифта для navbar, чтобы он остался как в оригинале */
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f7f7f7;
                padding-top: 50px;
            }

            body .navbar {
                padding: .5rem 1rem;
            }

            .container {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                padding: 30px;
            }

            .employee-info {
                text-align: center;
                font-size: 1.5rem;
                font-weight: bold;
                margin-bottom: 30px;
                color: #333;
            }

            .payslip-table {
                width: 100%;
                margin-top: 20px;
                border-collapse: collapse;
                display: flex;
                justify-content: center;
            }

            .payslip-table td,
            .payslip-table th {
                padding: 10px;
                border: 2px solid #ddd;
                text-align: left;
                font-size: 1rem;
            }

            .payslip-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .payslip-table tr:nth-child(odd) {
                background-color: #fff;
            }

            .payslip-table th {
                background-color: #007bff;
                color: white;
                font-weight: bold;
            }

            .payslip-table td {
                background-color: #f9f9f9;
            }

            .download-btn {
                display: flex;
                justify-content: center;
                margin-top: 30px;
            }

            .btn-custom {
                background-color: #007bff;
                color: white;
                font-size: 1rem;
                padding: 10px 20px;
                border-radius: 5px;
                border: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-custom:hover {
                background-color: #0056b3;
            }

            /* Устанавливаем шрифт по умолчанию для navbar */
            .navbar, .navbar-nav, .navbar-link, .navbar-brand {
                font-family: Arial, Helvetica, sans-serif !important;
            }

            .container {
                margin-top: 50px;
            }
        </style>
    </head>
    <body>

        <!-- Navbar -->
        @extends('layouts.navbar')

        <div class="container">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('message')['status']}} alert-dismissible fade show" role="alert" style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <span>{{ Session::get('message')['text'] }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="font-size: 1.5rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="employee-info">
                <p>{{$employee->firstname}} {{$employee->lastname}}</p>
            </div>

            <div class="payslip-table" id="payslip-table">
                <table>
                    <tbody>
                        <tr>
                            <td colspan="3" style="text-align: center; font-size: 1.1rem;">
                                Расчетный лист №{{$salaryModel->id}} за период {{Date::parse($salaryModel->from_measured)->format('d M Y')}} - {{Date::parse($salaryModel->date_measured)->format('d M Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>ФИО</b></td>
                            <td colspan="2">{{$employee->firstname}} {{$employee->lastname}}</td>
                        </tr>
                        <tr>
                            <td><b>Отработано</b></td>
                            <td>Дней: {{number_format($salaryModel->working_hours / 8, '0')}}</td>
                            <td>Часов: {{$salaryModel->working_hours}}</td>
                        </tr>
                        <tr>
                            <td><b>Больничные</b></td>
                            <td>Дней: {{number_format($salaryModel->sick_hours / 8, '0')}}</td>
                            <td>Часов: {{$salaryModel->sick_hours}}</td>
                        </tr>
                        <tr style="background-color: rgb(186, 186, 186)">
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td><b>Итого начислено</b></td>
                            <td colspan="2">{{$salaryModel->total}} BYN</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px">в т.ч. премия:</td>
                            <td colspan="2">{{$salaryModel->bonus}} BYN</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="download-btn">
                <button class="btn-custom" id="download-pdf">Скачать PDF</button>
                {{-- <button class="btn-custom" id="download-png" style="margin-left: 15px;">Скачать PNG</button> --}}
            </div>
        </div>

        <script>
            document.getElementById('download-pdf').addEventListener('click', function() {
                const element = document.querySelector("#payslip-table");
                const options = {
                    margin: 10,
                    filename: 'payslip.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };
                html2pdf().from(element).set(options).save();
            });
        
            // document.getElementById('download-png').addEventListener('click', function() {
            //     html2canvas(document.querySelector("#payslip-table"), { scale: 2 }).then(function(canvas) {
            //         var imgData = canvas.toDataURL('image/png');
            //         var link = document.createElement('a');
            //         link.href = imgData;
            //         link.download = 'payslip.png';
            //         link.click();
            //     });
            // });
        </script>
        
        

    </body>
</html>

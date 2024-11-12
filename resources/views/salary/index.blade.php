<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>New Salary</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- Table Sort -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
        </script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
        </script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js">
        </script>


<style>
    .container {
        margin-top: 70px;
    }

    .employee-info {
        margin-bottom: 30px;
    }
</style>
        
    </head>
    <body>

        <!-- Navbar -->
        @extends('layouts.navbar')

        @extends('layouts.infoModal');

        <div class="container">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('message')['status']}} alert-dismissible fade show" role="alert">
                    <span>{{ Session::get('message')['text'] }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="employee-info">
                New Salary for <b>{{ $employee->firstname }} {{ $employee->lastname }}</b>
            </div>

            <div class="preview-info">
                <span>Last Salary Date: {{$lastCalculatedSalary}} ({{$daysSinceLastCalculation}} days ago)</span>
                <br>
                <span>Bonus by period ({{$lastCalculatedSalary}} - {{Date::now()->format('d M Y')}}): {{$bonusByPeriod}} BYN</span>
            </div>

            <form action="/salary-save/{{$employee->employee_id}}" method="POST" id="salary-form">
                @csrf

                <div class="form-group">
                    <label>
                        Working hours
                        <input type="number" max="9999" min="0" step="1" class="form-control" name="workingHours" id="workingHours" value="0">
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        Sick hours
                        <input type="number" max="9999" min="0" step="1" class="form-control" name="sickDays" id="sickDays" value="0">
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>

    <script>
        document.getElementById('salary-form').addEventListener('submit', function (event) {
            const daysSinceLastCalculation = {{ $daysSinceLastCalculation }};
            const maxHours = daysSinceLastCalculation * 8;

            if (daysSinceLastCalculation === 0) {
                event.preventDefault();
                $('#infoModal-text').text(`Нельзя рассчитать зарплату дважды за день.`)
                $('#infoModal').modal('show');
                return;
            }

            const workingHours = parseInt(document.getElementById('workingHours').value) || 0;
            const sickDays = parseInt(document.getElementById('sickDays').value) || 0;

            const sickHours = sickDays * 8;
            const totalHours = workingHours + sickHours;

            if (totalHours > maxHours) {
                event.preventDefault();
                $('#infoModal-text').text(`Сумма рабочих часов и часов больничных не должна превышать ${maxHours} часов за прошедший период.`)
                $('#infoModal').modal('show');
                return;
            }
        });
    </script>
</html>

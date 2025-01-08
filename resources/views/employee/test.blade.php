Б!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$employee->firstname}} {{$employee->lastname}}</title>

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

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>




<style>
    .container {
        margin-top: 70px;
    }

    .employee-profile {
        display: flex;
        justify-content: space-between;
    }
</style>
        
    </head>
    <body>

        <!-- Navbar -->
        @extends('layouts.navbar');
        @extends('employee.delete-result');
        @extends('employee.salary-delete');


        <?= $isAdmin = auth()->user()->role == 'admin' ?>

        <div class="container">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('message')['status']}} alert-dismissible fade show" role="alert">
                    <span>{{ Session::get('message')['text'] }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="employee-profile">
                <div class="employee-fio">
                    <span><b>{{$employee->firstname}}</b></span><br>
                    <span><b>{{$employee->lastname}}</b></span>
                </div>
                <div class="employee-work-info">
                    @if ($isAdmin)
                    <p>Base Value: {{$employee->base_value}}</p>
                    @endif
                    <p>Department: {{$employee->department}}</p>
                    <p>Avg KPI: {{number_format($employee->averageKpi(), 1)}}%</p>
                </div>
                <div class="employee-actions">
                <a href="/kpi-results-new/{{$employee->employee_id}}" class="btn btn-primary">New KPI</a>
                <a href="/salary-new/{{$employee->employee_id}}" class="btn btn-primary">New Salary</a>
            </div>
        </div>


          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation" style="width: 50%">
              <button class="nav-link active" id="bonus-tab" data-toggle="tab" data-target="#bonusTab" type="button" role="tab" aria-controls="bonus" aria-selected="true" style="width: 100%">Премия</button>
            </li>
            <li class="nav-item" role="presentation" style="width: 50%">
              <button class="nav-link" id="salary-tab" data-toggle="tab" data-target="#salaryTab" type="button" role="tab" aria-controls="salary" aria-selected="false" style="width: 100%">Зарплата</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">

            {{-- KPI TAB --}}
            <div class="tab-pane fade show active" id="bonusTab" role="tabpanel" aria-labelledby="bonus-tab">
                <div class="employee-kpi-chart">
                    <canvas id="bonusChart" width="400" height="200"></canvas>
                    <button id="downloadPng-bonus" class="btn btn-secondary">Download PNG</button>
                    <br>
                    <canvas id="kpiChart" width="400" height="200"></canvas>
                    <button id="downloadPng" class="btn btn-secondary">Download PNG</button>
                </div>
                <br>
                <div class="employee-kpi">
                    <table class="table" id="kpiResultTable">
                        <thead>
                            <th>id</th>
                            <th>measured by</th>
                            <th>measure date</th>
                            <th>kpi name</th>
                            <th>kpi value</th>
                            <th>measured bonus</th>
                            @if ($isAdmin)
                            <th>action</th>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($employee->kpiResults()->get() as $kpiResult)
                                <tr>
                                    <td>{{ $kpiResult->result_id }}</td>
                                    <td>{{ $kpiResult->user()->username }}</td>
                                    <td>{{ $kpiResult->date_measured }}</td>
                                    <td>{{ $kpiResult->kpi()->name }}</td>
                                    <td>{{ $kpiResult->kpi_value }}</td>
                                    <td>{{ $kpiResult->value }}</td>
                                    @if ($isAdmin)
                                    <td>
                                        <button
                                            class="btn btn-danger"
                                            data-toggle="modal"
                                            data-target="#deleteResultModal"
                                            onClick="setDeleteResultId({{$kpiResult->result_id}}, {{$employee->employee_id}})"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SALARY TAB --}}
            <div class="tab-pane fade" id="salaryTab" role="tabpanel" aria-labelledby="salary-tab">
                <div>
                    <h2>Bar Chart: Salary Breakdown</h2>
                    <canvas id="salaryBarChart"></canvas>
                    <button id="downloadBarChart" class="btn btn-secondary">Download Bar Chart</button>
                </div>
                <div>
                    <h2>Line Chart: Salary Over Time</h2>
                    <canvas id="salaryLineChart"></canvas>
                    <button id="downloadLineChart" class="btn btn-secondary">Download Line Chart</button>
                </div>
                <br>
                <div class="employee-kpi">
                    <table class="table" id="salaryResultTable">
                        <thead>
                            <tr>
                                <th>Date Measured</th>
                                <th>Total Working Hours</th>
                                <th>Total Sick Hours</th>
                                <th>Total Bonus</th>
                                <th>Total Salary</th>
                                @if ($isAdmin)
                                <th>action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->getSalaryResultsArray() as $result)
                                <tr>
                                    <td>{{ $result['date_measured'] }}</td>
                                    <td>{{ $result['total_working_hours'] }}</td>
                                    <td>{{ $result['total_sick_hours'] }}</td>
                                    <td>{{ $result['total_bonus'] }}</td>
                                    <td>{{ $result['total_salary'] }}</td>
                                    @if ($isAdmin)
                                    <td>
                                        <button
                                            class="btn btn-danger"
                                            data-toggle="modal"
                                            data-target="#deleteSalaryModal"
                                            onClick="setDeleteSalaryId({{$result['id']}}, {{$employee->employee_id}})"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>


            

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const data = {!! json_encode($employee->getGroupedBonus()) !!};
    
                const labels = data.map(item => item.date_measured);
                const bonuses = data.map(item => item.total_bonus);
    
                const ctx = document.getElementById('bonusChart').getContext('2d');
                const bonusChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Bonus',
                            data: bonuses,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
    
                // Экспорт в PNG
                document.getElementById('downloadPng-bonus').addEventListener('click', function() {
                    const link = document.createElement('a');
                    link.href = bonusChart.toBase64Image();
                    link.download = 'bonus-chart.png';
                    link.click();
                });
            });
        </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Данные из вашего PHP-метода getKpiResultsArray, закодированные в JSON
        const data = {!! json_encode($employee->getKpiResultsArray()) !!};

        // Преобразуем данные для использования в Chart.js
        const groupedData = {};

        data.forEach(item => {
            if (!groupedData[item.kpi_name]) {
                groupedData[item.kpi_name] = { label: item.kpi_name, data: [], backgroundColor: '', borderColor: '' };
            }
            groupedData[item.kpi_name].data.push({ x: item.date_measured, y: item.avg_kpi_value });
        });

        // Устанавливаем разные цвета для каждого KPI
        const colors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ];
        const borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];

        let colorIndex = 0;
        Object.keys(groupedData).forEach((key, index) => {
            groupedData[key].backgroundColor = colors[colorIndex % colors.length];
            groupedData[key].borderColor = borderColors[colorIndex % borderColors.length];
            colorIndex++;
        });

        // Настройка данных для графика
        const ctx = document.getElementById('kpiChart').getContext('2d');
        const kpiChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: Object.values(groupedData)
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                        // type: 'time',
                        // time: {
                        //     unit: 'day'
                        // },
                        // title: {
                        //     display: true,
                        //     text: 'Date'
                        // }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Average KPI Value'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Экспорт в PNG
        document.getElementById('downloadPng').addEventListener('click', function() {
            const link = document.createElement('a');
            link.href = kpiChart.toBase64Image();
            link.download = 'kpi-chart.png';
            link.click();
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Данные из PHP метода getSalaryResultsArray
        const salaryData = {!! json_encode($employee->getSalaryResultsArray()) !!};

        // Подготовка данных для первой диаграммы (bar chart)
        const labels = salaryData.map(item => item.date_measured);
        const workingHours = salaryData.map(item => item.total_working_hours);
        const sickHours = salaryData.map(item => item.total_sick_hours);
        const bonuses = salaryData.map(item => item.total_bonus);
        const salaries = salaryData.map(item => item.total_salary);

        // Гистограмма (bar chart)
        const barCtx = document.getElementById('salaryBarChart').getContext('2d');
        const salaryBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Working Hours',
                        data: workingHours,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sick Hours',
                        data: sickHours,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Bonus',
                        data: bonuses,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Salary',
                        data: salaries,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Линейный график изменения зарплаты (line chart)
        const lineCtx = document.getElementById('salaryLineChart').getContext('2d');
        const salaryLineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: labels, // Даты измерений
                datasets: [
                    {
                        label: 'Total Salary Over Time',
                        data: salaries,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3, // Плавность линий
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointBorderColor: '#fff',
                        pointRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return Salary: ${context.parsed.y};
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Salary'
                        }
                    }
                }
            }
        });

        // Функция для скачивания графика в PNG
        function downloadChart(chart, fileName) {
            const link = document.createElement('a');
            link.href = chart.toBase64Image();
            link.download = fileName;
            link.click();
        }

        // Добавление событий на кнопки для скачивания
        document.getElementById('downloadBarChart').addEventListener('click', function() {
            downloadChart(salaryBarChart, 'Salary_Bar_Chart.png');
        });

        document.getElementById('downloadLineChart').addEventListener('click', function() {
            downloadChart(salaryLineChart, 'Salary_Line_Chart.png');
        });
    });
</script>


<script>
    function setDeleteResultId(resultId, employeeId) {
        document.getElementById('result_delete_id').value = resultId;
        document.getElementById('result_employee_id').value = employeeId;
    }
</script>

<script>
    function setDeleteSalaryId(salaryId, employeeId) {
        document.getElementById('salary_delete_id').value = salaryId;
        document.getElementById('salary_employee_id').value = employeeId;
    }
</script>

<script>
    $(document).ready(function() {
        $('#kpiResultTable').DataTable({
            "aaSorting": [],
            paging: true,
            scrollCollapse: true,
            scrollY: '500px'
        });

        $('#salaryResultTable').DataTable({
            "aaSorting": [],
            paging: true,
            scrollCollapse: true,
            scrollY: '500px'
        });
    });

</script>
        
    </body>
</html>
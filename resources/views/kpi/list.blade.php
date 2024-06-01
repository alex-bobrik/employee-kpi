<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>KPI List</title>
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
        </style>
    </head>
    <body>


         <!-- Navbar -->
         @extends('layouts.navbar')
         @extends('kpi.update-kpi')
         @extends('kpi.delete-kpi')

         {{ $isAdmin = auth()->user()->role == 'admin' }}

        <div class="container">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('message')['status']}} alert-dismissible fade show" role="alert">
                    <span>{{ Session::get('message')['text'] }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($isAdmin)
                <button
                        type="button"
                        class="btn btn-primary add-wish-btn"
                        data-toggle="modal"
                        data-target="#updateKpiModal"
                        onClick="resetForm()"
                    >
                        Add new KPI
                    </button>
            @endif
            
            <table class="table table-striped" id="kpiTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Weight</th>
                        @if ($isAdmin)
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kpiList as $kpi)
                        <tr>
                            <td>{{ $kpi->name }}</td>
                            <td>{{ $kpi->description }}</td>
                            <td>{{ $kpi->weight_value }}%</td>
                            @if ($isAdmin)
                                <td>
                                <button
                                    value="{{$kpi->kpi_id}}"
                                    class="btn btn-info edit-btn"
                                    data-toggle="modal"
                                    data-target="#updateKpiModal"
                                    onClick="setDataToModal({{$kpi}})"
                                >
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#deleteKpiModal"
                                        onClick="setDeleteId({{$kpi->kpi_id}})"
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

        <script>
            $(document).ready(function() {
                $('#kpiTable').DataTable({
                    "aaSorting": [],
                    paging: true,
                    scrollCollapse: true,
                    scrollY: '500px',
                    columnDefs: [{
                        orderable: false,
                        targets: [3],
                    }]
                });
            })
    
        </script>


<script>
    function setDeleteId(kpiId) {
        document.getElementById('kpi_delete_id').value = kpiId;
    }

    function setDataToModal(kpi) {
        $('#kpi_name').val(kpi.name);
        $('#kpi_description').val(kpi.description);
        $('#kpi_weight').val(kpi.weight_value);
        $('#kpi_id').val(kpi.kpi_id);
    }

    function resetForm() {
        let form = $('#updateKpiForm');
        form[0].reset();
        $('#kpi_id').val('');
    }
</script>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Employee List</title>

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

            .new-employee {
                margin-bottom: 5px;
                float: right;
            }
        </style>

        
    </head>
    <body>

         <!-- Navbar -->
         @extends('layouts.navbar');
         @extends('manager.update-manager');
         @extends('manager.delete-manager');



        <div class="container">
            @if(Session::has('message'))
                <div class="alert alert-{{Session::get('message')['status']}} alert-dismissible fade show" role="alert">
                    <span>{{ Session::get('message')['text'] }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div style="margin-bottom: 65px">
                <h1>Менеджеры</h1>
                <button
                        style="float: right"
                        type="button"
                        class="btn btn-primary add-wish-btn"
                        data-toggle="modal"
                        data-target="#updateManagerModal"
                        onClick="resetForm()"
                    >
                        Новый менеджер..
                    </button>
            </div>
            
            <table class="table table-striped" id="employeeTable">
                <thead>
                    <tr>
                        <th>Имя пользователя</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($managers as $manager)
                        <tr>
                            <td>{{ $manager->username }}</td>
                            <td>
                                <button
                                    value="{{$manager->user_id}}"
                                    class="btn btn-info edit-btn"
                                    data-toggle="modal"
                                    data-target="#updateManagerModal"
                                    onClick="setDataToModal({{$manager}})"
                                >
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#deleteManagerModal"
                                        onClick="setDeleteId({{$manager->user_id}})"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                            </td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>


        <script>
            $(document).ready(function() {
                $('#employeeTable').DataTable({
                    "aaSorting": [],
                    paging: true,
                    scrollCollapse: true,
                    scrollY: '500px',
                    columnDefs: [{
                        orderable: false,
                        targets: [1],
                    }]
                });
            });
    
        </script>

<script>
    function setDeleteId(managerId) {
        document.getElementById('manager_delete_id').value = managerId;
    }

    function setDataToModal(manager) {
        $('#username').val(manager.username);
        $('#password').val('');
        $('#manager_id').val(manager.user_id);
    }

    function resetForm() {
        let form = $('#updateManagerForm');
        form[0].reset();
        $('#manager_id').val('');
    }
</script>
    </body>
</html>

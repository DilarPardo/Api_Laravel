@extends('layouts.app')

@section('template_title')
    Qualification
@endsection

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Qualification') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('qualifications.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <input class="form-control" id="myInput" type="text" placeholder="Search..">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        
										<th>Student Id</th>
										<th>Course Id</th>
										<th>Grade</th>
                                        <th>Action</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @foreach ($qualifications as $qualification)
                                        <tr>
                                            <td>{{ $qualification->id }}</td>
                                            
											<td>{{ $qualification->student->name }}</td>
											<td>{{ $qualification->course->title }}</td>
											<td>{{ $qualification->grade }}</td>

                                            <td>
                                                <form action="{{ route('qualifications.destroy',$qualification->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('qualifications.show',$qualification->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('qualifications.edit',$qualification->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
          $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
    </script>

@endsection

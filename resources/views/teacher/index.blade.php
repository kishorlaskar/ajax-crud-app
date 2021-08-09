<html>
    <head>
        <title>Laravel Ajax Crud</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    </head>
    <body>
        <div style="padding: 30px"></div>
        <div class="container">
             <h2 style="color: blue">
                <marquee direction="" behaviour="">
                     Laravel 8 Ajax Crud
                    </marquee>
            </h2>
            <div class="row">
                <div class="col-sm-8">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Teachers Info</h5>
                      <table class="table table-bordered table-striped ">
                        <thead>
                          <tr>
                              <th scope="col" width="2%">TID</th>
                              <th scope="col" width="7%%">Name</th>
                              <th scope="col" width="10%">Title</th>
                              <th scope="col" width="15%">Instution</th>
                              <th scope="col" width="10%">Action</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="card">
                      <div class="card-header">
                          <span id="addTeacher">Add New Teacher</span>
                          <span id="updateTeacher">Update Teacher</span>
                      </div>
                    <div class="card-body">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Name</label>
                              <input type="text" class="form-control" id="teacher_name" aria-describedby="emailHelp" placeholder="Teacher's Name">
                                <span class="text-danger" id="nameError"></span>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designtation" aria-describedby="emailHelp" placeholder="Designation">
                                <span class="text-danger" id="designtationError"></span>
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label">Institution</label>
                              <input type="text" class="form-control" id="institution" placeholder="Instution">
                                <span class="text-danger" id="institutionError"></span>

                            </div>
                        <input type="hidden" id="id">
                            <button type="submit" class="btn btn-primary mr-2" onclick="addData()" id="addButton">Add</button>
                            <button type="submit" class="btn btn-primary" onclick="updateData()" id="updateButton">Update</button>

                    </div>
                  </div>
                </div>
              </div>
            <script>
                $('#addTeacher').show();
                $('#updateTeacher').hide();
                $('#addButton').show();
                $('#updateButton').hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })

                function allTeacher() {

                        $.ajax({
                            type:"GET",    //request type
                            dataType:'json', //return data type
                            url:"/all/teacher", //url to hit
                            success:function (response)
                            {
                                var data="";
                                $.each(response,function (key,value)
                                {
                                      data = data +"<tr>"
                                      data = data +"<td>"+value.id+"</td>"
                                      data = data +"<td>"+value.teacher_name+"</td>"
                                      data = data +"<td>"+value.designtation+"</td>"
                                      data = data +"<td>"+value.institution+"</td>"
                                      data =data+"<td>"
                                      data = data+"<button type='button' class='btn btn-warning' onclick='editData("+value.id+")'>Edit</button>  "
                                      data = data+"<button type='button' class='btn btn-danger' onclick='deleteData("+value.id+")'>Delete</button>"
                                      data = data+"</td>"
                                      data = data +"</tr>"

                                })
                                $('tbody').html(data);
                            }
                        })
                }

                allTeacher()
                function clearData()
                {
                        $('#teacher_name').val('');
                        $('#designtation').val('');
                        $('#institution').val('');
                        $('#nameError').val('');
                        $('#designtationError').val('');
                        $('#institutionError').val('');
                }

                function addData(){

                    var teacher_name = $('#teacher_name').val();
                    var designtation = $('#designtation').val();
                    var institution = $('#institution').val();


                    $.ajax({

                        type: "POST",
                        dataType: "json",
                        data:{teacher_name:teacher_name,designtation:designtation,institution:institution},
                        url:"/teacher/store",
                        success:function (data)
                        {
                            clearData();
                            allTeacher();
                           const Msg = Swal.mixin({
                               toast:true,
                                position: 'top-end',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            Msg.fire({
                                type: 'success',
                                title: 'Data Inserted',
                            })
                        },
                        error:function(error)
                        {

                            $('#nameError').text(error.responseJSON.errors.teacher_name);
                            $('#designtationError').text(error.responseJSON.errors.designtation);
                            $('#institutionError').text(error.responseJSON.errors.institution);

                        }

                    })
                }
                function editData(id)
                {
                    $.ajax({
                    type:"GET",
                    dataType:"json",
                    url:"/teacher/edit/"+id,
                    success: function (data)
                    {
                        $('#id').val(data.id);
                        $('#teacher_name').val(data.teacher_name);
                        $('#designtation').val(data.designtation);
                        $('#institution').val(data.institution);
                        $('#addTeacher').hide();
                        $('#updateTeacher').show();
                        $('#addButton').hide();
                        $('#updateButton').show();
                    }
                })
                }
                function updateData()
                {
                    var id = $('#id').val();
                    var teacher_name = $('#teacher_name').val();
                    var designtation = $('#designtation').val();
                    var institution = $('#institution').val();

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data:{teacher_name:teacher_name,designtation:designtation,institution:institution},
                        url:"/teacher/update/"+id,
                        success:function (data)
                        {
                            $('#addTeacher').show();
                            $('#updateTeacher').hide();
                            $('#addButton').show();
                            $('#updateButton').hide();
                            clearData();
                            allTeacher();
                            const Msg = Swal.mixin({
                                toast:true,
                                position: 'top-end',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            Msg.fire({
                                type: 'success',
                                title: 'Data Updated',
                            })
                        },
                        error:function(error)
                        {

                            $('#nameError').text(error.responseJSON.errors.teacher_name);
                            $('#designtationError').text(error.responseJSON.errors.designtation);
                            $('#institutionError').text(error.responseJSON.errors.institution);

                        }
                    })
                }
                function deleteData(id)
                {
                    swal({
                        title:"Are you sure to delete?",
                        text:"Once Deleted,data can not recoverd ",
                        icon:'warning',
                        buttons:true,
                        dangerMode:true,
                    })
                    .then((willdelete)=>
                    {
                        if(willdelete){

                            $.ajax({
                                type:"GET",
                                dataType:"json",
                                url:"/teacher/delete/"+id,
                                success:function (data)
                                {
                                    $('#addTeacher').show();
                                    $('#updateTeacher').hide();
                                    $('#addButton').show();
                                    $('#updateButton').hide();
                                    clearData();
                                    allTeacher();
                                    const Msg = Swal.mixin({
                                        toast:true,
                                        position: 'top-end',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    Msg.fire({
                                        type: 'success',
                                        title: 'Data Deleted',
                                    })
                                }
                            })



                        }else
                            {
                                swal("Canceled")
                             }
                    })

                }

            </script>
        </div>
    </body>
</html>

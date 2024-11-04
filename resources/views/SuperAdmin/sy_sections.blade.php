@extends('SuperAdmin.sidebar')
@section('content')



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">S.Y Sections</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-success" data-toggle="modal" data-target="#add_section_modal">
                    <i class="fas fa-plus"></i> Add Section
                </button>
                <div class="modal fade" id="add_section_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Sections</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="add_section_form">
                                    @csrf
                                    <label>Section Name</label>
                                    <input type="text" name="section_name" class="form-control" placeholder="Enter Section">

                                    <label>Description</label>
                                    <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>

                                    <label>Grade Level</label>
                                    <select class="form-select select2" name="grade_lvl">
                                        <option value="Grade 11">Grade 11</option>
                                        <option value="Grade 12">Grade 12</option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>

                                    <label>School Year</label>
                                    <select class="form-select select2" name="school_year">
                                        <option value="2024-2025">2024-2025</option>
                                        <option value="2025-2026">2025-2026</option>
                                        <option value="2026-2027">2026-2027</option>
                                        <option value="2027-2028">2027-2028</option>
                                        <option value="2028-2029">2028-2029</option>
                                        <option value="2029-2030">2029-2030</option>
                                    </select>



                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" onclick="add_section(event)" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

            </div>
        </div>

        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <p class="card-text">List of Sections</p>
                    </div>
                    <div class="card-body">
                        <table class="table tabe-hover table-striped table-bordered" id="data_table">
                            <thead class="table-dark">
                                <th>Section Name</th>
                                <th>Description</th>
                                <th>Grade Level</th>
                                <th>School Year</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="section_table_body">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
<script>
    display_sections();

    function display_sections() {
        $.ajax({
            type: "GET"
            , url: `{{ url('/get-sections') }}`
            , success: function(data) {
                let rows = '';

                $.each(data, function(index, sections) {
                    rows += `

                            <tr>
                                <td>${sections.section_name}</td>
                                <td>${sections.description}</td>
                                <td>${sections.grade_lvl}</td>
                                <td>${sections.school_year}</td>
                                <td>${sections.status}</td>
                                <td>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit_section_modal${sections.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete_section_modal${sections.id}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <a href="{{ url('/super-admin-sy-sections/section_member/${sections.id}') }}" class="btn btn-warning">
                                        <i class="fas fa-info"></i>
                                    </a>

                                    <div class="modal fade" id="delete_section_modal${sections.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Delete Section</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="delete_section_form${sections.id}">
                                                    @csrf

                                                    <input type="hidden"  name="section_id" value="${sections.id}">

                                                    <h5 class="text-center">Confirm Delete Section</h5>


                                                </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="delete_section(event, ${sections.id})" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->


                                    <div class="modal fade" id="edit_section_modal${sections.id}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit Section</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                <form id="edit_section_form${sections.id}">
                                                    @csrf

                                                    <input type="hidden"  name="section_id" value="${sections.id}">

                                                    <label>Section Name</label>
                                                    <input type="text" name="section_name" value="${sections.section_name}" class="form-control" placeholder="Enter Section">

                                                    <label>Description</label>
                                                    <textarea name="description"class="form-control">${sections.description}</textarea>

                                                    <label>Grade Level</label>
                                                    <select class="form-select select2" name="grade_lvl">
                                                        <option value="${sections.grade_lvl}" selected>${sections.grade_lvl}</option>
                                                        <option value="Grade 11">Grade 11</option>
                                                        <option value="Grade 12">Grade 12</option>
                                                        <option value="1st Year">1st Year</option>
                                                        <option value="2nd Year">2nd Year</option>
                                                        <option value="3rd Year">3rd Year</option>
                                                        <option value="4th Year">4th Year</option>
                                                    </select>

                                                    <label>School Year</label>
                                                    <select class="form-select select2" name="school_year">
                                                        <option value="${sections.school_year}">${sections.school_year}</option>
                                                        <option value="2024-2025">2024-2025</option>
                                                        <option value="2025-2026">2025-2026</option>
                                                        <option value="2026-2027">2026-2027</option>
                                                        <option value="2027-2028">2027-2028</option>
                                                        <option value="2028-2029">2028-2029</option>
                                                        <option value="2029-2030">2029-2030</option>
                                                    </select>

                                                    <label>Status</label>
                                                    <select class="form-select select2" name="status">
                                                        <option value="${sections.status}" selected>${sections.status}</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>


                                                </form>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" onclick="edit_section(event, ${sections.id})" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                </td>
                            </tr>

                        `;
                });

                $('#section_table_body').html(rows);
                $('.select2').select2();
            }
        });
    }
    function delete_section(event, section_id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/delete-section') }}`,
            data: $('#delete_section_form' + section_id).serialize(),
            success: function (data) {
                $('#delete_section_form' + section_id)[0].reset();
                $('#delete_section_modal' + section_id).modal('hide');
                display_sections();

                Swal.fire({
                    title: 'Deleted'
                    , text: 'Section Deleted successfully'
                    , icon: 'warning',
                 });
            }
        });
    }

    function edit_section(event, section_id){
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: `{{ url('/edit-section') }}`,
            data: $('#edit_section_form' + section_id).serialize(),
            success: function (data) {
                $('#edit_section_form' + section_id)[0].reset();
                $('#edit_section_modal' + section_id).modal('hide');
                display_sections();

                Swal.fire({
                    title: 'Edited'
                    , text: 'Section Edited successfully'
                    , icon: 'success',
                 });
            }
        });
    }


    function add_section(event) {
        event.preventDefault();

        $.ajax({
            type: "POST"
            , url: `{{ url('/add-section') }}`
            , data: $('#add_section_form').serialize()
            , success: function(data) {
                $('#add_section_form')[0].reset();
                $('#add_section_modal').modal('hide');
                display_sections();
                Swal.fire({
                    title: 'Added'
                    , text: 'Section added successfully'
                    , icon: 'success'
                , });

            }
        });
    }

</script>
@endsection

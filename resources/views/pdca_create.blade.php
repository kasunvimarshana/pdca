@extends('layouts.home_layout')

@section('section_stylesheet')
    @parent
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('node_modules/admin-lte/bower_components/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" />
    <!-- Bootstrap Datepicker -->
    <link rel="stylesheet" href="{{ asset('node_modules/admin-lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
    <!-- Bootstrap FileInput -->
    <link href="{!! asset('node_modules/bootstrap-fileinput/css/fileinput.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous" -->
    <link href="{!! asset('node_modules/bootstrap-fileinput/themes/explorer-fas/theme.css') !!}" media="all" rel="stylesheet" type="text/css"/>
@endsection

@section('section_script_main')
    @parent
@endsection

@section('content')
<!-- row -->
<div class="row">
    
    <!-- col -->
    <div class="col-sm-12">
        
        <!-- accordion -->
        <div class="panel-group" id="accordion">
            
            <!-- panel -->
            <div id="collapseOneParent" class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#collapseOneParent" href="#collapseOne"><span class="glyphicon glyphicon-plus"></span> Create New</a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <!-- --- -->
                        <!-- row -->
                        <div class="row">

                            <!-- col -->
                            <div class="col-sm-12">
                                <!-- form -->
                                <form action="{!! route('pDCA.store') !!}" method="POST" class="col-sm-9" autocomplete="off" id="formObject01" enctype="multipart/form-data">
                                    @csrf
                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <label for="own_user" class="col-sm-2 control-label">Create By</label>
                                        <div class="col-sm-10">
                                            <!-- p class="form-control-static"></p -->
                                            <select class="form-control select2" id="own_user" name="own_user[]" value="{{ old('own_user[]') }}" data-placeholder="Owner" style="width: 100%;" multiple="multiple">
                                            </select>
                                        </div>
                                        <!-- span id="form-control" class="help-block"></span -->
                                    </div>
                                    <!-- /.form-group -->
                                    
                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <label for="company_pk" class="col-sm-2 control-label">Company</label>
                                        <div class="col-sm-10">
                                            <!-- p class="form-control-static"></p -->
                                            <select class="form-control select2" id="company_pk" name="company_pk" value="{{ old('company_pk') }}" data-placeholder="Company" style="width: 100%;" required>
                                            </select>
                                        </div>
                                        <!-- span id="form-control" class="help-block"></span -->
                                    </div>
                                    <!-- /.form-group -->
                                    
                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <label for="department_pk" class="col-sm-2 control-label">Department</label>
                                        <div class="col-sm-10">
                                            <!-- p class="form-control-static"></p -->
                                            <select class="form-control select2" id="department_pk" name="department_pk" value="{{ old('department_pk') }}" data-placeholder="Department" style="width: 100%;" required>
                                            </select>
                                        </div>
                                        <!-- span id="form-control" class="help-block"></span -->
                                    </div>
                                    <!-- /.form-group -->

                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <label for="title" class="col-sm-2 control-label">Title</label>
                                        <div class="col-sm-10">
                                            <!-- p class="form-control-static"></p -->
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title') }}" required/>
                                        </div>
                                        <!-- span id="form-control" class="help-block"></span -->
                                    </div>
                                    <!-- /.form-group -->
                                    
                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <label for="complete_date" class="col-sm-2 control-label">Date</label>
                                        <div class="col-sm-10">
                                            <!-- p class="form-control-static"></p -->
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="complete_date" name="complete_date" placeholder="Date" value="{{ old('complete_date') }}" required/>
                                            </div>
                                        </div>
                                        <!-- span id="form-control" class="help-block"></span -->
                                    </div>
                                    <!-- /.form-group -->
                                    
                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <label for="description" class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-10">
                                            <!-- p class="form-control-static"></p -->
                                            <textarea class="form-control rounded-0" id="description" name="description" placeholder="Description" rows="5" required>{{ old('description') }}</textarea>
                                        </div>
                                        <!-- span id="form-control" class="help-block"></span -->
                                    </div>
                                    <!-- /.form-group -->
                                    
                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <label for="var_user_attachment" class="col-sm-2 control-label">File</label>
                                        <div class="col-sm-10">
                                            <!-- p class="form-control-static"></p -->
                                            <div class="col">
                                                <!-- class="file" -->
                                                <input type="file" multiple=true class="form-control" id="var_user_attachment" name="var_user_attachment[]" value="{{ old('var_user_attachment[]') }}"/>
                                            </div>
                                        </div>
                                        <!-- span id="form-control" class="help-block"></span -->
                                    </div>
                                    <!-- /.form-group -->

                                    <!-- form-group -->
                                    <div class="form-group col-sm-12">
                                        <!-- btn-toolbar -->
                                        <div class="col col-sm-12">
                                            <!-- div class="btn-group btn-group-lg pull-right" -->
                                                <button type="submit" class="btn btn-primary pull-right" id="submit">Submit</button>
                                            <!-- /div -->
                                        </div>
                                    </div>
                                    <!-- /.form-group -->

                                </form>
                                <!-- /.form -->
                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->
                        <!-- --- -->
                    </div>
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.accordion -->
        
    </div>
    <!-- /.col -->
    
</div>
<!-- /.row -->
@endsection

@section('section_script')
    @parent
    <!-- Select2 -->
    <script src="{{ asset('node_modules/admin-lte/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap Datepicker -->
    <script src="{{ asset('node_modules/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('node_modules/admin-lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Bootstrap FileInput -->
    <script src="{!! asset('node_modules/bootstrap-fileinput/js/plugins/piexif.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('node_modules/bootstrap-fileinput/js/plugins/purify.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('node_modules/bootstrap-fileinput/js/plugins/sortable.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('node_modules/bootstrap-fileinput/js/fileinput.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('node_modules/bootstrap-fileinput/js/locales/es.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('node_modules/bootstrap-fileinput/themes/fas/theme.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('node_modules/bootstrap-fileinput/themes/explorer-fas/theme.min.js') !!}" type="text/javascript"></script>

    @includeIf('partials.pdca_own_user_select', array('optionSelectId' => 'own_user'))
    @includeIf('partials.company_select', array('optionSelectId' => 'company_pk'))
    @includeIf('partials.department_select', array('optionSelectId' => 'department_pk'))
    <script>
    $(function() {
        "use strict";
        
        $("#var_user_attachment").fileinput({
            'showUpload': false,
            'showRemove': false,
            'previewFileType': 'any'
        });
        
        $('#complete_date').datepicker({
            'autoclose': true,
            'format': "yyyy-mm-dd",
            'immediateUpdates': true,
            'todayBtn': true,
            'todayHighlight': true,
            // 'widgetParent': ???,
            'widgetPositioning': {
                horizontal: "auto",
                vertical: "auto"
            },
            'toggleActive': true,
            'orientation': 'auto',
            'container': 'body'
        }).datepicker("setDate", new Date())
        .trigger("changeDate");
        
        $('#formObject01').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var form_id = $(this).attr('id');
            var _token = '{{ Session::token() }}';

            var own_user = form.find('#own_user');
            var company_pk = form.find('#company_pk');
            var department_pk = form.find('#department_pk');
            var title = form.find('#title');
            var complete_date = form.find('#complete_date');
            var description = form.find('#description');
            var var_user_attachment = form.find('#var_user_attachment');
            var submit = form.find('#submit');
            
            submit.attr("disabled", true);

            var formdata = new FormData( this );
            
            formdata.append('submit', true);
            // process the form
            $.ajax({
                type        : form.attr('method'), // define the type of HTTP verb we want to use (POST for our form)
                url         : form.attr('action'), // the url where we want to POST
                data        : formdata, // our data object
                //dataType    : 'json', // what type of data do we expect back from the server
                //encode      : true,
                processData : false,
                contentType : false,
                cache : false
            })
                // using the done promise callback
                .done(function(data) {
                    //console.log(data);
                    swal({
                        'title': data.title,
                        'text': data.text,
                        'type': data.type,
                        'timer': data.timer,
                        'showConfirmButton': false
                    });
                    //$('#dataTable').DataTable().ajax.reload( null, false ); // user paging is not reset on reload
                
                    own_user.val(null).trigger('change');
                    company_pk.val(null).trigger('change');
                    department_pk.val(null).trigger('change');
                    title.val(null);
                    complete_date.datepicker("setDate", new Date()).trigger("changeDate");
                    description.val(null);
                    var_user_attachment.fileinput('clear');
                    // scroll top
                    $('html, body').animate({scrollTop:0}, 'slow');
                })
                .fail(function() {
                    //console.log( "error" );
                })
                .always(function() {
                    //console.log( "complete" );
                    submit.attr("disabled", false);
                    //submit.removeAttr("disabled");
                });
        });
    });
    </script>
@endsection
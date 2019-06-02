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
                        <a data-toggle="collapse" data-parent="#collapseOneParent" href="#collapseOne"><span class="glyphicon glyphicon-plus"></span> View</a>
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
                                                @if($pDCA)
                                                    @php
                                                        $oldPDCAUsers = $pDCA->pDCAUsers;
                                                    @endphp
                                                    @isset($oldPDCAUsers)
                                                        @foreach ($oldPDCAUsers as $key => $value)
                                                        <option value="{!! $value->own_user !!}" selected> {{ $value->own_user }} </option>
                                                        @endforeach
                                                    @endisset
                                                @endif
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
                                                @if($pDCA)
                                                    @php
                                                        $oldCompanies = $pDCA->companies;
                                                    @endphp
                                                    @isset($oldCompanies)
                                                        @foreach ($oldCompanies as $key => $value)
                                                        <option value="{!! $value->name !!}" selected> {{ $value->name }} </option>
                                                        @endforeach
                                                    @endisset
                                                @endif
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
                                                @if($pDCA)
                                                    @php
                                                        $oldDepartments = $pDCA->departments;
                                                    @endphp
                                                    @isset($oldDepartments)
                                                        @foreach ($oldDepartments as $key => $value)
                                                        <option value="{!! $value->name !!}" selected> {{ $value->name }} </option>
                                                        @endforeach
                                                    @endisset
                                                @endif
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
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $pDCA->title }}" required/>
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
                                                <input type="text" class="form-control pull-right" id="complete_date" name="complete_date" placeholder="Date" value="{{ $pDCA->complete_date }}" required/>
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
                                            <textarea class="form-control rounded-0" id="description" name="description" placeholder="Description" rows="5" required>{{ $pDCA->description }}</textarea>
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
        
        $("#own_user").select2().prop("disabled", true);
        $("#company_pk").select2().prop("disabled", true);
        $("#department_pk").select2().prop("disabled", true);
        $("#title").prop("disabled", true);
        $("#description").prop("disabled", true);
        
        /*$("#var_user_attachment").fileinput({
            'showUpload': false,
            'showRemove': false,
            'previewFileType': 'any'
        })
        .fileinput("lock")
        .fileinput("disable")
        .fileinput("refresh", {showUpload: false});*/
        
        /////////////////////////////////////////////////////////////////////
        function getInitialPreview(){
            var returnData = Array();
            
            $.ajax({
                async: false,
                cache: false,
                processData: false,
                url: "{!! route('userAttachment.listUserAttachmentFileInput') !!}",
                method: "GET",
                data: {
                    '_token': '{!! csrf_token() !!}'
                },
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function( xhr ) {
                    //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                }
            })
            .done(function(data) {
                //console.log( "success" );
                //console.log(data);
            })
            .fail(function(data) {
                //console.log( "error" );
                //console.log(data);
            })
            .always(function(data) {
                //console.log( "complete" );
                //console.log(data);
                data = $.parseJSON( data );
                returnData = data.initialPreview;
            });
            
            return returnData;
        }
        
        function initialPreviewConfig(){
            var returnData = Array();
            
            $.ajax({
                async: false,
                cache: false,
                processData: false,
                url: "{!! route('userAttachment.listUserAttachmentFileInput') !!}",
                method: "GET",
                data: {
                    '_token': '{!! csrf_token() !!}'
                },
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function( xhr ) {
                    //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                }
            })
            .done(function(data) {
                //console.log( "success" );
                //console.log(data);
            })
            .fail(function(data) {
                //console.log( "error" );
                //console.log(data);
            })
            .always(function(data) {
                //console.log( "complete" );
                //console.log(data);
                data = $.parseJSON( data );
                returnData = data.initialPreviewConfig;
            });
            
            return returnData;
        }
        /////////////////////////////////////////////////////////////////////    
        $("#var_user_attachment").fileinput({
            'theme': "fa",
            'previewClass': "",
            'uploadAsync': false,
            'previewFileType': 'any',
            'validateInitialCount': true,
            'initialPreviewAsData': true,
            'overwriteInitial': true,
            'required': false,
            'showUpload': false,
            'showRemove': false,
            'slugCallback': function(filename){return filename},
            'uploadUrl': "{!! route('userAttachment.listUserAttachmentFileInput') !!}",
            'testUrl': "{!! route('userAttachment.listUserAttachmentFileInput') !!}",
            'uploadExtraData': function() {
                return {
                    '_token': '{!! csrf_token() !!}'
                };
            },
            'initialPreview': [],
            'initialPreviewConfig': []
        })
        .on("filebeforedelete", function() {
            return new Promise(function(resolve, reject) {
                $.confirm({
                    title: 'Confirmation!',
                    content: 'Are you sure you want to delete this file?',
                    type: 'red',
                    buttons: {   
                        ok: {
                            btnClass: 'btn-primary text-white',
                            keys: ['enter'],
                            action: function(){
                                resolve();
                            }
                        },
                        cancel: function(){
                            $.alert("File deletion was aborted!");
                        }
                    }
                });
            });
        })
        .on('filedeleted', function() {
            setTimeout(function() {
                $.alert("File deletion was successful!");
            }, 900);
        })
        .on('filesorted', function(e, params) {
            console.log('file sorted', e, params);
        }).on('fileuploaded', function(e, params) {
            console.log('file uploaded', e, params);
        })
        .on('fileclear', function(event) {
            console.log("fileclear");
        })
        .on('filecleared', function(event) {
            console.log("filecleared");
        })
        .on('fileloaded', function(event, file, previewId, index, reader) {
            console.log("fileloaded");
        })
        .on('filebrowse', function(event) {
            console.log("File browse triggered.");
        })
        .on('filepreajax', function(event, previewId, index) {
            console.log('File pre ajax triggered');
        })
        .on('fileuploaded', function(event, data, previewId, index) {
            var form = data.form, files = data.files, extra = data.extra;
            var response = data.response, reader = data.reader;
            console.log('File uploaded triggered');
        })
        .on('filesorted', function(event, params) {
            console.log('File sorted ', params.previewId, params.oldIndex, params.newIndex, params.stack);
        })
        .fileinput("clear")
        //.fileinput("unlock")
        //.fileinput("disable")
        .fileinput("refresh", {showUpload: false})
        .fileinput("upload");
        
        $("#complete_date").datepicker({
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
        })
        .datepicker("setDate", moment('{!! $pDCA->complete_date !!}', 'YYYY-MM-DD HH:mm:ss').toDate())
        .trigger("changeDate")
        .datepicker("destroy")
        .attr("readonly","readonly");
        
        $('#formObject01').submit(function(event) {
            event.preventDefault();
        });
    });
    </script>
@endsection
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
                        <a data-toggle="collapse" data-parent="#collapseOneParent" href="#collapseOne"><span class="glyphicon glyphicon-plus"></span> Edit</a>
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
                                <form action="{!! route('pDCA.update', array('pDCA' => $pDCA->id)) !!}" method="POST" class="col-sm-9" autocomplete="off" id="formObject01" enctype="multipart/form-data">
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

    @includeIf('partials.pdca_own_user_select_destroy', array('optionSelectId' => 'own_user', 'pDCA' => $pDCA))
    @includeIf('partials.company_select', array('optionSelectId' => 'company_pk'))
    @includeIf('partials.department_select', array('optionSelectId' => 'department_pk'))
    <script>
        function getInitialPreview(){
            "use strict";
            
            var returnData = Array();
            
            $.ajax({
                async: false,
                cache: false,
                processData: false,
                url: "{!! route('userAttachment.listUserAttachmentFileInput', array('attachable_type' => get_class($pDCA), 'attachable_id' => $pDCA->id)) !!}",
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
                //var dataObj = $.parseJSON( data );
                var dataObj = data;
                returnData = dataObj.initialPreview;
            })
            .fail(function(data) {
                //console.log( "error" );
                //console.log(data);
            })
            .always(function(data) {
                //console.log( "complete" );
                //console.log(data);
            });
            
            return returnData;
        }
        
        function getInitialPreviewConfig(){
            "use strict";
            
            var returnData = Array();
            
            $.ajax({
                async: false,
                cache: false,
                processData: false,
                url: "{!! route('userAttachment.listUserAttachmentFileInput', array('attachable_type' => get_class($pDCA), 'attachable_id' => $pDCA->id)) !!}",
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
                //var dataObj = $.parseJSON( data );
                var dataObj = data;
                returnData = dataObj.initialPreviewConfig;
            })
            .fail(function(data) {
                //console.log( "error" );
                //console.log(data);
            })
            .always(function(data) {
                //console.log( "complete" );
                //console.log(data);
            });
            
            return returnData;
        }
    </script>
    <script>
    $(function() {
        "use strict";
        
        $("#var_user_attachment").fileinput({
            'theme': "fa",
            'dropZoneEnabled': true,
            'dropZoneClickTitle': false,
            'browseOnZoneClick': false,
            'dropZoneTitle': "",
            'previewClass': "",
            'uploadAsync': false,
            'previewFileType': 'any',
            'validateInitialCount': true,
            'initialPreviewAsData': true,
            'overwriteInitial': true,
            'autoReplace': false,
            'append': true,
            'required': false,
            'showPreview': true,
            'showUploadedThumbs': false,
            'showUploadedState': false,
            'showCancel': false,
            'showPause': false,
            'showClose': false,
            'showUpload': false,
            'showRemove': false,
            'showCaption': true,
            'showBrowse': true,
            'slugCallback': function(filename){return filename},
            'uploadUrl': "{!! route('userAttachment.listUserAttachmentFileInput', array('attachable_type' => get_class($pDCA), 'attachable_id' => $pDCA->id)) !!}",
            'testUrl': "{!! route('userAttachment.listUserAttachmentFileInput', array('attachable_type' => get_class($pDCA), 'attachable_id' => $pDCA->id)) !!}",
            'encodeUrl': true,
            'mergeAjaxCallbacks': true,
            'mergeAjaxDeleteCallbacks': true,
            'purifyHtml': true,
            'uploadExtraData': function() {
                return {
                    '_token': '{!! csrf_token() !!}'
                };
            },
            'deleteExtraData': function() {
                return {
                    '_token': '{!! csrf_token() !!}'
                };
            },
            'initialPreview': getInitialPreview(),
            'initialPreviewConfig': getInitialPreviewConfig(),
            'initialPreviewThumbTags': [],
            'initialPreviewShowDelete': false,
            layoutTemplates: {},
            fileActionSettings: {
                showUpload: false,
                showDownload: true,
                showRemove: true,
                showZoom: true,
                showDrag: false,
            }
        })
        .on("filebeforedelete", function() {
            return new Promise(function(resolve, reject) {
                 bootbox.confirm({
                        size: "small",
                        title: "Confirm",
                        message: "Are You Sure ?",
                        onEscape: true,
                        show: true,
                        scrollable: true,
                        buttons: {
                            confirm: {
                                label: 'Yes',
                                className: 'btn-success',
                                callback: function(){}
                            },
                            cancel: {
                                label: 'No',
                                className: 'btn-danger  btn-primary',
                                callback: function(){}
                            }
                        },
                        callback: function (result) {
                            //console.log('This was logged in the callback: ' + result);
                            if( result === true ){
                                resolve();
                            }
                        }
                    })
                        .find('.modal-header').addClass('bg-danger')
                        /*.find('.bootbox-cancel:first').focus()
                        .find('.bootbox-cancel').attr('autofocus', true)
                        .on('shown.bs.modal', function(e){
                            $(this).find(".bootbox-cancel:first").focus();
                        })*/
                        .init(function(e){
                            $(this).find(".bootbox-cancel").focus();
                        });
            });
        })
        .on('filedeleted', function() {
            setTimeout(function() {
                console.log("File deletion was successful!");
            }, 900);
        });
        //.attr("readonly", "readonly")
        //.attr("disabled", "disabled");
        //.fileinput("disable");
        
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
        }).datepicker("setDate", moment('{!! $pDCA->complete_date !!}', 'YYYY-MM-DD HH:mm:ss').toDate())
        .trigger("changeDate");
        
        $('#formObject01').submit(function(event) {});
    });
    </script>
@endsection
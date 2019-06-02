@php
    $dataTableId = isset($dataTableId) ? $dataTableId : 'dataTableId';
@endphp
<!-- script>
$(function(){
    "use strict";
    var dataTableUserList = $('#userDataTable').DataTable();
});
</script -->

<script>
$(function(){
    "use strict";
    //$.fn.dataTable.ext.errMode = 'none';
    //$.fn.dataTableExt.errMode = 'ignore';
    $.fn.dataTableExt.sErrMode = "console";
    var dataTableObject = $('#{!! $dataTableId !!}').DataTable({
        'language' : {
            'lengthMenu' : 'Show _MENU_ Entries'
        },
        'columns' : [/*{
            'title' : '',
            'className' : 'details-control',
            'orderable' : false,
            'className' : 'center',
            'data' : null,
            'defaultContent' : '',
            'render' : function(data, type, row){
                //$.fn.dataTable.render.number( ',', '.', 0, '$' );
                return data.epf_no;
            }
        },*/{
            'title' : 'Company',
            'orderable' : false,
            'data' : 'p_d_c_a_company_departments',
            'render' : function(data, type, row){
                //return data;
                var data_str = '';
                if(($.isArray(data))){
                    $.each(data, function( key, value ){
                        var formatted_data = value.company_pk;
                        data_str =  formatted_data + ' <br/> ' + data_str;
                    });
                }else{
                    data_str = data.company_pk;
                }
                
                return data_str;
            }
        },{
            'title' : 'Department',
            'orderable' : false,
            'data' : 'p_d_c_a_company_departments',
            'render' : function(data, type, row){
                //return data;
                var data_str = '';
                if(($.isArray(data))){
                    $.each(data, function( key, value ){
                        var formatted_data = value.department_pk;
                        data_str =  formatted_data + ' <br/> ' + data_str;
                    });
                }else{
                    data_str = data.department_pk;
                }
                
                return data_str;
            }
        },{
            'title' : 'User',
            'orderable' : false,
            'data' : 'p_d_c_a_users',
            'render' : function(data, type, row){
                //return data;
                var data_str = '';
                if(($.isArray(data))){
                    $.each(data, function( key, value ){
                        var formatted_data = value.own_user;
                        formatted_data = formatted_data.substring(0, formatted_data.lastIndexOf('@'));
                        data_str =  formatted_data + ' <br/> ' + data_str;
                    });
                }else{
                    data_str = data.own_user;
                }
                
                return data_str;
            }
        },{
            'title' : 'Title',
            'orderable' : false,
            'data' : 'title',
            'render' : function(data, type, row){
                return data;
            }
        },{
            'title' : 'Description',
            'orderable' : false,
            'data' : 'description',
            'render' : function(data, type, row){
                return data;
            }
        },{
            'title' : 'Date',
            'orderable' : false,
            'data' : 'complete_date',
            'render' : function(data, type, row){
                //return data;
                var date = moment(data, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD');
                return date;
            }
        },{
            'title' : '',
            'orderable' : false,
            'className' : 'center',
            'data' : null,
            'render' : function(data, type, row){
                return '';
            }
        }],
        'responsive' : false,
        'scrollX' : true,
        'paging' : true,
        'lengthChange' : true,
        'lengthMenu' : [[5, 10, 25, 50, 100, {!! PHP_INT_MAX !!}], [5, 10, 25, 50, 100, 'all']],
        'searching' : true,
        'ordering' : false,
        'info' : true,
        'autoWidth' : true,
        'processing' : false,
        'serverSide' : true,
        'jQueryUI' : false,
        'initComplete' : function(){
            //console.log("initComplete");
            //$(this).show();
        },
        'ajax' : {
            'url' : "{!! route('pDCA.list') !!}",
            'cache' : true,
            'dataSrc' : 'data',
            'type' : 'GET',
            'deferRender' : true,
            //'dataType' : 'json',
            'delay' : 300,
            'data' : function(data){
                //console.log(data);
                var tableObj = $('#{!! $dataTableId !!}');
                var tableObjData = {};
                var tableObjDataTemp = tableObj.data();
                tableObj.removeData();
                //data.created_user = "{!! $auth_user->mail or null !!}";
                if( tableObjDataTemp.hasOwnProperty('own_user') ){
                    tableObjData.own_user = tableObjDataTemp.own_user;
                }
                if( tableObjDataTemp.hasOwnProperty('company_pk') ){
                    tableObjData.company_pk = tableObjDataTemp.company_pk;
                }
                if( tableObjDataTemp.hasOwnProperty('department_pk') ){
                    tableObjData.department_pk = tableObjDataTemp.department_pk;
                }
                if( tableObjDataTemp.hasOwnProperty('title') ){
                    tableObjData.title = tableObjDataTemp.title;
                }
                if( tableObjDataTemp.hasOwnProperty('complete_date') ){
                    tableObjData.complete_date = tableObjDataTemp.complete_date;
                }
                if( tableObjDataTemp.hasOwnProperty('description') ){
                    tableObjData.description = tableObjDataTemp.description;
                }
                
                data = $.extend(data, tableObjData);
            },
            'error' : function(e){
                //console.log(e);
            }
        },
        'rowCallback' : function(row, data, displayNum, displayIndex, dataIndex){},
        'createRow' : function(row, data, dataIndex){},
        //'order' : [[1, 'asc']],
        'columnDefs' : [{
            'targets' : [0],
            'responsivePriority' : 1,
            //'width' : '10%'
        },{
            'targets' : [0, 1],
            'responsivePriority' : 1,
            'width' : '15%'
        },{
            'targets' : [3, 4],
            'responsivePriority' : 1,
            //'width' : '20%'
        },{
            'targets' : [-1],
            'responsivePriority' : 2,
            'visible' : true,
            //'width' : '250px',
            'data' : null, // Use the full data source object for the renderer's source
            'createdCell' : function(td, cellData, rowData, row, col){
                var parentTd = $(td);
                parentTd.empty();
                
                //var date = moment(data.date, 'YYYY-MM-DD HH:mm:ss').toDate();
                //var today = moment().format('YYYY-MM-DD');
                //var date = moment(rowData.date, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD');
                
                var buttonToolbar = $('<div></div>');
                buttonToolbar.addClass('btn-toolbar');//pull-left
                //button group
                var buttonGroup_1 = $('<div></div>');
                buttonGroup_1.addClass('btn-group');
                var button_1 = $('<button></button>');
                button_1.addClass('btn btn-info btn-sm');
                var button_1_body = $('<i></i>');
                button_1_body.addClass('fa fa-edit');
                button_1_body.attr('data-toggle', 'tooltip');
                button_1_body.attr('data-placement', 'auto');
                button_1_body.attr('data-container', 'body');
                //button_1_body.attr('title', 'title');
                button_1_body.attr('data-title', 'Edit');
                //button_1_body.attr('data-content', 'content');
                button_1_body.tooltip();
                //button_1_body.text('text');
                button_1.bind("click", function(){
                    var url = "{!! route('pDCA.edit', ['#pDCA']) !!}";
                    url = url.replace("#pDCA", encodeURIComponent(rowData.id));
                    $( location ).attr("href", url);
                });
                button_1.append(button_1_body);
                buttonGroup_1.append(button_1);
                
                //button group
                var buttonGroup_2 = $('<div></div>');
                buttonGroup_2.addClass('btn-group');
                var button_2 = $('<button></button>');
                button_2.addClass('btn btn-danger btn-sm');
                var button_2_body = $('<i></i>');
                button_2_body.addClass('fa fa-trash-o');
                button_2_body.attr('data-toggle', 'tooltip');
                button_2_body.attr('data-placement', 'auto');
                button_2_body.attr('data-container', 'body');
                //button_2_body.attr('title', 'title');
                button_2_body.attr('data-title', 'Delete');
                //button_2_body.attr('data-content', 'content');
                button_2_body.tooltip();
                button_2.bind("click", function(){
                    button_2.attr("disabled", true);
                    bootbox.confirm({
                        size: "small",
                        title: "Confirm",
                        message: "Are You Sure That You Want to Delete <br/><strong>" + rowData.title + "</strong> ?",
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
                                className: 'btn-danger btn-primary',
                                callback: function(){}
                            }
                        },
                        callback: function (result) {
                            //console.log('This was logged in the callback: ' + result);
                            if( result === true ){
                                var url = "{!! route('pDCA.destroy', ['#pDCA']) !!}";
                                url = url.replace("#pDCA", encodeURIComponent(rowData.id));
                                //$( location ).attr("href", url);
                                
                                $.ajax({
                                    type: "GET",
                                    url: url,
                                    data: null,
                                    //success: success,
                                    //dataType: dataType,
                                    //context: document.body
                                })
                                .done(function( data ) {
                                    swal({
                                        'title': data.title,
                                        'text': data.text,
                                        'type': data.type,
                                        'timer': data.timer,
                                        'showConfirmButton': false
                                    });
                                    $('#{!! $dataTableId !!}').DataTable().ajax.reload( null, false ); // user paging is not reset on reload
                                })
                                .fail(function() {
                                    //console.log( "error" );
                                })
                                .always(function() {
                                    //console.log( "finished" );
                                    button_2.attr("disabled", false);
                                });
                                
                            }else{
                                button_2.attr("disabled", false);
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
                button_2.append(button_2_body);
                buttonGroup_2.append(button_2);
                
                //button group
                var buttonGroup_3 = $('<div></div>');
                buttonGroup_3.addClass('btn-group');
                var button_3 = $('<button></button>');
                button_3.addClass('btn btn-success btn-sm');
                var button_3_body = $('<i></i>');
                button_3_body.addClass('fa fa fa-eye');
                button_3_body.attr('data-toggle', 'tooltip');
                button_3_body.attr('data-placement', 'auto');
                button_3_body.attr('data-container', 'body');
                //button_3_body.attr('title', 'title');
                button_3_body.attr('data-title', 'View');
                //button_3_body.attr('data-content', 'content');
                button_3_body.tooltip();
                //button_3_body.text('text');
                button_3.bind("click", function(){
                    var url = "{!! route('pDCA.show', ['#pDCA']) !!}";
                    url = url.replace("#pDCA", encodeURIComponent(rowData.id));
                    $( location ).attr("href", url);
                });
                button_3.append(button_3_body);
                buttonGroup_3.append(button_3);
                
                buttonToolbar.append(buttonGroup_1);
                buttonToolbar.append(buttonGroup_2);
                buttonToolbar.append(buttonGroup_3);
                
                var popoverButtonToolbar = $('<div></div>');
                popoverButtonToolbar.addClass('btn-toolbar pull-left');
                var popoverButtonGroup_1 = $('<div></div>');
                popoverButtonGroup_1.addClass('btn-group');
                
                var popoverToggleButton = $('<button></button>');
                var popoverToggleButtonId = 'id-' + moment().format('HH-mm-ss-SSS');
                popoverToggleButton.addClass('btn btn-primary btn-sm my-popover');
                popoverToggleButton.attr('id', popoverToggleButtonId);
                popoverToggleButton.attr('data-toggle', 'popover');
                popoverToggleButton.attr('data-placement', 'auto');
                popoverToggleButton.attr('data-container', 'body');
                var popoverToggleButtonSpan = $('<span></span>');
                popoverToggleButtonSpan.addClass('fa fa-gears');
                
                popoverToggleButton.popover({
                    html: true, 
                    content: function() {
                        //var content_string = buttonToolbar.html();
                        return buttonToolbar;
                    }
                });

                popoverToggleButton.append(popoverToggleButtonSpan);
                popoverButtonGroup_1.append(popoverToggleButton);
                popoverButtonToolbar.append(popoverButtonGroup_1);
                popoverButtonToolbar.appendTo(parentTd);
            }
        }],
        'drawCallback' : function(settings){
            var api = this.api();
            var table = api.table();
        }
    });
    
    $('#{!! $dataTableId !!}').closest('.collapse').on('show.bs.collapse', function(){
        dataTableObject.table().columns.adjust().draw();
    });
});
</script>

<template id="formTemplate_{!! $dataTableId !!}">
  
    <!-- --- -->
    <!-- row -->
    <div class="row">

        <!-- col -->
        <div class="col-sm-12">
            <!-- form -->
            
            <!-- /.form -->
        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->
    <!-- --- -->
    
</template>
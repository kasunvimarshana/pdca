@php
    $optionSelectId = isset($optionSelectId) ? $optionSelectId : 'optionSelectId';
@endphp
<script>
$(function(){
    "use strict";
    $.fn.select2.defaults.set( "theme", "bootstrap" );
    /*$('#id').select2({
        theme: "bootstrap"
    });*/
    
    var optionSelectObject = $('#{!! $optionSelectId !!}').select2({
        ajax          : {
            url: "{!! route('user.list') !!}", //user.list
            cache: true,
            // dataType: 'json',
            delay: 50,
            data: function (params) {
                var query = {
                    search			: params.term, // $.trim(params.term)
                    active		    : 1,
                    page  			: params.page || 1,
                    length			: 10
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.data, function (obj) {
                        return { 
                            id  : obj.mail, 
                            text: obj.mail + ' | ' + obj.displayname || obj.employeenumber, 
                            data: obj 
                        };
                    }),
                    pagination: {
                        more: (params.page * data.length) < Number(data.recordsTotal)
                    }
                };
            },
            cache: true
        },
        placeholder	      : 'Select Type',
        minimumInputLength: 2,
        multiple		  : true,
        closeOnSelect	  : true,
        allowClear	  : true,
        escapeMarkup      : function (markup) { return markup; }
    })
    .on("select2:unselecting", function(e){
        $(this).on('select2:opening', function(e) {
            e.preventDefault();
        });
        var selectObj = $('#{!! $optionSelectId !!}');
        var selected_value = $('#{!! $optionSelectId !!}').val();
        var unselected_value = e.params.args.data.id;
        e.preventDefault();
        
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
                    var url = "{!! route('pDCAUser.destroy', ['#pDCAUser']) !!}";
                    url = url.replace("#pDCAUser", encodeURIComponent(unselected_value));
                    //$( location ).attr("href", url);

                    $.ajax({
                        type: "GET",
                        url: url,
                        data: {
                            '_token': '{!! csrf_token() !!}',
                            'p_d_c_a_id': '{!! $pDCA->id !!}'
                        },
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

                        selected_value.splice($.inArray(unselected_value, selected_value),1);
                        selectObj.val(selected_value).trigger("change");
                    })
                    .fail(function() {
                        //console.log( "error" );
                    })
                    .always(function() {
                        //console.log( "finished" );
                    });
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
        
    })
    .trigger('change');
    
});
</script>
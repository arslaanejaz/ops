<script>
    $(document).ready(function () {
        $('.delete-check').change(function () {
            var output = $.map($(':checkbox[name=delete_check\\[\\]]:checked'), function(n, i){
                return n.value;
            }).join(',');
            $('#delete_check_list').val(output);
        })
    })

</script>
{!! Form::open([
                    'method'=>'POST',
                    'url' => ['remove_all'],
                    'style' => 'display:inline',
                    'class' => 'pull-right'
                ]) !!}
<input type="hidden" name="collection" value="{{$_collection}}">
<input type="hidden" id="delete_check_list" name="delete_check_list" value="">
<input type="hidden" name="back_link" value="{{$_backLink}}">
{!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xl',
        'title' => 'Delete Link',
        'onclick'=>'return confirm("Confirm delete all selected rows?")'
)) !!}
{!! Form::close() !!}
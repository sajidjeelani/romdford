
<script>

    $(document).ready(function() {
      var fieldValue = '';
      $('#{{$item->id}}').on('focus', function() {
        fieldValue = $(this).val();
      });
      $('#{{$item->id}}').on('focusout', function() {
        var newFieldValue = $(this).val();
        var id={{$item->id}};
        if (fieldValue !== newFieldValue) {
        $('script').remove();
        console.log($(this).val())
          // Redirect to the desired page using window.location.href
          $.post('../../tables/updateQuantity/'+id, {
              param2: $(this).val()
            }, function(response) {
                window.alert("Updated Successfully");
            }).fail(function(xhr, status, error) {
                window.alert($(this).val());
            });
        }
      });
    });
    
</script>
 <input type="text" id="{{$item->id}}" style="
    background: none;
    border: none;
    text-align: center;
    width: 35%;
" value='{{ $item->quantity }}' />
<label style='display: none'>{{ $item->quantity }}</label>
<input value='{{$item->id}}' id='id' style='display: none' />
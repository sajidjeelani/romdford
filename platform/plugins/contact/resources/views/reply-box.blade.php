@if ($contact)
    <div id="reply-wrapper">
        @if (count($contact->replies) > 0)
            @foreach($contact->replies as $reply)
                <p>{{ trans('plugins/contact::contact.tables.time') }}: <i>{{ $reply->created_at }}</i></p>
                <p>{{ trans('plugins/contact::contact.tables.content') }}:</p>
                <pre class="message-content">{!! clean($reply->message) !!}</pre>
                <p>{{ trans('Attachment') }}: <a href={{ (url('/').'/storage/contact_reply/'.$reply->attachment) }} target="_blank" rel="noopener noreferrer">{!! clean($reply->attachment) !!}</a></p>
            @endforeach
        @else
            <p>{{ trans('plugins/contact::contact.no_reply') }}</p>
        @endif
    </div>

    
    <p><button class="btn btn-info answer-trigger-button">{{ trans('plugins/contact::contact.reply') }}</button></p>

    <div class="answer-wrapper">
        
        <div class="form-group">
            <textarea id="message" name="message" style="width: 100%; height: 70vh;"></textarea>
            <input type='file' id="attachment" name="attachment">
        </div>
        <div class="row">
            <button type="button" class="btn btn-primary col-md-4" style="width: 43%;margin-left: 0%;margin-bottom: 2%;" onclick="resetFileInput()">Remove Image</button>
        </div>
        <div class="form-group">
            <input type="hidden" value="{{ $contact->id }}" id="input_contact_id">
            <button class="btn btn-success answer-send-button"><i class="fas fa-reply"></i> {{ trans('plugins/contact::contact.send') }}</button>
        </div>
    </div>
    <script>
        window.onload=myfunc();
        function myfunc(){
            document.getElementById("botble-contact-forms-contact-form").setAttribute("enctype","multipart/form-data")
        }
        
 function resetFileInput() {
            // Reset the value of the file input element
            document.getElementById("attachment").value = "";
        }
    </script>
@endif
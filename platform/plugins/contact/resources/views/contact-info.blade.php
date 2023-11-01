@if ($contact)
    <p>{{ trans('Time') }}: <i>{{ $contact->created_at }}</i></p>
    <p>{{ trans('Reference Number') }}: <i>{{ $contact->name }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.email') }}: <i><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></i></p>
    <!--<p>{{ trans('plugins/contact::contact.tables.phone') }}: <i>@if ($contact->phone) <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a> @else N/A @endif</i></p>-->
    <p>{{ trans('File') }}: <a href={{ (url('/').'/storage/contact/'.$contact->address) }} target="_blank" rel="noopener noreferrer">{{ $contact->address }}</a></p>
    <p>{{ trans('plugins/contact::contact.tables.subject') }}: <i>{{ $contact->subject ? $contact->subject : 'N/A' }}</i></p>
    <p>{{ trans('Message') }}:</p>
    <pre class="message-content">{{ $contact->content ? $contact->content : '...' }}</pre>
@endif

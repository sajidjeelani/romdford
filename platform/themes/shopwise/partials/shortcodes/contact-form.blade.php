<!-- START SECTION CONTACT -->
<div class="section bg-white p-5">
    <div class="row">
        <div class="col-12">
            <div class="col-xl-7 col-lg-8 col-md-9 col-11 ">
                <h1>{{ __('SEND A MESSAGE') }}</h1>
            </div>
            <div class="field_form">
                {!! Form::open(['route' => 'public.send.contact', 'class' => 'form--contact contact-form', 'method' => 'POST' , 'enctype' => 'multipart/form-data']) !!}
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_subject" class="control-label">{{ __('Subject') }}</label>
                                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" id="contact_subject"
                                       placeholder="{{ __('Subject') }}">
                            </div>
                            <div class="form-group">
                                <label for="contact_email" class="control-label ">{{ __('Email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="contact_email"
                                       placeholder="{{ __('Email') }}">
                            </div>
                            <div class="form-group">
                                <label for="contact_name" class="control-label ">{{ __('Reference Number') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="contact_name">
                            </div>
                            <div class="form-group">
                                <label for="contact_address" class="control-label">{{ __('Attach file') }}</label>
                                <div class="row">
                                    <input type="file" class="form-control col-md-8" style="height: 20%;" name="address" value="{{ old('address') }}" id="contact_address">
                                    <button type="button" class="btn btn-primary col-md-4" onclick="resetFileInput()">Remove Image</button>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-6">-->
                        <!--    -->
                        <!--</div>-->
                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group">-->
                        <!--        <label for="contact_phone" class="control-label">{{ __('Phone') }}</label>-->
                        <!--        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" id="contact_phone"-->
                        <!--               placeholder="{{ __('Phone') }}">-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_content" class="control-label ">{{ __('Message') }}</label>
                                <textarea name="content" id="contact_content" class="form-control" rows="5" placeholder="{{ __('Message') }}">{{ old('content') }}</textarea>
                            </div>
                        </div>
                        @if (setting('enable_captcha') && is_plugin_active('captcha'))
                            <div class="form-group col-12">
                                {!! Captcha::display() !!}
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary sing-up">{{ __('Send') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="contact-message contact-success-message" style="display: none"></div>
                        <div class="contact-message contact-error-message" style="display: none"></div>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script>
    
 function resetFileInput() {
            // Reset the value of the file input element
            document.getElementById("contact_address").value = "";
        }
</script>
<!-- END SECTION CONTACT -->
@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8" id="form_top">
        <div>
            <x-card title="<span>Options</span>" classes="border border-info">

                <div class="container-fluid px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />
                    <form enctype="multipart/form-data" autocomplete="off" class="needs-validation row" novalidate=""
                        method="post" action="{{ route('settings.store') }}">
                        @csrf
                        <div class="col-md-12 order-md-1">
                            <div>
                                <div class="row mb-4">
                                    <div class="col-md-4 mb-3">
                                        <label for="application_name">Application Name</label>
                                        <input type="text" class="form-control" name="application_name"
                                            id="application_name" placeholder="Ticket Title"
                                            value="{{ isset($options['application_name']) ? $options['application_name'] : '' }}"
                                            required ="">
                                        <div class="invalid-feedback">
                                            Name is .
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="application_logo">Application Logo</label>
                                        <input type="file" class="form-control" name="application_logo"
                                            id="application_logo" placeholder="Ticket Title"
                                            value="{{ isset($options['application_logo']) ? $options['application_logo'] : '' }}">

                                    </div>

                                    <div class="col-md-4 mb-3">

                                        <label for="client_side">Client Side</label>
                                        <select class="custom-select d-block w-100" name="client_side" id="client_side">
                                            <option @selected(isset($options['client_side']) && $options['client_side'] == 'enable') value="enable">Enable</option>
                                            <option @selected(isset($options['client_side']) && $options['client_side'] == 'disable') value="disable">Disable</option>

                                        </select>

                                    </div>



                                </div>


                                <div class="row mb-4">


                                    <div class="col-md-4 mb-3">

                                        <label for="enable_chatgpt">Enable ChatGPT</label>

                                        <select class="custom-select d-block w-100" name="enable_chatgpt"
                                            id="enable_chatgpt">

                                            <option @selected(isset($options['enable_chatgpt']) && $options['enable_chatgpt'] == 'enable') value="enable">Enable</option>
                                            <option @selected(isset($options['enable_chatgpt']) && $options['enable_chatgpt'] == 'disable') value="disable">Disable</option>

                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Deadline.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">

                                        <label for="openai_api_key">ChatGPT Key</label>
                                        <input type="text" class="form-control" name="openai_api_key" id="openai_api_key"
                                            placeholder="OpenAI API KEY"
                                            value="{{ isset($options['openai_api_key']) ? $options['openai_api_key'] : '' }}">

                                    </div>

                                    <div class="col-md-4 mb-3">

                                        <label for="openai_organisation_id">ChatGPT Organisation ID</label>
                                        <input type="text" class="form-control" name="openai_organisation_id"
                                            id="openai_organisation_id" placeholder="OpenAI API KEY"
                                            value="{{ isset($options['openai_organisation_id']) ? $options['openai_organisation_id'] : '' }}">

                                    </div>

                                </div>


                                <div class="row mb-4">


                                    <div class="col-md-4 mb-3">

                                        <label for="enable_twilio">Enable Twilio</label>

                                        <select class="custom-select d-block w-100" name="enable_twilio" id="enable_twilio">

                                            <option @selected(isset($options['enable_twilio']) && $options['enable_twilio'] == 'enable') value="enable">Enable</option>
                                            <option @selected(isset($options['enable_twilio']) && $options['enable_twilio'] == 'disable') value="disable">Disable</option>

                                        </select>
                                        <div class="invalid-feedback">
                                            Please select an Option
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">

                                        <label for="twilio_key">Twilio Key</label>
                                        <input type="text" class="form-control" name="twilio_key" id="twilio_key"
                                            placeholder="Twilio API KEY"
                                            value="{{ isset($options['twilio_key']) ? $options['twilio_key'] : '' }}">

                                    </div>

                                    <div class="col-md-4 mb-3">

                                        <label for="twilio_sid">Twilio SID</label>
                                        <input type="text" class="form-control" name="twilio_sid" id="twilio_sid"
                                            placeholder="Twilio SID"
                                            value="{{ isset($options['twilio_sid']) ? $options['twilio_sid'] : '' }}">

                                    </div>

                                </div>

                                <div class="row">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Add Ticket</button>

                                </div>


                            </div>
                        </div>
                    </form>

                </div>

            </x-card>


        </div>
    </div>





    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
@endsection





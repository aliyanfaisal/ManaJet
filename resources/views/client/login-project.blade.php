@extends('layouts.guest_app')

@section('content')
<div class="container" style="min-height: 80vh">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 text-center">Project Details</h3>
                                </div>
                                <div class="card-body">
                                
                                    
                                    @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">:message</div>')) !!}
                                    @endif

                                    @if(session()->has("message"))
                                     <div class="alert alert-danger" role="alert">{{session()->get("message")}}</div>'
                                    @endif

                                    <form  action="{{ route('client.verify') }}" method="post">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <label for="secret_key">Project Secret ID</label>
                                            <input class="form-control" id="secret_key"  name="secret_key" type="text" placeholder="Secret Key Provided" />
                                            
                                        </div> 
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            
                                            <button class="btn btn-primary">Check</button>
                                        </div>
                                    </form>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
      
    </div>
</div>
@endsection

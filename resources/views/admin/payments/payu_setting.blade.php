@extends('layouts.admin')

@section('title', 'PayU Setting')
@section('style')
    <style>
        .font-size-10 {
            font-size: 10px;
        }
    </style>
@endsection

@section('subtitle', 'PayU Setting')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Secure</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.payu.save') }}">
                            @csrf
                            <input type="hidden" value="secure" name="environment">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="pos_id">Merchant PosID <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" class="form-control" value="{{ $payu_secure?$payu_secure->merchantPosId:'' }}"
                                           name="merchantPosId" placeholder="Pos Id" required>
                                </div>
                                <div class="form-group">
                                    <label for="signatureKey">Signature Key <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" value="{{ $payu_secure?$payu_secure->signatureKey:'' }}" class="form-control"
                                           name="signatureKey" placeholder="Signature Key" required>
                                </div>
                                <div class="form-group">
                                    <label for="oAuthClientId">OAuth ClientId <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" value="{{ $payu_secure?$payu_secure->oAuthClientId:'' }}" class="form-control"
                                           name="oAuthClientId"  placeholder="Oauth ClientId" required>
                                </div>
                                <div class="form-group">
                                    <label for="oAuthClientSecret">Oauth Client Secret <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" value="{{ $payu_secure?$payu_secure->oAuthClientSecret:'' }}" class="form-control"
                                           name="oAuthClientSecret" placeholder="Oauth Client Secret" required>
                                </div>

                                <div class="form-group">
                                    <label for="oAuthGrantType">Oauth GrantType</label>
                                    <select type="text" class="form-control"
                                            name="oAuthGrantType">
                                        <option value="client_credentials" @if($payu_secure && $payu_secure->oAuthGrantType==='client_credentials') selected @endif>Client credentials</option>
                                        <option value="trusted_merchant" @if($payu_secure && $payu_secure->oAuthGrantType==='trusted_merchant') selected @endif>Trusted merchant</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="oAuthEmail">Oauth Email</label>
                                    <input type="text" value="{{ $payu_secure?$payu_secure->oAuthEmail:'' }}" class="form-control"
                                           name="oAuthEmail" placeholder="Oauth Email">
                                </div>

                                <div class="form-group">
                                    <label for="oAuthExtCustomerID">Oauth ExtCustomerID</label>
                                    <input type="text" value="{{ $payu_secure?$payu_secure->oAuthExtCustomerID:'' }}" class="form-control"
                                           name="oAuthExtCustomerID" placeholder="Oauth ExtCustomerId">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sandbox</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.payu.save') }}">
                            @csrf
                            <input type="hidden" value="sandbox" name="environment">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="pos_id">Merchant PosID <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" class="form-control" value="{{ $payu_sandbox?$payu_sandbox->merchantPosId:'' }}"
                                           name="merchantPosId" placeholder="Pos Id" required>
                                </div>
                                <div class="form-group">
                                    <label for="signatureKey">Signature Key <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" value="{{ $payu_sandbox?$payu_sandbox->signatureKey:'' }}" class="form-control"
                                           name="signatureKey" placeholder="Signature Key" required>
                                </div>
                                <div class="form-group">
                                    <label for="oAuthClientId">OAuth ClientId <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" value="{{ $payu_sandbox?$payu_sandbox->oAuthClientId:'' }}" class="form-control"
                                           name="oAuthClientId"  placeholder="Oauth ClientId" required>
                                </div>
                                <div class="form-group">
                                    <label for="oAuthClientSecret">Oauth Client Secret <span class="fa fa-asterisk text-danger font-size-10"></span></label>
                                    <input type="text" value="{{ $payu_sandbox?$payu_sandbox->oAuthClientSecret:'' }}" class="form-control"
                                           name="oAuthClientSecret" placeholder="Oauth Client Secret" required>
                                </div>

                                <div class="form-group">
                                    <label for="oAuthGrantType">Oauth GrantType</label>
                                    <select type="text" class="form-control"
                                            name="oAuthGrantType">
                                        <option value="client_credentials" @if($payu_sandbox && $payu_sandbox->oAuthGrantType==='client_credentials') selected @endif>Client credentials</option>
                                        <option value="trusted_merchant" @if($payu_sandbox && $payu_sandbox->oAuthGrantType==='trusted_merchant') selected @endif>Trusted merchant</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="oAuthEmail">Oauth Email</label>
                                    <input type="text" value="{{ $payu_sandbox?$payu_sandbox->oAuthEmail:'' }}" class="form-control"
                                           name="oAuthEmail" placeholder="Oauth Email">
                                </div>

                                <div class="form-group">
                                    <label for="oAuthExtCustomerID">Oauth ExtCustomerID</label>
                                    <input type="text" value="{{ $payu_sandbox?$payu_sandbox->oAuthExtCustomerID:'' }}" class="form-control"
                                           name="oAuthExtCustomerID" placeholder="Oauth ExtCustomerId">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
@endsection

@extends('layouts.admin')

@section('title', 'Settings')

@section('subtitle', 'Settings')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.settings.save') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="environment">PayU Environment</label>
                                    <select class="form-control" name="environment">
                                        <option value="Development" {{ $setting->environment == 'Development'  ? 'selected' : ''}}>Development</option>
                                        <option value="Production" {{ $setting->environment == 'Production'  ? 'selected' : ''}}>Production</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="environment">Email Verification (Registration Only)</label>
                                    <select class="form-control" name="email_verification">
                                        <option value="active" {{ $setting->email_verification == 'active'  ? 'selected' : ''}}>Active</option>
                                        <option value="inactive" {{ $setting->email_verification == 'inactive'  ? 'selected' : ''}}>Inactive</option>
                                    </select>
                                </div>
		                        <div class="form-group">
                                    <label for="exampleInputPassword1">PayU Fee (%)</label>
                                    <input type="number" min="0" max="100" value="0" class="form-control"
                                           step="0.01" placeholder="PayU Fee">
                                </div>
                                <div class="form-group">
                                    <label for="ratelimit">Maximum Price per 1000 zzs (Marketplace Only)</label>
                                    <input type="number" class="form-control" min="0" step="0.01" value="{{ $setting?$setting->ratelimit:0 }}"
                                           name="ratelimit" id="ratelimit" placeholder="Enter Maximum Rate">
                                </div>

                                <div class="form-group">
                                    <label for="order_deadline_hours">Max Time for Order Delivery</label>
                                    <input type="number" class="form-control" min="0" value="{{ $setting?$setting->order_deadline_hours:0 }}"
                                           name="order_deadline_hours" id="order_deadline_hours" placeholder="Enter Maximum Hours">
                                </div>
                                 <div class="form-group">
                                    <label for="order_deadline_hours">Max Orders per Copywriter (Active Currently)</label>
                                    <input type="number" class="form-control" min="0" value="5" placeholder="Enter Maximum Open Orders">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Fee (%)</label>
                                    <input type="number" min="0" max="100" value="{{ $setting?$setting->fee:0 }}" class="form-control"
                                           step="0.01" name="fee" id="fee" placeholder="Project Fee">
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
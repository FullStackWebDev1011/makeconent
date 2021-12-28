@extends('layouts.main')
@section('content')
<section class="admin-content">
        <div class="bg-dark m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-md-6 text-white p-b-30">
                        <div class="media">
                            <div class="avatar mr-3  avatar-xl">

                                @if($user->avatar)
                                    <img src="{{asset($user->avatar)}}" alt="{{ $user->fullname }}" class="avatar-img rounded-circle">
                                @else
                                    <img src="/assets/img/users/user-3.jpg" alt="{{ $user->fullname }}" class="avatar-img rounded-circle">
                                @endif
                            </div>
                            <div class="media-body m-auto">
                                <h5 class="mt-0">{{ $user->fullname }} <img src="https://twemoji.maxcdn.com/2/72x72/1f397.png"
                                                                      width="20" alt=""></h5>
                                <div class="opacity-75">{{ $user->getCategoriesTitle() }}</div><br>
				     <div class="opacity-75">{{ $user->about }}</div>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
        <div class="container pull-up">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Single post-->
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="media">
                                
                                <div class="media-body m-auto">
                                    <h5 class="m-0"> Your Last Revievs </h5>
                                    
                                </div>
                            </div>

                            
                        </div>
                        <div class="card-raw">


                        </div>
                        <div class="card-body">
                            
                          
                            
                            
                            <div>
                                <div class="list-unstyled">
                                    @foreach($user->reviews as $review)
                                    <div class="media">
                                        <div class="avatar mr-3  avatar-sm">
                                            <img src="/assets/img/users/user-1.jpg" alt="..."  class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1"> {{ $review->owner->getFullName() }} <i style="color:#ffcc4d;" class="mdi mdi-star"></i>
 <i style="color:#ffcc4d;" class="mdi mdi-star"></i>
 <i style="color:#ffcc4d;" class="mdi mdi-star"></i>
 <i style="color:#ffcc4d;" class="mdi mdi-star"></i>
 <i style="color:#ffcc4d;" class="mdi mdi-star"></i>{{ $review->rate }}<span class="text-muted ml-3 small">{{ $review->created_at->diffForHumans() }}</span>
                                            </h6>
                                            <p>
                                                {{ $review->comment }}
                                            </p>
                                        </div>
                                    </div>
									<hr>
                                    @endforeach
                                </div>
                            </div>
                           
                             <!-- / .row -->

                        </div>
                    </div>

                   
                    

                </div>

                <div class="col-lg-4">

                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="avatar mr-2 avatar-xs">
                                <div class="avatar-title bg-dark rounded-circle">
                                    <i class="mdi mdi-account-star mdi-18px"></i>
                                </div>
                            </div>
                            Rating Review
                        </div>
                        <div class="list-group list  list-group-flush">

                            <div class="list-group-item ">
                                <i class="mdi mdi-account-star"></i> User Rate: <a href="#" class="text-underline" data-toggle="tooltip" data-placement="top"
                                    title="{{__('main.grades_indicator_info')}}"> {{ $user->rate / 100 }} / 5.00</a>
                            </div>
                            <div class="list-group-item ">
                                 Accepted: <a href="#" class="text-success" data-toggle="tooltip" data-placement="top"
                                    title="{{__('main.number_approved_client')}}">
                                    <i class="mdi mdi-check-circle "></i> {{ $user->accepted }}</a>
                            </div>
                            <div class="list-group-item ">
                               Declined: <a href="#" class="text-danger"  data-toggle="tooltip" data-placement="top"
                                    title="{{__('main.number_rejected_client')}}" >
                                    <i class="mdi mdi-close-circle "></i> {{ $user->declined }}</a>
                            </div>
                            <div class="list-group-item " data-toggle="tooltip" data-placement="top"
                                    title="{{__('main.ic_info')}}">
                                 I/C % Rate: <a href="#" class="text-underline"> {{ $user->getICRateText() }}</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

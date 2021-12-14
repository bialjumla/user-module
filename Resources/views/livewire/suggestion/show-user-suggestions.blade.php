<div class="tab-pane fade" id="suggestions" wire:ignore.self>
    <div class="main-wraper">
        <h3 class="main-title">المُقترحات</h3>
        <div class="row merged-10">
            <div class="col-lg-4">
                <figure class="research-avatar">
                    <a class="uk-inline" href="{{ asset('images/resources/image1.jpg') }}" data-fancybox="">
                        <img src="{{ asset('images/resources/image1.jpg') }}" alt="">
                    </a>
                </figure>
            </div>
        </div>
        <div class="editing-interest">
            <div class="notification-box">
                <ul class="uk-list-divider uk-list-large uk-accordion" uk-accordion="">
                    @foreach ($suggestions as $suggestion)
                    <li>
                        <a class="uk-accordion-title" href="#">
                            <figure><img
                                    src="{{ asset('storage/')}}/{{$suggestion->userSuggestion->image}}"
                                    alt=""></figure>
                            <div class="notifi-meta">
                                <p>{{$suggestion->userSuggestion->name}}</p>
                                <span><i class="fa fa-comment"></i> {{$suggestion->created_at->diffForHumans()}}</span>
                            </div>
                        </a>
                        {{-- :wire:key="{{$suggestion->id}}" --}}
                        <i wire:click ="deleteSuggestion({{$suggestion->id}})"  class="del icofont-close-circled" title="Remove"></i>
                        <div class="uk-accordion-content" hidden="" aria-hidden="true">
                            <p>{{$suggestion->details}}</p>
                            <figure class="research-avatar" style="max-width: 20%">
                                <a class="uk-inline" href="{{ asset('images/resources/image1.jpg') }}" data-fancybox="">
                                    <img src="{{ asset('images/resources/image1.jpg') }}"   style="border-radius: 0" alt="">
                                </a>
                            </figure>

                            <p>{{ asset('storage/'.$suggestion->file)}}</p>
                        </div>
                    </li>

                    {{-- <li>
                        <figure><img src="{{asset('assets/images/resources/user-avatar.jpg')}}" alt=""></figure>
                        <div class="notifi-meta">
                            <a>{{$suggestion->userSuggestion->name}}</a>
                            <p>{{$suggestion->details}}</p>
                            <img src="{{ asset('storage/'.$suggestion->file)}}" alt="">
                        </div>
                        <i class="del fa fa-close" wire:click ="deleteSuggestion({{$suggestion->id}})" ></i>
                    </li> --}}
                @endforeach
                </ul>
            </div>
            @include('components.loading')
        </div>
    </div>
</div>

{{-- <div class="col-lg-6">
    <div class="central-meta">
        <div class="editing-interest">
            <h5 class="f-title">{{__('all-suggestions')}}</h5>
            <div class="notification-box">
                <ul class="suggestion">
                    @foreach ($suggestions as $suggestion)
                        <li>
                            <figure><img src="{{asset('assets/images/resources/user-avatar.jpg')}}" alt=""></figure>
                            <div class="notifi-meta">
                                <a>{{$suggestion->userSuggestion->name}}</a>
                                <p>{{$suggestion->details}}</p>
                                <img src="{{ asset('storage/'.$suggestion->file)}}" alt="">
                            </div>
                            <i class="del fa fa-close" wire:click ="deleteSuggestion({{$suggestion->id}})" ></i>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div> --}}

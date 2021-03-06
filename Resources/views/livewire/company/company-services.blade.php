<div class="main-wraper">
    <style>
        .main-wraper,
        aside .widget {
            z-index: null;
        }
    </style>
    <h5 class="main-title">الخدمات
        @if ($isCurrantUser && Auth::user()->can("service-create"))
        <div class="more">
            <div class="more-post-optns">
                <i class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-more-horizontal">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg></i>
                <ul>
                    <li wire:click='setServiceCreateModal()' class="servies-opearition">
                        <a><i class="icofont-pen-alt-1"></i>إضافة خدمه</a>
                    </li>
                </ul>
            </div>
        </div>
        @endif
    </h5>
    @can('service-list', Model::class)
    <div class="info-block-list">
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                    <tr>
                        <th>اسم الخدمة</th>
                        <th>تفاصيل الخدمة</th>
                        @if ($isCurrantUser)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                    <tr>
                        <td>{{$service->name}}</td>
                        <td>{{$service->description}}</td>
                        @if ($isCurrantUser)
                        <td>
                            @can('service-delete')
                            <i class="" wire:click="deleteService({{$service->id}})" style="cursor: pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg></i>
                            @endcan
                            @can('service-edit')
                            <i wire:click="editUserService({{$service->id}})"
                                class="servies-opearition icofont-pen-alt-1" style="cursor: pointer"></i>
                            @endcan
                        </td>
                        @endif

                    </tr>
                    @empty
                    <td></td>
                    <td></td>
                    @if ($isCurrantUser)
                    <td></td>
                    @endif
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endcan

    @if (Auth::user()->can("service-create") || Auth::user()->can("service-edit"))
    <div class="servies-opearition-popup" wire:ignore.self>
        <div class="popup">
            <span class="popup-closed"><i class="icofont-close"></i></span>
            <div class="popup-meta">
                <div class="popup-head">
                    <h5><i>
                            <svg class="feather feather-message-square" stroke-linejoin="round" stroke-linecap="round"
                                stroke-width="2" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="24"
                                width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg></i> {{$modal['title']}}</h5>
                </div>
                <div class="send-message">
                    <form method="post" class="c-form">
                        <input type="text" wire:model.defer="serviceName" placeholder="اسم الخدمة">
                        @error('serviceName')<span class="text-danger">{{ $message }}</span>@enderror
                        <input type="text" wire:model.defer="serviceDescription"
                            placeholder="تفاصيل الخدمة">
                        @error('serviceDescription')<span class="text-danger">{{ $message }}</span>@enderror
                        <button wire:click.prevent="{{$modal['route']}}" type="submit" class="main-btn">
                            <div wire:loading wire:target="{{$modal['route']}}" class="sp sp-circle"></div>
                            {{$modal['name']}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif


</div>

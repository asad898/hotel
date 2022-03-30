@props(['room' => $room, 
            'guests' => $guests, 
                'roomprices' => $roomprices, 
                    'institutions' => $institutions, 
                        'meals' => $meals, 
                            'clothes' => $clothes, 
                                'roomall' => $roomall,
                                    'myRoom' => $myRoom,
                                        'accounts' => $accounts])

@include('rooms.create')
@include('rooms.edit')
{{-- @include('rooms.delete') --}}
@include('rooms.rent')
<!-- card -->
<div class="col-md-4">
    @if ($room->status == 'خارج الخدمة')
        <div class="card bg-danger">
            <div class="card card-danger collapsed-card">
            @elseif ($room->status == "تحت التنظيف")
                <div class="card bg-warning">
                    <div class="card card-warning collapsed-card">
                    @elseif ($room->status == "جاهزة")
                        <div class="card bg-primary">
                            <div class="card card-primary collapsed-card">
                            @else
                                <div class="card bg-success">
                                    <div class="card card-success collapsed-card">

    @endif
    <div class="card-header" style="height: 200px;">
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <b>{{ $room->number }}</b>
        </div>
        <h3 class="card-title col-12">
            @if ($room->status != 'تحت التنظيف' && $room->status != 'خارج الخدمة' && $room->status != 'جاهزة')
                @include('rooms.roomUpdate')
                @include('rooms.payment')
                @include('restaurants.create')
                @include('laundries.create')
                @include('rooms.changeRoom')
                @include('rooms.changeRoomPrice')
                @include('rooms.addPartner')
                @include('rooms.removePartner')
                <p class="mt-2">
                    النزيل : {{ $room->guest->name }}

                </p>
                @if ($room->partner_id != null)
                    <p>
                        المرافق : {{ $room->partner->name }}
                    </p>
                @else
                    <p>
                        لا يوجد مرافق
                        @if (auth()->user()->ree)
                            <button type="button" title="إضافة مرافق" class="btn btn-tool" data-toggle="modal"
                                data-target="#addPartner{{ $room->id }}">
                                <i class="fa fa-user-plus"></i>
                            </button>
                        @endif
                    </p>
                @endif
            @else
                <p class="mt-2">{{ $room->status }}</p>
                <p class="mt-2">غير ساكنة</p>
            @endif
        </h3>
        <!-- /.card-tools -->

        <div class="card-tools">
            {{-- <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#deleteRoom{{ $room->id }}">
                <i class="fas fa-trash"></i>
            </button> --}}
            <a type="button" href="{{ route('comments', $room->id) }}" title="التعليقات" class="btn btn-tool">
                <i class="fa fa-comments" aria-hidden="true"></i>
            </a>
            @if (auth()->user()->shm)
                @if (!$room->guest_id)
                    <button type="button" title="تغير حالة الغرفة" class="btn btn-tool" data-toggle="modal"
                        data-target="#updataRoom{{ $room->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                @endif
            @endif
            @if (auth()->user()->ree)
                @if ($room->guest_id)
                    <button type="button" title="تغير الغرفة للنزيل" class="btn btn-tool" data-toggle="modal"
                        data-target="#changeRoom{{ $room->id }}">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    @if ($room->partner_id)
                        <button type="button" title="مغادرة المرافق" class="btn btn-tool" data-toggle="modal"
                            data-target="#removePartner{{ $room->id }}">
                            <i class="fa fa-user-times"></i>
                        </button>
                        <button type="button" title="تبديل النزيل و المرافق" class="btn btn-tool" data-toggle="modal"
                            data-target="#pchange{{ $room->id }}">
                            <i class="fa fa-american-sign-language-interpreting"></i>
                        </button>
                        @include('rooms.pchange')
                    @endif
                @endif
            @endif
            @if ($room->guest_id)
                <a title="طباعة الفاتورة" href="{{ route('bill.show', $room->bill->id) }}" class="btn btn-tool">
                    <i class="fas fa-print" aria-hidden="true"></i>
                </a>
                @if (auth()->user()->ree)
                    <button type="button" title="تغير سعر الغرفة" class="btn btn-tool" data-toggle="modal"
                        data-target="#changeRoomPrice{{ $room->id }}">
                        <i class="fas fas fa-bed" aria-hidden="true"></i>
                    </button>
                    @if(auth()->user()->mm)
                    <button type="button" title="تحديث اليوم" class="btn btn-tool" data-toggle="modal"
                        data-target="#roomUpdate{{ $room->id }}">
                        <i class="far fa-bookmark"></i>
                    </button>
                    @endif
                    <button type="button" title="سداد" class="btn btn-tool" data-toggle="modal"
                        data-target="#payment{{ $room->id }}">
                        <i class="fas fa-dollar-sign" aria-hidden="true"></i>
                    </button>
                    {{-- <button type="button" title="إضافة فاتورة مطعم" class="btn btn-tool" data-toggle="modal"
                        data-target="#restBill{{ $room->id }}">
                        <i class="fas fa-fish"></i>
                    </button>
                    <button type="button" title="إضافة فاتورة مغسلة" class="btn btn-tool" data-toggle="modal"
                        data-target="#laundryBill{{ $room->id }}">
                        <i class="fas fa-tshirt"></i>
                    </button> --}}
                @endif
            @endif
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body text-dark" style="display: block;height: 230px;" >
        <p class="mt-3">الجهة :@if ($room->roomprice_id)
            {{ $room->institution->name }} @else غير
                ساكنة @endif
        </p>
        <p>التصنيف :@if ($room->roomprice_id) {{ $room->roomprice->desc }} /
            {{ $room->roomprice->rent }} @else غير ساكنة @endif
        </p>
        <p>
            الفاتورة :@if ($room->bill)
                @foreach ($myRoom as $item)
                    @if ($item['roomId'] == $room->id)
                        {{ number_format((float)($item['total']), 2) }}
                    @endif
                @endforeach
            @else 
                غير ساكنة
            @endif
        </p>
        @if (auth()->user()->mm || auth()->user()->rem)
        <p>مدخل البيانات :@if ($room->user_id) {{ $room->user->username }} @else
                    غير ساكنة @endif
            </p>
        @endif
    </div>
    @if ($room->status != 'تحت التنظيف' && $room->status != 'خارج الخدمة')
        @if (auth()->user()->ree)
            <div class="text-center">
                @if ($room->guest_id)
                    @include('rooms.leaving')
                    <button type="button" class="mb-3 rounded-0 btn btn-danger w-100" data-toggle="modal"
                        data-target="#leavingGuest{{ $room->id }}">
                        مغادرة <i class="fas fa-door-closed"></i>
                    </button>
                @else
                    <button type="button" class="mb-3 rounded-0 btn btn-success w-100" data-toggle="modal"
                        data-target="#rentGuest{{ $room->id }}">
                        تسكين <i class="fas fa-door-open"></i>
                    </button>
                @endif
            </div>
        @endif
    @else
        @if (auth()->user()->shm)
            @if ($room->status == 'خارج الخدمة')
                <button type="button" class="mb-3 rounded-0 btn btn-info w-100" data-toggle="modal"
                    data-target="#updataRoom{{ $room->id }}">
                    تجهيز الغرفة <i class="fas fa-tools"></i>
                </button>
            @elseif ($room->status == "تحت التنظيف")
                <button type="button" class="mb-3 rounded-0 btn btn-info w-100" data-toggle="modal"
                    data-target="#updataRoom{{ $room->id }}">
                    تجهيز الغرفة <i class="fas fa-hands-wash"></i>
                </button>
            @endif
        @endif
    @endif
    <!-- /.card-body -->
</div>

</div>
</div>
<!-- /.card -->

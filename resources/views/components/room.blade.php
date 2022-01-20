@props(['room' => $room,
             'guests' => $guests,
                'roomprices' => $roomprices,
                    'institutions' => $institutions,
                        'meals' => $meals,
                            'clothes' => $clothes,
                            'roomall' => $roomall])

@include('rooms.create')
@include('rooms.edit')
{{-- @include('rooms.delete') --}}
@include('rooms.rent')
<!-- card -->
<div class="col-md-3">
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
    <div class="card-header">
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
            <b>{{ $room->number }}</b>
        </div>
        <h3 class="card-title col-12">
            @if ($room->status != 'تحت التنظيف' && $room->status != 'خارج الخدمة' && $room->status != 'جاهزة')
                @include('rooms.roomUpdate')
                @include('restaurants.create')
                @include('laundries.create')
                @include('rooms.changeRoom')
                @include('rooms.changeRoomPrice')
                <p class="mt-2">النزيل : {{ $room->guest->name }}</p>
                @if ($room->partner_id != null)
                    <p>المرافق : {{ $room->partner->name }}</p>
                @else
                    <p>لا يوجد مرافق</p>
                @endif
            @else
                <p class="mt-2">{{ $room->status }}</p>
                <p class="mt-2">غير ساكنة</p>
            @endif
        </h3>
        <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body text-dark" style="display: none;">
        <div class="card-tools">
            {{-- <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#deleteRoom{{ $room->id }}">
                <i class="fas fa-trash"></i>
            </button> --}}
            @if (!$room->guest_id)
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#updataRoom{{ $room->id }}">
                    <i class="fas fa-edit"></i>
                </button>
            @endif
            @if ($room->guest_id)
                <a href="{{ route('bill.show', $room->bill->id) }}" class="btn btn-tool">
                    <i class="fas fa-print" aria-hidden="true"></i>
                </a>
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#changeRoomPrice{{ $room->id }}">
                    <i class="fas fa-dollar-sign" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#roomUpdate{{ $room->id }}">
                    <i class="far fa-bookmark"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#changeRoom{{ $room->id }}">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#restBill{{ $room->id }}">
                    <i class="fas fa-fish"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#laundryBill{{ $room->id }}">
                    <i class="fas fa-tshirt"></i>
                </button>
            @endif
        </div>
        <p class="mt-3">الجهة :@if ($room->roomprice_id){{ $room->institution->name }} @else غير
                ساكنة @endif
        </p>
        <p>التصنيف :@if ($room->roomprice_id) {{ $room->roomprice->desc }} -
            {{ $room->roomprice->price }} @else غير ساكنة @endif
        </p>
        <p>الفاتورة :@if ($room->bill) {{ $room->bill->price }} @else غير ساكنة @endif
        </p>
        <p>مدخل البيانات :@if ($room->user_id) {{ $room->user->username }} @else غير ساكنة @endif
        </p>
        @if ($room->status != 'تحت التنظيف' && $room->status != 'خارج الخدمة')
            <div class="text-center">
                @if ($room->guest_id)
                    @include('rooms.leaving')
                    <button type="button" class="btn btn-danger w-100" data-toggle="modal"
                        data-target="#leavingGuest{{ $room->id }}">
                        مغادرة <i class="fas fa-door-closed"></i>
                    </button>
                @else
                    <button type="button" class="btn btn-success w-100" data-toggle="modal"
                        data-target="#rentGuest{{ $room->id }}">
                        تسكين <i class="fas fa-door-open"></i>
                    </button>
                @endif
            </div>
        @else
            @if ($room->status == 'خارج الخدمة')
                <button type="button" class="btn btn-info w-100" data-toggle="modal"
                    data-target="#updataRoom{{ $room->id }}">
                    تجهيز الغرفة <i class="fas fa-tools"></i>
                </button>
            @elseif ($room->status == "تحت التنظيف")
                <button type="button" class="btn btn-info w-100" data-toggle="modal"
                    data-target="#updataRoom{{ $room->id }}">
                    تجهيز الغرفة <i class="fas fa-hands-wash"></i>
                </button>
            @endif
        @endif
    </div>
    <!-- /.card-body -->
</div>

</div>
</div>
<!-- /.card -->

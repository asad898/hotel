<!-- Updata Modal -->
<div class="modal fade" id="rentGuest{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تسكين نزيل في {{ $room->number }}</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['room.update', $room->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="name" class="font-weight-light">نوع التسكين</label>
                            <input name="roomprice_id" class="form-control" list="prices">
                            <datalist id="prices">
                                @if (count($roomprices))
                                    @foreach ($roomprices as $roomprice)
                                        <option value="{{ $roomprice->id }}">{{$roomprice->desc}}</option>
                                    @endforeach
                                @endif
                            </datalist>
                            <input type="hidden" name="number" id="number" value="{{ $room->number }}" class="form-control">
                            <input type="hidden" name="leaving" id="leaving" value="1" class="form-control">
                            <input type="hidden" name="room_id" id="room_id" value="{{ $room->id }}" class="form-control">
                            <input type="hidden" name="status" id="status" value="ساكنة" class="form-control">
                            <input name="statment" type="hidden" class="form-control" id="statment" placeholder=""
                                value="إيجار الغرفة رقم {{ $room->number }}" autofocus>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name" class="font-weight-light">رقم النزيل</label>
                            <input name="guest_id" class="form-control" list="guests">
                            <datalist id="guests">
                                @if (count($guests))
                                    @foreach ($guests as $guest)
                                        @if (!$guest->room)
                                            @if (!$guest->roomPartner)
                                                <option value="{{ $guest->id }}">{{$guest->name}} - {{ $guest->phone }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="name" class="font-weight-light">رقم المرافق</label>
                            <input name="partner_id" class="form-control" list="partner">
                            <datalist id="partner">
                                @if (count($guests))
                                    @foreach ($guests as $guest)
                                        @if (!$guest->room)
                                            @if (!$guest->roomPartner)
                                                <option value="{{ $guest->id }}">{{$guest->name}} - {{ $guest->phone }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </datalist>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name" class="font-weight-light">جهة العمل</label>
                            <input name="institution_id" class="form-control" list="institution">
                            <datalist id="institution">
                                @if (count($institutions))
                                    @foreach ($institutions as $institution)
                                        <option value="{{ $institution->id }}">{{$institution->name}}</option>
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                    </div>
                    
                </div>
                <div class="row m-0">
                    <input type="submit"  class="btn btn-info col-md-6 rounded-0 py-2" value="حفظ">
                    <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                        data-dismiss="modal">الغاء
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="roomCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">إضافة يوم للغرفة</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('detail.store1') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="guest_id" class="">البيان</label>
                            <input name="statment" type="text" class="form-control" id="statment" placeholder=""
                                value="إيجار الغرفة رقم {{ $bill->room->number }}" autofocus required>
                        </div>
                        <div class="col-md-6">
                            <label for="guest_id" class="">التاريخ</label>
                            <input name="created_at" type="text" class="form-control" id="created_at" placeholder=""
                                value="{{ \Carbon\Carbon::now() }}" autofocus required>
                            <input name="deleted_at" type="hidden" class="form-control" id="deleted_at" placeholder=""
                                value="{{ \Carbon\Carbon::now() }}" autofocus required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="guest_id" class="">رقم النزيل</label>
                            <input name="guest_id" value="{{ $detail->guest_id }}" class="form-control" list="guests">
                            <datalist id="guests">
                                @if (count($guests))
                                    @foreach ($guests as $guest)
                                        <option value="{{ $guest->id }}">{{ $guest->name }} -
                                            {{ $guest->phone }}</option>
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <label for="name" class="">الغرفة</label>
                            <input name="room_id" value="{{ $detail->room_id }}" class="form-control" list="rooms">
                            <datalist id="rooms">
                                @if (count($rooms))
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->number }}</option>
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <label for="bill_id" class="">رقم الفاتورة</label>
                            <input name="bill_id" type="text" class="form-control" id="bill_id" placeholder=""
                                value="{{ $bill->id }}" autofocus required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="guest_id" class="">المبلغ</label>
                            <input name="price" type="text" class="form-control" id="price" placeholder="" value=""
                                autofocus required>
                        </div>
                        <div class="col-md-4">
                            <label for="guest_id" class="">الضريبة</label>
                            <input name="tax" type="text" class="form-control" id="tax" placeholder="" value=""
                                autofocus>
                        </div>
                        <div class="col-md-4">
                            <label for="guest_id" class="">السياحة</label>
                            <input name="tourism" type="text" class="form-control" id="tourism" placeholder="" value=""
                                autofocus>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <label for="guest_id" class="">النوع</label>
                        <div class="mr-4 d-flex">
                            <div class="form-check" dir="ltr">
                                <input class="form-check-input" type="radio" name="type" value="pay"
                                    id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    سداد
                                </label>
                            </div>
                            <div class="form-check mr-5" dir="ltr">
                                <input class="form-check-input" type="radio" name="type" value="" id="flexRadioDefault2"
                                    checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    إيجار
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    <input type="submit" class="btn btn-primary col-md-6 rounded-0 py-2" value="حفظ">
                    <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                        data-dismiss="modal">الغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

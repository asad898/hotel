<!-- Create Modal -->
<div class="modal fade" id="editRe{{ $rebill->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">تعديل فاتورة مطعم</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('rebill.update', $rebill->id) }}">
                @csrf
                @method('put')
                <input type="hidden" name="done" value="0">
                <input type="hidden" name="total" value="0">
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="">الغرفة</label>
                            <input name="room_id" class="form-control" placeholder="" value="{{ $rebill->room_id }}"
                                list="rooms">
                            <datalist id="rooms">
                                @if (count($rooms))
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->number }}</option>
                                    @endforeach
                                @endif
                                <option value="300">فاتورة خارجية</option>
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">التاريخ</label>
                            <input type="text" class="form-control" value="{{ $rebill->created_at }}"
                                name="created_at">
                        </div>
                    </div>
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="">فاتورة النزيل</label>
                            <input type="text" class="form-control" value="{{ $rebill->bill_id }}" name="bill_id">
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

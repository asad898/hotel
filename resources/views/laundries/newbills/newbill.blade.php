<!-- Create Modal -->
<div class="modal fade" id="newbill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">إضافة فاتورة جديد</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('labill.store') }}">
                @csrf
                <input type="hidden" name="done" value="0">
                <input type="hidden" name="total" value="0">
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-12">
                            <input name="room_id" class="form-control" placeholder="الغرفة / كاش" list="rooms">
                            <datalist id="rooms">
                                @if (count($rooms))
                                    @foreach ($rooms as $room)
                                        @if($room->status == "ساكنة")
                                        <option value="{{ $room->id }}">{{ $room->number }}</option>
                                        @endif
                                    @endforeach
                                @endif
                                <option value="300">فاتورة خارجية</option>
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    <input type="submit" class="btn btn-info col-md-6 rounded-0 py-2" value="حفظ">
                    <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                        data-dismiss="modal">الغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

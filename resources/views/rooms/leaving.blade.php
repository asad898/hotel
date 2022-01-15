<!-- Updata Modal -->
<div class="modal fade" id="leavingGuest{{ $room->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">مغادرة نزيل من {{ $room->number }}</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['room.update', $room->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
            @csrf
            @method('PUT')
            <div class="modal-body">
                <p class="text-dark"> تاكيد مغادرة النزيل {{$room->guest->name}} ؟</p>
                <div class="form-group row mx-0">
                    <div class="form-group col-md-6">
                        <input type="hidden" name="number" id="number" value="{{ $room->number }}"
                        class="form-control">
                        <input type="hidden" name="status" id="status" value="تحت التنظيف" class="form-control">
                        <input type="hidden" name="leaving" id="leaving" value="1" class="form-control">
                    </div>
                    
                    <div class="form-group col-md-6">
                        <input type="hidden" name="roomprice_id" value="" class="form-control" list="prices">
                        <input type="hidden" name="guest_id" value="" class="form-control" list="guests">
                        <input type="hidden" name="institution_id" value="" class="form-control" list="guests">
                    </div>
                </div>

            </div>
            <div class="row m-0">
                <input type="submit" class="btn btn-info col-md-6 rounded-0 py-2" value="تاكيد">
                <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2" data-dismiss="modal">الغاء
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

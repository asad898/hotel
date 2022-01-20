<!-- Updata Modal -->
<div class="modal fade" id="changeRoomPrice{{ $room->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">تغير سعر الغرفة </h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['room.price', $room->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group col-md-12">
                    <label for="name" class="font-weight-light">رقم الغرفة</label>
                    <input name="id" class="form-control" list="roomPrice">
                    <datalist id="roomPrice">
                        @if (count($roomprices))
                            @foreach ($roomprices as $price)
                                <option value="{{ $price->id }}">{{ $price->desc }}</option>
                            @endforeach
                        @endif
                    </datalist>
                </div>
            </div>
            <div class="row m-0">
                <input type="submit" class="btn btn-primary col-md-6 rounded-0 py-2" value="حفظ">
                <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                    data-dismiss="modal">الغاء</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

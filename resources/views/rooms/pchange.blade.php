<!-- Updata Modal -->
<div class="modal fade" id="pchange{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تغير النزيل و المرافق </h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['room.change.partner', $room->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="hidden" name="bill_id" id="bill_id" value="{{ $room->bill->id }}">
                <input type="hidden" name="guest_id" id="guest_id" value="{{ $room->guest_id }}">
                <input type="hidden" name="partner_id" id="partner_id" value="{{ $room->partner_id }}">
                <p class="text-dark font-weight-bold">هل تريد تغير النزيل مع المرافق ؟</p>
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

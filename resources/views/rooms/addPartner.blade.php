<!-- Updata Modal -->
<div class="modal fade" id="addPartner{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">إضافة مرافق الى {{ $room->number }}</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['room.add.partner', $room->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-12">
                            <label for="name" class="font-weight-light text-dark">المرافق</label>
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
                    </div>
                </div>
                <div class="row m-0">
                    <input type="submit" class="btn btn-info col-md-6 rounded-0 py-2" value="حفظ">
                    <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                        data-dismiss="modal">الغاء</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

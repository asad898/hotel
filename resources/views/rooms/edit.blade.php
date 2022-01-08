<!-- Updata Modal -->
<div class="modal fade" id="updataRoom{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تحديث حالة غرفة رقم {{ $room->number }}</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['room.update', $room->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-12">
                            <input type="hidden" name="number" id="number" value="{{ $room->number }}" class="form-control">
                            <label for="nationality" class="font-weight-light">الحالة</label>
                            <select @if ($room->status == "ساكنة") disabled @endif class="custom-select" name="status">
                                @if ($room->status == "جاهزة")
                                    <option value="جاهزة" selected class="">جاهزة</option>
                                    <option value="تحت التنظيف" class="">تحت التنظيف</option>
                                    <option value="خارج الخدمة" class="">خارج الخدمة</option>
                                @endif
                                @if ($room->status == "تحت التنظيف")
                                    <option value="جاهزة" class="">جاهزة</option>
                                    <option value="تحت التنظيف" selected class="">تحت التنظيف</option>
                                    <option value="خارج الخدمة" class="">خارج الخدمة</option>
                                @endif
                                @if ($room->status == "خارج الخدمة")
                                    <option value="جاهزة" class="">جاهزة</option>
                                    <option value="تحت التنظيف" class="">تحت التنظيف</option>
                                    <option value="خارج الخدمة" selected class="">خارج الخدمة</option>
                                @endif
                                @if ($room->status == "ساكنة")
                                    <option value="ساكنة" selected class="">ساكنة</option>
                                    <option value="جاهزة" class="">جاهزة</option>
                                    <option value="تحت التنظيف" class="">تحت التنظيف</option>
                                    <option value="خارج الخدمة" class="">خارج الخدمة</option>
                                @endif
                            </select>
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

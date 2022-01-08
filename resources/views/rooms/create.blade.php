<!-- Create Modal -->
<div class="modal fade" id="createRoom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">إضافة غرفة جديد</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('room.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="name" class="font-weight-light">رقم الغرفة</label>
                            <input name="number" type="text" class="form-control" id="number" placeholder=""
                                value="{{ old('number') }}" autofocus required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="nationality" class="font-weight-light">الحالة</label>
                            <select class="custom-select" name="status">
                                <option value="جاهزة" class="">جاهزة</option>
                                <option value="تحت التنظيف" class="">تحت التنظيف</option>
                            </select>
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

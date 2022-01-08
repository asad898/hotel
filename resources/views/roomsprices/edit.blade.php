<!-- Create Modal -->
<div class="modal fade" id="editRoomPrice{{ $roomprice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تحديث التصنيف</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('roomprice.update', $roomprice->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="desc" class="font-weight-light">التصنيف</label>
                            <input name="desc" type="text" class="form-control" id="desc" placeholder=""
                                value="{{ $roomprice->desc }}" autofocus required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="rent" class="font-weight-light">الإيجار</label>
                            <input name="rent" type="text" class="form-control" id="rent" placeholder=""
                                value="{{ $roomprice->rent }}" autofocus required>
                        </div>
                    </div>

                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="tax" class="font-weight-light">الضربية</label>
                            <input name="tax" type="text" class="form-control" id="tax" placeholder=""
                                value="{{ $roomprice->tax }}" autofocus required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="tourism" class="font-weight-light">السياحة</label>
                            <input name="tourism" type="text" class="form-control" id="tourism" placeholder=""
                                value="{{ $roomprice->tourism }}" autofocus required>
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

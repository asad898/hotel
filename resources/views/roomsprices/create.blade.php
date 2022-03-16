<!-- Create Modal -->
<div class="modal fade" id="createRoomPrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">إضافة تصنيف</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('roomprice.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="desc" class="font-weight-light">التصنيف</label>
                            <input name="desc" type="text" class="form-control" id="desc" placeholder=""
                                value="{{ old('desc') }}" autofocus required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="rent" class="font-weight-light">الإيجار</label>
                            <input name="rent" type="text" class="form-control" id="rent" placeholder=""
                                value="{{ old('rent') }}" autofocus required>
                        </div>
                    </div>

                    <div class="form-group row mx-0">
                        <div class="form-group col-md-4">
                            <label for="tax" class="font-weight-light">الضربية 17</label>
                            <input name="tax" type="text" class="form-control" id="tax" placeholder=""
                                value="17" autofocus required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tourism" class="font-weight-light">السياحة 5</label>
                            <input name="tourism" type="text" class="form-control" id="tourism" placeholder=""
                                value="5" autofocus required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="sNumber" class="font-weight-light">ثابت 1.2285</label>
                            <input name="sNumber" type="text" class="form-control" id="sNumber" placeholder=""
                                value="1.2285" autofocus required>
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

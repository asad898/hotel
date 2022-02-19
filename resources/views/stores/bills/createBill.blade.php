<!-- Updata Modal -->
<div class="modal fade" id="sellBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">إذن صرف</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['store.bill.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="statement" class="">البيان / المورد</label>
                            {{Form::text('statement', '',['class' => 'form-control'])}}
                            <input type="hidden" value="إذن صرف" name="type">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="statement" class="">التصنيف</label>
                            <select class="custom-select" name="dept">
                                    <option value="إذن صرف (نزلاء) مطعم" selected class="">إذن صرف (نزلاء) مطعم</option>
                                    <option value="إذن صرف (الموظفين) مطعم" class="">إذن صرف (الموظفين) مطعم</option>
                                    <option value="إذن صرف (نزلاء) الاشراف" class="">إذن صرف (نزلاء) الاشراف</option>
                                    <option value="إذن صرف (موظفين) الاشراف" class="">إذن صرف (موظفين) الاشراف</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    {{Form::Submit('حفظ', ['class' => 'btn btn-info col-md-6 rounded-0 py-2'])}}
                    <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                        data-dismiss="modal">الغاء</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

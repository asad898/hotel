<!-- Updata Modal -->
<div class="modal fade" id="createGuest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تسجيل حساب نزيل جديد</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['guest.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">

                        <div class="form-group col-md-6">
                            <label for="name" class="font-weight-light">إسم النزيل</label>
                            {{Form::text('name', '',['class' => 'form-control'])}}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone" class="font-weight-light">الهاتف</label>
                            {{Form::text('phone', '', ['class' => 'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group row mx-0">
                        <div class="form-group col-md-12">
                            <label for="institution" class="font-weight-light">العنوان</label>
                            {{Form::text('institution', '',['class' => 'form-control'])}}
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

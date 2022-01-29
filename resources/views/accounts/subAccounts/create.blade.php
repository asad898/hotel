<!-- Updata Modal -->
<div class="modal fade" id="createSubAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route' => ['sub.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">إنشاء حساب</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="form-group row mx-0">

                    <div class="form-group col-md-12">
                        <label for="name" class="font-weight-light pb-3">إسم الحساب</label>
                        {{ Form::text('name', '', ['class' => 'form-control']) }}
                    </div>
                    <input type="hidden" value="{{ $mainAccount->id }}" name="main_accounts_id">
                </div>

            </div>
            <div class="row m-0">
                {{ Form::Submit('حفظ', ['class' => 'btn btn-info col-md-6 rounded-0 py-2']) }}
                <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                    data-dismiss="modal">الغاء</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<!-- Updata Modal -->
<div dir="rtl" class="modal fade text-right" id="updateSubAccount{{ $sub->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route' => ['sub.update', $sub->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">تعديل الحساب</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row mx-0">

                    <div class="form-group col-md-6">
                        <label for="name" class="font-weight-light pb-3">إسم الحساب</label>
                        {{ Form::text('name', $sub->name, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="my-select" class="pb-3">النوع الحساب</label>
                        <select id="my-select" class="custom-select" name="type">
                            @if ($sub->type == "عادي")
                                <option value="عادي" selected class="">عادي</option>
                                <option value="مدين" class="">مدين</option>
                                <option value="دائن" class="">دائن</option>
                            @endif
                            @if ($sub->type == "مدين")
                                <option value="عادي" class="">عادي</option>
                                <option value="مدين" selected class="">مدين</option>
                                <option value="دائن" class="">دائن</option>

                            @endif
                            @if ($sub->type == "دائن")
                                <option value="عادي" class="">عادي</option>
                                <option value="مدين" class="">مدين</option>
                                <option value="دائن" selected class="">دائن</option>
                            @else
                                <option value="عادي" class="">عادي</option>
                                <option value="مدين" class="">مدين</option>
                                <option value="دائن" class="">دائن</option>
                            @endif
                        </select>
                    </div>
                    <input type="hidden" value="{{ $mainAccount->id }}" name="main_accounts_id">
                </div>

            </div>
            <div class="row m-0">
                {{ Form::Submit('حفظ', ['class' => 'btn btn-success col-md-6 rounded-0 py-2']) }}
                <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                    data-dismiss="modal">الغاء</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

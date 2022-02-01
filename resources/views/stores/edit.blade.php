<!-- Updata Modal -->
<div class="modal fade" id="storeUpdate{{ $store->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تحديث السلعة</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['store.update', $store->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-12">
                            <label for="name" class="font-weight-light">إسم السلعة</label>
                            {{Form::text('name', $store->name,['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <label for="measure" class="font-weight-light">وحدة القياس</label>
                            {{Form::text('measure', $store->measure,['class' => 'form-control'])}}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price" class="font-weight-light">السعر الوحدة</label>
                            {{Form::text('price', $store->price, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    @if(auth()->user()->role == 'Admin')
                        <div class="form-group row mx-0">
                            <div class="form-group col-md-12">
                                <label for="name" class="font-weight-light">الكمية</label>
                                {{Form::text('quantity', $store->quantity,['class' => 'form-control'])}}
                            </div>
                        </div>
                    @endif
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

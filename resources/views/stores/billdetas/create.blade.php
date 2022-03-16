<!-- Updata Modal -->
<div class="modal fade" id="addDeta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">إضافة عنصر الى فاتورة</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['deta.bill.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
            @csrf
            <div class="modal-body">
                <div class="form-group row mx-0">
                    <div class="form-group col-md-6">
                        <label for="statement" class="font-weight-light">السلعة</label>
                        <input name="store_id" class="form-control" list="store_id">
                        <datalist id="store_id">
                            @if ($storeBill->type == 'إذن شراء')
                                @if (count($items))
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            @endif

                            @if ($storeBill->type == 'إذن صرف')
                                @if (count($items))
                                    @foreach ($items as $item)
                                        @if ($item->quantity != 0)
                                            <option value="{{ $item->id }}">{{ $item->name }} / {{ $item->quantity }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </datalist>
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::hidden('bill_id', $storeBill->id, ['class' => 'form-control']) }}
                        <label for="quantity" class="font-weight-light">الكمية</label>
                        {{ Form::text('quantity', '', ['class' => 'form-control']) }}
                    </div>
                </div>

            </div>
            <div class="row m-0">
                {{ Form::Submit('حفظ', ['class' => 'btn btn-info col-md-6 rounded-0 py-2']) }}
                <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                    data-dismiss="modal">الغاء</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

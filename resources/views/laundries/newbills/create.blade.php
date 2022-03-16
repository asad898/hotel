<!-- Create Modal -->
<div class="modal fade" id="labill{{ $labill->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">إضافة ملابس</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('ladeta.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            <input name="clothe_id" class="form-control" placeholder="رقم القطعة" list="clothes">
                            <datalist id="clothes">
                                @if (count($clothes))
                                    @foreach ($clothes as $clothe)
                                        <option value="{{ $clothe->id }}">{{ $clothe->name }}</option>
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <input name="amount" type="text" class="form-control" id="amount" placeholder="الكمية"
                                value="{{ old('amount') }}" autofocus required>
                            <input name="la_bill_id" type="hidden" value="{{ $labill->id }}" autofocus required>
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

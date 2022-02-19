<!-- Create Modal -->
<div class="modal fade" id="sell2{{ $storeBill->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">ترحيل سند شراء على الحساب</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('detail.move1', $storeBill->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-12">
                            <label for="name" class="text-dark">الحساب</label>
                            <input type="hidden" name="price" value="{{ $sum }}">
                            <input type="hidden" name="statement" value="شراء بضاعة على الحساب">
                            <input type="hidden" name="type" value="debit">
                            <input name="credit" class="form-control" list="account">
                            <datalist id="account">
                                @if (count($accounts))
                                    @foreach ($accounts as $account)
                                        @if ($account->type == 'دائن')
                                            <option value="{{ $account->id }}">
                                                {{ $account->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            </datalist>
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

<!-- Create Modal -->
<div class="modal fade" id="payment{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">السداد - مطالبة الغرفة @if ($room->bill) {{ $room->bill->price }} @else غير ساكنة @endif</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('detail.payment') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <input name="guest_id" type="hidden" class="form-control" id="guest_id" placeholder=""
                            value="{{ $room->guest->id }}" autofocus required>
                        <input name="room_id" type="hidden" class="form-control" id="room_id" placeholder=""
                            value="{{ $room->id }}" autofocus required>
                        <input name="price" type="hidden" class="form-control" id="price" placeholder=""
                            value="{{ $room->roomprice->price }}" autofocus required>
                        <input name="bill_id" type="hidden" class="form-control" id="bill_id" placeholder=""
                            value="{{ $room->bill->id }}" autofocus required>
                        <div class="form-group col-md-6">
                            <label for="name" class="text-dark">الحساب</label>
                            <input name="debit" class="form-control" list="account">
                            <datalist id="account">
                                @if (count($accounts))
                                    @foreach ($accounts as $account)
                                        @if ($account->type == 'مدين' or $account->id == 26 or $account->id == 31 or $account->id == 32)
                                            <option value="{{ $account->id }}">
                                                @if($account->id == 26) (كاش)
                                                @elseif($account->id == 31) (كاش)
                                                @elseif($account->id == 32) (كاش)
                                                @else مديونية
                                                @endif
                                                {{ $account->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="statment" class="text-dark">المبلغ</label>
                        <input name="price" type="text" class="form-control" id="price" placeholder="" autofocus required>
                        </div>
                    </div>
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-12">
                            <label for="statment" class="text-dark">نوع السداد</label>
                            <select class="custom-select" name="statment" id="statment">
                                <option value="سداد الغرفة رقم {{ $room->number }}" @if($room->institution->id == 1) selected @endif class="">سداد الغرفة رقم {{ $room->number }} (كاش)
                                </option>
                                <option value="تحويل مديونية الغرفة رقم {{ $room->number }}" @if($room->institution->id != 1) selected @endif class="">تحويل مديونية الغرفة رقم {{ $room->number }} (على الحساب)
                                </option>
                                <option value="سداد فاتورة مطعم الغرفة رقم {{ $room->number }}" @if($room->institution->id == 1) selected @endif class="">سداد فاتورة مطعم
                                </option>
                                <option value="سداد فاتورة مغسلة الغرفة رقم {{ $room->number }}" @if($room->institution->id == 1) selected @endif class="">سداد فاتورة مغسلة
                                </option>
                            </select>
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

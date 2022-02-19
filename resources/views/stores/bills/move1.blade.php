<!-- Create Modal -->
<div class="modal fade" id="sell1{{ $storeBill->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">ترحيل سند شراء نقداً</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('detail.move1', $storeBill->id ) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="form-group col-md-6">
                            {{-- <input name="hidden" value=""> --}}
                            <input type="hidden" name="price" value="{{ $sum }}">
                            <input type="hidden" name="statement" value="شراء بضاعة نقداً">
                            <input type="hidden" name="type" value="credit">
                            <input type="hidden" name="credit" value="credit">
                        </div>
                    </div>
                    <p>هل تريد ترحيل السند نقداً ؟</p>
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

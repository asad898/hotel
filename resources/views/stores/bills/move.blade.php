<div class="modal fade" id="move" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تأكيد ترحيل فاتورة</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد ترحيل الفاتورة بالرقم <b> {{ $storeBill->id }} </b> ؟</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('store.bill.delete', $storeBill->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" value="ترحيل الفاتوره" class="btn btn-info unprint mx-3 my-2">
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
            </div>
        </div>
    </div>
</div>

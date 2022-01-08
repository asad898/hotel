<div class="modal fade" id="deleteBill{{ $bill->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="exampleModalLabel">حذف فاتورة</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف الفاتورة رقم <b> {{ $bill->id }} </b> ؟</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('bill.delete', $bill->id ) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" value="نعم" class="btn btn-danger">
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
            </div>
        </div>
    </div>
</div>

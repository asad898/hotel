<!-- Create Modal -->
<div class="modal fade" id="deleteB{{ $labill->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">حذف عنصر</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="m-2">هل تريد حذف الفاتورة ({{ $labill->id}}) ؟</p>
            <div class="modal-footer">
            <form class="text-right" method="POST" action="{{ route('store.labill.delete', $labill->id) }}">
                @csrf
                @method('delete')
                <input type="submit" value="نعم" class="btn btn-danger">
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
        </div>
    </div>
    </div>
</div>

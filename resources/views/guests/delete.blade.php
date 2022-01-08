<div class="modal fade" id="deleteGuest{{ $guest->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="exampleModalLabel">حذف نزيل</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-right">هل تريد حذف  <b> {{ $guest->name }} </b> ؟</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('guest.delete', $guest->id ) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="submit" value="نعم" class="btn btn-danger">
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
            </div>
        </div>
    </div>
</div>
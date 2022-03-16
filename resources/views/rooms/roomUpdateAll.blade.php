<!-- Create Modal -->
<div class="modal fade" id="roomUpdateAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">تحديث كل الغرف</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="text-right" method="POST" action="{{ route('room.updateAll') }}">
                @csrf
                <div class="modal-body">
                    <h5 class="text-dark text-center mb-4">هل تريد إضافة يوم في كل فواتير الغرف الساكنة؟</h5>
                </div>
                <div class="row m-0">
                    <input type="submit" class="btn btn-success col-md-6 rounded-0 py-2" value="حفظ">
                    <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                        data-dismiss="modal">الغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

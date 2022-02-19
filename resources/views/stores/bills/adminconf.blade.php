<div class="modal fade" id="adminconf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تأكيد الموافقة على السندات</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.conf.store', $storeBill->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-check text-right">
                        <input class="form-check-input" {{ $storeBill->admin_conf == 1 ? ' checked' : '' }}
                            name="admin_conf" type="checkbox" value="check" id="flexCheckDefault">
                        <label class="form-check-label mr-3" for="flexCheckDefault">
                            الموافقة على السندات بالرقم <b> {{ $storeBill->id }} </b>
                        </label>
                    </div>
                    <div class="modal-footer mt-3">
                        <input type="submit" value="تأكيد" class="btn btn-info unprint mx-3 my-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

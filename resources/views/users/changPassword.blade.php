<!-- Updata Modal -->
<div class="modal fade" id="updatePass{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تغير كلمة المرور</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('change.password') }}">
                    @csrf

                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">كلمة المرور الحالية</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="current_password"
                                autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">كلمة المرور الجديدة</label>

                        <div class="col-md-6">
                            <input id="new_password" type="password" class="form-control" name="new_password"
                                autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">تأكيد كلمة المرور الجديدة</label>

                        <div class="col-md-6">
                            <input id="new_confirm_password" type="password" class="form-control"
                                name="new_confirm_password" autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                حفظ التغير
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Updata Modal -->
<div class="modal fade" id="role{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">صلاحيات المستخدم</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['users.update.roles', $user->username], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row mx-0">
                        <div class="mt-3 form-check text-right">
                            <input class="form-check-input" {{ $user->mm == 1 ? ' checked' : '' }}
                                name="mm" type="checkbox" value="check" id="mm">
                            <label class="form-check-label mr-3" for="mm">
                                <b>
                                    مدير عام 
                                </b>
                            </label>
                        </div>
                        <div class="mt-3 form-check text-right">
                            <input class="form-check-input" {{ $user->am == 1 ? ' checked' : '' }}
                                name="am" type="checkbox" value="check" id="am">
                            <label class="form-check-label mr-3" for="am">
                                <b>
                                    مدير حسابات 
                                </b>
                            </label>
                        </div>
                        <div class="mt-3 form-check text-right">
                            <input class="form-check-input" {{ $user->rem == 1 ? ' checked' : '' }}
                                name="rem" type="checkbox" value="check" id="rem">
                            <label class="form-check-label mr-3" for="rem">
                                <b>
                                    مدير إستقبال 
                                </b>
                            </label>
                        </div>
                        <div class="mt-3 form-check text-right">
                            <input class="form-check-input" {{ $user->shm == 1 ? ' checked' : '' }}
                                name="shm" type="checkbox" value="check" id="shm">
                            <label class="form-check-label mr-3" for="shm">
                                <b>
                                    مدير الإشراف 
                                </b>
                            </label>
                        </div>
                        <div class="mt-3 form-check text-right">
                            <input class="form-check-input" {{ $user->ree == 1 ? ' checked' : '' }}
                                name="ree" type="checkbox" value="check" id="ree">
                            <label class="form-check-label mr-3" for="ree">
                                <b>
                                    موظف إستقبال
                                </b>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    {{Form::Submit('حفظ', ['class' => 'btn btn-info col-md-6 rounded-0 py-2'])}}
                    <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2"
                        data-dismiss="modal">الغاء</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

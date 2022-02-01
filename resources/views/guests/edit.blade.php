<!-- Create Modal -->
<div class="modal fade" id="editGuest{{ $guest->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">تعديل حساب نزيل</h5>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {!! Form::open(['route' => ['guest.update', $guest->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'text-right']) !!}
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group row mx-0">
                    <div class="form-group col-md-6">
                        <label for="name" class="font-weight-light">إسم النزيل</label>
                        <input id="name" type="text" value="{{ $guest->name }}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone" class="font-weight-light">الهاتف</label>
                        <input id="phone" type="text" value="{{ $guest->phone }}" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autofocus>
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mx-0">
                    <div class="form-group col-md-12">
                        <label for="institution" class="font-weight-light">العنوان</label>
                        <input id="institution" type="text" value="{{ $guest->institution }}" class="form-control @error('institution') is-invalid @enderror" name="institution" value="{{ old('institution') }}" required autofocus>
                        @error('institution')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mx-0">
                    <div class="form-group col-md-6">
                        <label for="identity" class="font-weight-light">نوع إثبات الهوية</label>
                        <input id="identity" type="text" value="{{ $guest->identity }}" class="form-control @error('identity') is-invalid @enderror" name="identity" value="{{ old('identity') }}" required autofocus>
                        @error('identity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="identityId" class="font-weight-light">رقم إثبات الهوية</label>
                        <input id="identityId" type="text" value="{{ $guest->identityId }}" class="form-control @error('identityId') is-invalid @enderror" name="identityId" value="{{ old('identityId') }}" required autofocus>
                        @error('identityId')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="row m-0">
                {{Form::Submit('حفظ', ['class' => 'btn btn-info col-md-6 rounded-0 py-2'])}}
                <button type="button" class="btn btn-secondary col-md-6 rounded-0 py-2" data-dismiss="modal">الغاء</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
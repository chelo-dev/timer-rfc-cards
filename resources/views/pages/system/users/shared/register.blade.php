<div id="modal-register-user" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-kharma border-0">
                <h4 class="modal-title" id="titleModalUser">Registro de usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="text-justify">
                    <form id="createUser" method="POST" action="{{ route('createUser') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="nombre" class="form-control-label text-uppercase">
                                Nombre completo <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <input type="text" class="form-control text-muted @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" placeholder="Ej: Juan" autocomplete="off">
                            @error('name')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-control-label text-uppercase">
                                Email <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" placeholder="Ej: ejemplo@ejemplo.com">
                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="department" class="form-control-label text-uppercase">
                                Departamento <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <select name="department" id="department" class="form-control">
                                <option>Seleccionar...</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="position" class="form-control-label text-uppercase">
                                Posicion <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <select name="position" id="position" class="form-control">
                                <option>Seleccionar...</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position['id'] }}">{{ $position['name'] }}</option>
                                @endforeach
                            </select>
                            @error('position')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-control-label text-uppercase">
                                Teléfono <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"  name="phone" 
                                value="{{ old('phone') }}" placeholder="Ej: (000) 000-000" data-toggle="input-mask" 
                                data-mask-format="(000) 000-0000">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-control-label text-uppercase">Contraseña <small class="text-danger text-capitalize">(Requerido)</small></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="{{ old('password') }}" placeholder="Ej: Qwertyuiop1" autocomplete="off" required>
                            @error('password')
                                <div class="invalid-feedback" role="alert">{{ __('PASSWORD') }} </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="form-control-label text-uppercase">Confirmar Contraseña <small class="text-danger text-capitalize">(Requerido)</small></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Ej: Qwertyuiop1" autocomplete="off" required>
                            <p class="font-11" id="validacion_mensaje"></p>
                            @error('password_confirmation')
                                <div class="invalid-feedback" role="alert">{{ __('PASSWORD_CONFIRMATION') }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes" class="form-control-label text-uppercase">
                                Informacion extra <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes"
                                placeholder="Escribir aquí." autocomplete="off" rows="5">{{ old('notes')}}</textarea>
                            @error('notes')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success btn-sm text-uppercase mt-1" type="submit">
                                <i class="mdi mdi-content-save-outline"></i> Registrar
                            </button>
                            <a href="#!" class="btn btn-danger btn-sm text-uppercase mt-1">
                                <i class="mdi mdi-cancel"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
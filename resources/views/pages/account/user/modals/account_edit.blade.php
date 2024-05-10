<div id="account-form-edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-right">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h4 class="modal-title" id="myLargeModalLabel">Actualizar informacion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="text-justify">
                    <form id="sendForm" method="POST" action="{{ route('editAccount', $account->uuid) }}">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="form-group">
                            <label for="nombre" class="form-control-label text-uppercase">
                                Nombre completo <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <input type="text" class="form-control text-muted @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $account->name) }}" placeholder="Ej: Juan" autocomplete="off">
                            @error('name')
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
                                value="{{ old('phone', $account->phone) }}" placeholder="Ej: (000) 000-000" data-toggle="input-mask" 
                                data-mask-format="(000) 000-0000">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes" class="form-control-label text-uppercase">
                                Informacion extra <small class="text-success text-capitalize">(Opcional)</small>
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes"
                                placeholder="Escribir aquí." autocomplete="off" rows="5">{{ old('notes', $account->notes)}}</textarea>
                            @error('notes')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success btn-sm text-uppercase mt-1" type="submit" onclick="submitForm(event)">
                                <i class="mdi mdi-content-save-outline"></i> Actualizar
                            </button>
                            <a href="{{ route('getAccount', $account->uuid) }}" class="btn btn-danger btn-sm text-uppercase mt-1">
                                <i class="mdi mdi-cancel"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
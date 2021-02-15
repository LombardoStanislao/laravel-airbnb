@extends('layouts.dashboard')

@section('page-title', 'Aggiungi appartamento')

@section('scripts')
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.5.0/services/services-web.min.js"></script>

    <script type="text/javascript" defer>
        function convertAdress(event) {
            event.preventDefault();
            tt.services.structuredGeocode({
                key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                countryCode: 'IT',
                streetName: document.querySelector("input[name='street_name']").value,
                streetNumber: document.querySelector("input[name='street_number']").value,
                municipality: document.querySelector("input[name='municipality']").value
            }).then(response => {
                if (response.results.length) {
                    var latitude = response.results[0].position.lat;
                    document.querySelector("input[name='latitude']").value = latitude;
                    var longitude = response.results[0].position.lng;
                    document.querySelector("input[name='longitude']").value = longitude;
                }
                document.getElementById('create-apartment').submit();
            });
        }
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>
                    Nuovo appartamento
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="create-apartment" method="POST" enctype="multipart/form-data" action="{{ route('admin.apartments.store') }}" onsubmit="convertAdress(event)">
                    @csrf
                    <div class="form-group">
                        <label>Titolo riepilogativo: </label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" maxlength="255" required>
                        @error ('title')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero di stanze: </label>
                        <input type="number" name="rooms_number" class="form-control" value="{{ old('rooms_number', 1) }}" min="1" required>
                        @error ('rooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero posti letto: </label>
                        <input type="number" name="sleeps_accomodations" class="form-control" value="{{ old('sleeps_accomodations', 1) }}" min="1" required>
                        @error ('sleeps_accomodations')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero bagni: </label>
                        <input type="number" name="bathrooms_number" class="form-control" value="{{ old('bathrooms_number', 1) }}" min="1" required>
                        @error ('bathrooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Metri quadrati: </label>
                        <input type="number" name="mq" class="form-control" value="{{ old('mq') }}" min="1" required>
                        @error ('mq')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Indirizzo:</label>
                        <div class="d-md-flex">
                            <label>Via: </label>
                            <input type="text" name="street_name" class="form-control ml-md-3 mr-md-3" value="{{ old('street_name') }}" required>
                            <label>Numero: </label>
                            <input type="number" name="street_number" class="form-control ml-md-3 mr-md-3" value="{{ old('street_number') }}" required min="1">
                            <label>Città: </label>
                            <input type="text" name="municipality" class="form-control ml-md-3" value="{{ old('municipality') }}" required>
                        </div>
                        <input type="hidden" name="latitude">
                        <input type="hidden" name="longitude">
                        @error ('street_name')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @error ('street_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @error ('municipality')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Prezzo per notte: </label>
                        <input type="number" name="price_per_night" class="form-control" value="{{ old('price_per_night') }}" min="0" step="0.01" required>
                        @error ('price_per_night')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Immagine di copertina: </label>
                        <input type="file" class="form-control-file" name="image" required>
                        @error ('image')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Comforts: </label>
                        @foreach ($comforts as $comfort)
                            <div class="form-check">
                                <input name="comforts[]" class="form-check-input" type="checkbox" value="{{ $comfort->id }}" {{ in_array($comfort->id, old('comforts', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $comfort->name }}
                                </label>
                            </div>
                        @endforeach
                        @error ('comforts')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Disponibilità appartamento: </label>
                        <div class="form-check">
                            <input type="radio" name="available" value="1" required {{ !old('available') || old('available') === '1' ? 'checked' : '' }}>
                            <label>Sì</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="available" value="0" required {{ old('available') === '0' ? 'checked' : '' }}>
                            <label>No</label>
                        </div>
                        @error ('available')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Descrizione: </label>
                        <textarea name="description" rows="8" cols="80" class="form-control">{{ old('description') }}</textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        Aggiungi appartamento
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

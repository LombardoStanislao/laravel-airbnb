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

        var longitude_js = "{{$apartment->longitude}}";
        console.log(longitude_js);
        var latitude_js = "{{$apartment->latitude}}";
        console.log(latitude_js);

        function callbackFn() {
            tt.services.reverseGeocode({
                key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
                position: {longitude: longitude_js, latitude: latitude_js}
            }).then(response => {
                console.log(response.addresses[0].address);
                streetName = response.addresses[0].address.streetName;
                document.querySelector("input[name='street_name']").value = streetName;
                streetNumber = response.addresses[0].address.streetNumber;
                document.querySelector("input[name='street_number']").value = streetNumber;
                municipality = response.addresses[0].address.municipality;
                document.querySelector("input[name='municipality']").value = municipality;

            })
        }

        callbackFn();

    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>
                    Modifica appartamento
                </h1>
                {{-- <button type="button" name="button" onclick = "callbackFn()">Prova</button> --}}
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
                <form id="create-apartment" method="POST" enctype="multipart/form-data" action="{{ route('admin.apartments.update', ['apartment'=> $apartment->id]) }}" onsubmit="convertAdress(event)">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Titolo riepilogativo: </label>
                        <input type="text" name="title" class="form-control" value="{{ old('title',$apartment->title) }}" maxlength="255" required>
                        @error ('title')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero di stanze: </label>
                        <input type="number" name="rooms_number" class="form-control" value="{{ old('rooms_number',
                            $apartment->rooms_number) }}" min="1" required>
                        @error ('rooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero posti letto: </label>
                        <input type="number" name="sleeps_accomodations" class="form-control" value="{{ old('sleeps_accomodations', $apartment->sleeps_accomodations) }}" min="1" required>
                        @error ('sleeps_accomodations')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero bagni: </label>
                        <input type="number" name="bathrooms_number" class="form-control" value="{{ old('bathrooms_number', $apartment->bathrooms_number) }}" min="1" required>
                        @error ('bathrooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Metri quadrati: </label>
                        <input type="number" name="mq" class="form-control" value="{{ old('mq', $apartment->mq) }}" min="1" required>
                        @error ('mq')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label>Indirizzo: </label>
                        <input id="inputAdress" type="text" name="adress" class="form-control" value="{{ old('adress', $apartment->adress) }}" required>
                        <input type="hidden" name="latitude">
                        <input type="hidden" name="longitude">
                    </div> --}}
                    <div class="form-group">
                        <label>Indirizzo:</label>
                        <div class="d-md-flex">
                            <label>Via: </label>
                            <input type="text" name="street_name" class="form-control ml-md-3 mr-md-3" value="{{ old('street_name') }}" required>
                            <label>Numero: </label>
                            <input type="text" name="street_number" class="form-control ml-md-3 mr-md-3" value="{{ old('street_number') }}" required min="1">
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
                        <input type="number" name="price_per_night" class="form-control" value="{{ old('price_per_night', $apartment->price_per_night) }}" min="0" step="0.01" required>
                        @error ('price_per_night')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Immagine di copertina: </label>
                        @if($apartment->{"main-image"})
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $apartment->{"main-image"})}}"/>
                        </div>
                        <label for="">Cambia immagine:</label>
                        @else
                            <p>Immagine di copertina non presente</p>
                        <label for="">Seleziona una nuova immagine:</label>
                        @endif
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <div class="form-group">
                        <label>Comforts:</label>
                            @foreach ($comforts as $comfort)
                                <div class="form-check">
                                {{-- quando premo il button passo al mio database un array di comfort (name="comforts[]") --}}

                                {{-- se la compilazione dell'input presenta errori --}}
                                @if($errors->any())
                                    <input type="checkbox" name="comforts[]" value="{{$comfort->id}}"
                                    {{-- se il seguente comfort ($comfort->id) è presente nell'array 'comforts' o [] (se inviato il form o meno )  allora lo seleziono --}}
                                    {{ in_array($comfort->id, old('comforts', [])) ? 'checked=checked' : ''}}>
                                @else
                                    {{-- il ternario verifica che la checkbox con il comfort corrente sia contenuta all'interno dei miei comforts, se si la seleziona '(checked=checked )' --}}
                                    <input type="checkbox" name="comforts[]" value="{{$comfort->id}}"
                                    {{$apartment->comforts->contains($comfort)?'checked=checked':''}}>
                                @endif
                                <label for="">{{$comfort->name}}</label>
                                </div>
                            @endforeach
                            {{-- visualizzo l'errore sotto l'input --}}
                            @error ('comforts')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Disponibilità appartamento: </label>
                        <div class="form-check">
                            <input type="radio" name="available" value="1" required checked
                             {{$apartment->available? 'checked=checked' : ''}}>
                            <label>Sì</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="available" value="0" required
                            {{$apartment->available? '' : 'checked=checked'}}>
                            <label>No</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Descrizione: </label>
                        <textarea name="description" rows="8" cols="80" class="form-control">{{ old('description', $apartment->description) }}</textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        Conferma Modifiche
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

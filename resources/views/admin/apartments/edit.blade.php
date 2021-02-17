@extends('layouts.dashboard')

@section('page-title', 'Aggiungi appartamento')

@section('scripts')
    <script type="text/javascript" defer>
        var title = "{{ $apartment->title }}";
        var roomsNumber = "{{ $apartment->rooms_number }}";
        var sleepsAccomodations = "{{ $apartment->sleeps_accomodations }}";
        var bathroomsNumber = "{{ $apartment->bathrooms_number }}";
        var mq = "{{ $apartment->mq }}";
        var latitude = "{{ $apartment->latitude }}";
        var longitude = "{{ $apartment->longitude }}";
        var pricePerNight = "{{ $apartment->price_per_night }}";
        var description = "{{ $apartment->description }}";
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>
                    Modifica appartamento
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
                <form ref="editApartment" id="edit-apartment" method="POST" enctype="multipart/form-data" action="{{ route('admin.apartments.update', ['apartment'=> $apartment->id]) }}" @submit.prevent="submitForm()" v-cloak>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Titolo riepilogativo: </label>
                        <input type="text" name="title" class="form-control" v-model="title" maxlength="255" required>
                        @error ('title')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero di stanze: </label>
                        <input type="number" name="rooms_number" class="form-control" v-model="roomsNumber" min="1" required>
                        @error ('rooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero posti letto: </label>
                        <input type="number" name="sleeps_accomodations" class="form-control" v-model="sleepsAccomodations" min="1" required>
                        @error ('sleeps_accomodations')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero bagni: </label>
                        <input type="number" name="bathrooms_number" class="form-control" v-model="bathroomsNumber" min="1" required>
                        @error ('bathrooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Metri quadrati: </label>
                        <input type="number" name="mq" class="form-control" v-model="mq" min="1" required>
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
                            <input type="text" name="street_name" class="form-control ml-md-3 mr-md-3" v-model="streetName" required>
                            <label>Numero: </label>
                            <input type="text" name="street_number" class="form-control ml-md-3 mr-md-3" v-model="streetNumber" required min="1">
                            <label>Città: </label>
                            <input type="text" name="municipality" class="form-control ml-md-3" v-model="municipality" required>
                        </div>
                        <input type="hidden" name="latitude" v-model="latitude">
                        <input type="hidden" name="longitude" v-model="longitude">
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
                        <input type="number" name="price_per_night" class="form-control" v-model="pricePerNight" min="0" step="0.01" required>
                        @error ('price_per_night')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Immagine di copertina: </label>
                        <div class="mb-3">
                            <img class="mw-100" src="{{ asset('storage/' . $apartment->{"main-image"})}}"/>
                        </div>
                        <label>Seleziona una nuova immagine:</label>
                        <input ref="inputFile" type="file" class="form-control-file" name="image">
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
                        <textarea name="description" rows="8" cols="80" class="form-control">@{{ description }}</textarea>
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

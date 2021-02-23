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
        var address = "{{ $apartment->adress }}";
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
                        <div v-if="submitted && !title" class="alert alert-danger">
                            Il titolo è un campo obbligatorio
                        </div>
                        <div v-else-if="title.length > 255" class="alert alert-danger">
                            Il titolo non può essere più lungo di 255 caratteri
                        </div>
                        @error ('title')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero di stanze: </label>
                        <input type="number" name="rooms_number" class="form-control" v-model="roomsNumber" min="1" required>
                        <div v-if="!roomsNumber" class="alert alert-danger">
                            Il numero di stanze è un campo obbligatorio
                        </div>
                        <div v-else-if="roomsNumber < 1" class="alert alert-danger">
                            Il numero di stanze dev'essere maggiore di zero
                        </div>
                        <div v-else-if="roomsNumber > 255" class="alert alert-danger">
                            Il numero di stanze non può essere maggiore di 255
                        </div>
                        @error ('rooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero posti letto: </label>
                        <input type="number" name="sleeps_accomodations" class="form-control" v-model="sleepsAccomodations" min="1" required>
                        <div v-if="!sleepsAccomodations" class="alert alert-danger">
                            Il numero di posti letto è un campo obbligatorio
                        </div>
                        <div v-else-if="sleepsAccomodations < 1" class="alert alert-danger">
                            Il numero di posti letto dev'essere maggiore di zero
                        </div>
                        <div v-else-if="sleepsAccomodations > 255" class="alert alert-danger">
                            Il numero di posti letto non può essere maggiore di 255
                        </div>
                        @error ('sleeps_accomodations')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Numero bagni: </label>
                        <input type="number" name="bathrooms_number" class="form-control" v-model="bathroomsNumber" min="1" required>
                        <div v-if="!bathroomsNumber" class="alert alert-danger">
                            Il numero di bagni è un campo obbligatorio
                        </div>
                        <div v-else-if="bathroomsNumber < 1" class="alert alert-danger">
                            Il numero di bagni dev'essere maggiore di zero
                        </div>
                        <div v-else-if="bathroomsNumber > 255" class="alert alert-danger">
                            Il numero di bagni non può essere maggiore di 255
                        </div>
                        @error ('bathrooms_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Metri quadrati: </label>
                        <input type="number" name="mq" class="form-control" v-model="mq" min="1" required>
                        <div v-if="submitted && !mq" class="alert alert-danger">
                            Il numero di metri quadrati è un campo obbligatorio
                        </div>
                        <div v-else-if="!isNaN(parseInt(mq)) && mq < 1" class="alert alert-danger">
                            Il numero di metri quadrati dev'essere maggiore di zero
                        </div>
                        <div v-else-if="mq > 255" class="alert alert-danger">
                            Il numero di metri quadrati non può essere maggiore di 255
                        </div>
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
                        <input type="hidden" name="address" v-model="address">
                        <div v-if="submitted && !streetName" class="alert alert-danger">
                            Il nome della via è un campo obbligatorio
                        </div>
                        @error ('street_name')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <div v-if="submitted && !streetNumber" class="alert alert-danger">
                            Il numero della via è un campo obbligatorio
                        </div>
                        <div v-else-if="!isNaN(parseInt(streetNumber)) && streetNumber < 1" class="alert alert-danger">
                            Il numero della via dev'essere maggiore di zero
                        </div>
                        @error ('street_number')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <div v-if="submitted && !municipality" class="alert alert-danger">
                            La città è un campo obbligatorio
                        </div>
                        @error ('municipality')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <div v-if="noAdressFound" class="alert alert-danger">
                            L'indirizzo non è valido
                        </div>
                        @if ($errors->getMessageBag()->has('latitude') || $errors->getMessageBag()->has('longitude'))
                            <div class="alert alert-danger">
                                The adress is not valid
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Prezzo per notte: </label>
                        <input type="number" name="price_per_night" class="form-control" v-model="pricePerNight" min="0" step="0.01" required>
                        <div v-if="submitted && !pricePerNight" class="alert alert-danger">
                            Il prezzo per notte è un campo obbligatorio
                        </div>
                        <div v-else-if="pricePerNight < 0" class="alert alert-danger">
                            Il prezzo per notte non può essere negativo
                        </div>
                        <div v-else-if="pricePerNight > 9999.99" class="alert alert-danger">
                            Il prezzo per notte non può superare i 9999.99 euro
                        </div>
                        @error ('price_per_night')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Immagine principale: </label>
                        <img src="{{ asset("storage/" . $apartment->{"main-image"}) }}" class="mw-100">
                        <label>Scegli un'altra immagine: </label>
                        <input ref="inputFile" type="file" class="form-control-file" name="image" accept="image/*">
                        <div v-if="!imageValid" class="alert alert-danger">
                            L'immagine deve essere di uno dei seguenti tipi: jpeg, png, jpg, gif, svg
                        </div>
                        @error ('image')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Immagini secondarie: </label>
                        @foreach ($images as $image)
                            <div class="w-25 h-25 d-inline-block">
                                <img src="{{ asset("storage/" . $image->url) }}" class="mw-100 mh-100">
                            </div>
                        @endforeach
                        <input ref="inputFile" type="file" multiple accept="image/*" class="form-control-file " name="images[]" accept="image/*">
                        <div v-if="!imageValid" class="alert alert-danger">
                            L'immagine deve essere di uno dei seguenti tipi: jpeg, png, jpg, gif, svg
                        </div>
                        @error ('image')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label>Comforts:</label>
                            @foreach ($comforts as $comfort)
                                <div class="form-check">
                                    @if($errors->any())
                                        <input type="checkbox" name="comforts[]" value="{{$comfort->id}}"
                                        {{ in_array($comfort->id, old('comforts', [])) ? 'checked=checked' : ''}}>
                                    @else
                                        <input type="checkbox" name="comforts[]" value="{{$comfort->id}}"
                                        {{ $apartment->comforts->contains($comfort) ? 'checked=checked' : '' }}>
                                    @endif
                                    <label class="form-check-label">{{$comfort->name}}</label>
                                </div>
                            @endforeach
                            @error ('comforts')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label>Disponibilità appartamento: </label>
                        <div class="form-check">
                            <input type="radio" name="available" value="1" required
                             {{ $apartment->available ? 'checked=checked' : '' }}>
                            <label>Sì</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="available" value="0" required
                            {{ $apartment->available ? '' : 'checked=checked' }}>
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
                        <textarea name="description" rows="8" cols="80" class="form-control">@{{ description }}</textarea>
                        <div v-if="description.length > 65535" class="alert alert-danger">
                            La descrizione non può superare i 65535 caratteri
                        </div>
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

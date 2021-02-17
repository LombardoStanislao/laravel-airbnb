@extends('layouts.dashboard')

@section('page-title', 'Aggiungi appartamento')

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
                <form ref="createApartment" id="create-apartment" method="POST" enctype="multipart/form-data" action="{{ route('admin.apartments.store') }}" @submit.prevent="submitForm()" v-cloak>
                    @csrf
                <form id="create-apartment" method="POST" enctype="multipart/form-data" action="{{ route('admin.apartments.store') }}" onsubmit="convertAdress(event)">
                    @csrf
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
                        <input type="number" name="rooms_number" class="form-control" v-model="roomsNumber" min="1" max="255" required>
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
                        <input type="number" name="sleeps_accomodations" class="form-control" v-model="sleepsAccomodations" min="1" max="255" required>
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
                        <input type="number" name="bathrooms_number" class="form-control" v-model="bathroomsNumber" min="1" max="255" required>
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
                        <input type="number" name="mq" class="form-control" v-model="mq" min="1" max="255" required>
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
                            <input type="number" name="street_number" class="form-control ml-md-3 mr-md-3" v-model="streetNumber" required min="1">
                            <label>Città: </label>
                            <input type="text" name="municipality" class="form-control ml-md-3" v-model="municipality" required>
                        </div>
                        <input type="hidden" name="latitude" v-model="latitude">
                        <input type="hidden" name="longitude" v-model="longitude">
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
                        <input type="number" name="price_per_night" class="form-control" v-model="pricePerNight" min="0" max="9999.99" step="0.01" required>
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
                        <label>Immagine di copertina: </label>
                        <input ref="inputFile" type="file" class="form-control-file" name="image" accept="image/*" required>
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
                        <textarea name="description" rows="8" cols="80" class="form-control" max="65535">@{{ description }}</textarea>
                        <div v-if="description.length > 65535" class="alert alert-danger">
                            L'immagine deve essere di uno dei seguenti tipi: jpeg, png, jpg, gif, svg
                        </div>
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

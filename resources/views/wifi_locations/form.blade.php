<form action="{{ $subtitle == 'Edit Data' ? route($route.'.update_process', @$data_row->id) : route($route.'.store') }}" method="post" class="form-validate-ajax" enctype="multipart/form-data" >
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="font-weight-semibold">Wifi Name  <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama" value="{{ @$data_row->name }}" required >
            </div>
            <div class="form-group">
                <label class="font-weight-semibold">SSID Wifi Name  <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ssid_name" name="ssid_name" placeholder="Masukkan nama" value="{{ @$data_row->ssid_name }}" required >
            </div>
            <div class="form-group">
                <label class="font-weight-semibold">Description<span class="text-danger">*</span></label>
                <textarea class="form-control" id="desc" name="desc" placeholder="Masukkan deskripsi" required >{{ @$data_row->desc }}</textarea>
            </div>
            <div class="form-group">
                <label class="font-weight-semibold">Latitude <span class="text-danger">*</span></label>
                <input type="text" class="form-control"  name="latitude" id="latitude" value="{{ empty($data_row->latitude) ? -6.299176829599384 : $data_row->latitude }}" required onkeyup="handleChange()">
            </div>
            <div class="form-group">
                <label class="font-weight-semibold">Longitude <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="longitude" id="longitude" value="{{ empty($data_row->longitude) ? 107.29902714304457 : $data_row->longitude }}" required onkeyup="handleChange()">
            </div>
            <div class="form-group ">
                <label class="font-weight-semibold ">Kecamatan  <span class="text-danger">*</span></label>
                <div class="">
                    <select type="text" class="form-control select-search-kecamatan" id="kecamatan_id" name="kecamatan_id" placeholder="Enter" onchange="handleKecamatanChange(this.value)" required >
                        <option value="">Choose One</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $kecamatan->id == @$data_row->kecamatan_id ? 'selected' : ''}} >{{ $kecamatan->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="font-weight-semibold ">Desa  <span class="text-danger">*</span>
                    @if($subtitle != 'Edit Data')
                    <br/><span class="text-muted">Pilih salah satu Kecamatan terlebih dahulu</span>
                    @endif
                </label>
                <div class="">
                    <select type="text" class="form-control select-search-desa" id="desa_id" name="desa_id" placeholder="Enter" required >
                        <option value="">Choose One</option>
                        @if($subtitle == 'Edit Data')
                            @foreach($desas as $row)
                                <option value="{{ $row->id }}" {{ $row->id == @$data_row->desa_id ? 'selected' : ''}} >{{ $row->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="font-weight-semibold">Status </label>
                <div class="form-check form-check-switchery">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-input-switchery" {{ !empty($data_row->is_active) == 1 ? 'checked' : '' }} data-fouc value="1" name="is_active" id="is_active">
                        Active
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <label for="" class=""><b class="label">Titik Koordinat Lokasi </b> <span class="text-muted"><br/>Geser dan pilih lokasi. <br/>Pastikan marker merah berpindah sesuai lokasi yang Anda pilih </span></label>
            <div id="show-map" style="height:80%;min-height:300px;">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <input type="hidden" name="submit" id="submit-type" value="submit" />
                <button type="submit"  id="submit" value="submit" class="btn bg-transparent text-blue border-blue mr-2 btn-submit" onclick="(function(){$('#submit-type').val('submit');return true;})();return true;">Submit<i class="icon-paperplane ml-2"></i></button>
                <button type="submit"  id="submit-back" value="submit-back" class="btn bg-transparent text-blue border-blue mr-2 btn-submit-back" onclick="(function(){$('#submit-type').val('submit-back');return true;})();return true;">Submit & Back<i class="icon-paperplane ml-2"></i></button>
            </div>
        </div>
    </div>
</form>

<script>
    const handleKecamatanChange = (param = 0) => {
        if(param == null || param == undefined || param == 0){
            return false;
        }
        var notif = new Noty({
                        text: '<i class="icon-spinner4 spinner"></i> Loading data',
                        type: 'info',
                        timeout: false,
                    }).show();
        $.ajax({
            type: 'GET',
            url: "{{ route('desas.search_by_kecamatan') }}/"+param,
            success: function(data){
                $('#desa_id').html(data);
                notif.close();
            },
            cache: false,
            contentType: false,
            processData: false,
            error: function(data) {
                swalInit.fire("Failed", "Periksa koneksi internet Anda", "error");
                notif.close();
            },
            statusCode: {
                //to handle ci
                403: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    notif.close();
                },
                //to handle laravel
                419: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    notif.close();
                }
            }
        });
    }

    $( document ).ready(function() {
        initMap();
        var $select = $('.select-search-kecamatan').select2({
            allowClear: true,
            escapeMarkup: function (markup) { return markup; },
            placeholder: "Choose One",
            language: {
                noResults: function () {
                    return `<a href="{{ route('kecamatans.create') }}"><i class='icon-plus2'></i> Tambah data baru</a>`;
                }
            }
        });

        var $select = $('.select-search-desa').select2({
            allowClear: true,
            escapeMarkup: function (markup) { return markup; },
            placeholder: "Choose One",
            language: {
                noResults: function () {
                    return `<a href="{{ route('desas.create') }}"><i class='icon-plus2'></i> Tambah data baru</a>`;
                }
            }
        });
    });
    
    function initMap(position = {coords : {latitude : <?php echo empty($data_row->latitude) ? -6.299176829599384 : $data_row->latitude ;?>,longitude : <?php echo empty($data_row->longitude) ? 107.29902714304457 : $data_row->longitude ;?>, accuracy : '10'}}) {
        var coords = {
            lat: parseFloat(position.coords.latitude),
            lng: parseFloat(position.coords.longitude)
        };
        const map = new google.maps.Map(document.getElementById("show-map"), {
            zoom: 16,
            center: coords
        });
        var marker = addMarker(coords, map);

        var radius = $('#radius').val();
        var circle = addCircle(radius, coords, map)

        var infowindow = new google.maps.InfoWindow({
        content: `<?php echo empty($data_row->name) ? 'Pilih titik lokasi' : $data_row->name;?>`,
        position: coords
        });

        infowindow.open(map, marker);

        google.maps.event.addListener(map, "click", event => {
            marker.setMap(null);
            circle.setMap(null);
            marker = addMarker(event.latLng, map);

            var infowindow = new google.maps.InfoWindow({
            content: `<b>Titik Koordinat</b> <br/>Lat : <b>${event.latLng.lat()}</b><br/> Lng : <b>${event.latLng.lng()}`,
            position: event.latLng
            });

            infowindow.open(map, marker);

            $('#latitude').val(event.latLng.lat());
            $('#longitude').val(event.latLng.lng());

            radius = $('#radius').val();
            coords = {
                lat: parseFloat(event.latLng.lat()),
                lng: parseFloat(event.latLng.lng())
            };
            circle = addCircle(radius, coords, map)
        });

    }

    function addMarker(location, map) {
        return new google.maps.Marker({
            position: location,
            map: map
        });
    }

    function addCircle(radius, location, map){
        console.log(location);
        return new google.maps.Circle({
            strokeColor: '#ffa534',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#ffa534',
            fillOpacity: 0.35,
            map: map,
            center: new google.maps.LatLng(location.lat, location.lng),
            radius: radius == "" ? 1 : parseInt(radius)
        });
    }

    function handleChange(){
        const position = {coords : {latitude : $('#latitude').val() ,longitude : $('#longitude').val(), accuracy : '10'}}
        initMap(position);
    }
</script>

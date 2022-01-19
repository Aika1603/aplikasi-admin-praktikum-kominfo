<form action="{{ $subtitle == 'Edit Data' ? route($route.'.update_process', @$data_row->id) : route($route.'.store') }}" method="post" class="form-validate-ajax" enctype="multipart/form-data" >
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <label class="font-weight-semibold col-md-2 col-form-label">Name  <span class="text-danger">*</span></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name " value="{{ @$data_row->name }}" required >
                </div>
            </div>
            <div class="form-group row">
                <label class="font-weight-semibold col-md-2 col-form-label">Kecamatan  <span class="text-danger">*</span></label>
                <div class="col-md-10 pb-2">
                    <select type="text" class="form-control select-search-kecamatan" id="kecamatan_id" name="kecamatan_id" placeholder="Enter"  required >
                        <option value="">Choose One</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $kecamatan->id == @$data_row->kecamatan_id ? 'selected' : ''}} >{{ $kecamatan->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <br/>
            <div class="form-group">
                <input type="hidden" name="submit" id="submit-type" value="submit" />
                <button type="submit"  id="submit" value="submit" class="btn bg-transparent text-blue border-blue mr-2 btn-submit" onclick="(function(){$('#submit-type').val('submit');return true;})();return true;">Submit<i class="icon-paperplane ml-2"></i></button>
                <button type="submit"  id="submit-back" value="submit-back" class="btn bg-transparent text-blue border-blue mr-2 btn-submit-back" onclick="(function(){$('#submit-type').val('submit-back');return true;})();return true;">Submit & Back<i class="icon-paperplane ml-2"></i></button>
            </div>
        </div>
    </div>
</form>

<script>
    $( document ).ready(function() {
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
    })
</script>
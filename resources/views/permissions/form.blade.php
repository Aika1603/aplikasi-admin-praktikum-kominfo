<form action="{{ $subtitle == 'Edit Data' ? route($route.'.update_process', @$data_row->id) : route($route.'.store') }}" method="post" class="form-validate-ajax" enctype="multipart/form-data" >
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <label class="font-weight-semibold col-md-2 col-form-label">Menu  <span class="text-danger">*</span></label>
                <div class="col-md-10 pb-2">
                    <select type="text" class="form-control select-search-menu" id="menu_id" name="menu_id" placeholder="Enter" onchange="handleMenuChange(this)"  required >
                        <option value="">Choose One</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ $menu->id == @$data_row->menu_id ? 'selected' : ''}} >{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="font-weight-semibold col-md-2 col-form-label">Action  <span class="text-danger">*</span></label>
                <div class="col-md-10 pb-2">
                    <select type="text" class="form-control select-search-action" id="action_id" name="action_id" placeholder="Enter" onchange="handleActionChange(this)" required >
                        <option value="">Choose One</option>
                        @foreach($actions as $action)
                            <option value="{{ $action->id }}" {{ $action->id == @$data_row->action_id ? 'selected' : ''}} >{{ $action->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="font-weight-semibold col-md-2 col-form-label">Name Permission  <span class="text-danger">*</span></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="name" name="name" value="{{ @$data_row->name }}" readonly >
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
        var $select = $('.select-search-menu').select2({
            allowClear: true,
            escapeMarkup: function (markup) { return markup; },
            placeholder: "Choose One",
            language: {
                noResults: function () {
                    return `<a href="{{ route('menus.create') }}"><i class='icon-plus2'></i> Tambah menu baru</a>`;
                }
            }
        });

        var $select = $('.select-search-action').select2({
            allowClear: true,
            escapeMarkup: function (markup) { return markup; },
            placeholder: "Choose One",
            language: {
                noResults: function () {
                    return `<a href="{{ route('actions.create') }}"><i class='icon-plus2'></i> Tambah action baru</a>`;
                }
            }
        });
    })

    const handleMenuChange = (param) => {
        if($('#action_id').val() == ''){
            return false;
        }
        let menu = $(param).find(":selected").text().toLowerCase();
        let action = $('#action_id').find(":selected").text().toLowerCase();
        $('#name').val(menu+'-'+action)
    }

    const handleActionChange = (param) => {
        if($('#menu_id').val() == ''){
            return false;
        }
        let action = $(param).find(":selected").text().toLowerCase();
        let menu = $('#menu_id').find(":selected").text().toLowerCase();
        $('#name').val(menu+'-'+action)
    }
</script>
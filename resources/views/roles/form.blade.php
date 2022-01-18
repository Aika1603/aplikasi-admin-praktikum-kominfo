<form action="{{ $subtitle == 'Edit Data' ? route($route.'.update_process', @$data_row->id) : route($route.'.store') }}" method="post" class="form-validate-ajax" enctype="multipart/form-data" >
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <label class="font-weight-semibold col-md-2 col-form-label">Name  <span class="text-danger">*</span></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ @$data_row->name }}" required >
                </div>
            </div>
            <div class="form-group row">
                <label class="font-weight-semibold col-md-2 col-form-label">Description </label>
                <div class="col-md-10">
                    <textarea type="text" class="form-control" id="desc" name="desc" placeholder="Enter description" rows="4">{{ @$data_row->desc }}</textarea>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <label class="font-weight-semibold col-md-12 custom-checkbox-parent" style="margin-bottom:0px;">
                    Role Permissions  <span class="text-danger">*</span> 
                    <div class="custom-control custom-checkbox font-weight-normal">
                        <input type="checkbox" class="custom-control-input" value="0" id="is_all_check" name="is_all_check" >
                        <label class="custom-control-label" for="is_all_check"> Beri tanda check pada semua permissions</label>
                    </div>
                </label>
                <div class="col-md-12">
                    <div class="row">
                        <?php $last = 0;?>
                        @foreach($list_permission as $value)
                        <?php 
                            $check = $subtitle == 'Edit Data' ? in_array($value->id, $rolePermissions) ? "checked" : "" : "";?>
                            @if($last != $value->menu_id)
                                <label class="font-weight-semibold mt-3 col-sm-12" style="margin-bottom:0">{{ $value->menu_name }}</label>
                            @endif
                                <div class="col-sm-6 mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" {{ $check }}  value="{{ $value->id }}" id="{{ $value->id }}-permission"  name="permission[]" >
                                        <label class="custom-control-label" for="{{ $value->id }}-permission"> {{ ucfirst(str_replace("-", " ", $value->name)) }} ({{ $value->name }})</label>
                                    </div>
                                </div>
                            <?php 
                            $last = $value->menu_id;?>
                        @endforeach
                    </div>
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
    $('#is_all_check').on('click', () => {
        if($('#is_all_check').is(':checked')){
            $('.custom-control-input').prop('checked', true);
        }else{
            $('.custom-control-input').prop('checked', false);
        }
    })

</script>
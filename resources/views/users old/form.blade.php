<form action="{{ $subtitle == 'Edit' ? url('/users/edit_process/'.@$user->id) : route('users.add') }}" method="post" class="form-validate-ajax " enctype="multipart/form-data" >
    @csrf
    <div class="row">
        <div class="col-lg-5">
            <div class="form-group">
                <label class="font-weight-semibold">Photo</label>
                @if(!empty(@$user->avatar))
                    <!-- edit -->
                    <input type="file" name="avatar" id="avatar" class="file-input-overwrite" url_file="{{ !empty(@$user->avatar) ? asset('/assets/avatar/'.@$user->avatar) : '' }}" caption="{{ !empty(@$user->avatar) ? @$user->avatar : '' }}" data-show-caption="false" data-show-upload="false"   data-fouc  />
                    <span class="form-text text-muted"> Only file <code>jpg</code>, <code>png</code> and <code>jpeg</code> extensions are allowed. Max size file 1MB</span>
                @else
                    <!-- insert -->
                    <input type="file" name="avatar" id="avatar" class="file-input-extensions" data-show-caption="false" data-show-upload="false"  data-fouc  >
                    <span class="form-text text-muted"> Only file <code>jpg</code>, <code>png</code> and <code>jpeg</code> extensions are allowed. Max size file 1MB</span>
                @endif
            </div>
        </div>
        <div class="col-lg-7">
            <div class="form-group">
                <label class="font-weight-semibold">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="{{ @$user->username }}" {{ $subtitle != 'Edit' ? 'required' : 'readonly' }}  >
                <span class="text-danger">{{ $subtitle != 'Edit' ? '' : "can't be changed" }}</span>
                <input type="hidden" name="old-username"  value="{{ @$user->username }}">
            </div>
            <div class="form-group">
                <label class="font-weight-semibold">Email  <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat email aktif" value="{{ @$user->email }}" {{ $subtitle != 'Edit' ? 'required' : 'readonly' }}  >
                <span class="text-danger">{{ $subtitle != 'Edit' ? '' : "can't be changed" }}</span>
                <input type="hidden" name="old-email"  value="{{ @$user->email }}">
            </div>
            <div class="form-group">
                <label class="font-weight-semibold">Full Name  <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama" value="{{ @$user->name }}" required >
            </div>
            <div class="form-group">
                <label class="font-weight-semibold">Phone Number  <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan No HP " value="{{ @$user->phone_number }}" required >
            </div>
            @if($subtitle != 'Edit')
                <div class="form-group">
                    <label class="font-weight-semibold">Password </label>
                    <div class="alert alert-info  alert-dismissible">
                        Password default adalah <a class="alert-link">{{ config('app.default_pass', '123123123') }}</a>
                    </div>
                </div>
            @else
                <div class="form-group">
                    <label class="font-weight-semibold">Status User </label>
                    <div class="form-check form-check-switchery">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-input-switchery" {{ !empty($user->is_suspend) == 1 ? 'checked' : '' }} data-fouc value="1" name="is_suspend" id="is_suspend">
                            Suspend
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-semibold">Password </label>
                    <div class="form-check form-check-switchery">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-input-switchery"  data-fouc value="1" name="is_reset" id="is_reset">
                            Reset Password
                        </label>
                    </div>
                </div>
                <div class="alert alert-info alert-styled-left alert-dismissible">
                    Reset Password akan merubah password menjadi default <a class="alert-link">{{ config('app.default_pass', '123123123') }}</a>
                </div>
            @endif
            <hr/>
            <div class="form-group">
                <label class="font-weight-semibold">Roles  <span class="text-danger">*</span></label>
                @foreach($roles as $role)
                    {{ $check = "" }}
                    @if(@$user->roles != [])
                        @foreach($user->roles as $currentRole)
                            @if($currentRole->id == $role->id)
                                <?php $check = "checked";?>
                            @endif
                        @endforeach
                    @endif
                <div class="form-check form-check-switchery">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-input-switchery" {{ $check }}  {!! $role->name == 'driver' ? 'onclick="isDriver(this.value)"' : '' !!}  value="{{ $role->id }}"  id="{{ $role->id }}-role"  name="roles[]" required>
                        {{ ucfirst($role->name) }}
                    </label>
                </div>
                @endforeach
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
    const isDriver = (param) => {
        return true;
    }
</script>

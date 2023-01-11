<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-sm-2 col-form-label">
        Messengers contacts
    </label>
    <div class="col-sm-3 col-form-label">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">
                    <i class="fab fa-viber fa-2x text-primary"></i>
                </div>
                <input
                        style="opacity: 0"
                        class="form-check-input form-control"
                        type="checkbox"
                        name="messengers_arr[check][]"
                        value="viber"
                        @if(!empty($msg && isset($msg->viber))) checked @endif
                >
            </div>

            <input type="text" class="form-control"
                   placeholder="Viber"
                   name="messengers_arr[val][viber]"
                   value="{{$msg->viber ?? old('phone', str_replace("+","", $phone))}}" {{--pattern="[0-9]{12}"--}}>
        </div>
    </div>
    <div class="col-sm-3 col-form-label">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">
                    <i class="fab fa-whatsapp fa-2x text-success"></i>
                </div>
                <input
                        style="opacity: 0"
                        class="form-check-input form-control"
                        type="checkbox"
                        name="messengers_arr[check][]"
                        value="whatsapp"
                        @if(!empty($msg && isset($msg->whatsapp))) checked @endif
                >
            </div>

            <input type="text" class="form-control" placeholder="Whatsapp"
                   name="messengers_arr[val][whatsapp]"
                   value="{{$msg->whatsapp ?? old('phone', str_replace("+","", $phone))}}" {{--pattern="[0-9]{12}"--}}>
        </div>
    </div>
    <div class="col-sm-3 col-form-label">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">
                    <i class="fab fa-telegram fa-2x text-info"></i>
                </div>
                <input
                        style="opacity: 0"
                        class="form-check-input form-control"
                        type="checkbox"
                        name="messengers_arr[check][]"
                        value="telegram"
                        @if(!empty($msg && isset($msg->telegram))) checked @endif
                >
            </div>

            <input type="text" class="form-control" placeholder="Telegram"
                   name="messengers_arr[val][telegram]"
                   value="{{$msg->telegram ?? ''}}">
        </div>
    </div>
</div>


<div class="form-group m-form__group row">
    <label class="col-2 col-form-label"></label>
    <div class="col-sm-3 col-form-label">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">
                    <i class="fab fa-skype fa-2x text-info"></i>
                </div>
                <input
                        style="opacity: 0"
                        class="form-check-input form-control"
                        type="checkbox"
                        name="messengers_arr[check][]"
                        value="skype" @if(!empty($msg && isset($msg->skype))) checked @endif
                >
            </div>

            <input type="text" class="form-control" placeholder="Skype"
                   name="messengers_arr[val][skype]"
                   value="{{$msg->skype ?? ''}}">
        </div>
    </div>
    <div class="col-sm-3 col-form-label">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">
                    <i class="fab fa-facebook-f fa-2x text-primary"></i>
                </div>
                <input
                        style="opacity: 0"
                        class="form-check-input form-control"
                        type="checkbox"
                        name="messengers_arr[check][]"
                        value="facebook" @if(!empty($msg && isset($msg->facebook))) checked @endif
                >
            </div>

            <input type="text" class="form-control" placeholder="Facebook"
                   name="messengers_arr[val][facebook]"
                   value="{{$msg->facebook ?? ''}}">
        </div>
    </div>
    <div class="col-sm-3 col-form-label">
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">
                    <i class="fab fa-vk fa-2x text-primary"></i>
                </div>
                <input
                        style="opacity: 0"
                        class="form-check-input form-control"
                        type="checkbox"
                        name="messengers_arr[check][]"
                        value="vk" @if(!empty($msg && isset($msg->vk))) checked @endif
                >
            </div>

            <input type="text" class="form-control" placeholder="VK"
                   name="messengers_arr[val][vk]"
                   value="{{$msg->vk ?? ''}}">
        </div>
    </div>
</div>

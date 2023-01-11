<li>
    <span>
        Messengers contacts
    </span>
</li>
@if(!empty($msg && isset($msg->viber)))
    <li>
        <span><a href="viber://chat?number={{$msg->viber}}" class="mr-2" target="_blank"><span class="btn btn-light"><i class="fa fab fa-viber"></i> Viber </span></a> {{$msg->viber}} </span>
    </li>
@endif
@if(!empty($msg && isset($msg->whatsapp)))
    <li>
        <span><a href="https://wa.me/{{$msg->whatsapp}}" class="mr-2" target="_blank"><span class="btn btn-light"><i class="fa fab fa-whatsapp"></i> Whatsapp </span></a> {{$msg->whatsapp}}</span>
    </li>
@endif
@if(!empty($msg && isset($msg->telegram)))
    <li>
        <span><a href="https://telegram.me/{{$msg->telegram}}" class="mr-2" target="_blank"><span class="btn btn-light"><i class="fa fab fa-telegram"></i> Telegram </span></a> {{$msg->telegram}}</span>
    </li>
@endif
@if(!empty($msg && isset($msg->skype)))
    <li>
        <span><a href="skype:{{$msg->skype}}?chat" class="mr-2" target="_blank"><span class="btn btn-light"><i class="fa fab fa-skype"></i> Skype </span></a> {{$msg->skype}} </span>
    </li>
@endif
@if(!empty($msg && isset($msg->facebook)))
    <li>
        <span><a href="https://www.facebook.com/" class="mr-2" target="_blank"><span class="btn btn-light"><i class="fa fab fa-facebook"></i> facebook </span></a> {{$msg->facebook}} </span>
    </li>
@endif
@if(!empty($msg && isset($msg->vk)))
    <li>
        <span><a href="https://vk.com" class="mr-2" target="_blank"><span class="btn btn-light"><i class="fa fab fa-vk"></i> VK </span></a> {{$msg->vk}} </span>
    </li>
@endif
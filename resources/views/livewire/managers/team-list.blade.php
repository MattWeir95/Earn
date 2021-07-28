<div>
   {{ $response }}
   @foreach ($services as $service)
       <x-jet-label value="Name: {{ $service->app_name }}" />
        <x-jet-label value="Token: {{ $service->access_token }}" />
   @endforeach
</div>

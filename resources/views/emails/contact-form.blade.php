<h2>Nuevo mensaje de contacto</h2>

<p><strong>Nombre:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>

@if (!empty($data['subject']))
    <p><strong>Asunto:</strong> {{ $data['subject'] }}</p>
@endif

@if (!empty($data['department']))
    <p><strong>Departamento:</strong> {{ $data['department'] }}</p>
@endif

<p><strong>Mensaje:</strong></p>
<p>{{ $data['message'] }}</p>

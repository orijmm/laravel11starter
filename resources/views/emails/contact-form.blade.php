<div
    style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <!-- Header -->
    <div style="background-color: #007BFF; color: #ffffff; padding: 20px; text-align: center;">
        <h1 style="margin: 0; font-size: 24px;">{{ env('APP_NAME', 'Mi Empresa') }}</h1>
        <p style="margin: 0; font-size: 14px;">Nuevo mensaje de contacto</p>
    </div>

    <!-- Contenido del mensaje -->
    <div style="padding: 20px; color: #333333;">
        <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>

        @if (!empty($data['phone']))
            <p><strong>Teléfono:</strong> {{ $data['phone'] }}</p>
        @endif

        @if (!empty($data['company']))
            <p><strong>Empresa:</strong> {{ $data['company'] }}</p>
        @endif

        @if (!empty($data['subject']))
            <p><strong>Asunto:</strong> {{ $data['subject'] }}</p>
        @endif

        <p><strong>Mensaje:</strong></p>
        <p style="white-space: pre-line;">{{ $data['message'] }}</p>
    </div>

    <!-- Footer -->
    <div style="background-color: #f0f0f0; color: #666666; text-align: center; padding: 15px; font-size: 12px;">
        Este mensaje fue enviado desde el formulario de contacto del sitio <strong>{{ env('APP_URL') }}</strong>.
    </div>
</div>

@component('mail::message')
# Introduction

bienvenido a **Programación y  más** !

Espero que el material del sitio te sea de ayuda, y puedas mejorar tus habilidades en programación.

Lo primero que debes hacer es confirmar tu correo electrónico haciendo clic en el siguiente enlace,


@component('mail::button', ['url' => ''])
Clic para confirmar tu email
@endcomponent
 
De esta forma podremos estar en contacto.

Y si llegas a olvidar tu contraseña, la podrás recuperar a través de este correo.

Saludos, y que estés bien !

Thanks,<br>
{{ config('app.name') }}
@endcomponent

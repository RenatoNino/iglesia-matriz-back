<?php

namespace App\Http\Enums;

class EmailBodyTemplate
{
    const credentials = '
    <div class="container">
        <h1>Bienvenido a la Institución {{institutionName}}</h1>
        <p>Hola {{name}}</p>
        <p>Te enviamos las credenciales para acceder a tu Institución: <a href="{{institutionUrl}}">{{institutionName}}</a></p>
        <ul>
            <li><strong>Correo:</strong> {{email}}</li>
            <li><strong>Contraseña:</strong> {{password}}</li>
        </ul>
        <p>Te recomendamos cambiar tu contraseña desde tu perfil, puedes hacer esto en cualquier momento.</p>
    </div>
    ';

    const createContent = '
    <div class="container">
        <h1>Hola {{name}}</h1>
        <h4>¡Te notificamos la disponibilidad de nuevo contenido!</h4>
        <hr>
        <p><strong>Curso:</strong> {{courseName}}</p>
        <p><strong>Docente:</strong> {{teacherName}}</p>
    </div>
    ';

    const updateContent = '
    <div class="container">
        <h1>Hola {{name}}</h1>
        <h4>¡Te notificamos que se ah actualizado contenido!</h4>
        <hr>
        <p><strong>Curso:</strong> {{courseName}}</p>
        <p><strong>Docente:</strong> {{teacherName}}</p>
    </div>
    ';

    const deliveredAnswer = '
    <div class="container">
        <h1>Hola {{name}}</h1>
        <h4>¡Te notificamos que hay nuevas respuestas en el contenido!</h4>
        <hr>
        <p><strong>Curso:</strong> {{courseName}}</p>
        <p><strong>Estudiante:</strong> {{studentName}}</p>
    </div>
    ';

    const resetPassword = '
    <div class="container">
        <h1>Hola {{name}}</h1>
        <p>Solicitaste un cambio de contraseña para el correo: {{email}}</p>
        <hr>
        <p>Puedes cambiar tu contraseña en el siguiente enlace:</p>
        <p><a href="{{url}}">Restablecer contraseña</a></p>
    </div>
    ';
}

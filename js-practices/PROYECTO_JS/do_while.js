/*let value;
do {
    value = parseInt(prompt('Ingrese valor 1 para salir...'));
    document.write('Ingresó valor: ', value);
    document.write('<br>');
} while (value != 1);
document.write('Fin del bucle do while');*/

let user, passwd, control;

control = 0;
user = prompt('Ingrese su usuario: ');
passwd = prompt('Ingrese su contraseña: ');

do {
    if (passwd != 'Admin01') {
        passwd = prompt('Contraseña incorrecta\n' + 'Intente nuevamente...');
        control = 0;
    } else {
        control = 1;
    }
} while (control != 1);
document.write('Acceso permitido!');